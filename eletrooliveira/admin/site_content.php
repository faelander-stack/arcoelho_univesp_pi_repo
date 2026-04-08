<?php
require_once __DIR__ . '/../includes/functions.php';
require_role(['admin']);
$pdo = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['content'] ?? [] as $key => $data) {
        $stmt = $pdo->prepare('UPDATE fv_site_content SET title = :title, body = :body, updated_at = NOW() WHERE content_key = :content_key');
        $stmt->execute([
            'title' => trim($data['title'] ?? ''),
            'body' => trim($data['body'] ?? ''),
            'content_key' => $key,
        ]);
    }
    set_flash('success', 'Conteúdo institucional atualizado.');
    redirect('admin/site_content.php');
}

$content = get_site_content();
$pageTitle = 'Editar Conteúdo';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container section">
    <div class="card">
        <h1>Editar páginas institucionais</h1>
        <form method="post">
            <?php foreach ($content as $key => $item): ?>
                <h3><?= h($item['content_key']) ?></h3>
                <label>Título</label>
                <input type="text" name="content[<?= h($key) ?>][title]" value="<?= h($item['title']) ?>">
                <label>Texto</label>
                <textarea name="content[<?= h($key) ?>][body]"><?= h($item['body']) ?></textarea>
            <?php endforeach; ?>
            <button class="btn" type="submit">Salvar alterações</button>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
