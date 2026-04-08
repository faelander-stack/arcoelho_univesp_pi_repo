<?php
require_once __DIR__ . '/../includes/functions.php';
require_role(['admin']);
$pdo = db();

$reports = [
    'Clientes cadastrados' => (int) $pdo->query('SELECT COUNT(*) FROM fv_clients')->fetchColumn(),
    'Solicitações de orçamento' => (int) $pdo->query('SELECT COUNT(*) FROM fv_quote_requests')->fetchColumn(),
    'Projetos em andamento' => (int) $pdo->query("SELECT COUNT(*) FROM fv_quote_requests WHERE status IN ('Em análise', 'Aprovado', 'Em instalação')")->fetchColumn(),
    'Instalações concluídas' => (int) $pdo->query("SELECT COUNT(*) FROM fv_quote_requests WHERE status = 'Concluído'")->fetchColumn(),
];
$pageTitle = 'Relatórios';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container section">
    <div class="card">
        <h1>Relatórios Gerenciais</h1>
        <div class="table-wrap">
            <table>
                <tr><th>Indicador</th><th>Total</th></tr>
                <?php foreach ($reports as $label => $total): ?>
                    <tr><td><?= h($label) ?></td><td><?= h((string) $total) ?></td></tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
