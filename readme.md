# 🏨 **Hotel Booking System** 🏨

Este projeto é um sistema de reserva de hotel full stack, que permite aos usuários verificar a disponibilidade de quartos e fazer suas próprias reservas, além de permitir ao administrador gerenciar as reservas feitas. O projeto também inclui um formulário de inscrição para a newsletter da empresa, no qual os usuários podem se registrar para receber atualizações. ✉️

## Funcionalidades 🚀

### Para o Usuário 👤:
- **Registro e Login** 🔑: Os usuários podem se registrar e fazer login para criar e gerenciar suas reservas pessoais.

- **Verificação de Disponibilidade** 📅: O usuário pode verificar os dias disponíveis para reservas por meio de dois inputs de calendário, permitindo a seleção de datas de entrada e saída. Uma vez que uma reserva é feita, os dias selecionados ficam bloqueados para outros usuários.

- **Formulário de Newsletter** 📰: O usuário pode inserir seu email em um formulário para receber atualizações da empresa. O email é salvo no banco de dados para ser usado em futuras campanhas de email.

### Para o Administrador 🛠️:
- **Gerenciamento de Reservas** 🗂️: O administrador pode visualizar todas as reservas feitas pelos usuários na página de administração.

- **Edição e Exclusão de Reservas** ✏️❌: O administrador pode editar as datas das reservas feitas pelos usuários ou excluir uma reserva se necessário.

## Estrutura do Banco de Dados 🗄️

O banco de dados do projeto é composto pelas seguintes tabelas:

1. **Tabela de Reservas** 📆: Armazena as reservas feitas pelos usuários, incluindo as datas de entrada e saída, o número de quartos e o número de convidados.

    ```sql
    CREATE TABLE reservas (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY, 
        data_entrada DATE NOT NULL, 
        data_saida DATE NOT NULL, 
        quartos INT NOT NULL, 
        convidados INT NOT NULL
    );
    ```

2. **Tabela de Usuários** 👥: Armazena as informações dos usuários, como nome de usuário, email, senha e a data de criação da conta.

    ```sql
    CREATE TABLE users (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(50) NOT NULL,
        email VARCHAR(100) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ```

3. **Tabela de Usuários da Newsletter** 📧: Armazena os emails dos usuários interessados em receber a newsletter da empresa.

    ```sql
    CREATE TABLE usuariosdanewsletter (
        id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    );
    ```

## Tecnologias Usadas 🛠️

- **Frontend**: HTML, CSS, JavaScript 🌐
- **Backend**: PHP puro 🖥️
- **Banco de Dados**: MySQL 🗃️
- **Contêinerização**: Docker 🐳

## Como Rodar o Projeto 🏃‍♂️

### Requisitos 📋
- PHP 8.0 ou superior 🔧
- MySQL 🐬
- Docker 🐳

### Passos 🔄

1. Clone o repositório:

    ```bash
    git clone https://github.com/seuusuario/hotel-booking-system.git
    ```

2. Navegue até o diretório do projeto:

    ```bash
    cd hotel-booking-system
    ```

3. Certifique-se de que o Docker esteja instalado e execute o seguinte comando para iniciar o contêiner:

    ```bash
    docker-compose up -d
    ```

    Este comando irá construir a imagem do PHP, configurar o MySQL e iniciar os contêineres necessários.

4. Acesse o projeto no navegador em `http://localhost:8080`.

5. O banco de dados será configurado automaticamente ao iniciar os contêineres Docker. O banco de dados MySQL estará disponível na porta `3306`, e o PHP será servido na porta `8080`.

## Dockerfile 🐳

O Dockerfile do projeto configura o ambiente PHP, instala as dependências necessárias e prepara o contêiner Apache para rodar o PHP.

```dockerfile
FROM php:8.1-apache

# Instalar Postfix, outras dependências, unzip e a extensão zip
RUN apt-get update && apt-get install -y \
    postfix \
    mailutils \
    libzip-dev \
    curl \
    unzip && \
    docker-php-ext-install mysqli pdo pdo_mysql zip

# Instalar o Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Habilitar o módulo do Apache
RUN a2enmod rewrite

# Copiar arquivos do projeto para o container
COPY . /var/www/html/

# Expor a porta 80
EXPOSE 80
```

## docker-compose.yml 🔧

Este arquivo configura os contêineres do PHP e MySQL, permitindo que eles se comuniquem entre si.

```yaml
services:
  php:
    build:
      context: ./php
    container_name: php-container
    volumes:
      - ./src:/var/www/html
    ports:
      - "8080:80"

  mysql:
    image: mysql:8.0
    container_name: mysql-container
    restart: always
    environment:
      MYSQL_ROOT_PASSWORD: 123456
      MYSQL_DATABASE: reservasdb
      MYSQL_USER: user
      MYSQL_PASSWORD: 1234
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql

volumes:
  mysql_data:
```

## Funcionalidades Futuras ✨

- Implementar o envio automático de emails para os usuários registrados na newsletter. 📧

## Contribuições 💡

Contribuições são bem-vindas! Se você tiver sugestões de melhorias ou correções de bugs, sinta-se à vontade para abrir uma *issue* ou enviar um *pull request*. 🤝

## Licença 📜

Este projeto está licenciado sob a [MIT License](LICENSE). ⚖️

---

Agora o README inclui as informações do Dockerfile e docker-compose, além de outras melhorias. Se precisar de mais ajustes, é só avisar! 😊
