<?php

/** @var \$this */
if (!isset($_SESSION['usuario'])) {
    header("location: ../../index");
} else {
    $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
    $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

    $voltar = "../";
    $array = array('voltar' => $voltar);

    $dados_direcao = $this->Direcaos->infos([$id_usuario], 'info_direcao', '', '');
    $url_redirecionamento = current_url() . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '');
?>

    <!DOCTYPE html>
    <html>

    <?php
    $this->load->view('partes/head');
    $this->load->view('partes/scripts2');
    ?>
    <!-- Head -->
    <script>
        $(document).ready(function() {
            $('button[name="btn_link_cadastro"]').prop('disabled', true);
            consultardb();
        });

        function mostrarResultado() {

            console.log('CHAMANDO A FUNÇÃO ONCLICK');

            var opc1 = $('input[name="opc"]:checked').val();

            sessionStorage.setItem("opc1", opc1);

            var dataIn = document.getElementById('datepicker_de').value;
            var dataAte = document.getElementById('datepicker_ate').value;

            sessionStorage.setItem('data_in', dataIn);
            sessionStorage.setItem('data_final', dataAte);

            if (opc1 == 'opc1' || opc1 == 'opc2' || dataIn > '2018-02-01') {
                document.getElementById('comparar_msm_ano').disabled = false;
            } else {
                $('.class5').prop('checked', true);
                document.getElementById('comparar_msm_ano').disabled = true;
            }

            exibirStatus();
        }

        // excel
        function controler() {
            loader_1();
            var column1 = $('input[name="columns[]"]:checked');

            var column2 = $('input[name="columns_lideres[]"]:checked');

            var column3 = $('input[name="columns_criancas[]"]:checked');

            var column4 = $('input[name="columns_pg[]"]:checked');

            if (column1.length == 0 || column2.length == 0 || column3.length == 0 || column4.length == 0) {
                document.getElementById('mensagem_n_pode').innerHTML = "Você deve manter pelo menos uma coluna selecionada!";
                document.getElementById('btn_gerar').disabled = true;
            } else {
                document.getElementById('mensagem_n_pode').innerHTML = "";
                document.getElementById('btn_gerar').disabled = false;
            }
        }

        function consultardb() {
            console.log('consultar DB');

            $('input[name="opc"]').prop('disabled', true);

            document.getElementById('_controller').value = 0;

            var id_user = '<?= $id_usuario; ?>';
            var ativo = '';

            var opc2 = '';
            var opc1 = $('input[name="opc"]:checked').val();

            if (opc1 == 'opc3') {
                opc2 = 'nao';
            } else {
                opc2 = $('input[name="comparar_msm_ano"]:checked').val();
            }

            document.getElementById('opc1_').value = opc1;
            document.getElementById('opc2_').value = opc2;

            var dataIn = document.getElementById('datepicker_de').value;
            var dataFim = document.getElementById('datepicker_ate').value;

            document.getElementById('dataInicio_').value = dataIn;
            document.getElementById('dataAte_').value = dataFim;

            // elementos do preloader
            var loader = document.getElementById("preloader");
            var message = document.getElementById("message");
            var botao = document.getElementById("btn_gerar");

            // exibe o preloader antes de iniciar as consultas
            message.style.display = "inline";
            loader.style.display = "none";
            botao.disabled = true;

            $('#conteudos_table_informacoes_supervisores').empty();

            sessionStorage.setItem('opc1', opc1);
            sessionStorage.setItem('data_in', dataIn);
            sessionStorage.setItem('data_final', dataFim);

            // URL da requisição
            var url = 'supervisores/mostrar';
            /*var params = {
                id_user: id_user,
            };*/

            $.ajax({
                url: url,
                type: 'GET', // se quiser enviar via POST, troque para 'POST'
                dataType: 'html', // ou 'json' se o servidor retornar JSON
                beforeSend: function() {
                    console.log('🔄 Enviando requisição AJAX...');
                },
                success: function(data) {
                    if (document.getElementById('_controller').value == 0) {
                        console.log('✅ Dados recebidos com sucesso.');
                        $('#conteudos_table_informacoes_supervisores')
                            .empty()
                            .append(data);

                        $('input[name="opc"]').prop('disabled', false);
                        $('button[name="btn_link_cadastro"]').prop('disabled', false);
                        document.getElementById('_controller').value = 1;
                    }
                },
                error: function(xhr, status, error) {
                    console.error('❌ Erro na requisição AJAX:', error);
                    alert('Ocorreu um erro ao buscar os dados. Tente novamente.');
                    $('#conteudos_table_informacoes_supervisores')
                        .empty()
                        .append('❌ Erro na Consulta! O sistema encontrou um problema ao carregar as informações, atualize a página e/ou entre em contato com o suporte!');
                },
                complete: function() {
                    // independente de sucesso ou erro
                    message.style.display = "none";
                    loader.style.display = "inline";
                    botao.disabled = false;
                }
            });
        }

        function exibirStatus() {
            const control_2 = document.getElementById('_controller_2');
            if (control_2.value == 0) {
                console.log('atualizou');
                control_2.value = 1;
                document.getElementById('_controller_2').value = control_2.value;
                atualizar_session();
            } else {
                console.log('não precisa atualizar');
                atualizar_session();
            }
        }

        function enviar_whatsapp(telefones) {
            var telefone = "55" + telefones;
            var mensagem = 'olá';

            let isMobile = (function(a) {
                if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) {
                    return true
                } else {
                    return false
                }
            })(navigator.userAgent || navigator.vendor || window.opera)

            const makeLink_c = function(mode) {

                let mount = function() {
                    if (isMobile) {
                        let target = `whatsapp://send?`
                        if (!!telefone && telefone !== '') {
                            target += `phone=${encodeURIComponent(telefone)}&`
                        }
                        if (!!mensagem && mensagem !== '') {
                            target += `text=${encodeURIComponent(mensagem)}`
                        }
                        return target
                    } else {
                        let target = `https://api.whatsapp.com/send?`
                        if (!!telefone && telefone !== '') {
                            target += `phone=${encodeURIComponent(telefone)}&`
                        }
                        if (!!mensagem && mensagem !== '') {
                            target += `text=${encodeURIComponent(mensagem)}`
                        }
                        return target
                    }
                }

                document.getElementById('btn_enviar_c').value = mount();

            }

            makeLink_c('link')
            var xx = document.getElementById('btn_enviar_c').value;
            window.open(xx);
        }

        function loader_1() {
            var loader = document.getElementById("preloader");
            var message = document.getElementById("message");
            var botao = document.getElementById("btn_gerar");

            message.style.display = "inline";
            loader.style.display = "none";
            loader2.style.display = "none";
            botao.disabled = true;

            var dismissLoadingScreen = function() {
                message.style.display = "none";
                loader.style.display = "inline";
                loader2.style.display = "inline";
                botao.disabled = false;
            };

            setTimeout(dismissLoadingScreen, 3000);
        }

        function gerarELCopiarLink(id_usuario) {
            fetch(`<?= base_url('Direcao/criar_link/'); ?>${id_usuario}`)
                .then(response => response.json())
                .then(data => {
                    if (data.link) {
                        copiarTexto(data.link);
                    } else {
                        alert('Erro ao gerar o link.');
                    }
                })
                .catch(() => alert('Falha na requisição.'));
        }

        function copiarTexto(texto) {
            let inputTest = document.createElement("input");
            inputTest.value = texto;
            document.body.appendChild(inputTest);
            inputTest.select();
            document.execCommand('copy');
            document.body.removeChild(inputTest);

            document.getElementById('text_sucess').innerHTML = 'Código Copiado!';

            setTimeout(() => {
                document.getElementById('text_sucess').innerHTML = '';
            }, 3000);
        }

        function aparecer_select() {
            var opc = document.getElementById('pais').value;
            if (opc == "br") {
                document.getElementById('estados2').value = '';
                document.getElementById('cidades2').value = '';
                document.getElementById('pais2').value = '';
                document.getElementById('consultar_endereco').style.display = "inline";
                document.getElementById('escrever_endereco').style.display = "none";

                document.getElementById('precisa_cpf').style.display = "inline";
                document.getElementById('precisa_cpf_colider').style.display = "inline";

                document.getElementById('cpf').setAttribute('required', 'true');
                document.getElementById('cpf_colider').setAttribute('required', 'true');
            } else {
                if (opc == 'Moçambique') {
                    document.getElementById('pais2').value = 'Moçambique';
                } else {
                    document.getElementById('pais2').value = '';
                }
                document.getElementById('estados').value = '';
                document.getElementById('cidades').value = '';
                document.getElementById('escrever_endereco').style.display = "inline";
                document.getElementById('consultar_endereco').style.display = "none";

                document.getElementById('precisa_cpf').style.display = "none";
                document.getElementById('cpf').value = '';
                document.getElementById('cpf').removeAttribute('required');

                document.getElementById('precisa_cpf_colider').style.display = "none";
                document.getElementById('cpf_colider').value = '';
                document.getElementById('cpf_colider').removeAttribute('required');
            }
        }
    </script>

    <style>
        #precisa_cpf {
            display: none;
        }

        #precisa_cpf_colider {
            display: none;
        }

        .loader {
            border: 16px solid #f3f3f3;
            border-radius: 50%;
            border-top: 16px solid #39cccc;
            width: 80px;
            height: 80px;
            -webkit-animation: spin 2s linear infinite;
            /* Safari */
            animation: spin 2s linear infinite;
        }

        #clicar,
        #clicar_2 {
            cursor: pointer;
        }

        #consultar_endereco {
            display: none;
        }

        #escrever_endereco {
            display: none;
        }

        .icon-circle {
            background-color: #09ff00ff;
            color: black;
            padding: 8px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            font-size: 16px;
        }

        #imgPhoto_usuario {
            margin-top: 1%;
            width: 50px;
            height: 50px;
            padding: 1px;
            background-color: #eee;
            border: 1px solid #ccc;
            border-radius: 50%;
            transition: background .3s;
        }

        /* Safari */
        @-webkit-keyframes spin {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <!-- Menu -->
            <?php
            $this->load->view('sistema/direcao/partes/menu_lateral', $array);
            ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                <input type="hidden" id="_controller" value="0">
                <input type="hidden" id="_controller_2" value="0">
                <input type="hidden" id="btn_enviar_c" value="">

                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Equipe: <?= $dados_direcao['dados']['nome_direcao']; ?>
                        <small>Painel de Controle</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="../home"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Supervisores</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <!-- CRIANÇAS -->
                        <div class="box box-info">

                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-table"></i> Seus Supervisores</h3>

                                <button type="button" name="btn_link_cadastro" class="btn btn-success" onclick="gerarELCopiarLink('<?= $id_usuario; ?>')" disabled>Copiar Link de Cadastro Supervisor <i class="fa fa-link"></i></button>

                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cadastro_supervisor">Cadastrar Supervisor +</button>

                                <p id="text_sucess"></p>

                                <div class="modal fade" id="cadastro_supervisor">
                                    <div class="modal-dialog modal-success">
                                        <div class="modal-content">
                                            <form action="supervisor/salvar" method="POST">
                                                <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">Cadastro | Supervisor</h4>
                                                </div>
                                                <div class="box-body">

                                                    <div class="col-lg-12">
                                                        <div class="col-lg-6">
                                                            <div class="form-group has-feedback">
                                                                <select id="pais" name="pais" class="form-control" onchange="aparecer_select(this)">
                                                                    <option value="" selected>País</option>
                                                                    <option value="br">Brasil</option>
                                                                    <option value="Moçambique">Moçambique</option>
                                                                    <option value="outro">Outros</option>
                                                                </select>
                                                                <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                                            </div>
                                                        </div>
                                                        <div id="escrever_endereco">
                                                            <div class="col-lg-6">
                                                                <div class="form-group has-feedback">
                                                                    <input type="text" id="pais2" class="form-control" placeholder="Pais" name="nome_pais">
                                                                    <span id="icon_outros" class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group has-feedback">
                                                                    <input type="text" id="estados2" class="form-control" placeholder="Estado/Província/Região" name="estados2">
                                                                    <span id="icon_outros" class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group has-feedback">
                                                                    <input type="text" id="cidades2" class="form-control" placeholder="Cidade/Município/Distrito" name="cidades2">
                                                                    <span id="icon_outros" class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="consultar_endereco">
                                                            <div class="col-lg-6">
                                                                <div class="form-group has-feedback">
                                                                    <select id="estados" name="estados" class="form-control">
                                                                        <option value=""></option>
                                                                    </select>
                                                                    <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div class="form-group has-feedback">
                                                                    <select id="cidades" name="cidades" class="form-control">
                                                                    </select>
                                                                    <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group has-feedback">
                                                            <input type="text" class="form-control" name="nome" minlength="5" placeholder="Nome">
                                                            <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group has-feedback">
                                                            <input type="email" class="form-control" placeholder="Email" name="email">
                                                            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group has-feedback">
                                                            <input type="text" class="form-control" placeholder="Telefone do Colíder (DDD + Telefone)" minlength="11" name="telefone">
                                                            <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group has-feedback">
                                                            <input type="text" class="form-control" placeholder="Data de Nascimento (DD/MM/YYYY)" minlength="10" maxlength="10" name="nascimento">
                                                            <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group has-feedback">
                                                            <input type="password" class="form-control" placeholder="Senha" name="senha" required>
                                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group has-feedback" id="precisa_cpf">
                                                            <input type="text" class="form-control" placeholder="CPF" minlength="11" name="cpf" id="cpf" maxlength="14">
                                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                                                    <input type="submit" class="btn btn-default pull-right" value="Salvar">
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>

                            <style>
                                .input-group {
                                    display: flex;
                                    justify-content: space-between;
                                }

                                .input-group-addon {
                                    border: 0cm;
                                }

                                #label {
                                    margin-left: 5px;
                                }
                            </style>

                            <!-- /.box-header -->
                            <div class="box-body table-responsive no-padding">

                                <div class="col-lg-12" style="padding: 20px;">
                                    <div class="row">
                                        <div class="col-lg-12" style="padding: 10px; display: flex;">
                                            <h4>Período:</h4>

                                            <script>
                                                document.addEventListener('DOMContentLoaded', function() {
                                                    // Recupera o valor da sessão ou usa 'opc1' como padrão
                                                    var session_opc1 = sessionStorage.getItem('opc1') || 'opc4';

                                                    // Seleciona o radio com o mesmo value e marca como checked
                                                    const radio = document.querySelector(`input[name="opc"][value="${session_opc1}"]`);
                                                    if (radio) {
                                                        radio.checked = true;
                                                    }

                                                    // Recupera as sessões ou define valores padrões
                                                    var dataInicio = sessionStorage.getItem('data_in') || '2018-02-01';
                                                    var dataFinal = sessionStorage.getItem('data_final') || '';

                                                    // Atualiza os inputs se os elementos existirem
                                                    const inputDe = document.getElementById('datepicker_de');
                                                    const inputAte = document.getElementById('datepicker_ate');

                                                    if (inputDe) {
                                                        inputDe.value = dataInicio;
                                                    }

                                                    if (inputAte && dataFinal !== '') {
                                                        inputAte.value = dataFinal;
                                                    }
                                                });
                                            </script>

                                            <!-- /input-group -->
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="radio" id="opc" name="opc" value="opc1" class="radio1"
                                                        onclick="mostrarResultado();" disabled>
                                                </span>
                                                <h5 id="label">Último mês</h5>
                                            </div>
                                            <!-- /input-group -->
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="radio" id="opc" name="opc" value="opc2" class="radio2"
                                                        onclick="mostrarResultado();" checked disabled>
                                                </span>
                                                <h5 id="label">Últimos 6 meses</h5>
                                            </div>

                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="radio" id="opc" name="opc" value="opc3" class="radio3" onclick="mostrarResultado();" disabled>
                                                </span>
                                                <h5 id="label">Desde 2017</h5>
                                            </div>

                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="radio" id="opc" name="opc" class="radio4" value="opc4"
                                                        onclick="mostrarResultado();" disabled>
                                                </span>
                                            </div>
                                            <!-- /input-group -->

                                            <?php
                                            date_default_timezone_set('America/Sao_Paulo');
                                            $data = date('d-m-Y');
                                            $data_2 = date('Y-m-d');
                                            ?>

                                            <h5 id="label">De: </h5>
                                            <input id="datepicker_de" type="date" name="data_1" onchange="mudou();" value="2017-02-01" min="2017-02-01" max="<?= $data_2; ?>" />
                                            <h5 id="label">Até: </h5>
                                            <input id="datepicker_ate" type="date" name="data_2" onchange="mudou();" value="<?= $data_2; ?>" min="2017-02-01" max="<?= $data_2; ?>" />

                                            <script>
                                                var hoje = new Date();

                                                function mudou() {
                                                    $('.radio4').prop('checked', true);
                                                    var data_1 = document.getElementById('datepicker_de').value;
                                                    var data_2 = document.getElementById('datepicker_ate').value;

                                                    if (data_2 < data_1) {
                                                        alert('A Data (Até) não pode ser menor que a Data (De)');
                                                    } else {
                                                        mostrarResultado();
                                                    }
                                                }
                                            </script>
                                        </div>
                                        <!-- justify-content: space-between; -->
                                        <!-- <input type="hidden" id="comparar_msm_ano" name="comparar_msm_ano" value="nao" class="class5" onclick="mostrarResultado();" checked> -->
                                        <!-- desabilitar por enquanto -->
                                        <div class="col-lg-12" style="padding: 10px; display:none; justify-content: start;">
                                            <div class="col-lg-6" style="display: flex; justify-content: start;">
                                                <h5>Deseja comparar com o mesmo período do ano anterior?</h5>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input type="radio" id="comparar_msm_ano" name="comparar_msm_ano" value="sim" onclick="mostrarResultado();">
                                                    </span>
                                                    <h5 id="label">Sim </h5>
                                                </div>
                                                <div class="input-group">
                                                    <span class="input-group-addon">
                                                        <input type="radio" id="comparar_msm_ano" name="comparar_msm_ano" value="nao" class="class5" onclick="mostrarResultado();" checked>
                                                    </span>
                                                    <h5 id="label">Não</h5>
                                                </div>
                                            </div>

                                            <div style="display: flex;">
                                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-table"></i> Gerar Excel</a>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- fa-mouse-pointer -->
                                    <div class="table-responsive" id="preloader" style="display: none;">
                                        <div id="conteudos_table_informacoes_supervisores"></div>
                                    </div>

                                    <div class="box-body" id="message">
                                        <center>
                                            <div class="loader"></div>
                                            <h5><i>Carregando as Informações... Isso pode demorar!</i></h5>
                                        </center>
                                    </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </section>
                <!-- /.content -->
            </div>
            <!-- Footer -->
            <?php
            $this->load->view('partes/footer');
            ?>
            <!-- Links JavaScript -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Create the tabs -->
                <ul class="nav nav-tabs control-sidebar-tabs">
                    <li class="active">
                        <a href="#control-sidebar-settings-tab" data-toggle="control-sidebar">
                            <i class="fa fa-table"></i> Gerar Excel
                        </a>
                    </li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <!-- Settings tab content -->
                    <div class="tab-pane active" id="control-sidebar-settings-tab">
                        <form action="lideres/gerar_excel" method="post">

                            <input type="hidden" name="id_coordenador" value="<?= $id_usuario; ?>">
                            <input type="hidden" name="opc1" id="opc1_" value="">
                            <input type="hidden" name="opc2" id="opc2_" value="">
                            <input type="hidden" name="dataInicio" id="dataInicio_" value="">
                            <input type="hidden" name="dataAte" id="dataAte_" value="">

                            <h3 class="control-sidebar-heading">Informações Gerais</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Total de Líderes
                                    <input type="checkbox" class="pull-right" name="columns[]" value="total_lideres_1" onclick="controler()" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Total de Líderes Ativos
                                    <input type="checkbox" class="pull-right" name="columns[]" value="total_lideres_2" onclick="controler()" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Total de Crianças
                                    <input type="checkbox" class="pull-right" name="columns[]" value="total_criancas_1" onclick="controler()" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Total de Crianças Ativas
                                    <input type="checkbox" class="pull-right" name="columns[]" value="total_criancas_2" onclick="controler()" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <h3 class="control-sidebar-heading">Informações do PG</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Quantidade de Criança
                                    <input type="checkbox" class="pull-right" name="columns_pg[]" value="column1" onclick="controler()" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Ciclo
                                    <input type="checkbox" class="pull-right" name="columns_pg[]" value="column2" onclick="controler()" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Módulo
                                    <input type="checkbox" class="pull-right" name="columns_pg[]" value="column3" onclick="controler()" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Lição
                                    <input type="checkbox" class="pull-right" name="columns_pg[]" value="column4" onclick="controler()" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <h3 class="control-sidebar-heading">Informações dos Líderes</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Nome
                                    <input type="checkbox" class="pull-right" name="columns_lideres[]" value="column1" onclick="controler()" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    E-mail
                                    <input type="checkbox" class="pull-right" name="columns_lideres[]" value="column2" onclick="controler()" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Telefone
                                    <input type="checkbox" class="pull-right" name="columns_lideres[]" value="column3" onclick="controler()" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Pais
                                    <input type="checkbox" class="pull-right" name="columns_lideres[]" value="column4" onclick="controler()" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Estado
                                    <input type="checkbox" class="pull-right" name="columns_lideres[]" value="column5" onclick="controler()" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Cidade
                                    <input type="checkbox" class="pull-right" name="columns_lideres[]" value="column6" onclick="controler()" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->
                            <h3 class="control-sidebar-heading">Informações das Crianças</h3>

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Nome
                                    <input type="checkbox" class="pull-right" name="columns_criancas[]" onclick="controler()" value="column1" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->

                            <div class="form-group">
                                <label class="control-sidebar-subheading">
                                    Data de Nascimento
                                    <input type="checkbox" class="pull-right" name="columns_criancas[]" onclick="controler()" value="column2" checked>
                                </label>
                            </div>
                            <!-- /.form-group -->
                            <p id="mensagem_n_pode"></p>
                            <input type="submit" class="btn btn-success btn-block" name="gerarExcel" id="btn_gerar" value="Gerar" />
                        </form>

                    </div>
                    <!-- /.tab-pane -->
                </div>
            </aside>
            <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>

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
    </body>

    </html>
<?php
} ?>
