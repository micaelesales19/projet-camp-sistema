<?php
$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";

$materialCapaTrilha = array(
    'capa' => 'import/sistema/arquivos/01/Trilha/capa.jpg'
);

$materialContraCapaTrilha = array(
    'capa' => 'import/sistema/arquivos/01/Trilha/contracapa.jpg'
);

$materialCardsTrilha = array(
    'nome_visivel' => 'Versículos e Mistérios',
    'nome' => 'Versículos e Mistérios',
    'arquivo' => 'import/sistema/arquivos/01/Trilha/cards_novos.pdf'
);

$materialSemanarioTrilha = array(
    'nome' => 'Devocional Diário',
    'arquivo' => 'import/sistema/arquivos/01/Trilha/devocional.pdf'
);


$materialChequinhoTrilha = array(
    'nome' => 'Chequinho',
    'arquivo' => 'import/sistema/arquivos/01/Trilha/feirinha.pdf'
);

$materialIntroducaoTrilha = array(
    'id' => 1,
    'nome' => 'Introdução à Trilha',
    'nome_visivel' => 'Introdução',
    'arquivo' => 'import/sistema/arquivos/01/Trilha/introducao.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoTrilha = array(
    'id' => 2,
    'nome' => 'Manual da Trilha',
    'nome_visivel' => 'Manual',
    'arquivo' => 'import/sistema/arquivos/01/Trilha/Trilha.php?id_lider=' . $id_usuario . '&id_modulo=1',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoVisuaisTrilha1 = array(
    'id' => 3,
    'nome' => 'Visuais da Trilha',
    'nome_visivel' => 'Visuais',
    'arquivo' => 'import/sistema/arquivos/01/Trilha/visuais.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoVisuaisTrilha2 = array(
    'id' => 4,
    'nome' => 'Lição em PowerPoint da Trilha',
    'nome_visivel' => 'Lição em PowerPoint',
    'arquivo' => 'import/sistema/arquivos/01/Trilha/Trilha.ppsx',
    'imagem' => 'import/sistema/img/documento.png',
);
