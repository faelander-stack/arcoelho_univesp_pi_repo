<?php
require_once __DIR__ . '/../includes/functions.php';
require_role(['client']);
$pdo = db();
$stmt = $pdo->prepare('SELECT * FROM fv_quote_requests WHERE client_user_id = :id ORDER BY created_at DESC');
$stmt->execute(['id' => current_user()['id']]);
$requests = $stmt->fetchAll();
$pageTitle = 'Painel do Cliente';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container section">
    <div class="dashboard-grid">
        <div class="panel">
            <h1>Olá, <?= h(current_user()['name']) ?></h1>
            <p class="muted">Acompanhe seus orçamentos e o andamento da instalação.</p>
            <a class="btn" href="<?= h(base_url('client/request_quote.php')) ?>">Solicitar orçamento</a>
        </div>
        <div class="panel">
            <h2>Status mais recente</h2>
            <p class="muted"><?= $requests ? h($requests[0]['status']) : 'Nenhuma solicitação cadastrada ainda.' ?></p>
        </div>
    </div>
    <div class="card" style="margin-top:24px;">
        <h2>Minhas solicitações</h2>
        <div class="table-wrap">
            <table>
                <tr><th>Data</th><th>Imóvel</th><th>Consumo</th><th>Status</th><th>Observações</th></tr>
                <?php foreach ($requests as $request): ?>
                    <tr>
                        <td><?= h($request['created_at']) ?></td>
                        <td><?= h($request['property_type']) ?></td>
                        <td><?= h($request['energy_consumption']) ?></td>
                        <td><span class="status"><?= h($request['status']) ?></span></td>
                        <td><?= h($request['observations']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
