<script>
    const idpg = [];
    const idmodulo = [];
    const idmoduloslist = [];
    const anomodulo = [];
    const datasemana = [];

    $(function() {
        $("#datepicker_cadastro_pg").datepicker({
            dateFormat: 'dd/mm/yy',
            closeText: "Fechar",
            prevText: "&#x3C;Anterior",
            nextText: "Próximo&#x3E;",
            currentText: "Hoje",
            monthNames: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
            monthNamesShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
            dayNames: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"],
            dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
            dayNamesMin: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
            weekHeader: "Sm",
            firstDay: 1,
            minDate: 0,
        });
    });
</script>
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

    $consultarPG = $this->FConsultas_model->mostrarPG($id_usuario, 2);

    if ($consultarPG['row'] == 0) {
    } else {
        foreach ($consultarPG['dados'] as $key => $value) {

            $ano = $value['ano'];

            $modulos = $this->FConsultas_model->consultarModuloAno($ano);

            foreach ($modulos as $key => $dadosModulos) {
                echo '
                    <script>
                    idmoduloslist.push("' . $dadosModulos['id_modulo'] . '");
                    </script>
                ';
            }

            echo '
                <script>
                idpg.push("' . $value['id_pg'] . '");
                idmodulo.push("' . $value['id_modulo'] . '");
                anomodulo.push("' . $ano . '");
                datasemana.push("' . $value['data_semana'] . '");
                </script>
            ';
        }
    }

