resource "aws_route53_record" "oceans_route53_record" {
  zone_id = data.aws_route53_zone.oceans_route53_zone.zone_id
  name    = var.domain_name
  type    = "A"

  alias {
    name                   = aws_lb.oceans_alb.dns_name
    zone_id                = aws_lb.oceans_alb.zone_id
    evaluate_target_health = false
  }
}
