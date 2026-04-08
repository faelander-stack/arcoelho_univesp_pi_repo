<?php
require_once __DIR__ . '/../includes/functions.php';
require_role(['client']);
$pdo = db();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $billFilename = upload_file($_FILES['bill_file'] ?? [], UPLOAD_BILL_DIR, ALLOWED_BILL_EXTENSIONS);
        $stmt = $pdo->prepare('INSERT INTO fv_quote_requests (client_user_id, address, property_type, energy_consumption, bill_file, status, observations) VALUES (:client_user_id, :address, :property_type, :energy_consumption, :bill_file, :status, :observations)');
        $stmt->execute([
            'client_user_id' => current_user()['id'],
            'address' => trim($_POST['address'] ?? ''),
            'property_type' => trim($_POST['property_type'] ?? ''),
            'energy_consumption' => trim($_POST['energy_consumption'] ?? ''),
            'bill_file' => $billFilename ? UPLOAD_BILL_URL . $billFilename : null,
            'status' => 'Em análise',
            'observations' => 'Solicitação enviada pelo cliente.',
        ]);
        set_flash('success', 'Solicitação enviada com sucesso.');
        redirect('client/dashboard.php');
    } catch (Throwable $e) {
        set_flash('error', $e->getMessage());
        redirect('client/request_quote.php');
    }
}
$pageTitle = 'Solicitar Orçamento';
require_once __DIR__ . '/../includes/header.php';
?>
<div class="container">
    <div class="card form-card">
        <h1>Solicitar orçamento</h1>
        <form method="post" enctype="multipart/form-data">
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
            <input type="text" name="energy_consumption" required>
            <label>Conta de energia</label>
            <input type="file" name="bill_file" accept=".pdf,.jpg,.jpeg,.png">
            <button class="btn" type="submit">Enviar solicitação</button>
        </form>
    </div>
</div>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
