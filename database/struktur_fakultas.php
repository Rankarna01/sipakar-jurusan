<?php
/**
 * Struktur Fakultas & Jurusan (Terkoreksi)
 * ============================================================
 * Disusun mengikuti struktur fakultas yang lazim di PTN Indonesia:
 * - Farmasi, Keperawatan, Gizi dipisah dari Fakultas Kedokteran
 *   (di UI/UGM/UNAIR/UNPAD dll, ini adalah fakultas tersendiri)
 * - Teknik Informatika & Sistem Informasi dikelompokkan bersama
 *   rumpun Ilmu Komputer/Fasilkom
 * - Pendidikan Olahraga digabung dengan Ilmu Keolahragaan (FIK)
 * - Ilmu Perpustakaan masuk rumpun Ilmu Budaya/Bahasa
 * - Peternakan & Perikanan dipisah dari Fakultas Pertanian
 *   (mengikuti struktur IPB, UNHAS, dll)
 */

return [
    'Kedokteran' => ['icon' => 'bi-heart-pulse-fill', 'jurusan' => ['Kedokteran', 'Kedokteran Gigi']],
    'Farmasi' => ['icon' => 'bi-capsule', 'jurusan' => ['Farmasi']],
    'Ilmu Keperawatan' => ['icon' => 'bi-bandaid-fill', 'jurusan' => ['Keperawatan']],
    'Kesehatan Masyarakat dan Gizi' => ['icon' => 'bi-clipboard-pulse', 'jurusan' => ['Gizi']],
    'Kedokteran Hewan' => ['icon' => 'bi-heart-pulse', 'jurusan' => ['Kedokteran Hewan']],

    'Teknik' => ['icon' => 'bi-gear-fill', 'jurusan' => ['Teknik Elektro', 'Teknik Mesin', 'Teknik Sipil', 'Teknik Industri', 'Arsitektur', 'Teknik Kimia', 'Teknik Lingkungan', 'Teknik Perkapalan']],
    'Ilmu Komputer' => ['icon' => 'bi-cpu-fill', 'jurusan' => ['Teknik Informatika', 'Sistem Informasi', 'Ilmu Komputer', 'Teknik Komputer', 'Data Science', 'Keamanan Siber']],
    'Geografi dan Perencanaan' => ['icon' => 'bi-globe-asia-australia', 'jurusan' => ['Geografi', 'Perencanaan Wilayah dan Kota']],

    'Ekonomi dan Bisnis' => ['icon' => 'bi-graph-up-arrow', 'jurusan' => ['Manajemen', 'Akuntansi', 'Ekonomi Pembangunan', 'Bisnis Digital', 'Perbankan dan Keuangan']],
    'Hukum' => ['icon' => 'bi-bank2', 'jurusan' => ['Ilmu Hukum']],

    'Pendidikan' => ['icon' => 'bi-mortarboard-fill', 'jurusan' => ['Pendidikan Guru Sekolah Dasar', 'Pendidikan Matematika', 'Pendidikan Bahasa Inggris', 'Bimbingan dan Konseling']],
    'Ilmu Keolahragaan' => ['icon' => 'bi-trophy-fill', 'jurusan' => ['Ilmu Keolahragaan', 'Pendidikan Olahraga']],
    'Psikologi' => ['icon' => 'bi-emoji-smile-fill', 'jurusan' => ['Psikologi']],

    'MIPA' => ['icon' => 'bi-atom', 'jurusan' => ['Matematika', 'Fisika', 'Kimia', 'Biologi', 'Statistika', 'Aktuaria']],

    'Ilmu Sosial dan Politik' => ['icon' => 'bi-people-fill', 'jurusan' => ['Ilmu Pemerintahan', 'Sosiologi', 'Hubungan Internasional', 'Ilmu Administrasi Negara', 'Ilmu Politik']],
    'Ilmu Komunikasi' => ['icon' => 'bi-broadcast', 'jurusan' => ['Ilmu Komunikasi', 'Jurnalistik']],
    'Ilmu Budaya' => ['icon' => 'bi-translate', 'jurusan' => ['Sastra Indonesia', 'Sastra Inggris', 'Ilmu Perpustakaan']],

    'Pertanian' => ['icon' => 'bi-flower1', 'jurusan' => ['Agroteknologi', 'Agribisnis', 'Kehutanan', 'Ilmu dan Teknologi Pangan']],
    'Peternakan' => ['icon' => 'bi-egg-fried', 'jurusan' => ['Peternakan']],
    'Perikanan dan Ilmu Kelautan' => ['icon' => 'bi-water', 'jurusan' => ['Perikanan']],

    'Seni dan Desain' => ['icon' => 'bi-palette-fill', 'jurusan' => ['Desain Komunikasi Visual', 'Seni Musik', 'Desain Produk']],
];
