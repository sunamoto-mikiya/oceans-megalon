resource "aws_db_subnet_group" "oceans_db_subnet_group" {
  name       = "oceans-db-subnet-group"
  subnet_ids = var.subnet_ids

  tags = {
    Name = "oceans-db-subnet-group"
  }
}
