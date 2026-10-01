<?php
require_once 'init.php';

$id = $_GET['id'] ?? null;

if (!$id || !isset($_SESSION['eventos'][$id])) {
    echo "Evento não encontrado. <a href='index.php'>Voltar</a>";
    exit;
}

$evento = $_SESSION['eventos'][$id];
$total_inscritos = count($evento['inscritos'] ?? []);
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $capacidade = (int)($_POST['capacidade'] ?? 0);

    if ($capacidade <= 0) {
        $erro = "A capacidade deve ser um número inteiro positivo!";
    } elseif ($capacidade < $total_inscritos) {
        $erro = "A capacidade não pode ser menor que o número de inscritos atuais ($total_inscritos)!";
    } else {
        $_SESSION['eventos'][$id]['titulo'] = trim($_POST['titulo'] ?? '');
        $_SESSION['eventos'][$id]['descricao'] = trim($_POST['descricao'] ?? '');
        $_SESSION['eventos'][$id]['area'] = trim($_POST['area'] ?? '');
        $_SESSION['eventos'][$id]['data'] = trim($_POST['data'] ?? '');
        $_SESSION['eventos'][$id]['inicio'] = trim($_POST['inicio'] ?? '');
        $_SESSION['eventos'][$id]['fim'] = trim($_POST['fim'] ?? '');
        $_SESSION['eventos'][$id]['local'] = trim($_POST['local'] ?? '');
        $_SESSION['eventos'][$id]['responsavel'] = trim($_POST['responsavel'] ?? '');
        $_SESSION['eventos'][$id]['capacidade'] = $capacidade;

        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Evento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Editar Evento</h1>

    <?php if (!empty($erro)) { ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php } ?>

    <form method="POST">
        <label>Título:</label><br>
        <input type="text" name="titulo" value="<?php echo $evento['titulo']; ?>"><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao"><?php echo $evento['descricao']; ?></textarea><br><br>

        <label>Área:</label><br>
        <input type="text" name="area" value="<?php echo $evento['area']; ?>"><br><br>

        <label>Data:</label><br>
        <input type="date" name="data" value="<?php echo $evento['data']; ?>"><br><br>

        <label>Início:</label><br>
        <input type="time" name="inicio" value="<?php echo $evento['inicio']; ?>"><br><br>

        <label>Fim:</label><br>
        <input type="time" name="fim" value="<?php echo $evento['fim']; ?>"><br><br>

        <label>Local:</label><br>
        <input type="text" name="local" value="<?php echo $evento['local']; ?>"><br><br>

        <label>Responsável:</label><br>
        <input type="text" name="responsavel" value="<?php echo $evento['responsavel']; ?>"><br><br>

        <label>Capacidade (Vagas):</label><br>
        <input type="number" name="capacidade" min="1" value="<?php echo $evento['capacidade'] ?? 0; ?>"><br>
        <small>Mínimo permitido agora: <?php echo $total_inscritos; ?> (inscritos atuais)</small><br><br>

        <button type="submit">Salvar Alterações</button>
    </form>

    <br>
    <a href="index.php">Voltar</a>
</body>
</html>