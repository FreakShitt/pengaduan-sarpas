-- MySQL dump 10.13  Distrib 8.0.30, for Win64 (x86_64)
--
-- Host: localhost    Database: pengaduan-sarpas
-- ------------------------------------------------------
-- Server version	8.0.30

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `barang`
--

DROP TABLE IF EXISTS `barang`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `barang` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `barang`
--

LOCK TABLES `barang` WRITE;
/*!40000 ALTER TABLE `barang` DISABLE KEYS */;
INSERT INTO `barang` VALUES (1,'Ruang Kelas 7A','Meja Siswa','Meja untuk siswa',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(2,'Ruang Kelas 7A','Kursi Siswa','Kursi untuk siswa',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(3,'Ruang Kelas 7A','Papan Tulis','Whiteboard',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(4,'Ruang Kelas 7A','AC','Air Conditioner',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(5,'Ruang Kelas 7A','Kipas Angin','Kipas angin langit-langit',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(6,'Ruang Kelas 7A','Lampu','Lampu LED',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(7,'Ruang Kelas 7A','Proyektor','LCD Proyektor',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(8,'Ruang Kelas 7B','Meja Siswa','Meja untuk siswa',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(9,'Ruang Kelas 7B','Kursi Siswa','Kursi untuk siswa',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(10,'Ruang Kelas 7B','Papan Tulis','Whiteboard',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(11,'Ruang Kelas 7B','AC','Air Conditioner',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(12,'Ruang Kelas 7B','Kipas Angin','Kipas angin langit-langit',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(13,'Ruang Kelas 7B','Lampu','Lampu LED',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(14,'Lab Komputer','Komputer PC','PC Desktop',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(15,'Lab Komputer','Monitor','Monitor LCD',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(16,'Lab Komputer','Keyboard','Keyboard USB',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(17,'Lab Komputer','Mouse','Mouse USB',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(18,'Lab Komputer','Meja Komputer','Meja untuk PC',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(19,'Lab Komputer','Kursi Putar','Kursi putar untuk lab',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(20,'Lab Komputer','AC','Air Conditioner',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(21,'Lab Komputer','Proyektor','LCD Proyektor',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(22,'Lab IPA','Mikroskop','Mikroskop untuk praktikum',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(23,'Lab IPA','Bunsen Burner','Pembakar bunsen',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(24,'Lab IPA','Tabung Reaksi','Set tabung reaksi',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(25,'Lab IPA','Meja Praktikum','Meja praktikum IPA',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(26,'Lab IPA','Kursi Lab','Kursi tinggi untuk lab',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(27,'Lab IPA','Lemari Alat','Lemari penyimpanan alat',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(28,'Lab IPA','Wastafel','Wastafel untuk cuci tangan',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(29,'Perpustakaan','Rak Buku','Rak untuk menyimpan buku',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(30,'Perpustakaan','Meja Baca','Meja untuk membaca',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(31,'Perpustakaan','Kursi Baca','Kursi untuk membaca',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(32,'Perpustakaan','AC','Air Conditioner',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(33,'Perpustakaan','Lampu Baca','Lampu untuk area baca',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(34,'Perpustakaan','Komputer Katalog','PC untuk katalog buku',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(35,'Toilet Lt. 1','Kloset','Toilet duduk',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(36,'Toilet Lt. 1','Wastafel','Wastafel cuci tangan',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(37,'Toilet Lt. 1','Kran Air','Kran air',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(38,'Toilet Lt. 1','Cermin','Cermin dinding',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(39,'Toilet Lt. 1','Exhaust Fan','Kipas exhaust',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(40,'Toilet Lt. 1','Lampu','Lampu toilet',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(41,'Kantin','Meja Makan','Meja untuk makan',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(42,'Kantin','Kursi Makan','Kursi untuk makan',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(43,'Kantin','Wastafel','Tempat cuci tangan',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(44,'Kantin','Kipas Angin','Kipas angin dinding',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(45,'Lapangan Olahraga','Ring Basket','Ring basket outdoor',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(46,'Lapangan Olahraga','Net Voli','Net untuk voli',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(47,'Lapangan Olahraga','Gawang Futsal','Gawang untuk futsal',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(48,'Lapangan Olahraga','Lampu Taman','Lampu penerangan lapangan',1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(49,'Aula','speaker','Barang baru request dari pengaduan',1,'2025-11-11 14:14:22','2025-11-11 14:14:22');
/*!40000 ALTER TABLE `barang` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `item_requests`
--

DROP TABLE IF EXISTS `item_requests`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `item_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `requested_by` bigint unsigned NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `reviewed_by` bigint unsigned DEFAULT NULL,
  `review_note` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `item_requests_requested_by_foreign` (`requested_by`),
  KEY `item_requests_reviewed_by_foreign` (`reviewed_by`),
  CONSTRAINT `item_requests_requested_by_foreign` FOREIGN KEY (`requested_by`) REFERENCES `user` (`id`) ON DELETE CASCADE,
  CONSTRAINT `item_requests_reviewed_by_foreign` FOREIGN KEY (`reviewed_by`) REFERENCES `user` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `item_requests`
--

LOCK TABLES `item_requests` WRITE;
/*!40000 ALTER TABLE `item_requests` DISABLE KEYS */;
INSERT INTO `item_requests` VALUES (1,'Aula','speaker','Barang baru request dari pengaduan',6,'approved',4,'Item telah disetujui dan ditambahkan ke daftar barang.','2025-11-11 14:07:31','2025-11-11 14:14:22');
/*!40000 ALTER TABLE `item_requests` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `lokasi`
--

DROP TABLE IF EXISTS `lokasi`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `lokasi` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi` text COLLATE utf8mb4_unicode_ci,
  `aktif` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `lokasi`
--

LOCK TABLES `lokasi` WRITE;
/*!40000 ALTER TABLE `lokasi` DISABLE KEYS */;
INSERT INTO `lokasi` VALUES (1,'Ruang Kelas 7A',NULL,1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(2,'Ruang Kelas 7B',NULL,1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(3,'Ruang Kelas 8A',NULL,1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(4,'Ruang Kelas 8B',NULL,1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(5,'Ruang Kelas 9A',NULL,1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(6,'Ruang Kelas 9B',NULL,1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(7,'Lab Komputer',NULL,1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(8,'Lab IPA',NULL,1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(9,'Perpustakaan',NULL,1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(10,'Ruang Guru',NULL,1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(11,'Kantin',NULL,1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(12,'Toilet Lt. 1',NULL,1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(13,'Toilet Lt. 2',NULL,1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(14,'Lapangan Olahraga',NULL,1,'2025-11-06 05:59:07','2025-11-06 05:59:07'),(15,'Aula',NULL,1,'2025-11-06 05:59:07','2025-11-06 05:59:07');
/*!40000 ALTER TABLE `lokasi` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2025_09_09_114424_create_pengaduans_table',1),(5,'2025_10_30_011250_create_user_table',1),(6,'2025_10_30_072439_add_petugas_role_to_user_table',1),(7,'2025_10_30_073418_add_catatan_petugas_to_pengaduans_table',1),(8,'2025_10_30_184658_update_status_enum_in_pengaduans_table',1),(9,'2025_10_31_122708_create_lokasi_table',1),(10,'2025_10_31_122722_create_barang_table',1),(11,'2025_10_31_124752_add_admin_role_to_user_table',1),(12,'2025_11_03_131528_add_aktif_column_to_lokasi_table',1),(13,'2025_11_03_131551_add_aktif_column_to_barang_table',1),(14,'2025_11_03_132109_modify_barang_table_structure',1),(15,'2025_11_03_153950_add_temporary_item_to_pengaduans_table',1),(16,'2025_11_03_154002_add_temporary_item_to_pengaduans_table',1),(17,'2025_11_03_154059_create_item_requests_table',1),(18,'2025_11_05_133924_create_personal_access_tokens_table',1),(19,'2025_11_10_124535_modify_pengaduans_user_id_to_bigint',2),(20,'2025_11_10_124557_add_foreign_keys_to_item_requests',3),(23,'2025_11_11_111744_change_role_to_pengadu_in_user_table',4),(24,'2025_11_11_193144_add_petugas_id_to_pengaduans_table',4),(25,'2025_11_11_193722_delete_non_admin_users',4),(26,'2025_11_11_203409_fix_petugas_id_foreign_key_in_pengaduans_table',5);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pengaduans`
--

DROP TABLE IF EXISTS `pengaduans`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `pengaduans` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned NOT NULL,
  `petugas_id` bigint unsigned DEFAULT NULL,
  `lokasi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `barang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_temporary_item` tinyint(1) NOT NULL DEFAULT '0',
  `detail_laporan` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `gambar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('diajukan','diproses','selesai','ditolak') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'diajukan',
  `catatan_petugas` text COLLATE utf8mb4_unicode_ci,
  `catatan_admin` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `pengaduans_user_id_foreign` (`user_id`),
  KEY `pengaduans_petugas_id_foreign` (`petugas_id`),
  CONSTRAINT `pengaduans_petugas_id_foreign` FOREIGN KEY (`petugas_id`) REFERENCES `user` (`id`) ON DELETE SET NULL,
  CONSTRAINT `pengaduans_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pengaduans`
--

LOCK TABLES `pengaduans` WRITE;
/*!40000 ALTER TABLE `pengaduans` DISABLE KEYS */;
INSERT INTO `pengaduans` VALUES (1,6,5,'Ruang Kelas','Kursi',0,'kursi kurang 3 di ruang kelas 12',NULL,'diproses','sedang proses peninjauan dan ambil di gudang sekolah',NULL,'2025-11-11 13:30:48','2025-11-11 13:43:39'),(2,6,5,'Laboratorium IPA','Wastafel',0,'saluran penyedot mampet',NULL,'diproses','segera kesana',NULL,'2025-11-11 13:50:13','2025-11-11 13:53:13'),(3,6,NULL,'Ruang Kelas','AC',0,'ac rusak ga dingin di kela s5',NULL,'diajukan',NULL,NULL,'2025-11-11 14:03:23','2025-11-11 14:03:23'),(4,6,7,'Aula','speaker',1,'speaker rusak',NULL,'diproses','baru dibelikan speaker baru',NULL,'2025-11-11 14:07:31','2025-11-11 14:08:46'),(5,6,7,'Aula','speaker',0,'speaker rusak lagi',NULL,'diproses','mau di beli lagi',NULL,'2025-11-11 14:31:06','2025-11-11 14:31:26');
/*!40000 ALTER TABLE `pengaduans` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  KEY `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
INSERT INTO `personal_access_tokens` VALUES (1,'App\\Models\\User',1,'mobile-app','de7e8790d858fa4af3d8018cf8ccf8ae4cead8ba109e6b4621ad8dce8c2e9754','[\"*\"]','2025-11-06 02:34:28',NULL,'2025-11-06 02:14:12','2025-11-06 02:34:28'),(2,'App\\Models\\User',2,'mobile-app','8f78c0b50788823377173ed5d3929cc92329b00192fac980a3c5021cd9709e72','[\"*\"]','2025-11-06 02:40:14',NULL,'2025-11-06 02:39:46','2025-11-06 02:40:14'),(15,'App\\Models\\User',3,'mobile-app','180b090d90805cb9302dd69f580335190eb0e6dce3a3cec2232100ec1c550a98','[\"*\"]','2025-11-06 07:32:38',NULL,'2025-11-06 07:28:48','2025-11-06 07:32:38');
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('7XPqnWl7pupDzY2HGDbVafXxM9sw1xake5B7zvIi',5,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','YTo0OntzOjY6Il90b2tlbiI7czo0MDoiTTllNHRJZmh1TGhPVEhDQmhNMDdOT0xYWHI0TUtGQXlHckdQZ0lqUyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJuZXciO2E6MDp7fXM6Mzoib2xkIjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Mjc6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9sb2dpbiI7fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7fQ==',1762761955),('kRgCXlZV2JuM9MGZoHSRYUkQcuCCgyb7CsyLOJHH',NULL,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/142.0.0.0 Safari/537.36','YToyOntzOjY6Il90b2tlbiI7czo0MDoialF5d2xDeGh6Z2tnM3hjRWdXVFpxWnBENU92ZHF6VDdBM09naUs4dSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',1762761961);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama_pengguna` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('guru','siswa','petugas','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_username_unique` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (4,'Administrator','admin','$2y$12$/mqbde8T/alnzBA6nT/J2eNt2V0O9RMu3cuw/pBEtbODPruyIdjvy','admin',NULL,'2025-11-06 03:40:04','2025-11-06 03:40:04'),(5,'Rahmat Gunawan','Gunawan','$2y$12$KYS.mfBt4NIZW3poZ2NZ7.0Z.NRa8IV72yKQbJzvnhm07a.3b6qHe','petugas',NULL,'2025-11-11 13:23:24','2025-11-11 13:23:24'),(6,'Satrio Parikesit','Parikesit','$2y$12$GGkPc7C3f.ONQjBIHprH3OUrcR.DsF60CyTqWDsmH6tl7QF4C9Qu6','siswa',NULL,'2025-11-11 13:29:31','2025-11-11 13:29:31'),(7,'Muhammad Afiq','Afiq','$2y$12$3EeTc2Gs7CYevTwWRRZvmeNt7ZETFTeenzk65YyfqJRwInf8IPz1C','petugas',NULL,'2025-11-11 13:59:35','2025-11-11 13:59:35');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-11-13 11:41:01
