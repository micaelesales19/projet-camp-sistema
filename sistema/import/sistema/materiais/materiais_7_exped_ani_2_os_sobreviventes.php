<?php
$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";

$materialCapaSobreviventes = array(
    'capa' => 'import/sistema/arquivos/02/Sobreviventes/capa.jpg'
);

$materialContraCapaSobreviventes = array(
    'capa' => ''
    //'capa' => 'import/sistema/arquivos/02/Sobreviventes/contracapa.jpg'
);

$materialCardsSobreviventes = array(
    'nome' => 'Adesivos',
    'arquivo' => 'import/sistema/arquivos/02/Sobreviventes/adesivos.pdf'
);

$materialSemanarioSobreviventes = array(
    'nome' => 'Devocional Diário',
    'arquivo' => 'import/sistema/arquivos/02/Sobreviventes/semanarios.pdf'
);

$materialChequinhoSobreviventes = array(
    'nome' => 'Chequinho',
    'arquivo' => 'import/sistema/arquivos/02/Sobreviventes/feirinha.pdf'
);

$materialIntroducaoSobreviventes = array(
    'id' => 0
    /*'id' => 1,
    'nome' => 'Introdução à Expedição Animal 1',
    'arquivo' => 'import/sistema/arquivos/02/Sobreviventes/introducao.pdf',
    'imagem' => 'import/sistema/img/livro.png',*/
);

$materialLicaoSobreviventes = array(
    'id' => 2,
    'nome_visivel' => 'Manual',
    'nome' => 'Manual da Expedição Animal 2 - Os Sobreviventes',
    'arquivo' => 'import/sistema/arquivos/02/Sobreviventes/Sobreviventes.php?id_lider=' . $id_usuario . '&id_modulo=7',
    'imagem' => 'import/sistema/img/livro.png',
);

$materialLicaoVisuaisSobreviventes1 = array(
    'id' => 3,
    'nome_visivel' => 'Visuais',
    'nome' => 'Visuais da Expedição Animal 2 - Os Sobreviventes',
    'arquivo' => 'import/sistema/arquivos/02/Sobreviventes/visuais.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);


$materialLicaoVisuaisSobreviventes2 = array(
    'id' => 0
    /*'id' => 4,
    'nome' => 'Lição em PowerPoint',
    'arquivo' => 'import/sistema/arquivos/02/Sobreviventes/Estação Final.ppsx',
    'imagem' => 'import/sistema/img/livro.png',*/
);

$materialLicaoVisuaisSobreviventes3 = array(
    'id' => 4,
    'nome_visivel' => 'Visuais (Novos)',
    'nome' => 'Visuais da Expedição Animal 2 - Os Sobreviventes (Novos)',
    'arquivo' => 'import/sistema/arquivos/02/Sobreviventes/visuais-novos.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);
