<?php
require_once __DIR__ . '/../config/database.php';

function h(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function redirect(string $path): void
{
    header('Location: ' . base_url($path));
    exit;
}

function set_flash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function get_flash(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool
{
    return current_user() !== null;
}

function require_login(): void
{
    if (!is_logged_in()) {
        set_flash('error', 'Faça login para continuar.');
        redirect('login.php');
    }
}

function require_role(array $roles): void
{
    require_login();
    $user = current_user();
    if (!in_array($user['role'], $roles, true)) {
        set_flash('error', 'Você não possui permissão para acessar esta área.');
        redirect('index.php');
    }
}

function role_label(string $role): string
{
    return match ($role) {
        'admin' => 'Administrador',
        'employee' => 'Funcionário',
        'client' => 'Cliente',
        default => 'Usuário',
    };
}

function request_statuses(): array
{
    return ['Em análise', 'Aprovado', 'Em instalação', 'Concluído'];
}

function get_site_content(): array
{
    $stmt = db()->query('SELECT content_key, title, body FROM fv_site_content');
    $items = [];
    foreach ($stmt->fetchAll() as $row) {
        $items[$row['content_key']] = $row;
    }
    return $items;
}

function get_gallery_images(): array
{
    $stmt = db()->query('SELECT * FROM fv_gallery_images WHERE is_active = 1 ORDER BY created_at DESC');
    return $stmt->fetchAll();
}

function normalize_filename(string $filename): string
{
    $filename = preg_replace('/[^a-zA-Z0-9._-]/', '_', $filename);
    return time() . '_' . $filename;
}

function upload_file(array $file, string $targetDir, array $allowedExtensions): ?string
{
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return null;
    }

    if (($file['size'] ?? 0) > MAX_UPLOAD_SIZE) {
        throw new RuntimeException('Arquivo excede o tamanho máximo de 5 MB.');
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($extension, $allowedExtensions, true)) {
        throw new RuntimeException('Tipo de arquivo não permitido.');
    }

    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0775, true);
    }

    $filename = normalize_filename($file['name']);
    $destination = rtrim($targetDir, '/') . '/' . $filename;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        throw new RuntimeException('Falha ao salvar o arquivo enviado.');
    }

    return $filename;
}

function dashboard_path_for_role(string $role): string
{
    return match ($role) {
        'admin' => 'admin/dashboard.php',
        'employee' => 'employee/dashboard.php',
        default => 'client/dashboard.php',
    };
}
