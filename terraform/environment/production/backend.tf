module "backend" {
  source = "../../modules/backend"

  app_image = "httpd:latest"
  cpu       = 256
  memory    = 512
  security_group_ids = [
    module.security.oceans_ec2_sg_id
  ]
  ecs_subnet_ids = [
    module.network.oceans_public_subnet_id1,
    module.network.oceans_public_subnet_id2
  ]
  alb_security_group_ids = [
    module.security.oceans_alb_sg_id
  ]
  alb_subnet_ids = [
    module.network.oceans_public_subnet_id1,
    module.network.oceans_public_subnet_id2
  ]
  vpc_id      = module.network.oceans_vpc_id
  domain_name = "my-sample-domain.ml"
  acm_arn     = "arn:aws:acm:ap-northeast-1:418455050024:certificate/de19f803-a38e-49ea-b902-33f4813610a9"
}