?>

    <style>
        #imageContainer {
            margin-top: 1%;
            width: 200px;
            height: 200px;
            padding: 10px;
            background-color: #eee;
            border: 5px solid #ccc;
            cursor: pointer;
            transition: background .3s;
        }

        #imageContainer:hover {
            background-color: rgb(180, 180, 180);
            border: 5px solid #111;
        }

        .img-circle-pg {
            border-radius: 50%;
            overflow: hidden;
            position: relative;
        }

        .imgPhoto1 {
            margin-top: 1%;
            width: 100px;
            height: 100px;
            padding: 10px;
            background-color: #eee;
            border: 5px solid #ccc;
            cursor: pointer;
            transition: background .3s;
        }

        .imgPhoto1:hover {
            background-color: rgb(180, 180, 180);
            border: 5px solid #111;
        }


        .disabledTab {
            pointer-events: none;
        }
    </style>

    <!DOCTYPE html>
    <html>

    <?php
    $this->load->view('partes/head');
    ?>

    <script>
        $("ul.nav li").removeClass('active').addClass('disabledTab');

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
            var count = idpg.length;
            if (count == 0) {} else {

                var id_lider = '<?= $id_usuario; ?>';

                for (let index = 0; index < count; index++) {
                    const id_pg = idpg[index];
                    const id_modulo = idmodulo[index];
                    const check = datasemana[index];
                    const ano = anomodulo[index];

                    if (check == '' || check == '00') {
                        $('#atulizarDataComeco').modal('show');
                    }

                    mostrarProgressoInicial(id_modulo, id_lider, id_pg, ano, index);
                }
            }
        });


        function mostrarProgressoInicial(idModulo, idLider, idPg, ano, index) {
            var moduloAtual = idmodulo[index];
            var respostas = idmoduloslist;

            respostas.push(moduloAtual);

            var radio = document.getElementsByName('modulos_escolhidos');

            var total = 1;

            var ajax = AjaxF();

            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4) {
                    document.getElementById('conteudos_table').innerHTML = ajax.responseText;
                }
            }

            ajax.open("GET", "pg/consultarProgresso?id_lider=" + idLider + "&id_pg=" + idPg + "&id_modulo=" + respostas + "&total=" + total + "&ano=" + ano + "&page=geral", false);

            ajax.setRequestHeader("Content-Type", "text/html");
            ajax.send();
        }
    </script>
    <!-- Head -->

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <!-- Menu -->
            <?php
            $this->load->view('sistema/lider/partes/menu_lateral', $array);
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
                        <li class="active">PG</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <!-- CRIANÇAS -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-table"></i> Seus PG's</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>

                            <div class="box-body chat" id="chat-box">
                                <!-- <br><a href="pg/cadastro" class="btn btn-success">Cadastrar +</a>  -->
                                <button type="button" style="float: right; margin-right: 15px;" class="btn btn-info" data-toggle="modal" data-target="#cadastro_pg">Cadastrar +</button><br><br>

                                <div class="modal fade" id="cadastro_pg">
                                    <div class="modal-dialog modal-success">
                                        <div class="modal-content">
                                            <form action="pg/cadastro/salvar" method="POST">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">Cadastro | PG</h4>
                                                </div>
                                                <div class="box-body">
                                                    <input type="hidden" name="idLider" value="<?= $id_usuario; ?>">
                                                    <input type="hidden" name="nivel" value="2">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Nome para o PG</label>
                                                            <input class="form-control" type="text" name="nome_pg" aria-describedby="emailHelp" placeholder="Informe o nome para o PG" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Data de Início</label>
                                                            <p style="color: black;"><input type="text" autocomplete="off" minlength="10" name="data_inicio" placeholder="DD/MM/AAAA" class="form-control" id="datepicker_cadastro_pg" required></p>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label>
                                                                <input type="checkbox" name="autorizacao" value="1"> Desejo receber notificações por e-mail
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                                                    <input type="submit" class="btn btn-success pull-right" value="Salvar">
                                                </div>
                                            </form>
                                        </div>
                                        <!-- /.modal-content -->
                                    </div>
                                    <!-- /.modal-dialog -->
                                </div>

                                <?php
                                if ($consultarPG['row'] == 0) {
                                } else {
                                    $i = 0;
                                    foreach ($consultarPG['dados'] as $key => $dadosPG) {
                                        $foto = $dadosPG['foto'];

                                        $id_pg = $dadosPG['id_pg'];
                                        $id_lider = $dadosPG['id_lider'];
                                        $id_ano = $dadosPG['ano'];
                                        $id_modulo = $dadosPG['id_modulo'];
                                        $n_licao = $dadosPG['n_licao'];
                                        $dadosModulo = $this->FConsultas_model->consultarModuloId($id_modulo);
                                        $nome_modulo = $dadosModulo['nome_modulo'];

                                        $color_modulo = '';

                                        switch ($id_modulo) {
                                            case 1:
                                                $color_modulo = 'green';
                                                break;
                                            case 2:
                                                $color_modulo = 'blue';
                                                break;
                                            case 3:
                                                $color_modulo = 'gray';
                                                break;
                                            case 4:
                                                $color_modulo = 'red-active';
                                                break;
                                            case 5:
                                                $color_modulo = 'yellow-active';
                                                break;
                                            case 6:
                                                $color_modulo = 'orange-active';
                                                break;
                                            case 7:
                                                $color_modulo = 'orange';
                                                break;
                                            case 8:
                                                $color_modulo = 'navy';
                                                break;
                                            case 9:
                                                $color_modulo = 'brown';
                                                break;
                                            case 10:
                                                $color_modulo = 'brown-active';
                                                break;
                                            default:
                                                $color_modulo = 'green';
                                                break;
                                        }

                                        $disabled = $consultarPG['row'] == 1 ? 'disabled' : '';

                                        $criancas = $this->FConsultas_model->mostrarCriancasPaisPg($id_usuario, $id_pg, 2);
                                        $total_crianca = $criancas['row'];

                                ?>
                                        <div class="col-md-6">
                                            <!-- Widget: user widget style 1 -->
                                            <div class="box box-widget widget-user-2">
                                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                                <div class="widget-user-header bg-<?= $color_modulo; ?>">
                                                    <div class="widget-user-image ">
                                                        <img class="img-circle-pg" style="width: 100px; height: 100px; margin-right:10px;" src="../../<?= $foto; ?>" alt="User Avatar">
                                                    </div>
                                                    <!-- /.widget-user-image -->
                                                    <h4 class="widget-user-username">
                                                        <?= $dadosPG['nome_pg']; ?>
                                                    </h4>
                                                    <h5 class="widget-user-desc">PG</h5>

                                                    <button type="button" data-toggle="modal" class="btn btn-warning pull-left" data-target="<?= "#" . $dadosPG['id_pg']; ?>editar_pg">
                                                        Editar
                                                    </button>

                                                    <div class="modal fade" id="<?= $dadosPG['id_pg']; ?>editar_pg">
                                                        <div class="modal-dialog modal-info">
                                                            <div class="modal-content">
                                                                <form action="pg/edicao/salvar" method="post" enctype="multipart/form-data">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title">Edição | PG</h4>
                                                                    </div>
                                                                    <div class="box-body">
                                                                        <input type="hidden" name="idPg" id="id_pg<?= $i ?>" value="<?= $dadosPG['id_pg']; ?>">
                                                                        <input type="hidden" name="idLider" value="<?= $id_usuario; ?>">
                                                                        <input type="hidden" name="fotoOriginal" value="<?= $dadosPG['foto']; ?>">
                                                                        <input type="hidden" name="nivel" value="2">
                                                                        <div class="col-lg-12" style="display: flex; justify-content: center;">
                                                                            <div class="col-lg-4">
                                                                                <div class="form-group">
                                                                                    <label for="exampleInputEmail1">Foto (Opcional)</label>

                                                                                    <div class="imageContainer">
                                                                                        <img src="../../<?= $foto; ?>" alt="Selecione uma imagem" class="imgPhoto1" id="imgPhoto1<?= $i; ?>">
                                                                                    </div>

                                                                                    <input type="file" style="color:black;" name="imagemPG" id="fileImage1" onchange="loadFile(event)">

                                                                                    <script>
                                                                                        var loadFile = function(event) {
                                                                                            var output = document.getElementById('imgPhoto1<?= $i; ?>');
                                                                                            output.src = URL.createObjectURL(event.target.files[0]);
                                                                                            output.onload = function() {
                                                                                                URL.revokeObjectURL(output.src) // free memory
                                                                                            }
                                                                                        };
                                                                                    </script>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label for="nome">Nome para o PG</label>
                                                                                <input class="form-control" type="text" name="nome_pg" placeholder="Informe o nome para o PG" value="<?= $dadosPG['nome_pg']; ?>">
                                                                            </div>
                                                                        </div>

                                                                        <script>
                                                                            function mudarValor() {
                                                                                var radio = document.getElementsByName('autorizacao_<?= $dadosPG['id_pg']; ?>');
                                                                                if (radio[0].checked) {
                                                                                    document.getElementById('aut_<?= $dadosPG['id_pg']; ?>').value = 1;
                                                                                } else {
                                                                                    document.getElementById('aut_<?= $dadosPG['id_pg']; ?>').value = 0;
                                                                                }
                                                                            }
                                                                        </script>

                                                                        <div class="col-lg-12">
                                                                            <div class="form-group">
                                                                                <label>
                                                                                    <?php
                                                                                    $checked_option = "";
                                                                                    if ($dadosPG['autorizacao'] == 0) {
                                                                                    } else {
                                                                                        $checked_option = "checked";
                                                                                    }
                                                                                    ?>
                                                                                    <input type="checkbox" name="autorizacao_<?= $dadosPG['id_pg']; ?>" value="<?= $dadosPG['autorizacao']; ?>" onclick="mudarValor()" <?= $checked_option; ?>> Desejo receber notificações por e-mail
                                                                                    <input type="hidden" id="aut_<?= $dadosPG['id_pg']; ?>" name="autorizacao" value="<?= $dadosPG['autorizacao']; ?>">
                                                                                </label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Sair</button>
                                                                        <input type="submit" class="btn btn-default" value="Salvar">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>

                                                    <button type="button" class="btn btn-danger pull-left" <?= $disabled; ?> style="margin-left: 10px;" data-toggle="modal" data-target="<?= "#" . $dadosPG['id_pg']; ?>desativar_pg">
                                                        Desativar
                                                    </button><br>

                                                    <div class="modal fade" id="<?= $dadosPG['id_pg']; ?>desativar_pg">
                                                        <div class="modal-dialog modal-danger">
                                                            <div class="modal-content">
                                                                <form action="pg/exclusao/desativar" method="post">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title">Desativar | PG</h4>
                                                                    </div>
                                                                    <div class="box-body">
                                                                        <input type="hidden" name="idResponsavel" value="<?= $id_usuario; ?>">
                                                                        <input type="hidden" name="idLider" value="<?= $dadosPG['id_lider']; ?>">
                                                                        <input type="hidden" name="idPg" value="<?= $dadosPG['id_pg']; ?>">
                                                                        <input type="hidden" name="nomePg" value="<?= $dadosPG['nome_pg']; ?>">
                                                                        <input type="hidden" name="nivel" value="2">
                                                                        <div class="form-group">
                                                                            <label for="exampleInputEmail1">Deseja realmente retirar essa PG do projeto CAMP?</label>
                                                                            <label for="exampleInputPassword1">Conte-nos o motivo:</label>
                                                                            <textarea name="motivo" class="form-control"></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Sair</button>
                                                                        <input type="submit" class="btn btn-default" value="Desativar">
                                                                    </div>
                                                                </form>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                </div>
                                                <div class="box-footer no-padding">
                                                    <ul class="nav nav-stacked">
                                                        <li>
                                                            <a href="#" onclick="document.getElementById('form_mostrar_criancas').submit();">Crianças <span class="pull-right badge bg-red"><?= $total_crianca ?></span>
                                                            </a>

                                                            <form action="../page/criancas" id="form_mostrar_criancas" method="post">
                                                            </form>
                                                        </li>
                                                        <li>
                                                            <a href="#" onclick="document.getElementById('form_preencher_relatorio').submit();">Preencher Relatório <span class="pull-right badge bg-<?= $color_modulo; ?>"><?= $nome_modulo ?> - Lição <?= $n_licao; ?></span>
                                                            </a>

                                                            <form action="pg/licoes" id="form_preencher_relatorio" method="post">
                                                                <input type="hidden" name="id_pg" value="<?= $dadosPG['id_pg'] ?>">
                                                                <input type="hidden" name="id_lider" value="<?= $id_lider; ?>">
                                                                <input type="hidden" name="ano" value="<?= $id_ano; ?>">
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                <?php $i++;
                                    }
                                } ?>
                            </div>
                            <!-- /.item -->
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </section>

                <?php
                if ($consultarPG['row'] == 0) {
                } else {
                    $i = 0;
                    foreach ($consultarPG['dados'] as $key => $pg) {
                        $nome_pg = $pg['nome_pg'];

                        $criancas = $this->FConsultas_model->mostrarCriancasPaisPg($id_usuario, $id_pg, 2);
                        $total_crianca = $criancas['row'];
                ?>

                        <!-- Main content -->
                        <section class="content">
                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                <!-- CRIANÇAS -->
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><i class="fa fa-heart"></i> Tempo de Conversa PG - <?= $nome_pg; ?></h3>

                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>

                                    <section class="content">
                                        <div class="box-body chat" id="chat-box">
                                            <?php
                                            $diaComecou = $pg['data_semana'];

                                            $id_pg = $pg['id_pg'];
                                            $nome_pg = $pg['nome_pg'];

                                            $id_modulo_pg = $pg['id_modulo'];
                                            $licao_pg = $pg['n_licao'];

                                            $ano_pg = $pg['ano'];

                                            $id_modulo = $pg['modulo_devocional'];
                                            $n_licao = $pg['licao_devocional'];

                                            $devocionais =   $this->FConsultas_model->consultarDevocionalModuloLicao($ano_pg, $id_modulo, $n_licao);

                                            //$dataHjTrocada = date('m/d/Y');

                                            $dataHj = date('m/d/Y');

                                            if ($diaComecou == '') { // abrir modal para cadastrar uma data de início
                                            ?>
                                                <div class="col-md-12">
                                                    <div class="callout callout-warning"><br>
                                                        <h4>
                                                            Você receberá diaramente uma mensagem para um tempo de conversa!
                                                        </h4><br>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="atulizarDataComeco">
                                                    <div class="modal-dialog modal-info">
                                                        <div class="modal-content">
                                                            <form action="pg/atualizar_data_pg" method="post" id="form__submit">
                                                                <input type="hidden" name="id_lider" value="<?= $id_usuario; ?>">
                                                                <input type="hidden" name="id_pg" value="<?= $id_pg; ?>">

                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title">Já sabe quando vai começar o PG? | <?= $nome_pg; ?></h4>
                                                                </div>
                                                                <div class="box-body">
                                                                    <div class="form-group" style="text-align: center;">
                                                                        <label for="exampleInputEmail1">Digite a data de início do PG</label>
                                                                        <p style="color: black;">Data: <input type="text" name="data" id="datepicker" autocomplete="off" required></p>
                                                                    </div>
                                                                    <div class="form-group" style="text-align: center;">
                                                                        <input type="checkbox" name="check" value="true"> Não mostrar novamente
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Não sei ainda</button>
                                                                    <input type="submit" class="btn btn-default" value="Salvar">
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
                                                <?php
                                                // fim modal para cadastrar uma data de início
                                            } else {
                                                $dataSemana = "";

                                                $dia = $diaComecou[0] . $diaComecou[1];
                                                $mes = $diaComecou[3] . $diaComecou[4];
                                                $ano = $diaComecou[6] . $diaComecou[7] . $diaComecou[8] . $diaComecou[9];
                                                $data_trocada = $mes . "/" . $dia . "/" . $ano;

                                                $dia2 = date('m/d/Y', strtotime('+2 day', strtotime($data_trocada)));
                                                $dia3 = date('m/d/Y', strtotime('+3 day', strtotime($data_trocada)));
                                                $dia4 = date('m/d/Y', strtotime('+4 day', strtotime($data_trocada)));
                                                $dia5 = date('m/d/Y', strtotime('+5 day', strtotime($data_trocada)));
                                                $dia6 = date('m/d/Y', strtotime('+6 day', strtotime($data_trocada)));

                                                $class_day_2 = strtotime($dia2) <= strtotime($dataHj) ? '' : 'disabled disabledTab';
                                                $class_day_3 = strtotime($dia3) <= strtotime($dataHj) ? '' : 'disabled disabledTab';
                                                $class_day_4 = strtotime($dia4) <= strtotime($dataHj) ? '' : 'disabled disabledTab';
                                                $class_day_5 = strtotime($dia5) <= strtotime($dataHj) ? '' : 'disabled disabledTab';
                                                $class_day_6 = strtotime($dia6) <= strtotime($dataHj) ? '' : 'disabled disabledTab';

                                                $checkNPreencheu = $licao_pg == $n_licao ? false : true;

                                                if ($devocionais) {
                                                ?>

                                                    <!-- Existe o devocional -->


                                                    <!-- Check se já preencheu -->
                                                    <div>
                                                        <?php
                                                        if ($checkNPreencheu) { ?>

                                                            <div class="col-md-12">
                                                                <div class="callout callout-warning">
                                                                    <h4>
                                                                        Lembre-se de manter o relatório atualizado!
                                                                    </h4>
                                                                </div>
                                                            </div>
                                                        <?php
                                                        } else {
                                                        }
                                                        ?>
                                                    </div>
                                                    <!-- Check se já preencheu -->


                                                    <!-- NOME DOS DIAS -->
                                                    <div class="nav-tabs-custom">
                                                        <ul class="nav nav-tabs">
                                                            <?php
                                                            $i = 0;
                                                            foreach ($devocionais as $key => $d) {
                                                                $diaSemana = $d['dia'];
                                                                if ($i == 0) {
                                                            ?>
                                                                    <li class="active"><a href="#tab_<?= $i; ?>" data-toggle="tab">Dia <?= $diaSemana; ?></a></li>
                                                                <?php } else {
                                                                    $check = "";
                                                                    switch ($i) {
                                                                        case 1:
                                                                            $check = $class_day_2;
                                                                            break;
                                                                        case 2:
                                                                            $check = $class_day_3;
                                                                            break;
                                                                        case 3:
                                                                            $check = $class_day_4;
                                                                            break;
                                                                        case 4:
                                                                            $check = $class_day_5;
                                                                            break;
                                                                        case 5:
                                                                            $check = $class_day_6;
                                                                            break;
                                                                        default:
                                                                            $check = 'disabled disabledTab';
                                                                            break;
                                                                    }
                                                                ?>
                                                                    <li class="<?= $check; ?>"><a href="#tab_<?= $i; ?>" data-toggle="tab">Dia <?= $diaSemana; ?></a></li>
                                                                <?php } ?>
                                                            <?php $i++;
                                                            } ?>
                                                        </ul>
                                                    </div>
                                                    <!-- NOME DOS DIAS -->

                                                    <div class="tab-content">
                                                        <?php
                                                        $i = 0;
                                                        $color_modulo = "";

                                                        switch ($id_modulo) {
                                                            case 1:
                                                                $color_modulo = 'green';
                                                                break;
                                                            case 2:
                                                                $color_modulo = 'blue';
                                                                break;
                                                            case 3:
                                                                $color_modulo = 'gray';
                                                                break;
                                                            case 4:
                                                                $color_modulo = 'red';
                                                                $nome_modulo = 'Arco';
                                                                break;
                                                            case 5:
                                                                $color_modulo = 'yellow';
                                                                break;
                                                            case 6:
                                                                $color_modulo = 'orange-active';
                                                                break;
                                                            case 7:
                                                                $color_modulo = 'orange';
                                                                break;
                                                            case 8:
                                                                $color_modulo = 'navy';
                                                                break;
                                                            case 9:
                                                                $color_modulo = 'brown';
                                                                break;
                                                            case 10:
                                                                $color_modulo = 'brown-active';
                                                                break;
                                                            default:
                                                                $color_modulo = 'green';
                                                                break;
                                                        }

                                                        foreach ($devocionais as $key => $d) {
                                                            $diaSemana = $d['dia'];
                                                            $title = $d['titulo'];
                                                            $devocional = $d['texto'];
                                                            $file = base_url($d['file']);
                                                            if ($i == 0) {
                                                        ?>
                                                                <div class="tab-pane active" id="tab_<?= $i; ?>">
                                                                    <div class="col-md-6 col-xs-offset-3">
                                                                        <!-- Widget: user widget style 1 -->
                                                                        <div class="box box-widget widget-user">
                                                                            <!-- Add the bg color to the header using any of the bg-* classes -->
                                                                            <div class="widget-user-header bg-<?= $color_modulo; ?>" style="display: table;">
                                                                                <h5 class="widget-user-desc" style="text-align: center;display: table-cell; vertical-align: middle;"><?= $devocional ?></h5>
                                                                            </div>
                                                                            <div class="box-footer">
                                                                                <div class="row">
                                                                                    <div class="form-group mb-2">
                                                                                        <div class="col px-0">
                                                                                            <h5 class="widget-user-desc" style="text-align: center;">
                                                                                                <?= $title ?>
                                                                                            </h5>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- /.row -->
                                                                            </div>
                                                                        </div>
                                                                        <!-- /.widget-user -->
                                                                    </div>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div class="tab-pane" id="tab_<?= $i; ?>">
                                                                    <div class="col-md-6 col-xs-offset-3">
                                                                        <!-- Widget: user widget style 1 -->
                                                                        <div class="box box-widget widget-user">
                                                                            <!-- Add the bg color to the header using any of the bg-* classes -->
                                                                            <div class="widget-user-header bg-<?= $color_modulo; ?>" style="display: table;">
                                                                                <h5 class="widget-user-desc" style="text-align: center;display: table-cell; vertical-align: middle;"><?= $devocional ?></h5>
                                                                            </div>
                                                                            <div class="box-footer">
                                                                                <div class="row">
                                                                                    <div class="form-group mb-2">
                                                                                        <div class="col px-0">
                                                                                            <h5 class="widget-user-desc" style="text-align: center;">
                                                                                                <?= $title ?>
                                                                                            </h5>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- /.row -->
                                                                            </div>
                                                                        </div>
                                                                        <!-- /.widget-user -->
                                                                    </div>
                                                                </div>
                                                            <?php } ?>
                                                        <?php $i++;
                                                        } ?>
                                                    </div>
                                                    <!-- /.tab-content -->
                                                <?php } else { ?>
                                                    <!-- Não Existe o devocional -->

                                                    <div class="col-md-12">
                                                        <div class="callout callout-danger">
                                                            <h4>
                                                                Estamos trabalhando nisso! Adicionando novos Tempos de Conversa!
                                                            </h4>
                                                            <p>Tente novamente mais tarde!
                                                            </p>
                                                        </div>
                                                    </div>
                                                <?php } ?>

                                            <?php } ?>
                                        </div>
                                        <!-- /.item -->
                                    </section>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </section>
                        <!-- /.content -->

                        <section class="content">
                            <!-- Small boxes (Stat box) -->
                            <div class="row">
                                <!-- CRIANÇAS -->
                                <div class="box box-info">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">
                                            <i class="fa fa-bar-chart"></i> Progresso Geral
                                        </h3>

                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#termos"><i class="fa fa-question"></i>
                                            </button>
                                            <div class="modal fade" id="termos">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title">Tabela de Progresso</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="box-body">
                                                                <p style="text-align: justify;">
                                                                    <i><b>O que é?</b></i><br>
                                                                    Essa tabela contém informações do progresso do seu PG ao longo dos modúlos. <br>
                                                                    Ela contém informações de <b>Presença</b>, <b>Versículo</b>, <b>Mistério</b> e uma <b>Pontuação</b> total do Grupo. <br><br>
                                                                    <i><b>Como ela é calculada?</b></i><br>
                                                                    É calculada baseada nas informações do preenchimento dos relatórios dos encontros (IMPORTANTE: MANTENHA SEMPRE ELES ATUALIZADOS), o primeiro número de acordo com o preenchimento do relatório e o segundo número é o total do módulo multiplicado pelo número de crianças do PG. <br><br>
                                                                    <i><b>Exemplos:</b></i><br>
                                                                    <i>Grupo de 5 crianças que estão no Módulo Trilha na Lição 2</i><br>
                                                                    Na coluna Presença será assim: <u>10/40</u> (40 é minha meta e 10 é o caminho que estou pecorrendo) <br>
                                                                    Na coluna Versículo será assim: <u>5/20</u> (20 é minha meta e 5 é o caminho que estou pecorrendo) <br>
                                                                    Na coluna Mistério será assim: <u>5/20</u> (20 é minha meta e 5 é o caminho que estou pecorrendo) <br>
                                                                    A pontuação final será <u>190</u> <br><br>

                                                                    <i><b>Você também consegue vê o progresso individual de cada criança, ficando mais fácil a visualização e premiação</b></i><br>
                                                                </p>
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
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                            <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>

                                    <div class="box-body chat" id="chat-box">
                                        <div class="item">
                                            <h4 style="text-align: center; font-weight: bold;"> PG - <?= $nome_pg; ?></h4>
                                            <h4 style="text-align: center;"> Quantidade de Crianças - <?= $total_crianca; ?></h4>
                                        </div>

                                        <div id="conteudos_table"></div>
                                    </div>
                                    <!-- /.item -->
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </section>

                <?php
                    }
                } ?>
                <!-- /.content -->
            </div>

            <!-- Footer -->
            <?php
            $this->load->view('partes/footer');
            $this->load->view('partes/scripts2');
            ?>
            <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
        <!-- Links JavaScript -->

    </body>


    </html>
<?php } ?>