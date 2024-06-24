<?php

/** @var \$this */
if (!isset($_SESSION['usuario'])) {
    header("location: ../../index");
} else {

    $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
    $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

    $voltar = "../";
    $array = array('voltar' => $voltar);

    $CI = &get_instance();
    $CI->load->model('FConsultas_model');

    $dados_coordenador = $this->FConsultas_model->getInfoCoordenadorId($id_usuario);

    $id_pastor = "2000";
    $id_sr = $dados_coordenador['dados']['id_supervisorR'];
    $id_se = $dados_coordenador['dados']['id_supervisorE'];

    $link = "http://campbrasil.com/sistema/php/cadastro_lider.php?um=$id_pastor&dois=$id_usuario&tres=$id_sr&quatro=$id_se";

?>
    <!DOCTYPE html>
    <html>

    <?php
    $this->load->view('partes/head');
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script>
        function loader_1() {
            var loader = document.getElementById("preloader");
            var loader2 = document.getElementById("preloader2");
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

        let copiarTexto = (texto) => {
            //O texto que será copiado
            //const texto = "00020126470014br.gov.bcb.pix0125campbrasilemail@gmail.com27600016BR.COM.PAGSEGURO013659BAD104-74E5-4E29-8EE8-9738E5D5784A5204000053039865802BR5925CAMP - CENTRO DE APOIO MI6007Caucaia62290525PAGS0000000002404131224896304431F";
            //Cria um elemento input (pode ser um textarea)
            let inputTest = document.createElement("input");
            inputTest.value = texto;
            //Anexa o elemento ao body
            document.body.appendChild(inputTest);
            //seleciona todo o texto do elemento
            inputTest.select();
            //executa o comando copy
            //aqui é feito o ato de copiar para a area de trabalho com base na seleção
            document.execCommand('copy');
            //remove o elemento
            document.body.removeChild(inputTest);

            document.getElementById('text_sucess').innerHTML = 'Código Copiado!';
        };

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
    <!-- Head -->

    <script>
        function AjaxF() {
            var ajax;

            try {
                ajax = new XMLHttpRequest();
            } catch (e) {
                try {
                    ajax = new ActiveXObject("Msxml2.XMLHTTP");
                } catch (e) {
                    try {
                        ajax = new ActiveXObject("Microsoft.XMLHTTP");
                    } catch (e) {
                        alert("Seu browser não da suporte à AJAX!");
                        return false;
                    }
                }
            }
            return ajax;
        }

        $(document).ready(function() {
            mostrarResultado();
        });

        function mostrarResultado() {

            loader_1();
            var opc1 = $('input[name="opc"]:checked').val();

            var dataIn = document.getElementById('datepicker_de').value;

            if (opc1 == 'opc1' || opc1 == 'opc2' || dataIn > '2018-02-01') {
                document.getElementById('comparar_msm_ano').disabled = false;
            } else {
                $('.class5').prop('checked', true);
                document.getElementById('comparar_msm_ano').disabled = true;
            }

            setTimeout(function() {
                consultardb();
            }, 3000);
            /**/
        }

        function controler() {
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
            var ajax = AjaxF();

            document.getElementById('_controller').value = 0;

            var id_coordenador = '<?= $id_usuario; ?>';

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

            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4) {
                    document.getElementById('conteudos_table_informacoes_gerais').innerHTML = ajax.responseText;
                }
            }

            ajax.open("GET", "lideres/mostrar1?id_coordenador=" + id_coordenador + "&opc1=" + opc1 + "&opc2=" + opc2 + "&dataInicio=" + dataIn + "&dataAte=" + dataFim, false);

            ajax.setRequestHeader("Content-Type", "text/html");
            ajax.send();

            /*var url;
            url = 'lideres/mostrar2?id_coordenador=' + id_coordenador + "&opc1=" + opc1 + "&opc2=" + opc2 + "&dataInicio=" + dataIn + "&dataAte=" + dataFim;
            jQuery.get(url, function(data) {
                $('#conteudos_table_info_lideres').empty().append(data);
            });*/

            var control = document.getElementById('_controller').value;
            if (control == 0) {
                list_lideres();
            } else {}
        }


        function list_lideres() {

            loader_1();
            var id_coordenador = '<?= $id_usuario; ?>';

            document.getElementById('_controller').value = 0;

            var opc2 = '';

            var opc1 = $('input[name="opc"]:checked').val();

            if (opc1 == 'opc3') {
                opc2 = 'nao';
            } else {
                opc2 = $('input[name="comparar_msm_ano"]:checked').val();
            }

            var dataIn = document.getElementById('datepicker_de').value;
            var dataFim = document.getElementById('datepicker_ate').value;

            $('#conteudos_table_info_lideres').empty();

            var url;
            url = 'lideres/mostrar2?id_coordenador=' + id_coordenador + "&opc1=" + opc1 + "&opc2=" + opc2 + "&opc3=''" + "&dataInicio=" + dataIn + "&dataAte=" + dataFim;
            jQuery.get(url, function(data) {
                $('#conteudos_table_info_lideres').empty().append(data);
            });
        }

        function list_lideres_ativos() {

            loader_1();
            var id_coordenador = '<?= $id_usuario; ?>';

            document.getElementById('_controller').value = 1;

            var opc1 = document.getElementById('opc1_').value;
            var opc2 = document.getElementById('opc2_').value;
            var dataIn = document.getElementById('dataInicio_').value;
            var dataFim = document.getElementById('dataAte_').value;

            $('#conteudos_table_info_lideres').empty();

            var url;
            url = 'lideres/mostrar2?id_coordenador=' + id_coordenador + "&opc1=" + opc1 + "&opc2=" + opc2 + "&opc3=lideres_ativos" + "&dataInicio=" + dataIn + "&dataAte=" + dataFim;
            jQuery.get(url, function(data) {
                $('#conteudos_table_info_lideres').empty().append(data);
            });
        }
    </script>

    <style>
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

        #clicar {
            cursor: pointer;
        }

        #consultar_endereco {
            display: none;
        }

        #escrever_endereco {
            display: none;
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
            $this->load->view('sistema/coordenador/partes/menu_lateral', $array);
            ?>

            <input type="hidden" id="_controller" value="0">

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Líderes
                        <small>Painel de Controle</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="../home"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Líderes</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <!-- CRIANÇAS -->
                        <div class="box box-info">

                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-table"></i> Seus Líderes</h3>

                                <a href="#" onclick="copiarTexto('<?= $link; ?>')" style="color:white;" class="btn btn-success">
                                    Copiar Link de Cadastro <i class="fa fa-link"></i>
                                </a>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cadastro_lider">Cadastrar +</button>

                                <p id="text_sucess"></p>

                                <div class="modal fade" id="cadastro_lider">
                                    <div class="modal-dialog modal-success">
                                        <div class="modal-content">
                                            <form action="../../lider/salvar" method="POST">
                                                <input type="hidden" name="id_pastor" value="<?= $id_pastor; ?>">
                                                <input type="hidden" name="id_coordenador" value="<?= $id_usuario; ?>">
                                                <input type="hidden" name="id_slocal" value="<?= $id_sr; ?>">
                                                <input type="hidden" name="id_sregional" value="<?= $id_se; ?>">
                                                <input type="hidden" name="red" value="coordenador/lideres">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">Cadastro | Líder</h4>
                                                </div>
                                                <div class="box-body">

                                                    <div class="col-lg-12">
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
                                                            <input type="text" class="form-control" placeholder="CPF" minlength="11" name="cpf" minlength="11">
                                                            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
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

                                                    <div class="col-lg-12">
                                                        <div class="col-lg-4">
                                                            <div class="form-group has-feedback">
                                                                <select id="pais" name="pais" class="form-control" onchange="aparecer_select(this)">
                                                                    <option value="" selected>País</option>
                                                                    <option value="br">Brasil</option>
                                                                    <option value="outro">Outros</option>
                                                                </select>
                                                                <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                                            </div>
                                                        </div>
                                                        <div id="escrever_endereco">
                                                            <div class="col-lg-4">
                                                                <div class="form-group has-feedback">
                                                                    <input type="text" id="estaods2" class="form-control" placeholder="Estado" name="estados2">
                                                                    <span id="icon_outros" class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group has-feedback">
                                                                    <input type="text" id="cidades2" class="form-control" placeholder="Cidade" name="cidades2">
                                                                    <span id="icon_outros" class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div id="consultar_endereco">
                                                            <div class="col-lg-4">
                                                                <div class="form-group has-feedback">
                                                                    <select id="estados" name="estados" class="form-control">
                                                                        <option value=""></option>
                                                                    </select>
                                                                    <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-4">
                                                                <div class="form-group has-feedback">
                                                                    <select id="cidades" name="cidades" class="form-control">
                                                                    </select>
                                                                    <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group has-feedback">
                                                            <input type="text" class="form-control" placeholder="Igreja" minlength="5" name="igreja">
                                                            <span class="glyphicon glyphicon-home form-control-feedback"></span>
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
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="radio" id="opc" name="opc" value="opc1" class="radio1" onclick="mostrarResultado();">
                                                </span>
                                                <h5 id="label">Último mês</h5>
                                            </div>
                                            <!-- /input-group -->
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="radio" id="opc" name="opc" value="opc2" class="radio2" onclick="mostrarResultado();" checked>
                                                </span>
                                                <h5 id="label">Últimos 6 meses</h5>
                                            </div>
                                            <!-- /input-group -->
                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="radio" id="opc" name="opc" value="opc3" class="radio3" onclick="mostrarResultado();">
                                                </span>
                                                <h5 id="label">Desde 2017</h5>
                                            </div>
                                            <!-- /input-group -->

                                            <div class="input-group">
                                                <span class="input-group-addon">
                                                    <input type="radio" id="opc" name="opc" class="radio4" value="opc4" onclick="mostrarResultado();">
                                                </span>
                                                <?php
                                                date_default_timezone_set('America/Sao_Paulo');
                                                $data = date('d-m-Y');
                                                $data_2 = date('Y-m-d');
                                                ?>
                                                <h5 id="label">De: </h5>
                                                <input id="datepicker_de" type="date" name="data_1" onchange="mudou();" value="2017-02-01" min="2017-02-01" max="<?= $data_2; ?>" />
                                                <h5 id="label">Até: </h5>
                                                <input id="datepicker_ate" type="date" name="data_2" onchange="mudou();" value="<?= $data_2; ?>" min="2017-02-01" max="<?= $data_2; ?>" />
                                            </div>

                                            <script>
                                                var hoje = new Date();

                                                function mudou() {
                                                    $('.radio4').prop('checked', true);
                                                    var opc1 = document.getElementById('datepicker_de').value;
                                                    var opc2 = document.getElementById('datepicker_ate').value;

                                                    if (opc2 < opc1) {
                                                        alert('A Data (Até) não pode ser menor que a Data (De)');
                                                    } else {
                                                        mostrarResultado();;
                                                    }
                                                }
                                            </script>
                                        </div>
                                        <!-- justify-content: space-between; -->
                                        <div class="col-lg-12" style="padding: 10px; display: flex; justify-content: start;">
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
                                                <!-- /input-group -->
                                            </div>

                                            <div style="display: flex;">
                                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-table"></i> Gerar Excel</a>
                                            </div>

                                        </div>
                                    </div>

                                    <!-- fa-mouse-pointer -->
                                    <div class="table-responsive" id="preloader" style="display: none;">
                                        <div id="conteudos_table_informacoes_gerais"></div>
                                    </div>

                                    <div class="table-responsive" id="preloader2" style="display: none;">
                                        <div id="conteudos_table_info_lideres"></div>
                                    </div>

                                    <div class="box-body" id="message">
                                        <center>
                                            <div class="loader"></div>
                                            <h5><i>Carregando as Informações...</i></h5>
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
            <?php
            $this->load->view('partes/scripts2');
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
    </body>

    </html>
<?php } ?>