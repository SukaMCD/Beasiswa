# Changelog - Kedai Cendana

Semua perubahan signifikan pada proyek ini akan didokumentasikan di file ini.

## [1.2.0] - 2026-02-01

### Added

- Berkas `LICENSE` baru (Non-commercial All Rights Reserved).
- Berkas `ppt_data.json` berisi data konten untuk kebutuhan presentasi (16 slide).
- Bagian dokumentasi teknis di `README.md` yang menghubungkan ke diagram ERD dan Flowchart.

### Changed

- Perubahan lisensi proyek dari MIT ke Non-commercial All Rights Reserved oleh **SukaMCD**.
- Pembaruan jam operasional pada footer (10:00 - 21:00/22:00).
- Optimalisasi konten pada halaman Beranda (Tentang Kami, Visi & Misi) menjadi lebih ringkas.
- Update meta tags SEO (Judul & Gambar Open Graph).
- Penyederhanaan form kontak (menghapus referensi "Ulasan").

### Fixed

- Penyesuaian tautan dokumentasi di `README.md` menggunakan path relatif.
- Perbaikan minor pada layout modal tentang kami.

## [1.1.0] - 2026-01-31

### Added

- Implementasi **Firebase Cloud Messaging (FCM)** untuk notifikasi push.
- Model dan Migrasi baru untuk `fcm_tokens`.
- Dashboard Admin & User Notification via FCM.
- `firebase-messaging-sw.js` untuk dukungan notifikasi background.
- `fcm.js` untuk manajemen token di sisi klien.
- `OrderObserver` untuk otomatisasi pengiriman notifikasi saat pembuatan/pembaruan pesanan.

### Changed

- Migrasi dari sistem WebPush legacy (VAPID) ke Firebase Admin SDK untuk stabilitas lebih baik.
- Update `User` model untuk mendukung relasi `fcmTokens`.
- Update `README.md` dengan informasi teknologi Firebase.

### Fixed

- Perbaikan error `Undefined method 'updatePushSubscription'`.
- Perbaikan isu VAPID key length pada lingkungan Windows.
- Perbaikan notifikasi double (duplikat) dengan menggunakan _data-only payload_.
- Perbaikan aksi klik pada notifikasi yang sebelumnya tidak mengarah ke URL tujuan.

## [1.0.0] - 2026-01-20

- Rilis awal aplikasi Kedai Cendana.
- Fitur E-commerce dasar (Menu, Cart, Checkout).
- Integrasi Xendit Payment Gateway.
- Autentikasi Google.
