<?php
require_once 'init.php';

$busca = $_GET['busca'] ?? '';
$area = $_GET['area'] ?? '';
$data = $_GET['data'] ?? '';

$eventosFiltrados = [];

foreach ($_SESSION['eventos'] as $id => $evento) {

    // Busca pelo título
    if ($busca != '' && stripos($evento['titulo'], $busca) === false) {
        continue;
    }

    // Filtro por área
    if ($area != '' && $evento['area'] != $area) {
        continue;
    }

    // Filtro por data
    if ($data != '' && $evento['data'] != $data) {
        continue;
    }

    $eventosFiltrados[$id] = $evento;
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

    <!-- ÁREA DE FILTROS -->
    <div>

        <h2>Buscar e Filtrar Eventos</h2>

        <form method="GET" action="index.php">

            <label>
                Buscar pelo título:
                <input 
                    type="text" 
                    name="busca" 
                    placeholder="Digite o título do evento"
                    value="<?php echo htmlspecialchars($busca); ?>"
                >
            </label>

            <label>
                <br>
                <br>
                Área:
                <select name="area">
                    <option value="">Todas as áreas</option>

                    <?php
                    $areas = [];

                    foreach ($_SESSION['eventos'] as $evento) {
                        if (!in_array($evento['area'], $areas)) {
                            $areas[] = $evento['area'];
                        }
                    }

                    foreach ($areas as $nomeArea) {
                    ?>

                        <option 
                            value="<?php echo htmlspecialchars($nomeArea); ?>"
                            <?php if ($area == $nomeArea) echo 'selected'; ?>
                        >
                            <?php echo htmlspecialchars($nomeArea); ?>
                        </option>

                    <?php } ?>

                </select>
            </label>

            <label>
                <br>
                <br>
                Data:
                
                <input 
                    type="date" 
                    name="data"
                    value="<?php echo htmlspecialchars($data); ?>"
                >
            </label>

            <button type="submit">Buscar</button>

            <a href="index.php">Limpar filtros</a>

        </form>

    </div>


    <!-- LISTA DE EVENTOS -->

    <?php if (empty($eventosFiltrados)) { ?>

        <div>
            <p>Nenhum evento encontrado com os filtros informados.</p>
        </div>

    <?php } else { ?>

        <?php foreach ($eventosFiltrados as $id => $evento) { ?>

            <div>

                <h2>
                    <?php echo htmlspecialchars($evento['titulo']); ?>
                </h2>

                <p>
                    <?php echo htmlspecialchars($evento['descricao']); ?>
                </p>

                <p>
                    <strong>Área:</strong>
                    <?php echo htmlspecialchars($evento['area']); ?>
                </p>

                <p>
                    <strong>Data:</strong>
                    <?php echo htmlspecialchars($evento['data']); ?>
                </p>

                <p>
                    <strong>Horário:</strong>
                    <?php echo htmlspecialchars($evento['inicio']); ?>
                    às
                    <?php echo htmlspecialchars($evento['fim']); ?>
                </p>

                <p>
                    <strong>Local:</strong>
                    <?php echo htmlspecialchars($evento['local']); ?>
                </p>

                <a href="detalhes.php?id=<?php echo $id; ?>">
                    Ver Detalhes
                </a>

                |

                <a href="edicao.php?id=<?php echo $id; ?>">
                    Editar
                </a>

                |

                <a href="remocao.php?id=<?php echo $id; ?>">
                    Excluir
                </a>

            </div>

        <?php } ?>

    <?php } ?>

</body>

</html>