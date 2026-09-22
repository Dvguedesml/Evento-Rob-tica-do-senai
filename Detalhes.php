<?php
require_once 'init.php';

$id = $_GET['id'] ?? null;

if (!$id || !isset($_SESSION['eventos'][$id])) {
    echo "Evento não encontrado! <a href='index.php'>Voltar</a>";
    exit;
}

$evento = $_SESSION['eventos'][$id];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Evento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1><?php echo $evento['titulo']; ?></h1>
    <div>
        <p><strong>Descrição:</strong> <?php echo $evento['descricao']; ?></p>
        <p><strong>Área:</strong> <?php echo $evento['area']; ?></p>
        <p><strong>Data:</strong> <?php echo $evento['data']; ?></p>
        <p><strong>Horário:</strong> <?php echo $evento['inicio']; ?> às <?php echo $evento['fim']; ?></p>
        <p><strong>Local:</strong> <?php echo $evento['local']; ?></p>
        <p><strong>Responsável:</strong> <?php echo $evento['responsavel']; ?></p>

        <a href="index.php">Voltar para a lista</a>
    </div>
</body>
</html>