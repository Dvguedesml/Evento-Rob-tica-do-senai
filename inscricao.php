<?php
require_once 'init.php';

$id = $_GET['id'] ?? null;

if (!$id || !isset($_SESSION['eventos'][$id])) {
    echo "Evento não encontrado! <a href='index.php'>Voltar</a>";
    exit;
}

$evento = $_SESSION['eventos'][$id];
$capacidade = $evento['capacidade'] ?? 0;
$inscritos = $evento['inscritos'] ?? [];
$vagas_disponiveis = $capacidade - count($inscritos);
$erro = '';

// Bloqueios de segurança no PHP
if (($evento['status'] ?? 'ativo') === 'cancelado') {
    echo "Este evento está cancelado e não recebe inscrições. <a href='detalhes.php?id=$id'>Voltar</a>";
    exit;
}

if ($vagas_disponiveis <= 0) {
    echo "Este evento já está lotado! <a href='detalhes.php?id=$id'>Voltar</a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (empty($nome) || empty($email)) {
        $erro = "Preencha todos os campos!";
    } else {
        $ja_inscrito = false;

        foreach ($inscritos as $p) {
            if ($p['email'] === $email) {
                $ja_inscrito = true;
                break;
            }
        }

        if ($ja_inscrito) {
            $erro = "Este e-mail já está inscrito neste evento!";
        } else {
            $_SESSION['eventos'][$id]['inscritos'][] = [
                'nome' => $nome,
                'email' => $email
            ];
            header("Location: detalhes.php?id=$id");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Inscrição no Evento</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Inscrição: <?php echo $evento['titulo']; ?></h1>

    <?php if (!empty($erro)) { ?>
        <p style="color: red;"><?php echo $erro; ?></p>
    <?php } ?>

    <form method="POST">
        <label>Nome:</label><br>
        <input type="text" name="nome" value="<?php echo $_POST['nome'] ?? ''; ?>"><br><br>

        <label>E-mail:</label><br>
        <input type="email" name="email" value="<?php echo $_POST['email'] ?? ''; ?>"><br><br>

        <button type="submit">Confirmar Inscrição</button>
    </form>

    <br>
    <a href="detalhes.php?id=<?php echo $id; ?>">Voltar</a>
</body>
</html>