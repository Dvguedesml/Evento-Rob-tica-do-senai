<?php
require_once 'init.php';

$id = $_REQUEST['id'] ?? null;

if (!$id || !isset($_SESSION['eventos'][$id])) {
    echo "Evento não encontrado! <a href='index.php'>Voltar</a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_SESSION['eventos'][$id]);
    header('Location: index.php');
    exit;
}

$evento = $_SESSION['eventos'][$id];
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Remover Evento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Confirmar Remoção</h1>
    <p>Tem certeza que deseja remover o evento <strong><?php echo $evento['titulo']; ?></strong>?</p>

    <div>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <button type="submit">Sim, Remover</button>
        <a href="index.php">Cancelar</a>
    </form>
    </div>
</body>
</html>
