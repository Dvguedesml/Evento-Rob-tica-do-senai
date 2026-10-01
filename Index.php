<?php 
require_once 'init.php'; 

$busca_titulo = trim($_GET['titulo'] ?? '');
$busca_area   = trim($_GET['area'] ?? '');
$busca_data   = trim($_GET['data'] ?? '');

$eventos_filtrados = [];

if (!empty($_SESSION['eventos'])) {
    foreach ($_SESSION['eventos'] as $id => $evento) {
        if ($busca_titulo !== '' && stripos($evento['titulo'], $busca_titulo) === false) {
            continue;
        }
        if ($busca_area !== '' && stripos($evento['area'], $busca_area) === false) {
            continue;
        }
        if ($busca_data !== '' && $evento['data'] !== $busca_data) {
            continue;
        }

        $eventos_filtrados[$id] = $evento;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Eventos SENAI</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Eventos do SENAI</h1>
    <a href="cadastro.php">Cadastrar novo Evento</a>
    <hr>

    <h2>Buscar e Filtrar Eventos</h2>
    <form method="GET" action="index.php">
        <div>
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" value="<?php echo $busca_titulo; ?>">

            <label for="area">Área:</label>
            <input type="text" name="area" id="area" value="<?php echo $busca_area; ?>">

            <label for="data">Data:</label>
            <input type="date" name="data" id="data" value="<?php echo $busca_data; ?>">

            <button type="submit">Filtrar</button>
            <a href="index.php">Limpar Filtros</a>
        </div>
    </form>
    <hr>

    <?php if (empty($_SESSION['eventos'])) { ?>
        <p>Nenhum evento cadastrado no sistema.</p>
    <?php } elseif (empty($eventos_filtrados)) { ?>
        <p>Nenhum evento encontrado com os critérios de busca informados.</p>
    <?php } else { ?>
        <?php foreach ($eventos_filtrados as $id => $evento) { 
            $status = $evento['status'] ?? 'ativo';
            $capacidade = $evento['capacidade'] ?? 0;
            $inscritos = $evento['inscritos'] ?? [];
            $vagas_disponiveis = $capacidade - count($inscritos);
        ?>
            <div>
                <h2>
                    <?php echo $evento['titulo']; ?>
                    <?php if ($status === 'cancelado') { echo " <span style='color:red;'>(CANCELADO)</span>"; } ?>
                </h2>
                <p><?php echo $evento['descricao']; ?></p>
                <p>Data: <?php echo $evento['data']; ?> | Horário: <?php echo $evento['inicio']; ?> às <?php echo $evento['fim']; ?></p>
                <p>Local: <?php echo $evento['local']; ?></p>
                <p><strong>Status:</strong> <?php echo $status; ?></p>
                <p><strong>Vagas Restantes:</strong> <?php echo $vagas_disponiveis; ?> de <?php echo $capacidade; ?></p>
                
                <a href="detalhes.php?id=<?php echo $id; ?>">Ver Detalhes</a> |
                <a href="edicao.php?id=<?php echo $id; ?>">Editar</a> |
                <a href="status_evento.php?id=<?php echo $id; ?>">Status</a> |
                <a href="remocao.php?id=<?php echo $id; ?>">Excluir</a>
            </div>
            <hr>
        <?php } ?>
    <?php } ?>
</body>
</html>