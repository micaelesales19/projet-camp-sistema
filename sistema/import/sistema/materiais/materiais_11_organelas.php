<?php
$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";

$materialCapaOrganelas = array(
    'capa' => 'import/sistema/arquivos/03/Organelas/capa.JPG'
);

$materialContraCapaOrganelas = array(
    'capa' => 'import/sistema/arquivos/03/Organelas/contracapa.png'
);

$materialCardsOrganelas = array(
    'nome' => 'Adesivos',
    'arquivo' => 'import/sistema/arquivos/03/Organelas/adesivos.pdf'
);

$materialSemanarioOrganelas = array(
    'nome' => 'Devocional Diário',
    'arquivo' => 'import/sistema/arquivos/03/Organelas/semanarios.pdf'
);

$materialIntroducaoOrganelas = array(
    'id' => 0
    /*'id' => 1,
    'nome' => 'Introdução à Expedição Verde 1',
    'arquivo' => 'import/sistema/arquivos/03/Organelas/introducao.pdf',
    'imagem' => 'import/sistema/img/livro.png',*/
);

$materialLicaoOrganelas = array(
    'id' => 2,
    'nome_visivel' => 'Manual',
    'nome' => 'Manual Organelas',
    'arquivo' => 'import/sistema/arquivos/03/Organelas/Organelas.php?id_lider=' . $id_usuario . '&id_modulo=11',
    'imagem' => 'import/sistema/img/livro.png',
);

$materialLicaoVisuaisOrganelas1 = array(
    'id' => 3,
    'nome_visivel' => 'Visuais',
    'nome' => 'Visuais Organelas',
    'arquivo' => 'import/sistema/arquivos/03/Organelas/visuais.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);


$materialLicaoVisuaisOrganelas2 = array(
    'id' => 0
    /*'id' => 4,
    'nome' => 'Lição em PowerPoint',
    'arquivo' => 'import/sistema/arquivos/03/Organelas/Estação Final.ppsx',
    'imagem' => 'import/sistema/img/livro.png',*/
);
