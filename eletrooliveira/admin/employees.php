<?php
require_once __DIR__ . '/../includes/functions.php';
require_role(['admin']);
$pdo = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'create';
    $payload = [
        'name' => trim($_POST['name'] ?? ''),
        'email' => trim($_POST['email'] ?? ''),
        'phone' => trim($_POST['phone'] ?? ''),
        'address' => trim($_POST['address'] ?? ''),
    ];

    if ($action === 'create') {
        $stmt = $pdo->prepare('INSERT INTO fv_users (name, email, phone, address, role, password_hash) VALUES (:name, :email, :phone, :address, :role, :password_hash)');
        $stmt->execute($payload + [
            'role' => 'employee',
            'password_hash' => password_hash($_POST['password'] ?? '123456', PASSWORD_DEFAULT),
        ]);
        set_flash('success', 'Funcionário cadastrado.');
    } elseif ($action === 'update') {
        $stmt = $pdo->prepare('UPDATE fv_users SET name=:name, email=:email, phone=:phone, address=:address WHERE id=:id AND role="employee"');
        $stmt->execute($payload + ['id' => (int) $_POST['id']]);
        set_flash('success', 'Funcionário atualizado.');
    }
    redirect('admin/employees.php');
}

if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('UPDATE fv_users SET is_active = 0 WHERE id = :id AND role = "employee"');
    $stmt->execute(['id' => (int) $_GET['delete']]);
    set_flash('success', 'Funcionário desativado.');
    redirect('admin/employees.php');
}

$employees = $pdo->query('SELECT * FROM fv_users WHERE role = "employee" ORDER BY created_at DESC')->fetchAll();
$pageTitle = 'Funcionários';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container section">
    <div class="dashboard-grid">
        <div class="card">
            <h1>Cadastrar funcionário</h1>
            <form method="post">
                <input type="hidden" name="action" value="create">
                <label>Nome</label><input type="text" name="name" required>
                <label>Email</label><input type="email" name="email" required>
                <label>Telefone</label><input type="text" name="phone">
                <label>Endereço</label><textarea name="address"></textarea>
                <label>Senha inicial</label><input type="password" name="password" required>
                <button class="btn" type="submit">Salvar</button>
            </form>
        </div>
        <div class="card">
            <h2>Funcionários cadastrados</h2>
            <div class="table-wrap">
                <table>
                    <tr><th>Nome</th><th>Email</th><th>Telefone</th><th>Status</th><th>Ação</th></tr>
                    <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td><?= h($employee['name']) ?></td>
                            <td><?= h($employee['email']) ?></td>
                            <td><?= h($employee['phone']) ?></td>
                            <td><?= $employee['is_active'] ? 'Ativo' : 'Inativo' ?></td>
                            <td><a class="btn btn-small" href="<?= h(base_url('admin/employees.php?delete=' . $employee['id'])) ?>" onclick="return confirm('Desativar funcionário?')">Desativar</a></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
