-- ============================================================================
-- Kedai Cendana Database - MySQL Version
-- Converted from PostgreSQL
-- ============================================================================

-- Drop existing tables if needed (comment out if running for first time)
-- SET FOREIGN_KEY_CHECKS = 0;
-- DROP TABLE IF EXISTS cart_items, carts, reviews, cart_items, addresses, products, categories, articles, sessions, password_reset_tokens, cache_locks, cache, migrations, users;
-- SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================================
-- 1. USERS - Table utama
-- ============================================================================
CREATE TABLE IF NOT EXISTS `users` (
  `id_user` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nama_user` VARCHAR(100),
  `email` VARCHAR(75),
  `password` VARCHAR(255),
  `google_id` VARCHAR(255),
  `google_token` VARCHAR(255),
  `google_refresh_token` VARCHAR(255),
  `role` VARCHAR(50),
  `remember_token` VARCHAR(100),
  `auth_provider` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 2. ADDRESSES - Alamat pengguna
-- ============================================================================
CREATE TABLE IF NOT EXISTS `addresses` (
  `id_alamat` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT NOT NULL,
  `jalan` VARCHAR(255) NOT NULL,
  `kota` VARCHAR(100) NOT NULL,
  `provinsi` VARCHAR(100) NOT NULL,
  `kode_pos` VARCHAR(20) NOT NULL,
  `telepon` VARCHAR(20),
  `is_default` TINYINT(1) DEFAULT 0 NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_user`) REFERENCES `users`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 3. CATEGORIES - Kategori produk
-- ============================================================================
CREATE TABLE IF NOT EXISTS `categories` (
  `id_kategori` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nama_kategori` VARCHAR(150) NOT NULL,
  `deskripsi` LONGTEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 4. PRODUCTS - Produk/barang jualan
-- ============================================================================
CREATE TABLE IF NOT EXISTS `products` (
  `id_produk` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `nama_produk` VARCHAR(200) NOT NULL,
  `id_kategori` INT NOT NULL,
  `deskripsi` LONGTEXT,
  `harga` DECIMAL(12,2) NOT NULL,
  `stok` INT NOT NULL,
  `gambar` VARCHAR(255),
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_kategori`) REFERENCES `categories`(`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 5. CARTS - Keranjang belanja
-- ============================================================================
CREATE TABLE IF NOT EXISTS `carts` (
  `id_keranjang` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_user`) REFERENCES `users`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 6. CART_ITEMS - Item dalam keranjang
