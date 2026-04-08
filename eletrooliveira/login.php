<?php
require_once __DIR__ . '/includes/auth.php';
if (is_logged_in()) {
    redirect(dashboard_path_for_role(current_user()['role']));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (login_user($email, $password)) {
        set_flash('success', 'Login realizado com sucesso.');
        redirect(dashboard_path_for_role(current_user()['role']));
    }

    set_flash('error', 'Email ou senha inválidos.');
    redirect('login.php');
}

$pageTitle = 'Login';
require_once __DIR__ . '/includes/header.php';
?>
<div class="container">
    <div class="card form-card">
        <h1>Entrar</h1>
        <form method="post">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Senha</label>
            <input type="password" id="password" name="password" required>

            <button class="btn" type="submit">Acessar</button>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>
