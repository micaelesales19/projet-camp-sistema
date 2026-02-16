<?php
$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";

$materialCapaEstacao = array(
    'capa' => 'import/sistema/arquivos/01/Estacao/capa.jpg'
);

$materialContraCapaEstacao = array(
    'capa' => 'import/sistema/arquivos/01/Estacao/contracapa.jpg'
);

$materialCardsEstacao = array(
    'nome' => 'Versículos e Mistérios',
    'arquivo' => 'import/sistema/arquivos/01/Estacao/cards_novos.pdf'
);

$materialSemanarioEstacao = array(
    'nome' => 'Devocional Diário',
    'arquivo' => 'import/sistema/arquivos/01/Estacao/devocional.pdf'
);

$materialChequinhoEstacao = array(
    'id' => 0,
    'nome' => 'Chequinho',
    'arquivo' => 'import/sistema/arquivos/01/Estacao/feirinha.pdf'
);

$materialIntroducaoEstacao = array(
    'id' => 1,
    'nome' => 'Introdução',
    'nome_visivel' => 'Introdução à Estação Final',
    'arquivo' => 'import/sistema/arquivos/01/Estacao/introducao.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoEstacao = array(
    'id' => 2,
    'nome' => 'Manual da Estação Final',
    'nome_visivel' => 'Manual',
    'arquivo' => 'import/sistema/arquivos/01/Estacao/Estacao.php?id_lider=' . $id_usuario . '&id_modulo=5',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoVisuaisEstacao1 = array(
    'id' => 3,
    'nome' => 'Visuais da Estação Final',
    'nome_visivel' => 'Visuais',
    'arquivo' => 'import/sistema/arquivos/01/Estacao/visuais.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoVisuaisEstacao2 = array(
    'id' => 4,
    'nome' => 'Lição em PowerPoint da Estação Final',
    'nome_visivel' => 'Lição em PowerPoint',
    'arquivo' => 'import/sistema/arquivos/01/Estacao/EstaçãoFinal.ppsx',
    'imagem' => 'import/sistema/img/documento.png',
);

$materialLicaoVisuaisEstacao3 = array(
    'id' => 5,
    'nome' => 'Visuais da Estação Final (Novos)',
    'nome_visivel' => 'Visuais (Novos)',
    'arquivo' => 'import/sistema/arquivos/01/Estacao/visuais-novos.pdf',
    'imagem' => 'import/sistema/img/documento.png',
);
