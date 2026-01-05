<?php
$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";

$materialCapaArco = array(
    'capa' => 'import/sistema/arquivos/01/Arco/capa.jpg'
);

$materialContraCapaArco = array(
    'capa' => 'import/sistema/arquivos/01/Arco/contracapa.jpg'
);

$materialCardsArco = array(
    'nome' => 'Versículos e Mistérios',
    'arquivo' => 'import/sistema/arquivos/01/Arco/cards_novos.pdf'
);

$materialSemanarioArco = array(
    'nome' => 'Devocional Diário',
    'arquivo' => 'import/sistema/arquivos/01/Arco/devocional.pdf'
);

$materialIntroducaoArco = array(
    'id' => 1,
    'nome' => 'Introdução ao Arco',
    'nome_visivel' => 'Introdução',
    'arquivo' => 'import/sistema/arquivos/01/Arco/introducao.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialChequinhoArco = array(
    'nome' => 'Chequinho',
    'arquivo' => 'import/sistema/arquivos/01/Arco/feirinha.pdf'
);

$materialLicaoArco = array(
    'id' => 2,
    'nome' => 'Manual do Arco',
    'nome_visivel' => 'Manual',
    'arquivo' => 'import/sistema/arquivos/01/Arco/Arco.php?id_lider=' . $id_usuario . '&id_modulo=4',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoVisuaisArco1 = array(
    'id' => 3,
    'nome' => 'Visuais do Arco',
    'nome_visivel' => 'Visuais',
    'arquivo' => 'import/sistema/arquivos/01/Arco/visuais.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoVisuaisArco2 = array(
    'id' => 4,
    'nome' => 'Lição em PowerPoint do Arco',
    'nome_visivel' => 'Lição em PowerPoint',
    'arquivo' => 'import/sistema/arquivos/01/Arco/Arco.ppsx',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoVisuaisArco3 = array(
    'id' => 5,
    'nome' => 'Visuais do Arco (Novos)',
    'nome_visivel' => 'Visuais (Novos)',
    'arquivo' => 'import/sistema/arquivos/01/Arco/visuais-novos.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);
