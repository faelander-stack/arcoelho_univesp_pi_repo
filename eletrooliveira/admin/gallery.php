<?php
require_once __DIR__ . '/../includes/functions.php';
require_role(['admin']);
$pdo = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $filename = upload_file($_FILES['image'] ?? [], UPLOAD_GALLERY_DIR, ALLOWED_IMAGE_EXTENSIONS);
        if (!$filename) {
            throw new RuntimeException('Selecione uma imagem válida.');
        }
        $stmt = $pdo->prepare('INSERT INTO fv_gallery_images (title, description, image_path) VALUES (:title, :description, :image_path)');
        $stmt->execute([
            'title' => trim($_POST['title'] ?? 'Projeto'),
            'description' => trim($_POST['description'] ?? ''),
            'image_path' => UPLOAD_GALLERY_URL . $filename,
        ]);
        set_flash('success', 'Imagem adicionada com sucesso.');
    } catch (Throwable $e) {
        set_flash('error', $e->getMessage());
    }
    redirect('admin/gallery.php');
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('DELETE FROM fv_gallery_images WHERE id = :id');
    $stmt->execute(['id' => (int) $_GET['delete']]);
    set_flash('success', 'Imagem removida.');
    redirect('admin/gallery.php');
}

$images = $pdo->query('SELECT * FROM fv_gallery_images ORDER BY created_at DESC')->fetchAll();
$pageTitle = 'Galeria';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container section">
    <div class="dashboard-grid">
        <div class="card">
            <h1>Adicionar imagem</h1>
            <form method="post" enctype="multipart/form-data">
                <label>Título</label>
                <input type="text" name="title" required>
                <label>Descrição</label>
                <textarea name="description"></textarea>
                <label>Imagem</label>
                <input type="file" name="image" accept=".jpg,.jpeg,.png,.webp" required>
                <button class="btn" type="submit">Enviar</button>
            </form>
        </div>
        <div class="card">
            <h2>Imagens cadastradas</h2>
            <?php foreach ($images as $image): ?>
                <div style="padding: 14px 0; border-bottom: 1px solid var(--border);">
                    <strong><?= h($image['title']) ?></strong><br>
                    <span class="muted"><?= h($image['description']) ?></span><br>
                    <a class="btn btn-small" href="<?= h(base_url('admin/gallery.php?delete=' . $image['id'])) ?>" onclick="return confirm('Deseja remover esta imagem?')">Excluir</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
