<?php
$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";

$materialCapaOperacao = array(
    'capa' => 'import/sistema/arquivos/02/Operacao/capa.jpg'
);

$materialContraCapaOperacao = array(
    'capa' => ''
    //'capa' => 'import/sistema/arquivos/02/Operacao/contracapa.jpg'
);

$materialCardsOperacao = array(
    'nome' => 'Adesivos',
    'arquivo' => 'import/sistema/arquivos/02/Operacao/adesivos.pdf'
);

$materialSemanarioOperacao = array(
    'nome' => 'Devocional Diário',
    'arquivo' => 'import/sistema/arquivos/02/Operacao/semanarios.pdf'
);

$materialChequinhoOperacao = array(
    'nome' => 'Chequinho',
    'arquivo' => 'import/sistema/arquivos/02/Operacao/feirinha.pdf'
);

$materialIntroducaoOperacao = array(
    'id' => 0
    /*'id' => 1,
    'nome' => 'Introdução à Expedição Verde 1',
    'arquivo' => 'import/sistema/arquivos/02/Operacao/introducao.pdf',
    'imagem' => 'import/sistema/img/livro.png',*/
);

$materialLicaoOperacao = array(
    'id' => 2,
    'nome_visivel' => 'Manual',
    'nome' => 'Manual da Expedição Verde 1 - A Colheita',
    'arquivo' => 'import/sistema/arquivos/02/Operacao/Operacao.php?id_lider=' . $id_usuario . '&id_modulo=9',
    'imagem' => 'import/sistema/img/livro.png',
);

$materialLicaoVisuaisOperacao1 = array(
    'id' => 3,
    'nome_visivel' => 'Visuais',
    'nome' => 'Visuais da Expedição Verde 1 - A Colheita',
    'arquivo' => 'import/sistema/arquivos/02/Operacao/visuais.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);


$materialLicaoVisuaisOperacao2 = array(
    'id' => 0
    /*'id' => 4,
    'nome' => 'Lição em PowerPoint',
    'arquivo' => 'import/sistema/arquivos/02/Operacao/Estação Final.ppsx',
    'imagem' => 'import/sistema/img/livro.png',*/
);
