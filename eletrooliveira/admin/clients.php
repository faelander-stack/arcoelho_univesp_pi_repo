<?php
require_once __DIR__ . '/../includes/functions.php';
require_role(['admin', 'employee']);
$pdo = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('UPDATE fv_users SET name=:name, email=:email, phone=:phone, address=:address WHERE id=:id');
    $stmt->execute([
        'name' => trim($_POST['name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'address' => trim($_POST['address'] ?? ''),
        'id' => (int) $_POST['id'],
    ]);
    set_flash('success', 'Dados do cliente atualizados.');
    redirect((current_user()['role'] === 'admin' ? 'admin' : 'employee') . '/clients.php');
}

$clients = $pdo->query('SELECT u.*, c.property_type, c.energy_consumption FROM fv_users u INNER JOIN fv_clients c ON c.user_id = u.id WHERE u.role = "client" ORDER BY u.created_at DESC')->fetchAll();
$pageTitle = 'Clientes';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container section">
    <div class="card">
        <h1>Clientes cadastrados</h1>
        <div class="table-wrap">
            <table>
                <tr><th>Nome</th><th>Email</th><th>Telefone</th><th>Endereço</th><th>Imóvel</th><th>Consumo</th></tr>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><?= h($client['name']) ?></td>
                        <td><?= h($client['email']) ?></td>
                        <td><?= h($client['phone']) ?></td>
                        <td><?= h($client['address']) ?></td>
                        <td><?= h($client['property_type']) ?></td>
                        <td><?= h($client['energy_consumption']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
