<?php
// Conexão com o banco de dados
include ('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $email = trim($_POST['email']);

    // Verificar se os campos estão vazios
    if (empty($username) || empty($password) || empty($email)) {
        $error = "Todos os campos são obrigatórios!";
    } else {
        // Verificar se o email já existe
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $error = "Este email já está registrado!";
        } else {
            // Hash da senha
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Inserir o novo usuário no banco de dados
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->execute();

            $success = "Registro realizado com sucesso! Agora você pode fazer login.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro</title>
  <style>
    /* Reset básico */
body, h2, p, form, input, button {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: Arial, sans-serif;
  background: #f5f5f5;
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 100vh;
}

.register-container {
  width: 100%;
  max-width: 400px;
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.register-form h2 {
  text-align: center;
  margin-bottom: 20px;
  color: #333;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  margin-bottom: 5px;
  font-size: 14px;
  color: #555;
}

.form-group input {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 14px;
}

button {
  width: 100%;
  padding: 10px;
  background: #4CAF50;
  color: #fff;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  transition: background 0.3s ease;
}

button:hover {
  background: #45a049;
}

.login-link {
  text-align: center;
  margin-top: 15px;
  font-size: 14px;
  color: #555;
}

.login-link a {
  color: #4CAF50;
  text-decoration: none;
}

.login-link a:hover {
  text-decoration: underline;
}

  </style>
</head>
<body>
  <div class="register-container">
    <form class="register-form" method="POST" action="registro.php">
      <h2>Registro</h2>
      <div class="form-group">
        <label for="username">Nome de Usuário</label>
        <input type="text" id="username" name="username" placeholder="Digite seu nome de usuário" required>
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Digite seu email" required>
      </div>
      <div class="form-group">
        <label for="password">Senha</label>
        <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
      </div>
      <div class="form-group">
        <label for="confirm-password">Confirme a Senha</label>
        <input type="password" id="confirm-password" name="confirm-password" placeholder="Confirme sua senha" required>
      </div>
      <button type="submit">Registrar</button>
      <p class="login-link">Já tem uma conta? <a href="login.php">Faça login</a></p>
    </form>
  </div>

  <script>
   
  document.querySelector('.register-form').addEventListener('submit', function (e) {
    // Pega os valores dos campos
    const username = document.getElementById('username').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm-password').value;

    // Validação do nome de usuário (mínimo 3 caracteres)
    if (username.length < 3) {
      alert('O nome de usuário deve ter pelo menos 3 caracteres.');
      e.preventDefault(); // Impede o envio do formulário
      return;
    }

    // Validação do email (formato simples)
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
      alert('Por favor, insira um email válido.');
      e.preventDefault();
      return;
    }

    // Validação da senha (mínimo 6 caracteres)
    if (password.length < 6) {
      alert('A senha deve ter pelo menos 6 caracteres.');
      e.preventDefault();
      return;
    }

    // Validação de confirmação de senha
    if (password !== confirmPassword) {
      alert('As senhas não correspondem.');
      e.preventDefault();
      return;
    }

    // Se todas as validações passarem
    alert('Formulário enviado com sucesso!');
  });


  </script>
</body>
</html>
