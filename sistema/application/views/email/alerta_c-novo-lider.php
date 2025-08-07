<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style>
        #teste {
            padding: 30px;
            text-align: center;
            background-color: #08CC42;
            /* //position: relative; */
        }

        #texto1 {
            font-size: 20px;
            color: #fff;
        }

        #texto2 {
            font-size: 30px;
            color: #fff;
        }

        #texto3 {
            text-align: justify;
            font-size: 20px;
            margin-top: 10px;
        }
    </style>
</head>

<body class="col-lg-12" style="background-color: #017fb5; padding: 10px;">
    <div class="col-lg-12">
        <h2 id="texto2" style="text-align: center;"><strong>Discipulando no Lar</strong></h2>
    </div>
    <div class="col-lg-12" id="teste">
        <p id="texto1">
            Olá <?= $nome; ?> Tenho uma notícia maravilhosa para você!<br>
            <?= $dados_lider['nome_lider']; ?> está solicitando liberação para entrar na sua equipe e começar a cumprir o ide de Jesus no discipulado de crianças.<br>
            Para que ele possa prosseguir com o processo de acesso é necessário que você libere a solicitação. Por favor, acesse o sistema, confirme se você treinou o líder e aprove a solicitação de <?= $dados_lider['nome_lider']; ?>.<br>
        </p>
        <p id="texto1">
            <strong>Clique no link para visualizar</strong>
            <a href="<?= $link; ?>" style="color: #fff;">
                <u>
                    <p style="font-size: 20px; color: #fff;">Clique Aqui</p>
                </u>
            </a>
        </p>
        <p id="texto1">
            Agradecemos desde já sua atenção e cooperação. Estamos ansiosos para ter <?= $dados_lider['nome_lider']; ?> na nossa equipe!<br>
        </p>
    </div>
    <div class="col-lg-12">
        <p id="texto1">
            Se tiver alguma dúvida ou precisar de mais informações, por favor não hesite em entrar em contato conosco.<br>
            Atenciosamente, Equipe do CAMP Brasil! Obrigado!
        </p>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</html>
