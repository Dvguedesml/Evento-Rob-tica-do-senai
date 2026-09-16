<?php
require_once 'init.php';

$id = $_REQUEST['id'] ?? null;

if (!$id || !isset($_SESSION['eventos'][$id])) {
    echo "Evento não encontrado! <a href='index.php'>Voltar</a>";
    exit;
}

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $area = $_POST['area'];
    $data = $_POST['data'];
    $inicio = $_POST['inicio'];
    $fim = $_POST['fim'];
    $local = $_POST['local'];
    $responsavel = $_POST['responsavel'];

    if (!$titulo || !$descricao || !$area || !$data || !$inicio || !$fim || !$local || !$responsavel) {
        $erro = 'Todos os campos são obrigatórios!';
    } elseif ($fim <= $inicio) {
        $erro = 'O horário final deve ser maior que o inicial!';
    } else {
        $_SESSION['eventos'][$id] = [
            'id' => (int)$id,
            'titulo' => $titulo,
            'descricao' => $descricao,
            'area' => $area,
            'data' => $data,
            'inicio' => $inicio,
            'fim' => $fim,
            'local' => $local,
            'responsavel' => $responsavel
        ];

        header('Location: index.php');
        exit;
    }
} else {
    $evento = $_SESSION['eventos'][$id];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Evento</title>
</head>
<body>
    <h1>Editar Evento</h1>
    <?php if ($erro) echo "<p style='color:red;'>$erro</p>"; ?>


    <div>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <label>Título: <input type="text" name="titulo" value="<?php echo $evento['titulo']; ?>" required></label><br><br>
            <label>Descrição: <textarea name="descricao" required><?php echo $evento['descricao']; ?></textarea></label><br><br>
            <label>Área: <input type="text" name="area" value="<?php echo $evento['area']; ?>" required></label><br><br>
            <label>Data: <input type="date" name="data" value="<?php echo $evento['data']; ?>" required></label><br><br>
            <label>Início: <input type="time" name="inicio" value="<?php echo $evento['inicio']; ?>" required></label><br><br>
            <label>Fim: <input type="time" name="fim" value="<?php echo $evento['fim']; ?>" required></label><br><br>
            <label>Local: <input type="text" name="local" value="<?php echo $evento['local']; ?>" required></label><br><br>
            <label>Responsável: <input type="text" name="responsavel" value="<?php echo $evento['responsavel']; ?>" required></label><br><br>
            
            <button type="submit">Atualizar Evento</button>
            <a href="index.php">Cancelar</a>
    </form>
    </div>
</body>
</html>