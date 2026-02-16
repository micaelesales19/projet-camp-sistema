<?php
$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";

$materialCapaTerrarios = array(
    'capa' => 'import/sistema/arquivos/02/Terrarios/capa.jpg'
);

$materialContraCapaTerrarios = array(
    'capa' => ''
    //'capa' => 'import/sistema/arquivos/02/Terrarios/contracapa.jpg'
);

$materialCardsTerrarios = array(
    'nome' => 'Adesivos',
    'arquivo' => 'import/sistema/arquivos/02/Terrarios/adesivos.pdf'
);

$materialSemanarioTerrarios = array(
    'nome' => 'Devocional Diário',
    'arquivo' => 'import/sistema/arquivos/02/Terrarios/semanarios.pdf'
);

$materialChequinhoTerrarios = array(
    'id' => 0,
    'nome' => 'Chequinho',
    'arquivo' => 'import/sistema/arquivos/02/Terrarios/feirinha.pdf'
);

$materialIntroducaoTerrarios = array(
    'id' => 0
    /*'id' => 1,
    'nome' => 'Introdução à Expedição Verde 1',
    'arquivo' => 'import/sistema/arquivos/02/Terrarios/introducao.pdf',
    'imagem' => 'import/sistema/img/livro.png',*/
);

$materialLicaoTerrarios = array(
    'id' => 2,
    'nome_visivel' => 'Manual',
    'nome' => 'Manual do Ação Terrários - Exploradores do Subsolo',
    'arquivo' => 'import/sistema/arquivos/02/Terrarios/Terrarios.php?id_lider=' . $id_usuario . '&id_modulo=8',
    'imagem' => 'import/sistema/img/livro.png',
);

$materialLicaoVisuaisTerrarios1 = array(
    'id' => 3,
    'nome_visivel' => 'Visuais',
    'nome' => 'Visuais do Ação Terrários - Exploradores do Subsolo',
    'arquivo' => 'import/sistema/arquivos/02/Terrarios/visuais.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);


$materialLicaoVisuaisTerrarios2 = array(
    'id' => 0
    /*'id' => 4,
    'nome' => 'Lição em PowerPoint',
    'arquivo' => 'import/sistema/arquivos/02/Terrarios/Estação Final.ppsx',
    'imagem' => 'import/sistema/img/livro.png',*/
);

$materialLicaoVisuaisTerrarios3 = array(
    'id' => 4,
    'nome_visivel' => 'Visuais (Novos)',
    'nome' => 'Visuais do Ação Terrários - Exploradores do Subsolo (Novos)',
    'arquivo' => 'import/sistema/arquivos/02/Terrarios/visuais-novos.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);
