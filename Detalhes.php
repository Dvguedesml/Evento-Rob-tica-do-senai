<?php
require_once 'init.php';

$id = $_GET['id'] ?? null;

if (!$id || !isset($_SESSION['eventos'][$id])) {
    echo "Evento não encontrado! <a href='index.php'>Voltar</a>";
    exit;
}

$evento = $_SESSION['eventos'][$id];
$status = $evento['status'] ?? 'ativo';
$inscritos = $evento['inscritos'] ?? [];
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
        <p><strong>Status:</strong> <?php echo $status; ?></p>
        <p><strong>Descrição:</strong> <?php echo $evento['descricao']; ?></p>
        <p><strong>Área:</strong> <?php echo $evento['area']; ?></p>
        <p><strong>Data:</strong> <?php echo $evento['data']; ?></p>
        <p><strong>Horário:</strong> <?php echo $evento['inicio']; ?> às <?php echo $evento['fim']; ?></p>
        <p><strong>Local:</strong> <?php echo $evento['local']; ?></p>
        <p><strong>Responsável:</strong> <?php echo $evento['responsavel']; ?></p>

        <!-- Botão de Inscrição só se estiver ativo -->
        <?php if ($status === 'ativo') { ?>
            <a href="inscricao.php?id=<?php echo $id; ?>">Realizar Inscrição</a><br><br>
        <?php } ?>

        <hr>

        <!-- Lista de Inscritos -->
        <h3>Inscritos no Evento (<?php echo count($inscritos); ?>)</h3>
        <?php if (empty($inscritos)) { ?>
            <p>Nenhum participante inscrito até o momento.</p>
        <?php } else { ?>
            <ul>
                <?php foreach ($inscritos as $participante) { ?>
                    <li><?php echo $participante['nome']; ?> (<?php echo $participante['email']; ?>)</li>
                <?php } ?>
            </ul>
        <?php } ?>

        <br>
        <a href="index.php">Voltar para a lista</a>
    </div>
</body>
</html>