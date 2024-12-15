<?php

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar dados do formulário
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $rooms = (int) $_POST['rooms'];
    $guests = (int) $_POST['guests'];

    // Validações básicas
    if (empty($checkin) || empty($checkout) || $rooms <= 0 || $guests <= 0) {
        echo "Todos os campos são obrigatórios e devem conter valores válidos.";
        exit;
    }

    if ($checkin >= $checkout) {
        echo "A data de check-out deve ser posterior à data de check-in.";
        exit;
    }

    

    // Verificar disponibilidade
    $stmt = $pdo->prepare("
        SELECT COUNT(*) 
        FROM reservas 
        WHERE (:checkin < data_saida AND :checkout > data_entrada)
    ");
    $stmt->execute([
        ':checkin' => $checkin,
        ':checkout' => $checkout
    ]);

    $reservas = $stmt->fetchColumn();

    if ($reservas > 0) {
        echo "Não há disponibilidade para as datas selecionadas.";
    } else {
        echo "As datas estão disponíveis! Quartos: $rooms, Convidados: $guests";
    }
}
?>
