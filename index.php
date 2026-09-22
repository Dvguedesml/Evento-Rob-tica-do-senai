<?php require_once 'init.php'; ?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Eventos SENAI</title>
</head>
<body>
    <h1>Eventos do SENAI</h1>
    <a href="cadastro.php">Cadastrar novo Evento</a>
    <hr>

    <?php if (empty($_SESSION['eventos'])) { ?>
        <p>Nenhum evento cadastrado.</p>
    <?php } else { ?>
        <?php foreach ($_SESSION['eventos'] as $id => $evento) { ?>
            <div>
                <h2><?php echo $evento['titulo']; ?></h2>
                <p><?php echo $evento['descricao']; ?></p>
                <p>Data: <?php echo $evento['data']; ?></p>
                <p>Horário: <?php echo $evento['inicio']; ?> às <?php echo $evento['fim']; ?></p>
                <p>Local: <?php echo $evento['local']; ?></p>
                
                <a href="detalhes.php?id=<?php echo $id; ?>">Ver Detalhes</a> |
                <a href="edicao.php?id=<?php echo $id; ?>">Editar</a> |
                <a href="remocao.php?id=<?php echo $id; ?>">Excluir</a>
            </div>
            <hr>
        <?php } ?>
    <?php } ?>
</body>
</html>