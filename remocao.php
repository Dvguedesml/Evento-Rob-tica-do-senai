<?php
require_once 'init.php';

$id = $_REQUEST['id'] ?? null;

if (!$id || !isset($_SESSION['eventos'][$id])) {
    echo "Evento não encontrado! <a href='index.php'>Voltar</a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    unset($_SESSION['eventos'][$id]);
    header('Location: index.php');
    exit;
}

$evento = $_SESSION['eventos'][$id];
?>
