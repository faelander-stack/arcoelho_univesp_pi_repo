<?php
$pageTitle = 'Página Institucional';
require_once __DIR__ . '/includes/header.php';
$content = get_site_content();
$gallery = get_gallery_images();
?>
<section class="hero">
    <div class="container hero-grid">
        <div>
            <span class="badge">Energia solar com gestão digital</span>
            <h1><?= h($content['hero']['title'] ?? 'Projetos fotovoltaicos com orçamentos, cadastros e acompanhamento em um só sistema') ?></h1>
            <p class="muted"><?= nl2br(h($content['hero']['body'] ?? 'Automatize relatórios, organize clientes, acompanhe instalações e mantenha o site institucional atualizado por meio do painel administrativo.')) ?></p>
            <div class="actions">
                <a class="btn" href="<?= h(base_url('register.php')) ?>">Solicitar cadastro</a>
                <a class="btn btn-secondary" href="#projetos">Ver projetos</a>
            </div>
        </div>
        <div class="card">
            <h3>Recursos principais</h3>
            <ul>
                <li>Cadastro de clientes e funcionários</li>
                <li>Solicitação e acompanhamento de orçamentos</li>
                <li>Atualização de status em tempo quase real</li>
                <li>Relatórios gerenciais centralizados</li>
            </ul>
        </div>
    </div>
</section>

<section id="quem-somos" class="section">
    <div class="container grid-2">
        <div class="panel">
            <h2><?= h($content['about']['title'] ?? 'Quem somos') ?></h2>
            <p class="muted"><?= nl2br(h($content['about']['body'] ?? 'Somos uma empresa especializada em soluções fotovoltaicas, com foco em dimensionamento, instalação, monitoramento e relacionamento digital com o cliente.')) ?></p>
        </div>
        <div class="panel">
            <h2><?= h($content['services']['title'] ?? 'Serviços oferecidos') ?></h2>
            <p class="muted"><?= nl2br(h($content['services']['body'] ?? 'Projetos residenciais, comerciais e rurais, homologação, manutenção preventiva, análise de consumo e acompanhamento completo da instalação.')) ?></p>
        </div>
    </div>
</section>

<section id="energia-solar" class="section">
    <div class="container cards-grid">
        <article class="card">
            <h3><?= h($content['solar_info']['title'] ?? 'Como funciona a energia solar fotovoltaica') ?></h3>
            <p class="muted"><?= nl2br(h($content['solar_info']['body'] ?? 'Os módulos solares convertem a radiação do sol em energia elétrica. O inversor transforma essa energia para uso no imóvel e o excedente pode gerar créditos na distribuidora.')) ?></p>
        </article>
        <article class="card">
            <h3><?= h($content['advantages']['title'] ?? 'Vantagens do sistema') ?></h3>
            <p class="muted"><?= nl2br(h($content['advantages']['body'] ?? 'Redução da conta de luz, previsibilidade de custos, valorização do imóvel, sustentabilidade e retorno financeiro no médio e longo prazo.')) ?></p>
        </article>
        <article class="card">
            <h3><?= h($content['economy']['title'] ?? 'Economia e retorno') ?></h3>
            <p class="muted"><?= nl2br(h($content['economy']['body'] ?? 'Ao analisar o consumo do cliente, o sistema permite registrar a demanda mensal e gerar orçamentos compatíveis com o potencial de economia esperado.')) ?></p>
        </article>
    </div>
</section>

<section id="vantagens" class="section">
    <div class="container stats-grid">
        <div class="stat-card"><p class="kpi">24h</p><p>acesso ao painel</p></div>
        <div class="stat-card"><p class="kpi">3 perfis</p><p>admin, funcionário e cliente</p></div>
        <div class="stat-card"><p class="kpi">100%</p><p>dados centralizados no banco</p></div>
        <div class="stat-card"><p class="kpi">1 painel</p><p>para relatórios e acompanhamento</p></div>
    </div>
</section>

<section id="projetos" class="section">
    <div class="container">
        <h2>Projetos realizados</h2>
        <p class="muted">As imagens abaixo podem ser incluídas, removidas e substituídas pelo administrador.</p>
        <div class="gallery-grid">
            <?php if ($gallery): ?>
                <?php foreach ($gallery as $image): ?>
                    <article class="card gallery-item">
                        <img src="<?= h(base_url($image['image_path'])) ?>" alt="<?= h($image['title']) ?>">
                        <h3><?= h($image['title']) ?></h3>
                        <p class="muted"><?= h($image['description']) ?></p>
                    </article>
                <?php endforeach; ?>
            <?php else: ?>
                <article class="card">
                    <h3>Galeria pronta para uso</h3>
                    <p class="muted">Cadastre as imagens no painel do administrador para exibir seus projetos reais.</p>
                </article>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
