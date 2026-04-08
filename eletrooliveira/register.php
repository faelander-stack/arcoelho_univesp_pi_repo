<?php
require_once __DIR__ . '/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $propertyType = trim($_POST['property_type'] ?? '');
    $energyConsumption = trim($_POST['energy_consumption'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($name === '' || $email === '' || $password === '') {
        set_flash('error', 'Preencha os campos obrigatórios.');
        redirect('register.php');
    }

    $pdo = db();
    $check = $pdo->prepare('SELECT id FROM fv_users WHERE email = :email LIMIT 1');
    $check->execute(['email' => $email]);
    if ($check->fetch()) {
        set_flash('error', 'Já existe um usuário com este email.');
        redirect('register.php');
    }

    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare('INSERT INTO fv_users (name, email, phone, address, role, password_hash) VALUES (:name, :email, :phone, :address, :role, :password_hash)');
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'address' => $address,
            'role' => 'client',
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        $userId = (int) $pdo->lastInsertId();
        $clientStmt = $pdo->prepare('INSERT INTO fv_clients (user_id, property_type, energy_consumption) VALUES (:user_id, :property_type, :energy_consumption)');
        $clientStmt->execute([
            'user_id' => $userId,
            'property_type' => $propertyType,
            'energy_consumption' => $energyConsumption,
        ]);

        $pdo->commit();
        set_flash('success', 'Cadastro realizado com sucesso. Faça login para continuar.');
        redirect('login.php');
    } catch (Throwable $e) {
        $pdo->rollBack();
        set_flash('error', 'Não foi possível concluir o cadastro.');
        redirect('register.php');
    }
}

$pageTitle = 'Cadastro de Cliente';
require_once __DIR__ . '/includes/header.php';
?>
<div class="container">
    <div class="card form-card">
        <h1>Cadastro de Cliente</h1>
        <form method="post">
            <label>Nome</label>
            <input type="text" name="name" required>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Telefone</label>
            <input type="text" name="phone" required>
            <label>Endereço</label>
            <textarea name="address" required></textarea>
            <label>Tipo de imóvel</label>
            <select name="property_type" required>
                <option value="">Selecione</option>
                <option>Residencial</option>
                <option>Comercial</option>
                <option>Rural</option>
                <option>Industrial</option>
            </select>
            <label>Consumo de energia</label>
            <input type="text" name="energy_consumption" placeholder="Ex.: 450 kWh/mês" required>
            <label>Senha</label>
            <input type="password" name="password" required>
            <button class="btn" type="submit">Criar conta</button>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
