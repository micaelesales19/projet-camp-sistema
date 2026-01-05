<?php
$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";

$materialCapaEvolucao = array(
    'capa' => 'import/sistema/arquivos/02/Evolucao/capa.jpeg'
);

$materialContraCapaEvolucao = array(
    'capa' => ''
    //'capa' => 'import/sistema/arquivos/02/Evolucao/contracapa.jpg'
);

$materialCardsEvolucao = array(
    'nome' => 'Adesivos',
    'arquivo' => 'import/sistema/arquivos/02/Evolucao/adesivos.pdf'
);

$materialSemanarioEvolucao = array(
    'nome' => 'Devocional Diário',
    'arquivo' => 'import/sistema/arquivos/02/Evolucao/semanarios.pdf'
);

$materialChequinhoEvolucao = array(
    'nome' => 'Chequinho',
    'arquivo' => 'import/sistema/arquivos/02/Evolucao/feirinha.pdf'
);

$materialIntroducaoEvolucao = array(
    'id' => 0
    /*'id' => 1,
    'nome' => 'Introdução à Expedição Verde 1',
    'arquivo' => 'import/sistema/arquivos/02/Evolucao/introducao.pdf',
    'imagem' => 'import/sistema/img/livro.png',*/
);

$materialLicaoEvolucao = array(
    'id' => 2,
    'nome_visivel' => 'Manual',
    'nome' => 'Manual da Expedição Verde 2 - A Evolução',
    'arquivo' => 'import/sistema/arquivos/02/Evolucao/Evolucao.php?id_lider=' . $id_usuario . '&id_modulo=10',
    'imagem' => 'import/sistema/img/livro.png',
);

$materialLicaoVisuaisEvolucao1 = array(
    'id' => 3,
    'nome_visivel' => 'Visuais',
    'nome' => 'Visuais da Expedição Verde 2 - A Evolução',
    'arquivo' => 'import/sistema/arquivos/02/Evolucao/visuais.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);


$materialLicaoVisuaisEvolucao2 = array(
    'id' => 0
    /*'id' => 4,
    'nome' => 'Lição em PowerPoint',
    'arquivo' => 'import/sistema/arquivos/02/Evolucao/Estação Final.ppsx',
    'imagem' => 'import/sistema/img/livro.png',*/
);

$materialLicaoVisuaisEvolucao3 = array(
    'id' => 4,
    'nome_visivel' => 'Visuais (Novos)',
    'nome' => 'Visuais da Expedição Verde 2 - A Evolução',
    'arquivo' => 'import/sistema/arquivos/02/Evolucao/visuais-novos.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);
