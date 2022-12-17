data "aws_route53_zone" "oceans_route53_zone" {
  name = var.domain_name
}
