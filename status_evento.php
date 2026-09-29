<?php
require_once 'init.php';

$id = $_GET['id'] ?? null;

if (!$id || !isset($_SESSION['eventos'][$id])) {
    echo "Evento não encontrado.";
    exit;
}
if (!isset($_SESSION['eventos'][$id]['status'])) {
    $_SESSION['eventos'][$id]['status'] = 'ativo';
}

$evento = $_SESSION['eventos'][$id];
if (isset($_POST['cancelar'])) {
    $_SESSION['eventos'][$id]['status'] = 'cancelado';

    header("Location: index.php");
    exit;
}
if (isset($_POST['reativar'])) {
    $_SESSION['eventos'][$id]['status'] = 'ativo';

    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Status do Evento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Status do Evento</h1>
<h2><?php echo $evento['titulo']; ?></h2>

<p>
    Status:
    <?php echo $evento['status']; ?>
</p>
<?php if ($evento['status'] == 'ativo') { ?>

    <form method="POST">
        <button type="submit" name="cancelar">
            Cancelar evento
        </button>
    </form>
<?php } else { ?>

    <form method="POST">
        <button type="submit" name="reativar">
            Reativar evento
        </button>
    </form>

<?php } ?>

<br>

<a href="index.php">Voltar</a>
</body>
</html>