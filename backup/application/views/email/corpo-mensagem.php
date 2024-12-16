<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body style="background: #017fb5; color: #fff; height: 1000px; padding: 10px;" class="col-lg-12">
    <div class="col-lg-12">
        <h1 style="text-align: center;">Projeto Lado a Lado - CAMP Brasil</h1>
        <h2 style="text-align: center;"><strong>Discipulando no Lar</strong></h2>
    </div>
    <div class="col-lg-12" style="padding-top: 30px; text-align: center; height: 300px; background-color:#08CC42;position: relative;">
        <p style="font-size: 20px; color: #fff; position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
            Olá supervisor(a) <?= $nomeSupervisor; ?> um pai se inscreveu no sistema, segue os dados para acompanhamento!<br>
            <?= $nome; ?><br>
            <?= $email; ?><br>
            <?= $telefone; ?><br>
            <?= $estado; ?>/<?= $cidade; ?><br>
        </p> 
        <p style="font-size: 20px; color: #fff; position: absolute;top: 50%;left: 50%;transform: translate(-50%, -50%);">
        <strong>Entre em contato com ele</strong>
        <a href="<?= $link; ?>" style="color: #fff;">
            <u>
                <p style="font-size: 20px; color: #fff;">Clique Aqui</p>
            </u>
        </a>
        </p>
    </div>
    <div class="col-lg-12">
        <p style="text-align:justify; font-size: 20px; margin-top:10px;">
            Atenciosamente, Equipe do CAMP Brasil
        </p>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</html>