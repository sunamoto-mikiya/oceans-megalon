# サブネットにルートテーブルを紐づけ
resource "aws_route_table_association" "oceans_vpc_public_rt_assoc1" {
  subnet_id      = aws_subnet.oceans_public_subnet.id
  route_table_id = aws_route_table.oceans_public_rtb.id
}

resource "aws_route_table_association" "oceans_vpc_public_rt_assoc2" {
  subnet_id      = aws_subnet.oceans_public_subnet2.id
  route_table_id = aws_route_table.oceans_public_rtb.id
}
