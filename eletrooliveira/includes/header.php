<?php
require_once __DIR__ . '/functions.php';
$flash = get_flash();
$user = current_user();
$content = get_site_content();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? h($pageTitle) . ' | ' : '' ?><?= h(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= h(base_url('assets/css/style.css')) ?>">
</head>
<body>
<header class="site-header">
    <div class="container navbar">
        <a class="brand" href="<?= h(base_url('index.php')) ?>">Eletro Oliveira Energia Solar</a>
        <nav>
            <ul class="nav-links">
                <li><a href="<?= h(base_url('index.php#quem-somos')) ?>">Quem somos</a></li>
                <li><a href="<?= h(base_url('index.php#servicos')) ?>">Serviços</a></li>
                <li><a href="<?= h(base_url('index.php#energia-solar')) ?>">Energia solar</a></li>
                <li><a href="<?= h(base_url('index.php#vantagens')) ?>">Vantagens</a></li>
                <li><a href="<?= h(base_url('index.php#projetos')) ?>">Projetos</a></li>
                <?php if ($user): ?>
                    <li><a href="<?= h(base_url(dashboard_path_for_role($user['role']))) ?>">Painel</a></li>
                    <li><a href="<?= h(base_url('logout.php')) ?>">Sair</a></li>
                <?php else: ?>
                    <li><a href="<?= h(base_url('login.php')) ?>">Entrar</a></li>
                    <li><a class="btn btn-small" href="<?= h(base_url('register.php')) ?>">Cadastrar</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<?php if ($flash): ?>
    <div class="container">
        <div class="alert alert-<?= h($flash['type']) ?>"><?= h($flash['message']) ?></div>
    </div>
<?php endif; ?>
