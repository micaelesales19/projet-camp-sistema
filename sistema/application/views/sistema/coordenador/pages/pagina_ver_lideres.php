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
?>
    <!DOCTYPE html>
    <html>

    <?php
    $this->load->view('partes/head');
    ?>

    <script>
        /*$(document).ready(function() {

            var loader = document.getElementById("preloader");
            var message = document.getElementById("message");

            var dismissLoadingScreen = function() {
                message.style.display = "none";
                loader.style.display = "inline";
            };

            var wait3seconds = function() {
                var result = setTimeout(dismissLoadingScreen, 300);
            };

            window.addEventListener("load", wait3seconds);
        });*/

        function loader() {
            var loader = document.getElementById("preloader");
            var message = document.getElementById("message");
            var botao = document.getElementById("btn_gerar");

            message.style.display = "inline";
            loader.style.display = "none";
            botao.disabled = true;

            var dismissLoadingScreen = function() {
                message.style.display = "none";
                loader.style.display = "inline";
                botao.disabled = false;
            };

            setTimeout(dismissLoadingScreen, 3000);
            /*var wait3seconds = function() {
            };

            window.addEventListener("click", wait3seconds);*/
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

            loader();
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
                    document.getElementById('conteudos_table_1').innerHTML = ajax.responseText;
                }
            }

            ajax.open("GET", "lideres/mostrar1?id_coordenador=" + id_coordenador + "&opc1=" + opc1 + "&opc2=" + opc2 + "&dataInicio=" + dataIn + "&dataAte=" + dataFim, false);

            //setTimeout( 3000);

            ajax.setRequestHeader("Content-Type", "text/html");
            ajax.send();

            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4) {
                    document.getElementById('conteudos_table_2').innerHTML = ajax.responseText;
                }
            }

            ajax.open("GET", "lideres/mostrar2?id_coordenador=" + id_coordenador + "&opc1=" + opc1 + "&opc2=" + opc2 + "&dataInicio=" + dataIn + "&dataAte=" + dataFim, false);

            //setTimeout( 3000);

            ajax.setRequestHeader("Content-Type", "text/html");
            ajax.send();
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

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        PG
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

                                    <div class="box-body" id="message">
                                        <center>
                                            <div class="loader"></div>
                                            <h5><i>Carregando as Informações...</i></h5>
                                        </center>
                                    </div>

                                    <div class="table-responsive" id="preloader" style="display: none;">
                                        <div id="conteudos_table_1"></div>
                                        <div id="conteudos_table_2"></div>
                                    </div>
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
            <!-- Footer -->
            <?php
            $this->load->view('partes/footer');
            $this->load->view('partes/scripts2');
            ?>
        </div>
        <!-- Links JavaScript -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Create the tabs -->
            <ul class="nav nav-tabs control-sidebar-tabs">
                <li class="active">
                    <a href="#control-sidebar-settings-tab" data-toggle="tab">
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
    </body>


    </html>
<?php } ?>