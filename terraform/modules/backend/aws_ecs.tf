resource "aws_ecs_cluster" "oceans_ecs_cluster" {
  name = "oceans-ecs-fargate-cluster"
}

resource "aws_ecs_task_definition" "oceans_ecs_task" {
  family                   = "oceans-ecs-task"
  network_mode             = "awsvpc"
  task_role_arn            = aws_iam_role.ecs_task_role.arn
  execution_role_arn       = aws_iam_role.ecs_task_execution_role.arn
  requires_compatibilities = ["FARGATE"]
  cpu                      = var.cpu
  memory                   = var.memory

  container_definitions = <<DEFINITION
[
  {
    "name": "oceans-app-container",
    "image": "${aws_ecr_repository.repository.repository_url}:a0d16659023cd210a5e19e591b8cacf7c105a3a4",
    "secrets": [
      {
        "name": "DB_HOST",
        "valueFrom": "arn:aws:ssm:ap-northeast-1:418455050024:parameter/oceans/rds/host"
      },
      {
        "name": "DB_USERNAME",
        "valueFrom": "arn:aws:ssm:ap-northeast-1:418455050024:parameter/oceans/rds/username"
      },
      {
        "name": "DB_PASSWORD",
        "valueFrom": "arn:aws:ssm:ap-northeast-1:418455050024:parameter/oceans/rds/password"
      },
      {
        "name": "MAIL_USERNAME",
        "valueFrom": "arn:aws:ssm:ap-northeast-1:418455050024:parameter/oceans/mail/address"
      },
      {
        "name": "MAIL_FROM_ADDRESS",
        "valueFrom": "arn:aws:ssm:ap-northeast-1:418455050024:parameter/oceans/mail/address"
      },
      {
        "name": "MAIL_PASSWORD",
        "valueFrom": "arn:aws:ssm:ap-northeast-1:418455050024:parameter/oceans/mail/password"
      },
      {
        "name": "AWS_ACCESS_KEY_ID",
        "valueFrom": "arn:aws:ssm:ap-northeast-1:418455050024:parameter/oceans/aws/accesskey"
      },
      {
        "name": "AWS_SECRET_ACCESS_KEY",
        "valueFrom": "arn:aws:ssm:ap-northeast-1:418455050024:parameter/oceans/aws/secretkey"
      }
    ],
    "portMappings": [
      {
        "containerPort": 80,
        "hostPort": 80,
        "protocol": "tcp"
      }
    ],
    "essential": true,
    "memory": ${var.memory},
    "cpu": ${var.cpu},
    "logConfiguration": {
      "logDriver": "awslogs",
      "options": {
        "awslogs-region": "ap-northeast-1",
        "awslogs-stream-prefix": "php",
        "awslogs-group": "${aws_cloudwatch_log_group.php.name}"
      }
    }
  }
]
DEFINITION
}

resource "aws_ecs_service" "ecs_service" {
  name            = "ecs-fargate-service"
  cluster         = aws_ecs_cluster.oceans_ecs_cluster.id
  task_definition = aws_ecs_task_definition.oceans_ecs_task.arn
  desired_count   = 1
  launch_type     = "FARGATE"

  network_configuration {
    assign_public_ip = true
    security_groups  = var.security_group_ids
    subnets          = var.ecs_subnet_ids
  }

  load_balancer {
    target_group_arn = aws_lb_target_group.oceans_alb_target_group.arn
    container_name   = "oceans-app-container"
    container_port   = 80
  }
}

resource "aws_cloudwatch_log_group" "php" {
  name              = "/ecs/oceans/production/php"
  retention_in_days = 30
}
