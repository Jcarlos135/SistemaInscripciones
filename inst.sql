-- MySQL dump 10.13  Distrib 8.0.46, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: inst
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `asignatura`
--

DROP TABLE IF EXISTS `asignatura`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `asignatura` (
  `codigo` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(120) COLLATE utf8mb4_spanish_ci NOT NULL,
  `horas` int DEFAULT NULL,
  `gestion` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL,
  `hora` time NOT NULL DEFAULT '08:00:00',
  `id_carrera` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nivel` int NOT NULL DEFAULT '101',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`codigo`),
  KEY `idx_asig_carrera` (`id_carrera`),
  CONSTRAINT `fk_asig_carrera` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asignatura`
--

LOCK TABLES `asignatura` WRITE;
/*!40000 ALTER TABLE `asignatura` DISABLE KEYS */;
INSERT INTO `asignatura` VALUES ('ADS-206','ANALISIS Y DISEÑO DE SISTEMAS I',NULL,'2024','08:00:00','SIS-INF',200,1),('ADS-306','ANALISIS Y DISEÑO DE SISTEMAS II',NULL,'2024','08:00:00','SIS-INF',300,1),('BDD-208','BASE DE DATOS I',NULL,'2024','08:00:00','SIS-INF',200,1),('BDD-308','BASE DE DATOS II',NULL,'2024','08:00:00','SIS-INF',300,1),('DPW-107','DISEÑO Y PROGRAMACIÓN WEB I',NULL,'2024','08:00:00','SIS-INF',100,1),('DPW-207','DISEÑO Y PROGRAMACIÓN WEB II',NULL,'2024','08:00:00','SIS-INF',200,1),('DPW-302','DISEÑO Y PROGRAMACIÓN WEB III',NULL,'2024','08:00:00','SIS-INF',300,1),('EDD-203','ESTRUCTURA DE DATOS',NULL,'2024','08:00:00','SIS-INF',200,1),('EMP-301','EMPRENDIMIENTO PRODUCTIVO',NULL,'2024','08:00:00','SIS-INF',300,1),('EST-201','ESTADISTICA',NULL,'2024','08:00:00','SIS-INF',200,1),('GMC-303','GESTIÓN Y MEJORAMIENTO DE LA CALIDAD DE SOFTWARE',NULL,'2024','08:00:00','SIS-INF',300,1),('HDC-104','HARDWARE DE COMPUTADORAS',NULL,'2024','08:00:00','SIS-INF',100,1),('INT-103','INGLES TECNICO',NULL,'2024','08:00:00','SIS-INF',100,1),('MPI-101','MATEMATICA PARA LA INFORMATICA',NULL,'2024','08:00:00','SIS-INF',100,1),('OMT-106','OFIMATICA Y TECNOLOGIA MULTIMEDIA',NULL,'2024','08:00:00','SIS-INF',100,1),('PDM-205','PROGRAMACIÓN PARA DISPOSITIVOS MOVILES I',NULL,'2024','08:00:00','SIS-INF',200,1),('PDM-307','PROGRAMACIÓN PARA DISPOSITIVOS MOVILES II',NULL,'2024','08:00:00','SIS-INF',300,1),('PRG-202','PROGRAMACIÓN II',NULL,'2024','08:00:00','SIS-INF',200,1),('PROG-102','PROGRAMACIÓN I',NULL,'2024','08:00:00','SIS-INF',100,1),('RDC-204','REDES DE COMPUTADORAS I',NULL,'2024','08:00:00','SIS-INF',200,1),('RDC-304','REDES DE COMPUTADORA II',NULL,'2024','08:00:00','SIS-INF',300,1),('TMG-305','TALLER DE MODALIDAD DE GRADUACIÓN',NULL,'2024','08:00:00','SIS-INF',300,1),('TSO-105','TALLER DE SISTEMAS OPERATIVOS',NULL,'2024','08:00:00','SIS-INF',100,1);
/*!40000 ALTER TABLE `asignatura` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carrera`
--

DROP TABLE IF EXISTS `carrera`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carrera` (
  `id` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `resolucion` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `descripcion` varchar(200) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `gestion` varchar(10) COLLATE utf8mb4_spanish_ci NOT NULL,
  `duracion` int DEFAULT NULL,
  `anios` int DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carrera`
--

LOCK TABLES `carrera` WRITE;
/*!40000 ALTER TABLE `carrera` DISABLE KEYS */;
INSERT INTO `carrera` VALUES ('SIS-INF','SISTEMAS INFORMÁTICOS','RM-205','Centro de Enseñanza Técnica','2024',3,2,1);
/*!40000 ALTER TABLE `carrera` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `docente`
--

DROP TABLE IF EXISTS `docente`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `docente` (
  `id_docente` int NOT NULL AUTO_INCREMENT,
  `ci` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ap_pat` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ap_mat` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `genero` char(1) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cel` varchar(15) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `id_rol` int NOT NULL DEFAULT '4',
  `activo` tinyint(1) DEFAULT '1',
  PRIMARY KEY (`id_docente`),
  UNIQUE KEY `ci` (`ci`),
  KEY `fk_doc_rol` (`id_rol`),
  CONSTRAINT `fk_doc_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `docente`
--

LOCK TABLES `docente` WRITE;
/*!40000 ALTER TABLE `docente` DISABLE KEYS */;
INSERT INTO `docente` VALUES (1,'5550001','JONATAN','HINOJOSA','MAMANI','M','70500001','jhinojosa@instituto.edu',4,1),(2,'5550002','WENDY','NAVIA','QUISPE','F','70500002','wnavia@instituto.edu',4,1),(3,'5550003','FREDDY','COLQUE','TORRES','M','70500003','fcolque@instituto.edu',4,1),(4,'5550004','ROXANA','FORONDA','LOPEZ','F','70500004','rforonda@instituto.edu',4,1),(5,'5550005','LUIS','GUTIERREZ','MORALES','M','70500005','lgutierrez@instituto.edu',4,1),(6,'5550006','YNCLAN','SANTOS','VARGAS','M','70500006','ysantos@instituto.edu',4,1),(7,'5550007','VICTOR','PACO','CHURA','M','70500007','vpaco@instituto.edu',4,1),(8,'5550008','ANGEL','RODRIGUEZ','FLORES','M','70500008','arodriguez@instituto.edu',4,1),(9,'5550009','FREDY','CALSI NA','MENDOZA','M','70500009','fcalsina@instituto.edu',4,1),(10,'5550010','PATRICIA','FERNANDEZ','ROJAS','F','70500010','pfernandez@instituto.edu',4,1),(11,'5550011','ANTONIO','CONDORI','APAZA','M','70500011','acondori@instituto.edu',4,1);
/*!40000 ALTER TABLE `docente` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `documentos_est`
--

DROP TABLE IF EXISTS `documentos_est`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `documentos_est` (
  `id_documento` int NOT NULL AUTO_INCREMENT,
  `ci_est` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo_documento` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre_archivo` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ruta_archivo` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha_subida` datetime DEFAULT CURRENT_TIMESTAMP,
  `observaciones` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id_documento`),
  KEY `ci_est` (`ci_est`),
  CONSTRAINT `documentos_est_ibfk_1` FOREIGN KEY (`ci_est`) REFERENCES `estudiante` (`ci`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `documentos_est`
--

LOCK TABLES `documentos_est` WRITE;
/*!40000 ALTER TABLE `documentos_est` DISABLE KEYS */;
/*!40000 ALTER TABLE `documentos_est` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `estudiante`
--

DROP TABLE IF EXISTS `estudiante`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `estudiante` (
  `ci` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ap_pat` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `ap_mat` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `genero` char(1) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `edad` int DEFAULT NULL,
  `cel` varchar(15) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `img` varchar(255) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `id_carrera` varchar(15) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `id_usuario` int DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`ci`),
  KEY `fk_est_carrera` (`id_carrera`),
  KEY `fk_est_usuario` (`id_usuario`),
  CONSTRAINT `fk_est_carrera` FOREIGN KEY (`id_carrera`) REFERENCES `carrera` (`id`),
  CONSTRAINT `fk_est_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `estudiante`
--

LOCK TABLES `estudiante` WRITE;
/*!40000 ALTER TABLE `estudiante` DISABLE KEYS */;
INSERT INTO `estudiante` VALUES ('10203203','MARIA','MIRANDA','MERCADO','F',23,'76754757','img/1781664837_1781664825_M11.jpg','SIS-INF',6,1),('10223203','MAYTE','ORELLANA','REDONDO','F',26,'75647576','img/1782266519_1782266491_DEFAUL_M.jpg','SIS-INF',7,0),('11239832','DANIELA','LUJAN','','F',23,'6756453','img/1782266491_DEFAUL_M.jpg','SIS-INF',12,0),('121232431','LUCIA','MERCADO','PARADO','F',23,'76565454','img/1782271159_1781708233_1781664900_H1.jpg','SIS-INF',25,1),('12345678','MARIA','MERCADO','PERALTA','F',21,'76574757','img/1781664439_1__1_.jpg','SIS-INF',1,1),('190102033','MARCOS','MERCAD','AGUILERA','M',32,'64564565','img/1782269370_1782266470_1781664857_H1.jpg','SIS-INF',23,1),('2222222','MARIA','MERCEZ','MERCADO','F',23,'75675475','img/1781664622_M__4_.jpg','SIS-INF',2,1),('2736233','MARCOS','MERCADO','','M',33,'75475746','img/1781664589_N__3_.webp','SIS-INF',5,0),('2736234','LUCASSS','MARINO','MILIAN','M',24,'6574756','img/1781664551_H__2_.jpg','SIS-INF',10,1),('37473743','LUIS','MAMANI','MAMANI','M',23,'67576757','img/1782268206_1781708233_1781664900_H1.jpg','SIS-INF',22,1),('38283283','FERNADO','TORNADO','MENDEZ','M',45,'75474757','img/1781664900_H1.jpg','SIS-INF',8,1),('45345353','RAMIRO','PERALTA','MERCADO','M',23,'56564564','img/1782271425_1781708233_1781664900_H1.jpg','SIS-INF',26,1),('45463464','MARIA','MERCEDEZ','PARRILLA','F',21,'565646564','img/1782270727_DEFAUL_M.jpg','SIS-INF',24,1),('45645467','MARIANO','MERCADO','PERALTA','M',32,'74564755','img/1782268041_1782266470_1781664857_H1.jpg','SIS-INF',21,1),('46574343','JUAN CARLOS','QUISPE','CHIRINOS','M',43,'75647574','img/1781664857_H1.jpg','SIS-INF',14,1),('4780223','DANIELA','ROSARIO','MILAN','F',23,'76767578','img/1781664868_H1.jpg','SIS-INF',13,1),('4780252','MARINA','RODUATA','MERIDA','F',33,'767575477','img/1781666105_1781664825_M11.jpg','SIS-INF',19,1),('4780257','JUAN CARLOS','CHIRIINOS','QUISPE','M',38,'77657635','img/1782266470_1781664857_H1.jpg','SIS-INF',4,1),('47892832','MARCOS','RUIZ','PERALES','M',32,'74547345','img/1782261748_1781664857_H1.jpg','SIS-INF',20,1),('48574857','MARIA','MIRANDA','PACOSILLO','F',34,'66566656','img/1781664825_M11.jpg','SIS-INF',11,1),('7685675','MARTICA','MERCADO','MARIMA','M',23,'75473745','img/1781664574_M__5_.jpg','SIS-INF',3,1),('7685676','MARIA','MERCADO','','F',23,'67574757','img/1781664598_M__1_.png','SIS-INF',9,1);
/*!40000 ALTER TABLE `estudiante` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `historial`
--

DROP TABLE IF EXISTS `historial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `historial` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ci_est` varchar(15) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `cod_asig` varchar(20) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `nota_teorico1` int DEFAULT NULL,
  `nota_pract1` int DEFAULT NULL,
  `nota_primerbim` int DEFAULT NULL,
  `nota_teorico2` int DEFAULT NULL,
  `nota_pract2` int DEFAULT NULL,
  `nota_segundobim` int DEFAULT NULL,
  `nota_teorico3` int DEFAULT NULL,
  `nota_pract3` int DEFAULT NULL,
  `nota_tercerbim` int DEFAULT NULL,
  `nota_teorico4` int DEFAULT NULL,
  `nota_pract4` int DEFAULT NULL,
  `nota_cuartobim` int DEFAULT NULL,
  `nota_parcial` int DEFAULT NULL COMMENT 'Nota parcial (promedio bimestres)',
  `segundo_turno` tinyint(1) DEFAULT '0' COMMENT '1 si la materia se cursa en segundo turno',
  `TotalAnual` int DEFAULT NULL COMMENT 'Nota total anual',
  `gestion` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `literal` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL COMMENT 'Literal en texto de la nota TotalAnual',
  `observaciones` text CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci,
  `estado` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `id_docente` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_estudiante_materia_gestion` (`ci_est`,`cod_asig`,`gestion`),
  KEY `ci_est` (`ci_est`),
  KEY `id_docente` (`id_docente`),
  CONSTRAINT `historial_ibfk_1` FOREIGN KEY (`ci_est`) REFERENCES `estudiante` (`ci`),
  CONSTRAINT `historial_ibfk_2` FOREIGN KEY (`id_docente`) REFERENCES `docente` (`id_docente`),
  CONSTRAINT `chk_estado` CHECK ((`estado` in (_utf8mb4'APROBADO',_utf8mb4'REPROBADO',_utf8mb4'EN PROCESO',_utf8mb4'SEGUNDO TURNO',_utf8mb4'RETIRADO'))),
  CONSTRAINT `chk_nota_cuartobim` CHECK ((`nota_cuartobim` between 0 and 100)),
  CONSTRAINT `chk_nota_parcial` CHECK ((`nota_parcial` between 0 and 100)),
  CONSTRAINT `chk_nota_pract1` CHECK ((`nota_pract1` between 0 and 100)),
  CONSTRAINT `chk_nota_pract2` CHECK ((`nota_pract2` between 0 and 100)),
  CONSTRAINT `chk_nota_pract3` CHECK ((`nota_pract3` between 0 and 100)),
  CONSTRAINT `chk_nota_pract4` CHECK ((`nota_pract4` between 0 and 100)),
  CONSTRAINT `chk_nota_primerbim` CHECK ((`nota_primerbim` between 0 and 100)),
  CONSTRAINT `chk_nota_segundobim` CHECK ((`nota_segundobim` between 0 and 100)),
  CONSTRAINT `chk_nota_teorico1` CHECK ((`nota_teorico1` between 0 and 100)),
  CONSTRAINT `chk_nota_teorico2` CHECK ((`nota_teorico2` between 0 and 100)),
  CONSTRAINT `chk_nota_teorico3` CHECK ((`nota_teorico3` between 0 and 100)),
  CONSTRAINT `chk_nota_teorico4` CHECK ((`nota_teorico4` between 0 and 100)),
  CONSTRAINT `chk_nota_tercerbim` CHECK ((`nota_tercerbim` between 0 and 100)),
  CONSTRAINT `chk_segundo_turno` CHECK ((`segundo_turno` in (0,1))),
  CONSTRAINT `chk_total_anual` CHECK ((`TotalAnual` between 0 and 100))
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `historial`
--

LOCK TABLES `historial` WRITE;
/*!40000 ALTER TABLE `historial` DISABLE KEYS */;
INSERT INTO `historial` VALUES (2,'7685675','MPI-101',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',2),(3,'7685675','PROG-102',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',7),(4,'7685675','INT-103',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',11),(5,'7685675','HDC-104',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(6,'7685675','TSO-105',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(7,'7685675','OMT-106',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',6),(8,'7685675','DPW-107',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',1),(9,'12345678','MPI-101',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',2),(10,'12345678','PROG-102',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',7),(11,'12345678','INT-103',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',11),(12,'12345678','HDC-104',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(13,'12345678','TSO-105',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(14,'12345678','OMT-106',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',6),(15,'12345678','DPW-107',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',1),(16,'4780257','MPI-101',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',2),(17,'4780257','PROG-102',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',7),(18,'4780257','INT-103',65,70,69,55,80,73,70,60,63,61,61,61,67,0,67,'2026','SESENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',11),(19,'4780257','HDC-104',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',NULL),(20,'4780257','TSO-105',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',NULL),(21,'4780257','OMT-106',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',6),(22,'4780257','DPW-107',61,51,54,44,75,66,60,60,60,53,66,62,61,0,61,'2026','SESENTA Y UNO','Evaluación por porcentaje registrada','APROBADO',1),(23,'2736233','MPI-101',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',2),(24,'2736233','PROG-102',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',7),(25,'2736233','INT-103',30,20,23,25,30,29,40,35,37,35,30,32,30,0,30,'2026','TREINTA','Evaluación por porcentaje registrada','REPROBADO',11),(26,'2736233','HDC-104',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(27,'2736233','TSO-105',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(28,'2736233','OMT-106',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',6),(29,'2736233','DPW-107',30,20,23,25,30,29,40,35,37,35,30,32,30,0,30,'2026','TREINTA','Evaluación por porcentaje registrada','REPROBADO',1),(30,'10203203','MPI-101',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',2),(31,'10203203','PROG-102',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',7),(32,'10203203','INT-103',30,20,23,25,30,29,40,35,37,35,30,32,30,0,30,'2026','TREINTA','Evaluación por porcentaje registrada','REPROBADO',11),(33,'10203203','HDC-104',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(34,'10203203','TSO-105',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(35,'10203203','OMT-106',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',6),(36,'10203203','DPW-107',30,20,23,25,30,29,40,35,37,35,30,32,30,0,30,'2026','TREINTA','Evaluación por porcentaje registrada','REPROBADO',1),(37,'10223203','MPI-101',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',2),(38,'10223203','PROG-102',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',7),(39,'10223203','INT-103',30,20,23,25,30,29,40,35,37,35,30,32,30,0,30,'2026','TREINTA','Evaluación por porcentaje registrada','REPROBADO',11),(40,'10223203','HDC-104',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(41,'10223203','TSO-105',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(42,'10223203','OMT-106',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',6),(43,'10223203','DPW-107',30,20,23,25,30,29,40,35,37,35,30,32,30,0,30,'2026','TREINTA','Evaluación por porcentaje registrada','REPROBADO',1),(44,'2222222','MPI-101',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',2),(45,'2222222','PROG-102',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',7),(46,'2222222','INT-103',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',11),(47,'2222222','HDC-104',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(48,'2222222','TSO-105',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(49,'2222222','OMT-106',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',6),(50,'2222222','DPW-107',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',1),(51,'38283283','MPI-101',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',2),(52,'38283283','PROG-102',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',7),(53,'38283283','INT-103',30,20,23,25,30,29,40,35,37,35,30,32,30,0,30,'2026','TREINTA','Evaluación por porcentaje registrada','REPROBADO',11),(54,'38283283','HDC-104',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(55,'38283283','TSO-105',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(56,'38283283','OMT-106',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',6),(57,'38283283','DPW-107',30,20,23,25,30,29,40,35,37,35,30,32,30,0,30,'2026','TREINTA','Evaluación por porcentaje registrada','REPROBADO',1),(58,'7685676','MPI-101',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',2),(59,'7685676','PROG-102',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',7),(60,'7685676','INT-103',65,70,69,55,80,73,70,60,63,81,75,77,71,0,71,'2026','SETENTA Y UNO','Evaluación por porcentaje registrada','APROBADO',11),(61,'7685676','HDC-104',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',NULL),(62,'7685676','TSO-105',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',NULL),(63,'7685676','OMT-106',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',6),(64,'7685676','DPW-107',65,70,69,55,80,73,70,60,63,80,75,77,71,0,71,'2026','SETENTA Y UNO','Evaluación por porcentaje registrada','APROBADO',1),(65,'2736234','MPI-101',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',2),(66,'2736234','PROG-102',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',7),(67,'2736234','INT-103',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',11),(68,'2736234','HDC-104',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(69,'2736234','TSO-105',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(70,'2736234','OMT-106',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',6),(71,'2736234','DPW-107',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',1),(72,'48574857','MPI-101',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',2),(73,'48574857','PROG-102',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',7),(74,'48574857','INT-103',65,70,69,55,80,73,70,60,63,79,75,76,70,0,70,'2026','SETENTA','Evaluación por porcentaje registrada','APROBADO',11),(75,'48574857','HDC-104',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',NULL),(76,'48574857','TSO-105',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',NULL),(77,'48574857','OMT-106',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',6),(78,'48574857','DPW-107',65,70,69,55,80,73,70,60,63,80,75,77,71,0,71,'2026','SETENTA Y UNO','Evaluación por porcentaje registrada','APROBADO',1),(79,'11239832','MPI-101',40,36,37,40,36,37,40,36,37,40,36,37,37,1,0,'2026','F','Evaluación por porcentaje registrada','REPROBADO',2),(80,'11239832','PROG-102',40,36,37,40,36,37,40,36,37,40,36,37,37,1,0,'2026','F','Evaluación por porcentaje registrada','REPROBADO',7),(81,'11239832','INT-103',40,36,37,40,36,37,40,36,37,40,36,37,37,1,0,'2026','CERO','Evaluación por porcentaje registrada','REPROBADO',11),(82,'11239832','HDC-104',40,36,37,40,36,37,40,36,37,40,36,37,37,1,0,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(83,'11239832','TSO-105',40,36,37,40,36,37,40,36,37,40,36,37,37,1,0,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(84,'11239832','OMT-106',40,36,37,40,36,37,40,36,37,40,36,37,37,1,0,'2026','F','Evaluación por porcentaje registrada','REPROBADO',6),(85,'11239832','DPW-107',79,88,85,40,36,37,40,36,37,40,36,37,49,1,0,'2026','CERO','Evaluación por porcentaje registrada','REPROBADO',1),(86,'4780223','MPI-101',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',2),(87,'4780223','PROG-102',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',7),(88,'4780223','INT-103',65,70,69,55,80,73,70,60,63,81,75,77,71,0,71,'2026','SETENTA Y UNO','Evaluación por porcentaje registrada','APROBADO',11),(89,'4780223','HDC-104',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',NULL),(90,'4780223','TSO-105',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',NULL),(91,'4780223','OMT-106',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',6),(92,'4780223','DPW-107',65,70,69,55,80,73,70,60,63,80,75,77,71,0,71,'2026','SETENTA Y UNO','Evaluación por porcentaje registrada','APROBADO',1),(93,'46574343','MPI-101',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',2),(94,'46574343','PROG-102',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',7),(95,'46574343','INT-103',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',11),(96,'46574343','HDC-104',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(97,'46574343','TSO-105',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(98,'46574343','OMT-106',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',6),(99,'46574343','DPW-107',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',1),(100,'4780252','DPW-107',65,70,69,55,80,73,70,60,63,80,75,77,71,0,71,'2026','SETENTA Y UNO','Evaluación por porcentaje registrada','APROBADO',1),(101,'4780252','HDC-104',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',NULL),(102,'4780252','INT-103',65,70,69,55,80,73,70,60,63,81,75,77,71,0,71,'2026','SETENTA Y UNO','Evaluación por porcentaje registrada','APROBADO',11),(103,'4780252','MPI-101',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',2),(104,'4780252','OMT-106',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',6),(105,'4780252','PROG-102',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',7),(106,'4780252','TSO-105',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',NULL),(107,'47892832','DPW-107',65,70,69,55,80,73,70,60,63,80,75,77,71,0,71,'2026','SETENTA Y UNO','Evaluación por porcentaje registrada','APROBADO',1),(108,'47892832','HDC-104',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',NULL),(109,'47892832','INT-103',65,70,69,55,80,73,70,60,63,81,75,77,71,0,71,'2026','SETENTA Y UNO','Evaluación por porcentaje registrada','APROBADO',11),(110,'47892832','MPI-101',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',2),(111,'47892832','OMT-106',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',6),(112,'47892832','PROG-102',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',7),(113,'47892832','TSO-105',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',NULL),(114,'2736233','ADS-206',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(115,'2736233','BDD-208',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',10),(116,'2736233','DPW-207',30,20,23,25,30,28,40,35,36,35,30,32,30,0,30,'2026','TREINTA','Evaluación por porcentaje registrada','REPROBADO',1),(117,'2736233','EDD-203',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(118,'2736233','EST-201',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(119,'2736233','PDM-205',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(120,'2736233','PRG-202',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',7),(121,'2736233','RDC-204',30,20,23,25,30,28,40,35,36,35,30,31,30,0,30,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(122,'45645467','DPW-107',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',1),(123,'45645467','HDC-104',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(124,'45645467','INT-103',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',11),(125,'45645467','MPI-101',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',2),(126,'45645467','OMT-106',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',6),(127,'45645467','PROG-102',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',7),(128,'45645467','TSO-105',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(129,'37473743','DPW-107',30,45,41,30,20,23,70,75,74,75,80,79,54,0,54,'2026','CINCUENTA Y CUATRO','Evaluación por porcentaje registrada','REPROBADO',1),(130,'37473743','HDC-104',30,20,23,30,20,23,70,75,73,75,80,78,23,0,23,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(131,'37473743','INT-103',30,20,23,30,20,23,70,75,74,75,80,79,50,0,50,'2026','CINCUENTA','Evaluación por porcentaje registrada','REPROBADO',11),(132,'37473743','MPI-101',30,20,23,30,20,23,70,75,73,75,80,78,23,0,23,'2026','F','Evaluación por porcentaje registrada','REPROBADO',2),(133,'37473743','OMT-106',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',6),(134,'37473743','PROG-102',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',7),(135,'37473743','TSO-105',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(136,'190102033','DPW-107',65,70,69,55,80,73,70,60,63,80,75,77,71,0,71,'2026','SETENTA Y UNO','Evaluación por porcentaje registrada','APROBADO',1),(137,'190102033','HDC-104',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',NULL),(138,'190102033','INT-103',65,70,69,55,80,73,70,60,63,81,75,77,71,0,71,'2026','SETENTA Y UNO','Evaluación por porcentaje registrada','APROBADO',11),(139,'190102033','MPI-101',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',2),(140,'190102033','OMT-106',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',6),(141,'190102033','PROG-102',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',7),(142,'190102033','TSO-105',65,70,67,55,80,65,70,60,66,80,75,78,69,0,NULL,'2026',NULL,'Evaluación por porcentaje registrada','APROBADO',NULL),(143,'45463464','DPW-107',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',1),(144,'45463464','HDC-104',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(145,'45463464','INT-103',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',11),(146,'45463464','MPI-101',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',2),(147,'45463464','OMT-106',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',6),(148,'45463464','PROG-102',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',7),(149,'45463464','TSO-105',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(150,'45463464','ADS-206',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(151,'45463464','BDD-208',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',10),(152,'45463464','DPW-207',70,80,77,75,80,78,70,75,73,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',1),(153,'45463464','EDD-203',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(154,'45463464','EST-201',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(155,'45463464','PDM-205',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(156,'45463464','PRG-202',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',7),(157,'45463464','RDC-204',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(158,'121232431','DPW-107',40,36,37,40,36,37,40,36,37,40,36,37,37,1,0,'2026','CERO','Evaluación por porcentaje registrada','REPROBADO',1),(159,'121232431','HDC-104',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(160,'121232431','INT-103',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',11),(161,'121232431','MPI-101',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',2),(162,'121232431','OMT-106',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',6),(163,'121232431','PROG-102',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',7),(164,'121232431','TSO-105',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(165,'121232431','ADS-206',40,36,37,40,36,37,40,36,37,40,36,37,37,1,0,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(166,'121232431','BDD-208',40,36,37,40,36,37,40,36,37,40,36,37,37,1,0,'2026','F','Evaluación por porcentaje registrada','REPROBADO',10),(167,'121232431','DPW-207',40,36,37,40,36,37,40,36,37,40,61,55,42,1,42,'2026','CUARENTA Y DOS','Evaluación por porcentaje registrada','APROBADO',1),(168,'121232431','EDD-203',40,36,37,40,36,37,40,36,37,40,36,37,37,1,0,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(169,'121232431','EST-201',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(170,'121232431','PDM-205',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(171,'121232431','PRG-202',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',7),(172,'121232431','RDC-204',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL),(173,'45345353','DPW-107',30,20,23,75,80,79,70,75,74,75,80,79,64,0,64,'2026','SESENTA Y CUATRO','Evaluación por porcentaje registrada','APROBADO',1),(174,'45345353','HDC-104',30,20,23,75,80,78,70,75,73,75,80,78,23,0,23,'2026','F','Evaluación por porcentaje registrada','REPROBADO',NULL),(175,'45345353','INT-103',70,80,77,75,80,79,70,75,74,75,80,79,77,0,77,'2026','SETENTA Y SIETE','Evaluación por porcentaje registrada','APROBADO',11),(176,'45345353','MPI-101',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',2),(177,'45345353','OMT-106',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',6),(178,'45345353','PROG-102',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',7),(179,'45345353','TSO-105',70,80,77,75,80,78,70,75,73,75,80,78,77,0,77,'2026','A','Evaluación por porcentaje registrada','APROBADO',NULL);
/*!40000 ALTER TABLE `historial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripcion`
--

DROP TABLE IF EXISTS `inscripcion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscripcion` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ci_est` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `cod_asig` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_sec` int NOT NULL,
  `fecha` date NOT NULL,
  `turno` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `grupo` char(1) COLLATE utf8mb4_spanish_ci NOT NULL,
  `tipo` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL DEFAULT 'Normal',
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  `estado_final` varchar(50) COLLATE utf8mb4_spanish_ci DEFAULT 'EN PROCESO',
  `observaciones` text COLLATE utf8mb4_spanish_ci,
  PRIMARY KEY (`id`),
  KEY `fk_ins_estudiante` (`ci_est`),
  KEY `fk_ins_asignatura` (`cod_asig`),
  KEY `fk_ins_secretaria` (`id_sec`),
  CONSTRAINT `fk_ins_asignatura` FOREIGN KEY (`cod_asig`) REFERENCES `asignatura` (`codigo`),
  CONSTRAINT `fk_ins_estudiante` FOREIGN KEY (`ci_est`) REFERENCES `estudiante` (`ci`),
  CONSTRAINT `fk_ins_secretaria` FOREIGN KEY (`id_sec`) REFERENCES `secretaria` (`id`) ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=260 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripcion`
--

LOCK TABLES `inscripcion` WRITE;
/*!40000 ALTER TABLE `inscripcion` DISABLE KEYS */;
INSERT INTO `inscripcion` VALUES (1,'7685675','MPI-101',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(2,'7685675','PROG-102',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(3,'7685675','INT-103',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(4,'7685675','HDC-104',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(5,'7685675','TSO-105',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(6,'7685675','OMT-106',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(7,'7685675','DPW-107',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(8,'12345678','MPI-101',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(9,'12345678','PROG-102',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(10,'12345678','INT-103',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(11,'12345678','HDC-104',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(12,'12345678','TSO-105',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(13,'12345678','OMT-106',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(14,'12345678','DPW-107',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(15,'4780257','MPI-101',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(16,'4780257','PROG-102',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(17,'4780257','INT-103',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(18,'4780257','HDC-104',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(19,'4780257','TSO-105',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(20,'4780257','OMT-106',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(21,'4780257','DPW-107',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(22,'2736233','MPI-101',1,'2026-06-02','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(23,'2736233','PROG-102',1,'2026-06-02','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(24,'2736233','INT-103',1,'2026-06-02','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(25,'2736233','HDC-104',1,'2026-06-02','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(26,'2736233','TSO-105',1,'2026-06-02','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(27,'2736233','OMT-106',1,'2026-06-02','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(28,'2736233','DPW-107',1,'2026-06-02','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(29,'10203203','MPI-101',1,'2026-06-02','TARDE','B','Regular',1,'EN PROCESO',NULL),(30,'10203203','PROG-102',1,'2026-06-02','TARDE','B','Regular',1,'EN PROCESO',NULL),(31,'10203203','INT-103',1,'2026-06-02','TARDE','B','Regular',1,'EN PROCESO',NULL),(32,'10203203','HDC-104',1,'2026-06-02','TARDE','B','Regular',1,'EN PROCESO',NULL),(33,'10203203','TSO-105',1,'2026-06-02','TARDE','B','Regular',1,'EN PROCESO',NULL),(34,'10203203','OMT-106',1,'2026-06-02','TARDE','B','Regular',1,'EN PROCESO',NULL),(35,'10203203','DPW-107',1,'2026-06-02','TARDE','B','Regular',1,'EN PROCESO',NULL),(36,'10223203','MPI-101',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(37,'10223203','PROG-102',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(38,'10223203','INT-103',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(39,'10223203','HDC-104',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(40,'10223203','TSO-105',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(41,'10223203','OMT-106',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(42,'10223203','DPW-107',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(43,'2222222','MPI-101',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(44,'2222222','PROG-102',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(45,'2222222','INT-103',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(46,'2222222','HDC-104',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(47,'2222222','TSO-105',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(48,'2222222','OMT-106',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(49,'2222222','DPW-107',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(50,'38283283','MPI-101',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(51,'38283283','PROG-102',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(52,'38283283','INT-103',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(53,'38283283','HDC-104',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(54,'38283283','TSO-105',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(55,'38283283','OMT-106',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(56,'38283283','DPW-107',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(57,'7685676','MPI-101',1,'2026-06-02','TARDE','B','Regular',1,'EN PROCESO',NULL),(58,'7685676','PROG-102',1,'2026-06-02','TARDE','B','Regular',1,'EN PROCESO',NULL),(59,'7685676','INT-103',1,'2026-06-02','TARDE','B','Regular',1,'EN PROCESO',NULL),(60,'7685676','HDC-104',1,'2026-06-02','TARDE','B','Regular',1,'EN PROCESO',NULL),(61,'7685676','TSO-105',1,'2026-06-02','TARDE','B','Regular',1,'EN PROCESO',NULL),(62,'7685676','OMT-106',1,'2026-06-02','TARDE','B','Regular',1,'EN PROCESO',NULL),(63,'7685676','DPW-107',1,'2026-06-02','TARDE','B','Regular',1,'EN PROCESO',NULL),(64,'2736234','MPI-101',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(65,'2736234','PROG-102',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(66,'2736234','INT-103',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(67,'2736234','HDC-104',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(68,'2736234','TSO-105',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(69,'2736234','OMT-106',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(70,'2736234','DPW-107',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(71,'48574857','MPI-101',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(72,'48574857','PROG-102',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(73,'48574857','INT-103',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(74,'48574857','HDC-104',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(75,'48574857','TSO-105',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(76,'48574857','OMT-106',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(77,'48574857','DPW-107',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(78,'11239832','MPI-101',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(79,'11239832','PROG-102',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(80,'11239832','INT-103',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(81,'11239832','HDC-104',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(82,'11239832','TSO-105',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(83,'11239832','OMT-106',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(84,'11239832','DPW-107',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(85,'4780223','MPI-101',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(86,'4780223','PROG-102',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(87,'4780223','INT-103',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(88,'4780223','HDC-104',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(89,'4780223','TSO-105',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(90,'4780223','OMT-106',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(91,'4780223','DPW-107',1,'2026-06-02','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(92,'46574343','MPI-101',1,'2026-06-03','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(93,'46574343','PROG-102',1,'2026-06-03','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(94,'46574343','INT-103',1,'2026-06-03','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(95,'46574343','HDC-104',1,'2026-06-03','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(96,'46574343','TSO-105',1,'2026-06-03','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(97,'46574343','OMT-106',1,'2026-06-03','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(98,'46574343','DPW-107',1,'2026-06-03','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(99,'4780252','DPW-107',1,'2026-06-16','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(100,'4780252','HDC-104',1,'2026-06-16','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(101,'4780252','INT-103',1,'2026-06-16','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(102,'4780252','MPI-101',1,'2026-06-16','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(103,'4780252','OMT-106',1,'2026-06-16','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(104,'4780252','PROG-102',1,'2026-06-16','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(105,'4780252','TSO-105',1,'2026-06-16','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(106,'47892832','DPW-107',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(107,'47892832','HDC-104',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(108,'47892832','INT-103',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(109,'47892832','MPI-101',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(110,'47892832','OMT-106',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(111,'47892832','PROG-102',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(112,'47892832','TSO-105',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(113,'2736233','ADS-206',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(114,'2736233','BDD-208',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(115,'2736233','DPW-207',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(116,'2736233','EDD-203',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(117,'2736233','EST-201',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(118,'2736233','PDM-205',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(119,'2736233','PRG-202',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(120,'2736233','RDC-204',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(143,'45645467','DPW-107',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(144,'45645467','HDC-104',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(145,'45645467','INT-103',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(146,'45645467','MPI-101',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(147,'45645467','OMT-106',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(148,'45645467','PROG-102',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(149,'45645467','TSO-105',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(165,'37473743','DPW-107',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(166,'37473743','HDC-104',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(167,'37473743','INT-103',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(168,'37473743','MPI-101',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(169,'37473743','OMT-106',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(170,'37473743','PROG-102',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(171,'37473743','TSO-105',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(172,'190102033','DPW-107',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(173,'190102033','HDC-104',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(174,'190102033','INT-103',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(175,'190102033','MPI-101',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(176,'190102033','OMT-106',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(177,'190102033','PROG-102',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(178,'190102033','TSO-105',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(194,'45463464','DPW-107',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(195,'45463464','HDC-104',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(196,'45463464','INT-103',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(197,'45463464','MPI-101',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(198,'45463464','OMT-106',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(199,'45463464','PROG-102',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(200,'45463464','TSO-105',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(201,'45463464','ADS-206',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(202,'45463464','BDD-208',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(203,'45463464','DPW-207',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(204,'45463464','EDD-203',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(205,'45463464','EST-201',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(206,'45463464','PDM-205',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(207,'45463464','PRG-202',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(208,'45463464','RDC-204',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(216,'121232431','DPW-107',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(217,'121232431','HDC-104',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(218,'121232431','INT-103',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(219,'121232431','MPI-101',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(220,'121232431','OMT-106',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(221,'121232431','PROG-102',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(222,'121232431','TSO-105',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(223,'121232431','ADS-206',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(224,'121232431','BDD-208',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(225,'121232431','DPW-207',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(226,'121232431','EDD-203',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(227,'121232431','EST-201',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(228,'121232431','PDM-205',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(229,'121232431','PRG-202',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(230,'121232431','RDC-204',1,'2026-06-23','MAÑANA','A','BTH',1,'EN PROCESO',NULL),(238,'45345353','DPW-107',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(239,'45345353','HDC-104',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(240,'45345353','INT-103',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(241,'45345353','MPI-101',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(242,'45345353','OMT-106',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(243,'45345353','PROG-102',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL),(244,'45345353','TSO-105',1,'2026-06-23','MAÑANA','A','Regular',1,'EN PROCESO',NULL);
/*!40000 ALTER TABLE `inscripcion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prerequisito`
--

DROP TABLE IF EXISTS `prerequisito`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `prerequisito` (
  `id` int NOT NULL AUTO_INCREMENT,
  `cod_asig` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'Asignatura que requiere un prerequisito',
  `cod_req` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_spanish_ci NOT NULL COMMENT 'Asignatura que funciona como prerequisito',
  PRIMARY KEY (`id`),
  KEY `fk_prereq_asig` (`cod_asig`),
  KEY `fk_prereq_req` (`cod_req`),
  CONSTRAINT `fk_prereq_asig` FOREIGN KEY (`cod_asig`) REFERENCES `asignatura` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_prereq_req` FOREIGN KEY (`cod_req`) REFERENCES `asignatura` (`codigo`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prerequisito`
--

LOCK TABLES `prerequisito` WRITE;
/*!40000 ALTER TABLE `prerequisito` DISABLE KEYS */;
INSERT INTO `prerequisito` VALUES (1,'PRG-202','PROG-102'),(2,'DPW-207','DPW-107'),(3,'DPW-302','DPW-207'),(4,'RDC-304','RDC-204'),(5,'ADS-306','ADS-206'),(6,'PDM-307','PDM-205'),(7,'BDD-308','BDD-208');
/*!40000 ALTER TABLE `prerequisito` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rol`
--

DROP TABLE IF EXISTS `rol`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rol` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_rol_nombre` (`nombre`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rol`
--

LOCK TABLES `rol` WRITE;
/*!40000 ALTER TABLE `rol` DISABLE KEYS */;
INSERT INTO `rol` VALUES (1,'ADMIN','Administrador del sistema con acceso total',1),(2,'SECRETARIA','Secretaria académica, gestiona inscripciones',1),(3,'ESTUDIANTE','Estudiante, consulta y gestión de sus materias',1),(4,'DOCENTE','Docente, gestión de notas y materias asignadas',1);
/*!40000 ALTER TABLE `rol` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `secretaria`
--

DROP TABLE IF EXISTS `secretaria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `secretaria` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_usuario` int NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  KEY `fk_sec_usuario` (`id_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `secretaria`
--

LOCK TABLES `secretaria` WRITE;
/*!40000 ALTER TABLE `secretaria` DISABLE KEYS */;
INSERT INTO `secretaria` VALUES (1,'SECRETARIA CENTRAL',15,1);
/*!40000 ALTER TABLE `secretaria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `clave` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `id_rol` int NOT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`),
  KEY `fk_usu_rol` (`id_rol`),
  CONSTRAINT `fk_usu_rol` FOREIGN KEY (`id_rol`) REFERENCES `rol` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (1,'12345678','123456',3,1),(2,'2222222','123456',3,1),(3,'7685675','123456',3,1),(4,'4780257','123456',3,1),(5,'2736233','123456',3,0),(6,'10203203','123456',3,1),(7,'10223203','123456',3,0),(8,'38283283','123456',3,1),(9,'7685676','123456',3,1),(10,'2736234','123456',3,1),(11,'48574857','123456',3,1),(12,'11239832','123456',3,0),(13,'4780223','123456',3,1),(14,'46574343','123456',3,1),(15,'secretaria','123456',2,1),(16,'admin','123456',1,1),(17,'43221211','123456',3,1),(19,'4780252','123456',3,1),(20,'47892832','123456',3,1),(21,'45645467','123456',3,1),(22,'37473743','123456',3,1),(23,'190102033','123456',3,1),(24,'45463464','123456',3,1),(25,'121232431','123456',3,1),(26,'45345353','123456',3,1),(27,'5511223','123456',3,1),(28,'5522334','123456',3,1),(29,'5533445','123456',3,1),(30,'5544556','123456',3,1),(35,'5550001','123456',4,1),(36,'5550002','123456',4,1),(37,'5550003','123456',4,1),(38,'5550004','123456',4,1),(39,'5550005','123456',4,1),(40,'5550006','123456',4,1),(41,'5550007','123456',4,1),(42,'5550008','123456',4,1),(43,'5550009','123456',4,1),(44,'5550010','123456',4,1),(45,'5550011','123456',4,1);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-09-18  7:08:22