-- ============================================================================
CREATE TABLE IF NOT EXISTS `cart_items` (
  `id_item` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_keranjang` INT NOT NULL,
  `id_produk` INT NOT NULL,
  `jumlah` INT DEFAULT 1 NOT NULL,
  `harga_satuan` DECIMAL(12,2) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (`id_keranjang`) REFERENCES `carts`(`id_keranjang`) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`id_produk`) REFERENCES `products`(`id_produk`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 7. REVIEWS - Review/ulasan produk
-- ============================================================================
CREATE TABLE IF NOT EXISTS `reviews` (
  `id_ulasan` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `id_user` INT NOT NULL,
  `id_produk` INT,
  `rating` INT NOT NULL,
  `komentar` LONGTEXT,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CHECK (`rating` >= 1 AND `rating` <= 5),
  FOREIGN KEY (`id_user`) REFERENCES `users`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 8. ARTICLES - Artikel/konten blog
-- ============================================================================
CREATE TABLE IF NOT EXISTS `articles` (
  `id_artikel` BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `judul` VARCHAR(255) NOT NULL,
  `slug` VARCHAR(255) NOT NULL,
  `isi` LONGTEXT NOT NULL,
  `thumbnail` VARCHAR(255),
  `status` VARCHAR(20) DEFAULT 'draft' NOT NULL,
  `views` BIGINT DEFAULT 0,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  CHECK (`status` IN ('draft', 'published')),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 9. SESSIONS - Session pengguna
-- ============================================================================
CREATE TABLE IF NOT EXISTS `sessions` (
  `id` VARCHAR(255) NOT NULL PRIMARY KEY,
  `user_id` BIGINT,
  `ip_address` VARCHAR(45),
  `user_agent` LONGTEXT,
  `payload` LONGTEXT NOT NULL,
  `last_activity` INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 10. PASSWORD_RESET_TOKENS - Token reset password
-- ============================================================================
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL PRIMARY KEY,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 11. CACHE - Sistem cache
-- ============================================================================
CREATE TABLE IF NOT EXISTS `cache` (
  `key` VARCHAR(255) NOT NULL PRIMARY KEY,
  `value` LONGTEXT NOT NULL,
  `expiration` INT NOT NULL,
  INDEX `expiration_idx` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 12. CACHE_LOCKS - Cache locks
-- ============================================================================
CREATE TABLE IF NOT EXISTS `cache_locks` (
  `key` VARCHAR(255) NOT NULL PRIMARY KEY,
  `owner` VARCHAR(255) NOT NULL,
  `expiration` INT NOT NULL,
  INDEX `expiration_idx` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- 13. MIGRATIONS - Tracking migrasi database
-- ============================================================================
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT NOT NULL,
  UNIQUE KEY `migration` (`migration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ============================================================================
-- DATA INSERTION
-- ============================================================================

-- Insert Categories
INSERT INTO `categories` (`id_kategori`, `nama_kategori`, `deskripsi`, `created_at`, `updated_at`) VALUES
(1, 'Pempek Palembang', 'Lorem Ipsum', '2025-09-12 15:39:31', '2025-09-12 15:39:31'),
(2, 'Bakmi Ayam', 'Lorem Ipsum', '2025-09-12 15:39:42', '2025-09-12 15:39:42')
ON DUPLICATE KEY UPDATE `nama_kategori`=VALUES(`nama_kategori`), `deskripsi`=VALUES(`deskripsi`);

-- Insert Products
INSERT INTO `products` (`id_produk`, `nama_produk`, `id_kategori`, `deskripsi`, `harga`, `stok`, `gambar`, `created_at`, `updated_at`) VALUES
(2, 'Bakmi Ayam', 2, 'Lorem Ipsum', 13000.00, 100, 'product-images/01K4ZDF2R8XWAS015AEP3WXZN5.png', '2025-09-12 16:52:17', '2025-09-12 16:52:17')
ON DUPLICATE KEY UPDATE `nama_produk`=VALUES(`nama_produk`), `harga`=VALUES(`harga`), `stok`=VALUES(`stok`);

-- Insert Articles
INSERT INTO `articles` (`id_artikel`, `judul`, `slug`, `isi`, `thumbnail`, `status`, `views`, `created_at`, `updated_at`) VALUES
(1, 'test satu', 'test-1', 'lorem ipsum sit dolor amet', 'article-thumbnails/01K54H06QWWDASAT73144QZ5JS.webp', 'published', 0, '2025-09-14 16:30:16', '2025-09-14 16:32:27')
ON DUPLICATE KEY UPDATE `judul`=VALUES(`judul`), `isi`=VALUES(`isi`), `status`=VALUES(`status`);

-- Insert Migrations
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2025_09_11_142957_create_sessions_table', 1),
(2, '2025_09_12_055441_create_cache_table', 2),
(3, '2025_09_13_165941_create_password_resets_table', 3),
(4, '2025_09_13_174321_create_password_reset_table', 4)
ON DUPLICATE KEY UPDATE `batch`=VALUES(`batch`);

-- Insert Cache data (opsional)
INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('kedai-cendana-cache-356a192b7913b04c54574d18c28d46e6395428ab:timer', 'i:1757867471;', 1757867471),
('kedai-cendana-cache-356a192b7913b04c54574d18c28d46e6395428ab', 'i:1;', 1757867471)
ON DUPLICATE KEY UPDATE `value`=VALUES(`value`), `expiration`=VALUES(`expiration`);

-- ============================================================================
-- INDEXES untuk performa optimal
-- ============================================================================
CREATE INDEX IF NOT EXISTS `idx_addresses_id_user` ON `addresses` (`id_user`);
CREATE INDEX IF NOT EXISTS `idx_carts_id_user` ON `carts` (`id_user`);
CREATE INDEX IF NOT EXISTS `idx_cart_items_id_keranjang` ON `cart_items` (`id_keranjang`);
CREATE INDEX IF NOT EXISTS `idx_cart_items_id_produk` ON `cart_items` (`id_produk`);
CREATE INDEX IF NOT EXISTS `idx_products_id_kategori` ON `products` (`id_kategori`);
CREATE INDEX IF NOT EXISTS `idx_reviews_id_user` ON `reviews` (`id_user`);
CREATE INDEX IF NOT EXISTS `idx_articles_slug` ON `articles` (`slug`);
CREATE INDEX IF NOT EXISTS `idx_articles_status` ON `articles` (`status`);
CREATE INDEX IF NOT EXISTS `idx_sessions_user_id` ON `sessions` (`user_id`);
CREATE INDEX IF NOT EXISTS `idx_sessions_last_activity` ON `sessions` (`last_activity`);

-- ============================================================================
-- Selesai
-- ============================================================================
