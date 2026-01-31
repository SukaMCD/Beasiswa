# Changelog - Kedai Cendana

Semua perubahan signifikan pada proyek ini akan didokumentasikan di file ini.

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
