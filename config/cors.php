<?php

return [
    'paths' => ['*'],  // Atau ['register'] jika hanya ingin memberi izin untuk endpoint register

    'allowed_methods' => ['*'],  // Semua metode HTTP diperbolehkan (GET, POST, PUT, DELETE, dll.)

    'allowed_origins' => ['http://localhost:5174'],  // Sesuaikan dengan URL frontend kamu

    'allowed_origins_patterns' => [],  // Jika tidak diperlukan, bisa dikosongkan

    'allowed_headers' => ['*'],  // Semua header diperbolehkan

    'exposed_headers' => [],  // Tidak ada header yang perlu dipaparkan

    'max_age' => 0,  // Menentukan waktu dalam detik untuk cache preflight request

    'supports_credentials' => true,  // Set ke true jika kamu perlu menggunakan cookies atau otentikasi berbasis sesi
];

