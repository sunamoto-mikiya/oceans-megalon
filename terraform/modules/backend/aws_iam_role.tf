# ECSタスク実行ロール．ECS Fargateを利用するため．
resource "aws_iam_role" "ecs_task_execution_role" {
  name               = "oceans-ecs-task-execution-role"
  assume_role_policy = data.aws_iam_policy_document.ecs_task_assume_policy.json
}

data "aws_iam_policy_document" "ecs_task_assume_policy" {
  version = "2012-10-17"
  statement {
    effect = "Allow"
    actions = [
      "sts:AssumeRole"
    ]
    principals {
      type = "Service"
      identifiers = [
        "ecs-tasks.amazonaws.com"
      ]
    }
  }
}

resource "aws_iam_role_policy_attachment" "ecs_task_execution_role_fargate" {
  role       = aws_iam_role.ecs_task_execution_role.name
  policy_arn = "arn:aws:iam::aws:policy/service-role/AmazonECSTaskExecutionRolePolicy"
}

resource "aws_iam_role_policy_attachment" "ecs_task_execution_role_ssm" {
  role       = aws_iam_role.ecs_task_execution_role.name
  policy_arn = "arn:aws:iam::aws:policy/AmazonSSMReadOnlyAccess"
}

# ECSタスク自体のロール．Systems Managerへのアクセス権限を持つ．
resource "aws_iam_role" "ecs_task_role" {
  name               = "oceans-ecs-task-role"
  assume_role_policy = data.aws_iam_policy_document.ecs_task_assume_policy.json
}

resource "aws_iam_role_policy" "ecs_task_role_policy" {
  name = "oceans-ecs-task-role-policy"
  role = aws_iam_role.ecs_task_role.id
  policy = data.aws_iam_policy_document.ecs_task_role_policy_document.json
}

data "aws_iam_policy_document" "ecs_task_role_policy_document" {
  version = "2012-10-17"
  statement {
    effect = "Allow"
    actions = [
      "s3:GetObject",
      "s3:PutObject",
      "s3:ListBucket",
      "s3:GetEncryptionConfiguration"
    ]
    #tfsec:ignore:aws-iam-no-policy-wildcards 不特定のリソースにアクセスするため、ワイルドカードは許可
    resources = [
      aws_s3_bucket.oceans_image_bucket.arn,
      "${aws_s3_bucket.oceans_image_bucket.arn}/*"
    ]
  }
}

resource "aws_iam_role_policy_attachment" "ecs_task_role_ssm" {
  role       = aws_iam_role.ecs_task_role.name
  policy_arn = "arn:aws:iam::aws:policy/AmazonSSMReadOnlyAccess"
}

# ECSタスクスケジューラー実行用ロール
resource "aws_iam_role" "ecs_scheduled_task_role" {
  name               = "oceans-ecs-scheduled-task-role"
  assume_role_policy = data.aws_iam_policy_document.ecs_scheduled_task_assume_policy.json
}

data "aws_iam_policy_document" "ecs_scheduled_task_assume_policy" {
  version = "2012-10-17"
  statement {
    effect = "Allow"
    actions = [
      "sts:AssumeRole"
    ]
    principals {
      type = "Service"
      identifiers = [
        "events.amazonaws.com"
      ]
    }
  }
}

resource "aws_iam_role_policy_attachment" "ecs_scheduled_task_policy" {
  role       = aws_iam_role.ecs_scheduled_task_role.name
  policy_arn = "arn:aws:iam::aws:policy/service-role/AmazonEC2ContainerServiceEventsRole"
}
