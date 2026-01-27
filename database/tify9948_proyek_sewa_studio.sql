-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 27 Jan 2026 pada 16.04
-- Versi server: 10.11.14-MariaDB-cll-lve
-- Versi PHP: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tify9948_proyek_sewa_studio`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `booking_studio`
--

CREATE TABLE `booking_studio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `studio_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal_booking` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status_booking` enum('pending','disetujui','selesai','dibatalkan') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `booking_studio`
--

INSERT INTO `booking_studio` (`id`, `user_id`, `studio_id`, `tanggal_booking`, `jam_mulai`, `jam_selesai`, `status_booking`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2026-01-20', '12:00:00', '15:00:00', 'selesai', '2026-01-16 19:18:29', '2026-01-19 02:48:07'),
(2, 2, 2, '2026-01-22', '05:20:00', '07:20:00', 'selesai', '2026-01-18 11:20:33', '2026-01-19 07:23:43'),
(3, 2, 1, '2026-01-26', '09:36:00', '13:36:00', 'disetujui', '2026-01-25 13:36:49', '2026-01-25 15:24:27'),
(4, 3, 3, '2026-01-31', '12:38:00', '16:38:00', 'disetujui', '2026-01-25 16:38:55', '2026-01-25 16:43:53'),
(5, 2, 3, '2026-01-28', '13:28:00', '18:29:00', 'pending', '2026-01-25 17:29:08', '2026-01-25 17:29:08'),
(6, 2, 3, '2026-01-26', '14:41:00', '15:41:00', 'pending', '2026-01-25 19:41:39', '2026-01-25 19:41:39'),
(7, 2, 2, '2026-01-28', '16:09:00', '17:09:00', 'pending', '2026-01-25 21:09:04', '2026-01-25 21:09:04'),
(8, 4, 1, '2026-01-28', '10:10:00', '11:10:00', 'dibatalkan', '2026-01-25 21:10:47', '2026-01-25 21:11:32'),
(9, 5, 2, '2026-01-28', '01:05:00', '02:10:00', 'pending', '2026-01-25 21:12:10', '2026-01-25 21:12:10'),
(10, 6, 2, '2026-01-27', '13:21:00', '17:21:00', 'disetujui', '2026-01-25 21:22:03', '2026-01-25 21:24:35'),
(11, 7, 3, '2026-02-04', '13:00:00', '15:00:00', 'pending', '2026-01-26 23:43:48', '2026-01-26 23:43:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jadwal_studio`
--

