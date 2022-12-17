output "oceans_public_subnet_id1" {
  value = aws_subnet.oceans_public_subnet.id
}

output "oceans_public_subnet_id2" {
  value = aws_subnet.oceans_public_subnet2.id
}

output "oceans_private_subnet1_id" {
  value = aws_subnet.oceans_private_subnet1.id
}

output "oceans_private_subnet2_id" {
  value = aws_subnet.oceans_private_subnet2.id
}

output "oceans_vpc_id" {
  value = aws_vpc.oceans_vpc.id
}

output "oceans_vpc_cidr_block" {
  value = aws_vpc.oceans_vpc.cidr_block
}
