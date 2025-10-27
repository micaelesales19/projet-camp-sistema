<?php
$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";

$materialCapaMergulho = array(
    'capa' => 'import/sistema/arquivos/01/Mergulho/capa.jpg'
);

$materialContraCapaMergulho = array(
    'capa' => 'import/sistema/arquivos/01/Mergulho/contracapa.jpg'
);

$materialCardsMergulho = array(
    'nome' => 'Versículos e Mistérios',
    'arquivo' => 'import/sistema/arquivos/01/Mergulho/cards_novos.pdf'
);

$materialSemanarioMergulho = array(
    'nome' => 'Devocional Diário',
    'arquivo' => 'import/sistema/arquivos/01/Mergulho/devocional.pdf'
);

$materialChequinhoMergulho = array(
    'nome' => 'Chequinho',
    'arquivo' => 'import/sistema/arquivos/01/Mergulho/feirinha.pdf'
);

$materialIntroducaoMergulho = array(
    'id' => 1,
    'nome' => 'Introdução ao Mergulhuo',
    'nome_visivel' => 'Introdução',
    'arquivo' => 'import/sistema/arquivos/01/Mergulho/introducao.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoMergulho = array(
    'id' => 2,
    'nome' => 'Manual do Mergulho',
    'nome_visivel' => 'Manual',
    'arquivo' => 'import/sistema/arquivos/01/Mergulho/Mergulho.php?id_lider=' . $id_usuario . '&id_modulo=2',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoVisuaisMergulho1 = array(
    'id' => 3,
    'nome' => 'Visuais do Mergulho',
    'nome_visivel' => 'Visuais',
    'arquivo' => 'import/sistema/arquivos/01/Mergulho/visuais.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoVisuaisMergulho2 = array(
    'id' => 4,
    'nome' => 'Lição em PowerPoint do Mergulho',
    'nome_visivel' => 'Lição em PowerPoint',
    'arquivo' => 'import/sistema/arquivos/01/Mergulho/Mergulho.ppsx',
    'imagem' => 'import/sistema/img/documento.png',
);
