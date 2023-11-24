<!DOCTYPE html>
<html>

<?php
date_default_timezone_set('America/Sao_Paulo');
$hora = date('H');
$nomeHora = "";

if ($hora >= 6 && $hora <= 12) {
    $nomeHora = 'Bom dia';
} else if ($hora > 12 && $hora <= 18) {
    $nomeHora = 'Boa tarde';
} else {
    $nomeHora = 'Boa noite';
}
?>

<head>
    <link href="import/css/bootstrap.min.css" rel="stylesheet">
    <meta charset="utf-8">
</head>

<body style="height: 800px; padding: 10px;">
    <div class="col-lg-12">
        <h1 style="text-align: center;">Projeto Lado a Lado - CAMP Brasil</h1>
        <p style="text-align:justify; font-size: 20px;">
            Olá <?= $nome; ?>, <?= $nomeHora; ?>! Hoje nosso tempo de conversa será:
        </p>
    </div>
    <div class="col-lg-12" style="padding-top: 30px; height: 532px; background-position: center;background-repeat: no-repeat;">
        <img src="<?= $devocionais['imagem']; ?>" alt="no file" />
    </div>
    <div class="col-lg-12">
        <p style="text-align:justify; font-size: 20px; margin-top:10px;">
            Atenciosamente, Equipe do CAMP Brasil
        </p>
    </div>
</body>

</html>