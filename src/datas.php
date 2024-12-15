<?php
// Conexão com o banco de dados
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['checkin'], $_POST['checkout'], $_POST['rooms'], $_POST['guests'])) {
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
        $stmt = $pdo->prepare("SELECT COUNT(*) 
                               FROM reservas 
                               WHERE (:checkin < data_saida AND :checkout > data_entrada)");
        $stmt->execute([
            ':checkin' => $checkin,
            ':checkout' => $checkout
        ]);

        $reservas = $stmt->fetchColumn();

        if ($reservas > 0) {
            echo "Não há vagas disponíveis para as datas selecionadas.";
        } else {
            // Se as datas estiverem disponíveis, salvar a reserva
            $sql = "INSERT INTO reservas (data_entrada, data_saida, quartos, convidados) 
                    VALUES (:data_entrada, :data_saida, :quartos, :convidados)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':data_entrada' => $checkin,
                ':data_saida' => $checkout,
                ':quartos' => $rooms,
                ':convidados' => $guests
            ]);

            echo "Reserva salva com sucesso!";
        }
    }
}

?>


