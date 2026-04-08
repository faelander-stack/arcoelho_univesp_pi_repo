<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('APP_NAME', 'FV Solar Gestão');
define('BASE_URL', 'https://appspiunivesp2026.infinityfreeapp.com/eletrooliveira');

define('DB_HOST', 'host_do_site');
define('DB_NAME', 'if0_41358857_eletrooliveira');
define('DB_USER', 'usuario_do_banco');
define('DB_PASS', 'senha_do_banco');

define('UPLOAD_GALLERY_DIR', __DIR__ . '/../uploads/gallery/');
define('UPLOAD_BILL_DIR', __DIR__ . '/../uploads/bills/');
define('UPLOAD_GALLERY_URL', 'uploads/gallery/');
define('UPLOAD_BILL_URL', 'uploads/bills/');

define('ALLOWED_IMAGE_EXTENSIONS', ['jpg', 'jpeg', 'png', 'webp']);
define('ALLOWED_BILL_EXTENSIONS', ['pdf', 'jpg', 'jpeg', 'png']);
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024);

function base_url(string $path = ''): string
{
    $base = rtrim(BASE_URL, '/');
    $path = ltrim($path, '/');
    return $base === '' ? '/' . $path : $base . '/' . $path;
}
