resource "aws_db_instance" "oceans_db" {
  allocated_storage      = 10
  db_name                = "oceans"
  engine                 = "mysql"
  engine_version         = "8.0"
  storage_type           = "gp2"
  instance_class         = "db.t3.micro"
  username               = var.username
  password               = var.password
  db_subnet_group_name   = aws_db_subnet_group.oceans_db_subnet_group.name
  vpc_security_group_ids = var.security_group_ids
  skip_final_snapshot    = true
}
