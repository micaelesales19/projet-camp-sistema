<?php
$voltar = "../";
$array = array('voltar' => $voltar);

$CI = &get_instance();
$CI->load->model('FConsultas_model');
?>
<!DOCTYPE html>
<html>
<!-- Head -->
<?php
$this->load->view('partes/head');
?>

<script>
    function validar_form() {
        var dados = document.form_cadastro_lider.opc.checked;
        if (dados) {} else {
            alert("Você não concordou com os termos.");
            document.form_cadastro_lider.opc.focus;
            return false;
        }
    }

    function aparecer_select() {
        var opc = document.getElementById('pais').value;


        if (opc == "br") {
            document.getElementById('estaods2').value = '';
            document.getElementById('cidades2').value = '';
            document.getElementById('consultar_endereco').style.display = "inline";
            document.getElementById('escrever_endereco').style.display = "none";
        }

        if (opc == "outro") {
            document.getElementById('estados').value = '';
            document.getElementById('cidades').value = '';
            document.getElementById('escrever_endereco').style.display = "inline";
            document.getElementById('consultar_endereco').style.display = "none";
        }
    }
</script>

<style type="text/css" media="screen">
    #consultar_endereco {
        display: none;
    }

    #escrever_endereco {
        display: none;
    }

    /* The switch - the box around the slider */

    #linha {
        width: 60%;
        display: flex;
        flex-direction: row;
        justify-content: space-around;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 24px;
    }

    /* Hide default HTML checkbox */
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    /* The slider */
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        -webkit-transition: .4s;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 20px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        -webkit-transition: .4s;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: #2196F3;
    }

    input:focus+.slider {
        box-shadow: 0 0 1px #2196F3;
    }

    input:checked+.slider:before {
        -webkit-transform: translateX(26px);
        -ms-transform: translateX(26px);
        transform: translateX(26px);
    }

    /* Rounded sliders */
    .slider.round {
        border-radius: 24px;
    }

    .slider.round:before {
        border-radius: 50%;
    }
