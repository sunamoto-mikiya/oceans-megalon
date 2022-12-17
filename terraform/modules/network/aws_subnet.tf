# パブリックサブネット
resource "aws_subnet" "oceans_public_subnet" {
  vpc_id                  = aws_vpc.oceans_vpc.id
  cidr_block              = "10.0.1.0/24"
  availability_zone       = "ap-northeast-1a"
  map_public_ip_on_launch = true

  tags = {
    Name = "oceans-public-subnet1"
  }
}

resource "aws_subnet" "oceans_public_subnet2" {
  vpc_id                  = aws_vpc.oceans_vpc.id
  cidr_block              = "10.0.4.0/24"
  availability_zone       = "ap-northeast-1d"
  map_public_ip_on_launch = true

  tags = {
    Name = "oceans-public-subnet2"
  }
}

# プライベートサブネット
resource "aws_subnet" "oceans_private_subnet1" {
  vpc_id                  = aws_vpc.oceans_vpc.id
  cidr_block              = "10.0.2.0/24"
  availability_zone       = "ap-northeast-1a"
  map_public_ip_on_launch = false

  tags = {
    Name = "oceans-private-subnet1"
  }
}

resource "aws_subnet" "oceans_private_subnet2" {
  vpc_id                  = aws_vpc.oceans_vpc.id
  cidr_block              = "10.0.3.0/24"
  availability_zone       = "ap-northeast-1c"
  map_public_ip_on_launch = false

  tags = {
    Name = "oceans-private-subnet2"
  }
}
