<?php
$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
$id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

if (!isset($_SESSION['usuario'])) {
    header("location: ../../index.php");
}

?>
<!DOCTYPE html>
<html>
<!-- Head -->
<?php
$this->load->view('partes/head');
?>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="https://site.campbrasil.com/"><b>CAMP</b>Brasil</a>
        </div>

        <div class="login-box-body">
            <p class="login-box-msg">TERMO DE ADESÃO A SERVIÇO VOLUNTÁRIO E RESPONSABILIDADE PESSOAL</p>
            <form action="primeiro_acesso" method="POST">
                <!-- <form action="#" method="POST"> -->
                <div class="form-group has-feedback">
                    <p>
                        Eu, assumo mediante o Camp Brasil (Centro de Apoio Missional e Pastoral), nos termos da lei No. 9.608 de 18 de fevereiro de 1998 – “Lei do Voluntariado” - firmar o presente TERMO DE ADESÃO E RESPONSABILIDADE PESSOAL, com as seguintes cláusulas e condições:
                        1a) A adesão de uso deste material é uma decisão pessoal minha para a realização de encontros semanais com crianças em Pequenos Grupos ou células, em uma casa ou em uma igreja, pelo período de uma hora semanal, em um dia da semana que eu mesmo escolhi.
                        2a) Que estes encontros serão realizados objetivando ajudar crianças por meio de amizade, companheirismo e do ensino de valores éticos, orientação moral e ensinos espirituais para a vida das mesmas. E que ele será́ realizado com crianças da minha comunidade e com a permissão de seus responsáveis legais.
                        3a) Que a participação do CAMP Brasil neste trabalho é referente somente a ceder-me o material didático disponível para este fim, o qual se encontra em um site por meio de um sistema (plataforma). E ajudar-me com respeito a melhor forma de realizar estes encontros com transparência e na busca do bem-estar para as crianças.
                        4a) Como signatário tenho conhecimento que este serviço não gera vinculo empregatício, nem obrigação de natureza trabalhista, previdenciária ou afim com ou para o Camp Brasil.
                        5a) Eventuais despesas com este meu uso serão ressarcidas por mim mesmo, ou pela igreja na qual sirvo como membro, caso esta tenha assumido tal compromisso.
                        6a) O presente termo vigora por prazo indeterminado, podendo qualquer das partes rescindi-lo a qualquer tempo, sem qualquer ônus e independentemente de prévia comunicação.
                    </p>
                </div>
                <?php
                if ($x == "") {
                    $x .= 2;
                } else {
                }
                ?>
                <input type="hidden" value="<?= $id_usuario_2; ?>" name="id_usuario">
                <input type="hidden" value="<?= $x; ?>" name="x_ir">
                <input type="hidden" value="<?= $nivel; ?>" name="nivel">
                <div class="row">
                    <div class="col-xs-4">
                        <!-- <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button> -->
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Concordo</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.form-box -->
    </div>
    <?php
    $this->load->view('partes/scripts');
    ?>
</body>

</html>