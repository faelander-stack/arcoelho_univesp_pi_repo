<?php
require_once __DIR__ . '/includes/auth.php';
logout_user();
set_flash('success', 'Sessão encerrada com sucesso.');
redirect('index.php');
