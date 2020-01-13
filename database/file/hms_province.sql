DROP TABLE IF EXISTS `hms_province`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `hms_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `status` enum('Published','Unpublished') DEFAULT 'Published',
  `code` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 ROW_FORMAT=DYNAMIC;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `hms_province`
--

LOCK TABLES `hms_province` WRITE;
/*!40000 ALTER TABLE `hms_province` DISABLE KEYS */;
INSERT INTO `hms_province` VALUES (11,'ACEH',NULL,NULL,'Published','AC'),(12,'SUMATERA UTARA',NULL,NULL,'Published','SU'),(13,'SUMATERA BARAT',NULL,NULL,'Published','SB'),(14,'RIAU',NULL,NULL,'Published','RI'),(15,'JAMBI',NULL,NULL,'Published','JA'),(16,'SUMATERA SELATAN',NULL,NULL,'Published','SS'),(17,'BENGKULU',NULL,NULL,'Published','BB'),(18,'LAMPUNG',NULL,NULL,'Published','LA'),(19,'KEPULAUAN BANGKA BELITUNG',NULL,NULL,'Published','BB'),(21,'KEPULAUAN RIAU',NULL,NULL,'Published','KR'),(31,'DAERAH KHUSUS IBUKOTA JAKARTA',NULL,NULL,'Published','JK'),(32,'JAWA BARAT',NULL,NULL,'Published','JB'),(33,'JAWA TENGAH',NULL,NULL,'Published','JT'),(34,'DAERAH ISTIMEWA YOGYAKARTA',NULL,NULL,'Published','YO'),(35,'JAWA TIMUR',NULL,NULL,'Published','JI'),(36,'BANTEN',NULL,NULL,'Published','BT'),(51,'BALI',NULL,NULL,'Published','BA'),(52,'NUSA TENGGARA BARAT',NULL,NULL,'Published','NB'),(53,'NUSA TENGGARA TIMUR',NULL,NULL,'Published','NT'),(61,'KALIMANTAN BARAT',NULL,NULL,'Published','KB'),(62,'KALIMANTAN TENGAH',NULL,NULL,'Published','KT'),(63,'KALIMANTAN SELATAN',NULL,NULL,'Published','KS'),(64,'KALIMANTAN TIMUR',NULL,NULL,'Published','KI'),(65,'KALIMANTAN UTARA',NULL,NULL,'Published','KU'),(71,'SULAWESI UTARA',NULL,NULL,'Published','SA'),(72,'SULAWESI TENGAH',NULL,NULL,'Published','ST'),(73,'SULAWESI SELATAN',NULL,NULL,'Published','SN'),(74,'SULAWESI TENGGARA',NULL,NULL,'Published','SG'),(75,'GORONTALO',NULL,NULL,'Published','GO'),(76,'SULAWESI BARAT',NULL,NULL,'Published','SR'),(81,'MALUKU',NULL,NULL,'Published','MA'),(82,'MALUKU UTARA',NULL,NULL,'Published','MU'),(91,'PAPUA',NULL,NULL,'Published','PA'),(92,'PAPUA BARAT',NULL,NULL,'Published','PB');
/*!40000 ALTER TABLE `hms_province` ENABLE KEYS */;
UNLOCK TABLES;
