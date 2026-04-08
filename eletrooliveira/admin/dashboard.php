<?php
require_once __DIR__ . '/../includes/functions.php';
require_role(['admin']);

$pdo = db();
$stats = [
    'clients' => (int) $pdo->query('SELECT COUNT(*) FROM fv_clients')->fetchColumn(),
    'quotes' => (int) $pdo->query('SELECT COUNT(*) FROM fv_quote_requests')->fetchColumn(),
    'ongoing' => (int) $pdo->query("SELECT COUNT(*) FROM fv_quote_requests WHERE status IN ('Em análise','Aprovado','Em instalação')")->fetchColumn(),
    'completed' => (int) $pdo->query("SELECT COUNT(*) FROM fv_quote_requests WHERE status = 'Concluído'")->fetchColumn(),
];

$pageTitle = 'Painel do Administrador';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container section">
    <h1>Painel do Administrador</h1>
    <div class="stats-grid">
        <div class="stat-card"><p class="kpi"><?= $stats['clients'] ?></p><p>Clientes cadastrados</p></div>
        <div class="stat-card"><p class="kpi"><?= $stats['quotes'] ?></p><p>Solicitações de orçamento</p></div>
        <div class="stat-card"><p class="kpi"><?= $stats['ongoing'] ?></p><p>Projetos em andamento</p></div>
        <div class="stat-card"><p class="kpi"><?= $stats['completed'] ?></p><p>Instalações concluídas</p></div>
    </div>
    <div class="dashboard-grid" style="margin-top: 24px;">
        <div class="panel">
            <h2>Gestão institucional</h2>
            <p class="muted">Edite os textos da página pública e mantenha o conteúdo atualizado.</p>
            <a class="btn" href="<?= h(base_url('admin/site_content.php')) ?>">Editar conteúdo</a>
        </div>
        <div class="panel">
            <h2>Galeria de projetos</h2>
            <p class="muted">Adicione, substitua ou remova imagens dos projetos realizados.</p>
            <a class="btn" href="<?= h(base_url('admin/gallery.php')) ?>">Gerenciar galeria</a>
        </div>
        <div class="panel">
            <h2>Funcionários</h2>
            <p class="muted">Cadastre, edite ou desative funcionários e permissões de acesso.</p>
            <a class="btn" href="<?= h(base_url('admin/employees.php')) ?>">Gerenciar funcionários</a>
        </div>
        <div class="panel">
            <h2>Clientes e relatórios</h2>
            <p class="muted">Consulte a base de clientes e os relatórios gerenciais do sistema.</p>
            <div class="actions">
                <a class="btn" href="<?= h(base_url('admin/clients.php')) ?>">Ver clientes</a>
                <a class="btn btn-secondary" href="<?= h(base_url('admin/reports.php')) ?>">Relatórios</a>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
