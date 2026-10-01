<?php
require_once 'init.php';

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $area = trim($_POST['area'] ?? '');
    $data = trim($_POST['data'] ?? '');
    $inicio = trim($_POST['inicio'] ?? '');
    $fim = trim($_POST['fim'] ?? '');
    $local = trim($_POST['local'] ?? '');
    $responsavel = trim($_POST['responsavel'] ?? '');
    $capacidade = (int)($_POST['capacidade'] ?? 0);

    if (empty($titulo) || empty($capacidade) || $capacidade <= 0) {
        $erro = "Informe uma capacidade válida (número inteiro positivo)!";
    } else {
        $id = $_SESSION['proximo_id']++;
        $_SESSION['eventos'][$id] = [
            'id' => $id,
            'titulo' => $titulo,
            'descricao' => $descricao,
            'area' => $area,
            'data' => $data,
            'inicio' => $inicio,
            'fim' => $fim,
            'local' => $local,
            'responsavel' => $responsavel,
            'status' => 'ativo',
            'capacidade' => $capacidade,
            'inscritos' => []
        ];
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Evento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Cadastrar Novo Evento</h1>

    <?php if (!empty($erro)) { ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php } ?>

    <form method="POST">
        <label>Título:</label><br>
        <input type="text" name="titulo" value="<?php echo $_POST['titulo'] ?? ''; ?>"><br><br>

        <label>Descrição:</label><br>
        <textarea name="descricao"><?php echo $_POST['descricao'] ?? ''; ?></textarea><br><br>

        <label>Área:</label><br>
        <input type="text" name="area" value="<?php echo $_POST['area'] ?? ''; ?>"><br><br>

        <label>Data:</label><br>
        <input type="date" name="data" value="<?php echo $_POST['data'] ?? ''; ?>"><br><br>

        <label>Início:</label><br>
        <input type="time" name="inicio" value="<?php echo $_POST['inicio'] ?? ''; ?>"><br><br>

        <label>Fim:</label><br>
        <input type="time" name="fim" value="<?php echo $_POST['fim'] ?? ''; ?>"><br><br>

        <label>Local:</label><br>
        <input type="text" name="local" value="<?php echo $_POST['local'] ?? ''; ?>"><br><br>

        <label>Responsável:</label><br>
        <input type="text" name="responsavel" value="<?php echo $_POST['responsavel'] ?? ''; ?>"><br><br>

        <label>Capacidade (Vagas):</label><br>
        <input type="number" name="capacidade" min="1" value="<?php echo $_POST['capacidade'] ?? ''; ?>"><br><br>

        <button type="submit">Cadastrar</button>
    </form>

    <br>
    <a href="index.php">Voltar</a>
</body>
</html>