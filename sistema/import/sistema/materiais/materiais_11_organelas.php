<?php
$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";

$materialCapaOrganelas = array(
    'capa' => 'import/sistema/arquivos/03/Organelas/capa.JPG'
);

$materialContraCapaOrganelas = array(
    'capa' => 'import/sistema/arquivos/03/Organelas/contracapa.png'
);

$materialCardsOrganelas = array(
    'nome' => 'Código Estufas',
    'arquivo' => 'import/sistema/arquivos/03/Organelas/6 - CÓDIGOS ESTUFAS - CICLO III - Módulo 1 -  PROJETO ORGANELAS.pdf'
);

$materialSemanarioOrganelas = array(
    'nome' => 'Devocional Diário',
    'arquivo' => 'import/sistema/arquivos/03/Organelas/4 - SEMANARIOS - CICLO III – Módulo 1 –  PROJETO ORGANELAS.pdf'
);

$materialVersiculoOrganelas = array(
    'nome' => 'Versículos',
    'arquivo' => 'import/sistema/arquivos/03/Organelas/5 - VERSÍCULOS - CICLO III - Módulo 1 -  PROJETO ORGANELAS.pdf'
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

$materialComplementarOrganela = array(
    'id' => 5,
    'nome' => 'Teste de Dons',
    'arquivo' => 'import/sistema/arquivos/03/Organelas/10 - MATERIAL SUPLEMENTAR - TESTE DE DONS - CICLO III - Módulo 1 - PROJETO ORGANELAS.pdf',
);

$materialComplementarJogo1 = array(
    'id' => 5,
    'nome' => 'Jogo - Tabuleiro',
    'arquivo' => 'import/sistema/arquivos/03/Organelas/8 - MATERIAL SUPLEMENTAR - TABULEIRO MISSÃO MAKER.pdf',
);


$materialComplementarJogo2 = array(
    'id' => 5,
    'nome' => 'Jogo - Cartas 1',
    'arquivo' => 'import/sistema/arquivos/03/Organelas/3.1 - CARDS - CICLO III - Módulo 1 - PROJETO ORGANELAS.pdf',
);


$materialComplementarJogo3 = array(
    'id' => 5,
    'nome' => 'Jogo - Cartas 2',
    'arquivo' => 'import/sistema/arquivos/03/Organelas/3.3 - MINI CARDS - CICLO III - Módulo 1 -  PROJETO ORGANELAS.pdf',
);


$materialComplementarJogo4 = array(
    'id' => 10,
    'nome' => 'Jogo Completo',
    'arquivo' => 'https://drive.google.com/drive/folders/1_Kid2dPZpyEvHZXL7LPWsOT19kXL0y7G?usp=sharing',
);