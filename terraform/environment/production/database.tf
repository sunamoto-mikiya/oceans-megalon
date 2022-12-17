module "database" {
  source = "../../modules/database"

  username = var.rds_username
  password = var.rds_password

  subnet_ids = [
    module.network.oceans_private_subnet1_id,
    module.network.oceans_private_subnet2_id,
  ]

  security_group_ids = [
    module.security.oceans_rds_sg_id
  ]
}
