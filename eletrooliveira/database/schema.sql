CREATE TABLE fv_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(180) NOT NULL UNIQUE,
    phone VARCHAR(40) DEFAULT NULL,
    address TEXT DEFAULT NULL,
    role ENUM('admin', 'employee', 'client') NOT NULL DEFAULT 'client',
    password_hash VARCHAR(255) NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE fv_clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    property_type VARCHAR(80) DEFAULT NULL,
    energy_consumption VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_fv_clients_user FOREIGN KEY (user_id) REFERENCES fv_users(id) ON DELETE CASCADE
);

CREATE TABLE fv_site_content (
    id INT AUTO_INCREMENT PRIMARY KEY,
    content_key VARCHAR(50) NOT NULL UNIQUE,
    title VARCHAR(200) NOT NULL,
    body TEXT NOT NULL,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE fv_gallery_images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(150) NOT NULL,
    description TEXT DEFAULT NULL,
    image_path VARCHAR(255) NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE fv_quote_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_user_id INT NOT NULL,
    address TEXT NOT NULL,
    property_type VARCHAR(80) NOT NULL,
    energy_consumption VARCHAR(100) NOT NULL,
    bill_file VARCHAR(255) DEFAULT NULL,
    status ENUM('Em análise', 'Aprovado', 'Em instalação', 'Concluído') NOT NULL DEFAULT 'Em análise',
    observations TEXT DEFAULT NULL,
    updated_by INT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_fv_quote_requests_user FOREIGN KEY (client_user_id) REFERENCES fv_users(id) ON DELETE CASCADE,
    CONSTRAINT fk_fv_quote_requests_updated_by FOREIGN KEY (updated_by) REFERENCES fv_users(id) ON DELETE SET NULL
);

INSERT INTO fv_site_content (content_key, title, body) VALUES
('hero', 'Projetos fotovoltaicos com orçamentos, cadastros e acompanhamento em um só sistema', 'Automatize relatórios, organize clientes, acompanhe instalações e mantenha o site institucional atualizado por meio do painel administrativo.'),
('about', 'Quem somos', 'Somos uma empresa especializada em soluções fotovoltaicas, com foco em dimensionamento, instalação, monitoramento e relacionamento digital com o cliente.'),
('services', 'Serviços oferecidos', 'Projetos residenciais, comerciais e rurais, homologação, manutenção preventiva, análise de consumo e acompanhamento completo da instalação.'),
('solar_info', 'Como funciona a energia solar fotovoltaica', 'Os módulos solares convertem a radiação do sol em energia elétrica. O inversor transforma essa energia para uso no imóvel e o excedente pode gerar créditos na distribuidora.'),
('advantages', 'Vantagens do sistema', 'Redução da conta de luz, previsibilidade de custos, valorização do imóvel, sustentabilidade e retorno financeiro no médio e longo prazo.'),
('economy', 'Economia e retorno', 'Ao analisar o consumo do cliente, o sistema permite registrar a demanda mensal e gerar orçamentos compatíveis com o potencial de economia esperado.');

INSERT INTO fv_users (name, email, role, password_hash) VALUES
('Administrador', 'admin@exemplo.com', 'admin', '$2y$12$vMC.OMDaxZaMNSZ7lndJy.eRBxzIR34pyIwBBcn7nwHlFVWA3Uc4i');
-- Senha do admin padrão: admin123
