<?php
$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";

$materialCapaSegredos = array(
    'capa' => 'import/sistema/arquivos/02/Segredos/capa.jpg'
);

$materialContraCapaSegredos = array(
    'capa' => ''
    //'capa' => 'import/sistema/arquivos/02/Segredos/contracapa.jpg'
);

$materialCardsSegredos = array(
    'nome' => 'Adesivos',
    'arquivo' => 'import/sistema/arquivos/02/Segredos/adesivos.pdf'
);

$materialSemanarioSegredos = array(
    'nome' => 'Devocional Diário',
    'arquivo' => 'import/sistema/arquivos/02/Segredos/semanarios.pdf'
);

$materialChequinhoSegredos = array(
    'nome' => 'Chequinho',
    'arquivo' => 'import/sistema/arquivos/02/Segredos/feirinha.pdf'
);

$materialIntroducaoSegredos = array(
    'id' => 0
    /*'id' => 1,
    'nome' => 'Introdução à Expedição Animal 1',
    'arquivo' => 'import/sistema/arquivos/02/Segredos/introducao.pdf',
    'imagem' => 'import/sistema/img/livro.png',*/
);

$materialLicaoSegredos = array(
    'id' => 2,
    'nome_visivel' => 'Manual',
    'nome' => 'Manual da Expedição Animal 1 - Os Segredos',
    'arquivo' => 'import/sistema/arquivos/02/Segredos/Segredos.php?id_lider=' . $id_usuario . '&id_modulo=6',
    'imagem' => 'import/sistema/img/livro.png',
);

$materialLicaoVisuaisSegredos1 = array(
    'id' => 3,
    'nome_visivel' => 'Visuais',
    'nome' => 'Visuais da Expedição Animal 1 - Os Segredos',
    'arquivo' => 'import/sistema/arquivos/02/Segredos/visuais.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);


$materialLicaoVisuaisSegredos2 = array(
    'id' => 0
    /*'id' => 4,
    'nome' => 'Lição em PowerPoint',
    'arquivo' => 'import/sistema/arquivos/02/Segredos/Estação Final.ppsx',
    'imagem' => 'import/sistema/img/livro.png',*/
);
