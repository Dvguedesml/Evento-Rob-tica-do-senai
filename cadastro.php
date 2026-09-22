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

    if (!$titulo || !$descricao || !$area || !$data || !$inicio || !$fim || !$local || !$responsavel) {
        $erro = 'Todos os campos são obrigatórios!';
    } elseif ($fim <= $inicio) {
        $erro = 'O horário final deve ser maior que o horário inicial!';
    } else {
        $id = $_SESSION['proximo_id'];
        
        $_SESSION['eventos'][$id] = [
            'id' => $id,
            'titulo' => $titulo,
            'descricao' => $descricao,
            'area' => $area,
            'data' => $data,
            'inicio' => $inicio,
            'fim' => $fim,
            'local' => $local,
            'responsavel' => $responsavel
        ];

        $_SESSION['proximo_id']++;
        
        header('Location: index.php');
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
    <h1>Cadastrar Evento</h1>
    <?php if ($erro) echo "<p style='color:red;'>$erro</p>"; ?>


    <div>
        <form method="POST">
            <label>Título: <input type="text" name="titulo" required></label><br><br>
            <label>Descrição: <textarea name="descricao" required></textarea></label><br><br>
            <label>Área: <input type="text" name="area" required></label><br><br>
            <label>Data: <input type="date" name="data" required></label><br><br>
            <label>Início: <input type="time" name="inicio" required></label><br><br>
            <label>Fim: <input type="time" name="fim" required></label><br><br>
            <label>Local: <input type="text" name="local" required></label><br><br>
            <label>Responsável: <input type="text" name="responsavel" required></label><br><br>
            
            <button type="submit">Salvar Evento</button>
            <a href="index.php">Cancelar</a>
        </form>
    </div>
</body>
</html>