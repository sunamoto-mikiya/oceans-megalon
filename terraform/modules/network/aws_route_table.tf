# ルートテーブル
resource "aws_route_table" "oceans_public_rtb" {
  vpc_id = aws_vpc.oceans_vpc.id
  route {
    cidr_block = "0.0.0.0/0"
    gateway_id = aws_internet_gateway.oceans_igw.id
  }

  tags = {
    Name = "oceans-public-route-table"
  }
}
