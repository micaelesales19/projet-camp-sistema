<?php
$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";

$materialCapaTrilha = array(
    'capa' => 'import/sistema/arquivos/01/Trilha/capa.jpg'
);

$materialContraCapaTrilha = array(
    'capa' => 'import/sistema/arquivos/01/Trilha/contracapa.jpg'
);

$materialCardsTrilha = array(
    'nome' => 'Versículos e Mistérios',
    'arquivo' => 'import/sistema/arquivos/01/Trilha/cards_novos.pdf'
);

$materialSemanarioTrilha = array(
    'nome' => 'Devocional Diário',
    'arquivo' => 'import/sistema/arquivos/01/Trilha/devocional.pdf'
);

$materialIntroducaoTrilha = array(
    'id' => 1,
    'nome' => 'Introdução à Trilha',
    'arquivo' => 'import/sistema/arquivos/01/Trilha/introducao.pdf',
    'imagem' => 'import/sistema/img/livro.png',
);

$materialLicaoTrilha = array(
    'id' => 2,
    'nome' => 'Manual da Trilha',
    'arquivo' => 'import/sistema/arquivos/01/Trilha/Trilha.php?id_lider=' . $id_usuario . '&id_modulo=1',
    'imagem' => 'import/sistema/img/livro.png',
);

$materialLicaoVisuaisTrilha1 = array(
    'id' => 3,
    'nome' => 'Visuais da Trilha',
    'arquivo' => 'import/sistema/arquivos/01/Trilha/visuais.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoVisuaisTrilha2 = array(
    'id' => 4,
    'nome' => 'PowerPoint - Trilha',
    'arquivo' => 'import/sistema/arquivos/01/Trilha/Trilha.ppsx',
    'imagem' => 'import/sistema/img/livro.png',
);
