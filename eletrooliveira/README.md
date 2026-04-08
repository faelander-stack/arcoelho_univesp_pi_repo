# Eletrooliveira Sistema de Gestão

Sistema web em PHP + MySQL para empresa fotovoltaica, com página institucional responsiva, cadastro de clientes, login por perfil, solicitações de orçamento, acompanhamento de status, galeria de projetos e relatórios gerenciais.

## Estrutura de pastas

- `assets/css/` → estilos CSS
- `assets/js/` → scripts JS
- `config/` → configuração do banco e aplicação
- `includes/` → funções, autenticação e layout compartilhado
- `admin/` → painel do administrador
- `employee/` → painel do funcionário
- `client/` → painel do cliente
- `uploads/gallery/` → imagens de projetos
- `uploads/bills/` → contas de energia anexadas
- `database/schema.sql` → estrutura do banco com prefixo `fv_`

## Instalação

1. Crie um banco MySQL no painel da hospedagem.
2. Importe o arquivo `database/schema.sql` no phpMyAdmin.
3. Edite `config/config.php` com host, banco, usuário e senha.
4. Faça upload de toda a pasta para o `htdocs` ou raiz pública da conta.
5. Ajuste `BASE_URL` em `config/config.php` se o sistema estiver em subpasta.
6. Garanta permissão de escrita nas pastas `uploads/gallery/` e `uploads/bills/`.

## Login inicial

- **Email:** `admin@exemplo.com`
- **Senha:** `admin123`

## Perfis implementados

- **Administrador:** conteúdo do site, galeria, funcionários, clientes e relatórios
- **Funcionário:** visualização de clientes e atualização de solicitações
- **Cliente:** cadastro, login, solicitação de orçamento e acompanhamento

## Observações

- O sistema já atende à maior parte dos requisitos funcionais, como, por exemplo o MVP.
