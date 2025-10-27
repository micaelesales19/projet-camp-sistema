<?php
$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";

$materialCapaSantuario = array(
    'capa' => 'import/sistema/arquivos/01/Santuario/capa.jpg'
);

$materialContraCapaSantuario = array(
    'capa' => 'import/sistema/arquivos/01/Santuario/contracapa.jpg'
);

$materialCardsSantuario = array(
    'nome' => 'Versículos e Mistérios',
    'arquivo' => 'import/sistema/arquivos/01/Santuario/cards_novos.pdf'
);

$materialSemanarioSantuario = array(
    'nome' => 'Devocional Diário',
    'arquivo' => 'import/sistema/arquivos/01/Santuario/devocional.pdf'
);

$materialChequinhoSantuario = array(
    'nome' => 'Chequinho',
    'arquivo' => 'import/sistema/arquivos/01/Santuario/feirinha.pdf'
);

$materialIntroducaoSantuario = array(
    'id' => 1,
    'nome' => 'Introdução ao Santuário',
    'nome_visivel' => 'Introdução',
    'arquivo' => 'import/sistema/arquivos/01/Santuario/introducao.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoSantuario = array(
    'id' => 2,
    'nome' => 'Manual do Santuário',
    'nome_visivel' => 'Manual',
    'arquivo' => 'import/sistema/arquivos/01/Santuario/Santuario.php?id_lider=' . $id_usuario . '&id_modulo=3',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoVisuaisSantuario1 = array(
    'id' => 3,
    'nome' => 'Visuais do Santuário',
    'nome_visivel' => 'Visuais',
    'arquivo' => 'import/sistema/arquivos/01/Santuario/visuais.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoVisuaisSantuario2 = array(
    'id' => 4,
    'nome' => 'Lição em PowerPoint',
    'nome_visivel' => 'Lição em PowerPoint',
    'arquivo' => 'import/sistema/arquivos/01/Santuario/Santuario.ppsx',
    'imagem' => 'import/sistema/img/documento.png',
);
