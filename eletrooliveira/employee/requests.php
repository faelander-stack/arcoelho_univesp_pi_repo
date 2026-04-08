<?php
require_once __DIR__ . '/../includes/functions.php';
require_role(['employee']);
$pdo = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('UPDATE fv_quote_requests SET status=:status, observations=:observations, updated_by=:updated_by, updated_at=NOW() WHERE id=:id');
    $stmt->execute([
        'status' => $_POST['status'] ?? 'Em análise',
        'observations' => trim($_POST['observations'] ?? ''),
        'updated_by' => current_user()['id'],
        'id' => (int) $_POST['id'],
    ]);
    set_flash('success', 'Solicitação atualizada.');
    redirect('employee/requests.php');
}

$requests = $pdo->query('SELECT qr.*, u.name AS client_name, u.email AS client_email FROM fv_quote_requests qr INNER JOIN fv_users u ON u.id = qr.client_user_id ORDER BY qr.created_at DESC')->fetchAll();
$pageTitle = 'Solicitações';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container section">
    <div class="card">
        <h1>Solicitações de orçamento</h1>
        <?php foreach ($requests as $request): ?>
            <form method="post" class="panel" style="margin-bottom:16px;">
                <input type="hidden" name="id" value="<?= h((string) $request['id']) ?>">
                <strong><?= h($request['client_name']) ?></strong> — <?= h($request['client_email']) ?><br>
                <span class="muted">Endereço: <?= h($request['address']) ?> | Imóvel: <?= h($request['property_type']) ?> | Consumo: <?= h($request['energy_consumption']) ?></span><br>
                <?php if ($request['bill_file']): ?>
                    <a href="<?= h(base_url($request['bill_file'])) ?>" target="_blank">Ver conta anexada</a><br>
                <?php endif; ?>
                <label>Status</label>
                <select name="status">
                    <?php foreach (request_statuses() as $status): ?>
                        <option value="<?= h($status) ?>" <?= $request['status'] === $status ? 'selected' : '' ?>><?= h($status) ?></option>
                    <?php endforeach; ?>
                </select>
                <label>Observações</label>
                <textarea name="observations"><?= h($request['observations']) ?></textarea>
                <button class="btn" type="submit">Salvar atualização</button>
            </form>
        <?php endforeach; ?>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
