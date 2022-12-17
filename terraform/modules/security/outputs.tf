output "oceans_ec2_sg_id" {
  value = aws_security_group.oceans_ec2_sg.id
}

output "oceans_rds_sg_id" {
  value = aws_security_group.oceans_rds_sg.id
}

output "oceans_alb_sg_id" {
  value = aws_security_group.oceans_alb_sg.id
}
