<?php
// Lista de eventos
$eventos = [

    [
        "titulo" => "Workshop de PHP",
        "area" => "Tecnologia",
        "data" => "2026-10-05"
    ],

    [
        "titulo" => "Palestra de Marketing",
        "area" => "Marketing",
        "data" => "2026-10-10"
    ],

    [
        "titulo" => "Curso de Excel",
        "area" => "Educação",
        "data" => "2026-10-15"
    ]
];

$busca = $_GET["busca"] ?? "";
$area = $_GET["area"] ?? "";
$data = $_GET["data"] ?? "";

$resultados = [];

foreach ($eventos as $evento) {

    // Verifica o título
    $tituloCorreto = true;

    if ($busca != "") {

        if ($evento["titulo"] != $busca) {
            $tituloCorreto = false;
        }
    }

    // Verifica a área
    $areaCorreta = true;

    if ($area != "") {

        if ($evento["area"] != $area) {
            $areaCorreta = false;
        }
    }

    // Verifica a data
    $dataCorreta = true;

    if ($data != "") {

        if ($evento["data"] != $data) {
            $dataCorreta = false;
        }
    }

    // Os três filtros precisam estar corretos
    if ($tituloCorreto && $areaCorreta && $dataCorreta) {

        $resultados[] = $evento;
    }
}


// Verifica se não encontrou nenhum evento

if (count($resultados) == 0) {

    echo "Nenhum evento encontrado.";
}
