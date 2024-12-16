<?php
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['nomedousuario']);
    $email = trim($_POST['emaildousuario']);

    if (empty($username) || empty($email)) {
        echo "Todos os campos são obrigatórios!";
        http_response_code(400); // Código de erro
    } else {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuariosdanewsletter WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            echo "Este email já está registrado na newsletter!";
            http_response_code(400); // Código de erro
        } else {
            $stmt = $pdo->prepare("INSERT INTO usuariosdanewsletter (username, email) VALUES (:username, :email)");
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            echo "Inscrição realizada com sucesso!";
            http_response_code(200); // Código de sucesso
        }
    }
}