</style>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="register-logo">
            <a href="https://site.campbrasil.com/"><b>CAMP</b>Brasil</a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">Formulário de Cadastro</p>
            <h4>Preencha com todos os dados e informações válidas.</h4>

            <form action="cadastro/salvar" method="post" name="form_cadastro_lider">
                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="nome" minlength="5" placeholder="Seu nome" required>
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email" name="email" required>
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="CPF" minlength="11" name="cpf" required>
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Telefone (DDD + Telefone)" minlength="11" name="telefone" required>
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <select id="pais" name="pais" class="form-control" onchange="aparecer_select(this)">
                        <option value="" selected>País</option>
                        <option value="br">Brasil</option>
                        <option value="outro">Outros</option>
                    </select>
                    <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                </div>

                <div id="escrever_endereco">
                    <div class="form-group has-feedback">
                        <input type="text" id="estaods2" class="form-control" placeholder="Estado" name="estados2">
                        <span id="icon_outros" class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="text" id="cidades2" class="form-control" placeholder="Cidade" name="cidades2">
                        <span id="icon_outros" class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                    </div>
                </div>

                <div id="consultar_endereco">
                    <div class="form-group has-feedback">
                        <select id="estados" name="estados" class="form-control">
                            <option value=""></option>
                        </select>
                        <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <select id="cidades" name="cidades" class="form-control">
                        </select>
                        <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                    </div>
                </div>

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" minlength="5" placeholder="Igreja" name="igreja">
                    <span class="glyphicon glyphicon-home form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Data de Nascimento (DD/MM/YYYY)" minlength="10" maxlength="10" name="nascimento" required>
                    <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                </div>

                <div class="form-group has-feedback" id="linha">
                    Você tem colíder?
                    <label class="switch">
                        <input type="checkbox" name="checkColider" id="check" value="true" onclick="mostrar_form_colider();">
                        <span class="slider round"></span>
                    </label>
                </div>

                <script>
                    function mostrar_form_colider() {
                        const checked = document.querySelector('#check:checked') !== null;

                        if (checked) {
                            document.getElementById('form_colider').style.display = "inline";
                            document.getElementById('isColider').value = "1";
                        } else {
                            document.getElementById('form_colider').style.display = "none";
                            document.getElementById('isColider').value = "";
                        }
                    }
                </script>

                <input type="hidden" id="isColider" name="isColider" value="">
                <div id="form_colider" style="display: none;">
                    <p class="login-box-msg">Preencha com as informações do seu colíder</p>
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="nomeColider" minlength="5" placeholder="Nome do Colíder">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email do Colíder" name="emailColider">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="CPF do Colíder" minlength="11" name="cpfColider">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Telefone do Colíder (DDD + Telefone)" minlength="11" name="telefoneColider">
                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Data de Nascimento do Colíder (DD/MM/YYYY)" minlength="10" maxlength="10" name="nascimentoColider">
                        <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                    </div>
                </div>

                <div class="row" style="margin: 10px;">
                    <div class="col-xs-8">
                        <div class="checkbox icheck">
                            <label>
                                <input type="checkbox" id="opc" value="confirmado"> Eu li e aceito os <a data-toggle="modal" data-target="#termos">termos</a>
                                <div class="modal fade" id="termos">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">TERMO DE ADESÃO A SERVIÇO VOLUNTÁRIO E RESPONSABILIDADE PESSOAL</h4>
                                            </div>
                                            <div class="modal-body">
                                                <div class="box-body">
                                                    <p>Eu, assumo mediante o Camp Brasil (Centro de Apoio Missional e Pastoral), nos termos da lei No. 9.608 de 18 de fevereiro de 1998 – “Lei do Voluntariado” - firmar o presente TERMO DE ADESÃO E RESPONSABILIDADE PESSOAL, com as seguintes cláusulas e condições: 1a) A adesão de uso deste material é uma decisão pessoal minha para a realização de encontros semanais com crianças em Pequenos Grupos ou células, em uma casa ou em uma igreja, pelo período de uma hora semanal, em um dia da semana que eu mesmo escolhi. 2a) Que estes encontros serão realizados objetivando ajudar crianças por meio de amizade, companheirismo e do ensino de valores éticos, orientação moral e ensinos espirituais para a vida das mesmas. E que ele será́ realizado com crianças da minha comunidade e com a permissão de seus responsáveis legais. 3a) Que a participação do CAMP Brasil neste trabalho é referente somente a ceder-me o material didático disponível para este fim, o qual se encontra em um site por meio de um sistema (plataforma). E ajudar-me com respeito a melhor forma de realizar estes encontros com transparência e na busca do bem-estar para as crianças. 4a) Como signatário tenho conhecimento que este serviço não gera vinculo empregatício, nem obrigação de natureza trabalhista, previdenciária ou afim com ou para o Camp Brasil. 5a) Eventuais despesas com este meu uso serão ressarcidas por mim mesmo, ou pela igreja na qual sirvo como membro, caso esta tenha assumido tal compromisso. 6a) O presente termo vigora por prazo indeterminado, podendo qualquer das partes rescindi-lo a qualquer tempo, sem qualquer ônus e independentemente de prévia comunicação.</p>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                                            </div>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>
                            </label>
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <input type="submit" class="btn btn-primary btn-block btn-flat" value="Registar" id="msg-submit" onclick="return validar_form()">
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
    <script type="text/javascript">
        $(document).ready(function() {
            $.getJSON('<?php echo base_url('import/sistema/dist/js/estados_cidades.json'); ?>', function(data) {
                var items = [];
                var options = '<option value="">escolha um estado</option>';
                $.each(data, function(key, val) {
                    options += '<option value="' + val.nome + '">' + val.nome + '</option>';
                });
                $("#estados").html(options);
                $("#estados").change(function() {
                    var options_cidades = '';
                    var str = "";
                    $("#estados option:selected").each(function() {
                        str += $(this).text();
                    });
                    $.each(data, function(key, val) {
                        if (val.nome == str) {
                            $.each(val.cidades, function(key_city, val_city) {
                                options_cidades += '<option value="' + val_city + '" class="form-control">' + val_city + '</option>';
                            });
                        }
                    });
                    $("#cidades").html(options_cidades);
                }).change();
            });
        });
    </script>
    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        });
    </script>
</body>

</html>