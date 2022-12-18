resource "aws_s3_bucket" "oceans_image_bucket" {
  bucket = "oceans-image-bucket"
}

# resource "aws_s3_bucket_acl" "acl" {
#   bucket = aws_s3_bucket.oceans_image_bucket.id
#   acl    = "private"
# }

resource "aws_s3_bucket_public_access_block" "example" {
  bucket = aws_s3_bucket.oceans_image_bucket.id

  block_public_acls       = true
  block_public_policy     = false
  ignore_public_acls      = true
  restrict_public_buckets = false
}

# resource "aws_s3_bucket_server_side_encryption_configuration" "encryption_configuration" {
#   bucket = aws_s3_bucket.oceans_image_bucket.id
#   rule {
#     apply_server_side_encryption_by_default {
#       sse_algorithm = "AES256"
#     }
#   }
# }
