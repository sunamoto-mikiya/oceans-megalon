resource "aws_lb" "oceans_alb" {
  name = "oceans-alb"
  #tfsec:ignore:aws-elb-alb-not-public 外部に公開するALBなのでpublic設定
  internal           = false
  load_balancer_type = "application"
  security_groups    = var.alb_security_group_ids
  subnets            = var.alb_subnet_ids

  enable_deletion_protection = true
  drop_invalid_header_fields = true
}

resource "aws_lb_target_group" "oceans_alb_target_group" {
  name                 = "oceans-alb-target-group"
  port                 = 80
  protocol             = "HTTP"
  vpc_id               = var.vpc_id
  target_type          = "ip"
  deregistration_delay = 180

  health_check {
    interval            = 30
    path                = "/"
    protocol            = "HTTP"
    timeout             = 20
    unhealthy_threshold = 4
    matcher             = 200
  }
}

resource "aws_lb_listener" "oceans_https" {
  load_balancer_arn = aws_lb.oceans_alb.arn
  port              = "443"
  protocol          = "HTTPS"
  ssl_policy        = "ELBSecurityPolicy-TLS-1-2-2017-01"
  certificate_arn   = var.acm_arn

  default_action {
    type             = "fixed-response"
    target_group_arn = aws_lb_target_group.oceans_alb_target_group.arn

    fixed_response {
      content_type = "text/plain"
      message_body = "403 Forbidden"
      status_code  = 403
    }
  }
}

# resource "aws_lb_listener" "oceans_http" {
#   load_balancer_arn = aws_lb.oceans_alb.arn
#   port              = "80"
#   protocol          = "HTTP"

#   default_action {
#     type = "redirect"
#     redirect {
#       port        = "443"
#       protocol    = "HTTPS"
#       status_code = "HTTP_301"
#     }
#   }
# }

resource "aws_lb_listener_rule" "oceans_alb_listener_rule" {
  listener_arn = aws_lb_listener.oceans_https.arn
  priority     = 1

  action {
    type             = "forward"
    target_group_arn = aws_lb_target_group.oceans_alb_target_group.arn
  }

  condition {
    host_header {
      values = [
        var.domain_name
      ]
    }
  }
}
