# VPC
resource "aws_vpc" "oceans_vpc" {
  cidr_block           = "10.0.0.0/16"
  enable_dns_hostnames = true

  tags = {
    Name = "oceans-vpc"
  }
}