CREATE TABLE `jadwal_studio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `studio_id` bigint(20) UNSIGNED NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status` enum('tersedia','terisi') NOT NULL DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_05_084754_create_studio_table', 1),
(5, '2026_01_05_084836_create_booking_studio_table', 1),
(6, '2026_01_05_084936_create_pembayaran_table', 1),
(7, '2026_01_05_085007_create_jadwal_studio_table', 1),
(8, '2026_01_26_000000_add_bukti_pembayaran_to_pembayaran_table', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `booking_id` bigint(20) UNSIGNED NOT NULL,
  `total_bayar` int(11) NOT NULL,
  `metode_bayar` enum('transfer','tunai','ewallet') NOT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status_bayar` enum('lunas','belum_lunas') NOT NULL DEFAULT 'belum_lunas',
  `tanggal_bayar` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pembayaran`
--

INSERT INTO `pembayaran` (`id`, `booking_id`, `total_bayar`, `metode_bayar`, `bukti_pembayaran`, `status_bayar`, `tanggal_bayar`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 'tunai', NULL, 'belum_lunas', '2026-01-17', '2026-01-17 11:48:40', '2026-01-25 21:11:07'),
(2, 2, 130000, 'transfer', 'bukti_pembayaran/bukti_2_1769401345.png', 'belum_lunas', '2026-01-19', '2026-01-18 11:20:33', '2026-01-25 21:22:25'),
(3, 3, 240000, 'tunai', 'bukti_pembayaran/bukti_3_1769496251.jpg', 'belum_lunas', '2026-01-26', '2026-01-25 13:36:49', '2026-01-26 23:45:04'),
(4, 4, 800000, 'transfer', NULL, 'lunas', '2026-01-25', '2026-01-25 16:38:55', '2026-01-25 16:43:39'),
(5, 5, 1003333, 'transfer', NULL, 'lunas', '2026-01-26', '2026-01-25 17:29:08', '2026-01-25 19:46:45'),
(6, 6, 200000, 'transfer', NULL, 'lunas', '2026-01-26', '2026-01-25 19:41:39', '2026-01-25 19:46:32'),
(7, 7, 65000, 'transfer', NULL, 'belum_lunas', NULL, '2026-01-25 21:09:04', '2026-01-25 21:09:04'),
(8, 8, 60000, 'transfer', NULL, 'belum_lunas', NULL, '2026-01-25 21:10:47', '2026-01-25 21:10:47'),
(9, 9, 70417, 'transfer', NULL, 'belum_lunas', NULL, '2026-01-25 21:12:10', '2026-01-25 21:12:10'),
(10, 10, 260000, 'transfer', NULL, 'lunas', '2026-01-26', '2026-01-25 21:22:03', '2026-01-25 21:24:51'),
(11, 11, 400000, 'transfer', NULL, 'belum_lunas', NULL, '2026-01-26 23:43:48', '2026-01-26 23:43:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('5RbpK9ttclyqufoGjSAwBIGH6Veu7wsMoniiPRqe', NULL, '2a09:bac5:3a22:25b9::3c2:2a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiSUNCeHZEc2xuNkNhZEpnOGV4WXd4WXBLTjJ6T2xjT0VqSVk4c282aCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vdGVzdDEudGlmYXcudGlmYXcubXkuaWQiO3M6NToicm91dGUiO3M6Nzoid2VsY29tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769504545),
('5ZnrER2UwixgQdFMMwmrBE1KRyahmhFHEoqNevfZ', NULL, '119.10.176.115', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36 Edg/144.0.0.0', 'YTo4OntzOjY6Il9mbGFzaCI7YToyOntzOjM6Im5ldyI7YTowOnt9czozOiJvbGQiO2E6MDp7fX1zOjY6Il90b2tlbiI7czo0MDoiNm82NnBHeFpXMjZlMlN4ZkpwemFpVTZRcGx6WEp3T2VjaTVScW5UNSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDg6Imh0dHBzOi8vdGVzdDEudGlmYXcudGlmYXcubXkuaWQvY3VzdG9tZXIvcHJvZmlsZSI7czo1OiJyb3V0ZSI7czoxNjoiY3VzdG9tZXIucHJvZmlsZSI7fXM6NzoidXNlcl9pZCI7czoxOiIyIjtzOjQ6Im5hbWUiO3M6ODoibmFiaWxsYWgiO3M6NToiZW1haWwiO3M6MjU6Im5hYmlsbGFodHJzeTQxMkBnbWFpbC5jb20iO3M6NDoicm9sZSI7czo4OiJjdXN0b21lciI7czo1OiJsb2dpbiI7YjoxO30=', 1769502143),
('QLT8YSUsoEKDtFe7mhcqs7IcLjqksJd2UtZIBcmD', NULL, '149.57.180.54', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZ2xwa0NUUHV2UlRCTkkySm9qR0lMejk4U3JoVE10a25uUndkRjZJbyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzE6Imh0dHBzOi8vdGVzdDEudGlmYXcudGlmYXcubXkuaWQiO3M6NToicm91dGUiO3M6Nzoid2VsY29tZSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1769504414),
('zPOMimSdifBiIYqIkLib6ABkVYGCPJgZ6urPl4yx', NULL, '23.27.145.3', 'Mozilla/5.0 (X11; Linux i686; rv:109.0) Gecko/20100101 Firefox/120.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUVBCcEZvMkRCbDZVOThXTVk1TU9IbU1Rc1owdmVXYWxjSGFiZTRuVyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzU6Imh0dHBzOi8vd3d3LnRlc3QxLnRpZmF3LnRpZmF3Lm15LmlkIjtzOjU6InJvdXRlIjtzOjc6IndlbGNvbWUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1769504406);

-- --------------------------------------------------------

--
-- Struktur dari tabel `studio`
--

CREATE TABLE `studio` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga_per_jam` decimal(15,2) NOT NULL,
  `kapasitas` int(11) NOT NULL DEFAULT 1,
  `gambar` varchar(255) DEFAULT NULL,
  `status` enum('tersedia','tidak tersedia') NOT NULL DEFAULT 'tersedia',
  `fasilitas` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `studio`
--

INSERT INTO `studio` (`id`, `nama`, `deskripsi`, `harga_per_jam`, `kapasitas`, `gambar`, `status`, `fasilitas`, `created_at`, `updated_at`) VALUES
(1, 'Product Studio', NULL, 60000.00, 5, 'images/studio/1769347123_product-studio.jpg', 'tersedia', 'AC, lighting, backdrop, dan property', '2026-01-15 22:57:22', '2026-01-25 06:18:43'),
(2, 'Potrait Studio', 'Disini kamu bisa foto dengan fotografer dari kami.', 65000.00, 2, 'images/studio/1769347060_potrait-studio.jpg', 'tersedia', 'AC, lighting, backdrop, fotografer', '2026-01-18 03:32:14', '2026-01-25 06:17:40'),
(3, 'VIP Studio', 'private studio', 200000.00, 25, 'images/studio/1769379657_vip-studio.jpg', 'tersedia', 'AC, lighting, property, background', '2026-01-25 15:20:57', '2026-01-25 15:21:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','customer') NOT NULL DEFAULT 'customer',
  `phone` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `phone`, `address`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'adminfoto@gmail.com', NULL, '$2y$10$ZnGYnTobBlP7CkTCYsmOIe1/5hGKzVQmyZyDnoNfcq0SQ15sj0CGO', 'admin', '081299999999', 'Duren sawit', NULL, '2026-01-09 03:19:06', '2026-01-16 03:19:06'),
(2, 'nabillah', 'nabillahtrsy412@gmail.com', NULL, '$2y$12$20zr3tRWnCze5b1WU6s/KeW4gdyXi6CStvNf8ucbxSUntOZ5CNBb2', 'customer', '089999999999', 'bintara jaya', NULL, '2026-01-15 22:58:01', '2026-01-15 22:58:01'),
(3, 'suazzah', 'suazzah@gmail.com', NULL, '$2y$12$Y45sYEFx1xoU.WkYneJ4bu70.jg.9bTQy06hzS8YphU6EvIfmJ1M6', 'customer', '089777776767', 'Duren Sawit', NULL, '2026-01-25 16:38:15', '2026-01-25 16:38:15'),
(4, 'Suazzah Dwi Atika', 'suazzahatika@gmail.com', NULL, '$2y$12$VRh8apFZSGEoxmWur9aPEedPhUoz8JPBGmeLSKgaHNg2Nm2rqCyFa', 'customer', '083801267484', 'Jalan lembah aren VII no.1A', NULL, '2026-01-25 21:10:28', '2026-01-25 21:10:28'),
(5, 'Novia Trisuci Ramadhani', 'noviatrisuciramadhani@gmail.com', NULL, '$2y$12$/9qRkEYCskH5mhCvvEM9BuiUFBXOx0e0aD1RqpcUpGkU95/IibYLK', 'customer', '085600569315', 'Pondok kopi', NULL, '2026-01-25 21:10:54', '2026-01-25 21:10:54'),
(6, 'Yudha', 'test@gmail.com', NULL, '$2y$12$95tZnQPQv9HpjZa6Hp.RLuUO2BsgnqmEoXESGPr3iVnjNMFzZnNNu', 'customer', '09282829292', '9392022', NULL, '2026-01-25 21:21:19', '2026-01-25 21:21:19'),
(7, 'zahra', 'zahra@gmail.com', NULL, '$2y$12$52H9AyTIkcOxxorfE5nZsOikix1KkzonUupgnxtXScdYi5X037DlG', 'customer', '089765434567', 'Bekasea', NULL, '2026-01-26 23:42:37', '2026-01-26 23:42:37');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `booking_studio`
--
ALTER TABLE `booking_studio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `booking_studio_user_id_foreign` (`user_id`),
  ADD KEY `booking_studio_studio_id_foreign` (`studio_id`);

--
-- Indeks untuk tabel `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `jadwal_studio`
--
ALTER TABLE `jadwal_studio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jadwal_studio_studio_id_foreign` (`studio_id`);

--
-- Indeks untuk tabel `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indeks untuk tabel `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`),
  ADD KEY `pembayaran_booking_id_foreign` (`booking_id`);

--
-- Indeks untuk tabel `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indeks untuk tabel `studio`
--
ALTER TABLE `studio`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `booking_studio`
--
ALTER TABLE `booking_studio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jadwal_studio`
--
ALTER TABLE `jadwal_studio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `studio`
--
ALTER TABLE `studio`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `booking_studio`
--
ALTER TABLE `booking_studio`
  ADD CONSTRAINT `booking_studio_studio_id_foreign` FOREIGN KEY (`studio_id`) REFERENCES `studio` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `booking_studio_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jadwal_studio`
--
ALTER TABLE `jadwal_studio`
  ADD CONSTRAINT `jadwal_studio_studio_id_foreign` FOREIGN KEY (`studio_id`) REFERENCES `studio` (`id`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD CONSTRAINT `pembayaran_booking_id_foreign` FOREIGN KEY (`booking_id`) REFERENCES `booking_studio` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
