<?php
require_once __DIR__ . '/../includes/functions.php';
require_role(['employee']);
$pdo = db();
$stats = [
    'pending' => (int) $pdo->query("SELECT COUNT(*) FROM fv_quote_requests WHERE status = 'Em análise'")->fetchColumn(),
    'approved' => (int) $pdo->query("SELECT COUNT(*) FROM fv_quote_requests WHERE status = 'Aprovado'")->fetchColumn(),
    'installation' => (int) $pdo->query("SELECT COUNT(*) FROM fv_quote_requests WHERE status = 'Em instalação'")->fetchColumn(),
    'done' => (int) $pdo->query("SELECT COUNT(*) FROM fv_quote_requests WHERE status = 'Concluído'")->fetchColumn(),
];
$pageTitle = 'Painel do Funcionário';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container section">
    <h1>Painel do Funcionário</h1>
    <div class="stats-grid">
        <div class="stat-card"><p class="kpi"><?= $stats['pending'] ?></p><p>Em análise</p></div>
        <div class="stat-card"><p class="kpi"><?= $stats['approved'] ?></p><p>Aprovados</p></div>
        <div class="stat-card"><p class="kpi"><?= $stats['installation'] ?></p><p>Em instalação</p></div>
        <div class="stat-card"><p class="kpi"><?= $stats['done'] ?></p><p>Concluídos</p></div>
    </div>
    <div class="dashboard-grid" style="margin-top:24px;">
        <div class="panel">
            <h2>Solicitações</h2>
            <p class="muted">Atualize status e registre observações técnicas.</p>
            <a class="btn" href="<?= h(base_url('employee/requests.php')) ?>">Gerenciar solicitações</a>
        </div>
        <div class="panel">
            <h2>Clientes</h2>
            <p class="muted">Visualize os dados cadastrais dos clientes.</p>
            <a class="btn" href="<?= h(base_url('employee/clients.php')) ?>">Ver clientes</a>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
