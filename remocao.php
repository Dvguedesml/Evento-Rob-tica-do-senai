<?php
// inicia a sessão e configurações básicas 
require_once 'init.php';

// Pega o ID do evento
$id = $_REQUEST['id'] ?? null;


// Cancela se o evento não existir
if (!$id || !isset($_SESSION['eventos'][$id])) {
    echo "Evento não encontrado! <a href='index.php'>Voltar</a>";
    exit;
}

// Se o utilizador confirmou a remoção
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Apaga o evento
    unset($_SESSION['eventos'][$id]);
    // Redireciona para a página inicial
    header('Location: index.php');
    exit;
}

// Carrega os dados do evento para exibir
$evento = $_SESSION['eventos'][$id];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Remover Evento</title>
</head>
<body>
    <h1>Confirmar Remoção</h1>

    <!-- Mostra o nome do evento -->
    <p>Tem certeza que deseja remover o evento <strong><?php echo $evento['titulo']; ?></strong>?</p>

    <div>
    <form method="POST">
        <!-- Envia o ID junto com o formulário -->
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="submit">Sim, Remover</button>
        <a href="index.php">Cancelar</a>
    </form>
    </div>
</body>
</html>