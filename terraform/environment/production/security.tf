module "security" {
  source = "../../modules/security"

  vpc_id         = module.network.oceans_vpc_id
  vpc_cidr_block = module.network.oceans_vpc_cidr_block
}
