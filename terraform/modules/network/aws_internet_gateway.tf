# インターネットゲートウェイ
resource "aws_internet_gateway" "oceans_igw" {
  vpc_id = aws_vpc.oceans_vpc.id

  tags = {
    Name = "oceans-igw"
  }
}
