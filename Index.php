<?php 
require_once 'init.php'; 

// 1. Capturar os valores enviados pelo formulário de busca (GET)
$busca_titulo = trim($_GET['titulo'] ?? '');
$busca_area   = trim($_GET['area'] ?? '');
$busca_data   = trim($_GET['data'] ?? '');

// 2. Filtrar a lista de eventos com base nos critérios informados
$eventos_filtrados = [];

if (!empty($_SESSION['eventos'])) {
    foreach ($_SESSION['eventos'] as $id => $evento) {
        // Filtro por Título (pesquisa parcial, ignora maiúsculas/minúsculas)
        if ($busca_titulo !== '' && stripos($evento['titulo'], $busca_titulo) === false) {
            continue;
        }

        // Filtro por Área (pesquisa parcial)
        if ($busca_area !== '' && stripos($evento['area'], $busca_area) === false) {
            continue;
        }

        // Filtro por Data (data exata)
        if ($busca_data !== '' && $evento['data'] !== $busca_data) {
            continue;
        }

        // Se passou por todos os filtros, adiciona na lista
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

    <!-- FORMULÁRIO DE BUSCA E FILTROS -->
    <h2>Buscar e Filtrar Eventos</h2>
    <form method="GET" action="index.php">
        <div>
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" placeholder="Digite o título..." value="<?php echo htmlspecialchars($busca_titulo); ?>">

            <label for="area">Área:</label>
            <input type="text" name="area" id="area" placeholder="Ex: Automação, TI..." value="<?php echo htmlspecialchars($busca_area); ?>">

            <label for="data">Data:</label>
            <input type="date" name="data" id="data" value="<?php echo htmlspecialchars($busca_data); ?>">

            <button type="submit">Filtrar</button>
            <a href="index.php">Limpar Filtros</a>
        </div>
    </form>
    <hr>

    <!-- LISTAGEM DOS EVENTOS -->
    <?php if (empty($_SESSION['eventos'])) { ?>
        <p>Nenhum evento cadastrado no sistema.</p>
    <?php } elseif (empty($eventos_filtrados)) { ?>
        <p>Nenhum evento encontrado com os critérios de busca informados.</p>
    <?php } else { ?>
        <?php foreach ($eventos_filtrados as $id => $evento) { 
            $status = $evento['status'] ?? 'ativo';
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