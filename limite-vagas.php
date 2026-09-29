<?php
session_start();

// Inicia as listas vazias se elas não existirem
if (!isset($_SESSION['inscritos'])) {
    $_SESSION['inscritos'] = [];
}

// Configuração fixa e simples de vagas por evento
$vagas_por_evento = [
    "Senai cursos" => 3,
    "Eventos de robotica" => 5
];

$erro = "";
$sucesso = "";

// Processa quando o formulário é enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $evento = $_POST['evento'];

    // 1. Contar quantas pessoas já se inscreveram nesse evento
    $inscritos_nesse_evento = 0;
    foreach ($_SESSION['inscritos'] as $i) {
        if ($i['evento'] == $evento) {
            $inscritos_nesse_evento++;
        }
    }

    // 2. Verificar se o e-mail já está cadastrado NESSE mesmo evento
    $ja_cadastrado = false;
    foreach ($_SESSION['inscritos'] as $i) {
        if ($i['evento'] == $evento && $i['email'] == $email) {
            $ja_cadastrado = true;
        }
    }

    // 3. Validações básicas
    if (empty($nome) || empty($email) || empty($evento)) {
        $erro = "Preencha todos os campos!";
    } elseif ($ja_cadastrado) {
        $erro = "Este e-mail já está inscrito neste evento!";
    } elseif ($inscritos_nesse_evento >= $vagas_por_evento[$evento]) {
        $erro = "As vagas para este evento acabaram!";
    } else {
        // Se estiver tudo certo, salva a inscrição
        $_SESSION['inscritos'][] = [
            'nome' => $nome,
            'email' => $email,
            'evento' => $evento
        ];
        $sucesso = "Inscrição realizada com sucesso!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Inscrição Simples</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <h1>Formulário de Inscrição</h1>

    <!-- Exibe mensagens se houver -->
    <?php if ($erro) echo "<p style='color:red;'><b>Erro:</b> $erro</p>"; ?>
    <?php if ($sucesso) echo "<p style='color:green;'><b>Sucesso:</b> $sucesso</p>"; ?>

    <form method="POST" action="">
        Nome: <input type="text" name="nome" required><br><br>
        E-mail: <input type="email" name="email" required><br><br>
        
        Evento: 
        <select name="evento" required>
            <option value="">Selecione...</option>
            <option value="Senai cursos">Senai cursos (3 vagas)</option>
            <option value="Eventos de robotica">Eventos de robotica (5 vagas)</option>
        </select>
        <br><br>
        
        <button type="submit">Inscrever</button>
    </form>

    <hr>

    <h2>Lista de Inscritos</h2>
    <table border="1">
        <tr>
            <th>Evento</th>
            <th>Nome</th>
            <th>E-mail</th>
        </tr>
        <?php foreach ($_SESSION['inscritos'] as $i): ?>
        <tr>
            <td><?php echo $i['evento']; ?></td>
            <td><?php echo $i['nome']; ?></td>
            <td><?php echo $i['email']; ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
            <br><br>
    <a href="index.php">Voltar a tela inicial</a>

</body>
</html>