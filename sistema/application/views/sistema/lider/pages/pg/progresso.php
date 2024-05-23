<?php

/** @var \$this */

if (!isset($_SESSION['usuario'])) {
    header("location: ../../../index");
}

date_default_timezone_set('America/Sao_Paulo');

$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
$id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

$consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPg($id_usuario, $pg['id_pg'], 2);

$voltar = "../../";
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
    $("ul.nav li").removeClass('active').addClass('disabledTab');

    $(document).ready(function() {
        var check = '<?= $pg['data_semana']; ?>';
        var id_lider = '<?= $id_usuario; ?>';
        var id_pg = '<?= $pg['id_pg']; ?>';
        var id_modulo = ['<?= $pg['id_modulo']; ?>'];

        if (check == '' || check == '00') {
            $('#atulizarDataComeco').modal('show');
        }

        mostrarProgressoInicial(id_modulo, id_lider, id_pg);
    });

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

    function mostrarProgressoInicial(idModulo, idLider, idPg) {
        var moduloAtual = '<?= $pg['id_modulo']; ?>';
        var respostas = [];

        var radio = document.getElementsByName('modulos_escolhidos');

        radio[moduloAtual - 1].checked = true;
        document.getElementById('controllerClickModulo_' + idModulo).value = 1;
        document.getElementById('linha_licoes').style.display = 'inline';

        var total = 0;

        for (var i = 0; i < radio.length; i++) {
            if (radio[i].checked) {
                respostas.push(radio[i].value);
                total = total + 1;
            }
        }

        var ajax = AjaxF();

        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4) {
                document.getElementById('conteudos_table').innerHTML = ajax.responseText;
            }
        }

        ajax.open("GET", "consultarProgresso?id_lider=" + idLider + "&id_pg=" + idPg + "&id_modulo=" + respostas + "&total=" + total, false);

        ajax.setRequestHeader("Content-Type", "text/html");
        ajax.send();
    }

    function atualizarProgresso(idModulo, idLider, idPg) {
        var respostas = [];
        var moduloAtual = '<?= $pg['id_modulo']; ?>';

        var radio = document.getElementsByName('modulos_escolhidos');

        if (radio[idModulo - 1].checked) {
            document.getElementById('controllerClickModulo_' + idModulo).value = 1;
        } else {
            document.getElementById('controllerClickModulo_' + idModulo).value = 0;
        }


        var check1 = document.getElementById('controllerClickModulo_1').value;
        var check2 = document.getElementById('controllerClickModulo_2').value;
        var check3 = document.getElementById('controllerClickModulo_3').value;
        var check4 = document.getElementById('controllerClickModulo_4').value;
        var check5 = document.getElementById('controllerClickModulo_5').value;

        /*alert('id modulo atual - ' + moduloAtual + '\n id modulo escolhido - ' + idModulo + '\n check1 - ' + check1 + '\n check2 - ' + check2 + '\n check3 - ' + check3 + '\n check4 - ' + check4 + '\n check5 - ' + check5);*/

        if (check1 == 0 && check2 == 0 && check3 == 0 && check4 == 0 && check5 == 0) {
            document.getElementById('linha_licoes').style.display = 'inline';
        } else {
            if (moduloAtual == "1" && check1 == 1 && check2 == 0 && check3 == 0 && check4 == 0 && check5 == 0) {
                document.getElementById('linha_licoes').style.display = 'inline';
            } else if (moduloAtual == "2" && check1 == 0 && check2 == 1 && check3 == 0 && check4 == 0 && check5 == 0) {
                document.getElementById('linha_licoes').style.display = 'inline';
            } else if (moduloAtual == "3" && check1 == 0 && check2 == 0 && check3 == 1 && check4 == 0 && check5 == 0) {
                document.getElementById('linha_licoes').style.display = 'inline';
            } else if (moduloAtual == "4" && check1 == 0 && check2 == 0 && check3 == 0 && check4 == 1 && check5 == 0) {
                document.getElementById('linha_licoes').style.display = 'inline';
            } else if (moduloAtual == "5" && check1 == 0 && check2 == 0 && check3 == 0 && check4 == 0 && check5 == 1) {
                document.getElementById('linha_licoes').style.display = 'inline';
            } else {
                document.getElementById('linha_licoes').style.display = 'none';
            }
        }

        var total = 0;


        for (var i = 0; i < radio.length; i++) {
            if (radio[i].checked) {
                respostas.push(radio[i].value);
                total = total + 1;
            }
        }

        var ajax = AjaxF();

        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4) {
                document.getElementById('conteudos_table').innerHTML = ajax.responseText;
            }
        }

        ajax.open("GET", "consultarProgresso?id_lider=" + idLider + "&id_pg=" + idPg + "&id_modulo=" + respostas + "&total=" + total, false);

        ajax.setRequestHeader("Content-Type", "text/html");
        ajax.send();
    }
</script>

<style>
    #linha_licoes {
        display: none;
    }

    .disabledTab {
        pointer-events: none;
    }

    .rp-modulos {
        width: 80%;
        margin-left: auto;
        margin-right: auto;
        display: flex;
        justify-content: space-evenly;
    }

    .rp-licoes {
        width: 100%;
        margin-left: auto;
        margin-right: auto;
        display: inline-flex;
        justify-content: space-around;
    }

    div label input {
        margin-right: 100px;
    }

    .cat {
        margin: 4px;
        background-color: #d3d3d3;
        border-radius: 4px;
        border: 1px solid #fff;
        overflow: hidden;
        float: left;
    }

    .cat label {
        float: left;
        line-height: 3.0em;
        width: 8.0em;
        height: 3.0em;
    }

    .licao {
        width: 5.0em;
    }

    .zerado {
        cursor: none;
    }

    .habilitados {
        cursor: pointer;
    }

    .cat label span {
        text-align: center;
        padding: 3px 0;
        display: block;
    }

    .cat label input {
        position: absolute;
        display: none;
        color: #fff !important;
    }

    .cat label input+span {
        color: black;
    }

    .cat input:checked+span {
        color: #ffffff;
        text-shadow: 0 0 6px rgba(0, 0, 0, 0.8);
    }

    .action input:checked+span {
        background-color: #A6332B;
    }

    .soum {
        margin: 4px;
        background-color: #A6332B;
        border-radius: 4px;
        border: 1px solid #fff;
        overflow: hidden;
        float: left;
    }

    .soum label {
        float: left;
        line-height: 3.0em;
        width: 8.0em;
        height: 3.0em;
    }

    .soum label span {
        text-align: center;
        padding: 3px 0;
        display: block;
        color: #fff;
    }

    .soum label input {
        position: absolute;
        display: none;
        color: #fff !important;
    }

    /* ATUAL */
    .atual {
        margin: 4px;
        background-color: #379CEF;
        border-radius: 4px;
        border: 1px solid #fff;
        overflow: hidden;
        float: left;
    }

    .atual span,
    .jafez span,
    .anfez span {
        color: #fff;
    }

    .jafez {
        margin: 4px;
        background-color: #214A09;
        border-radius: 4px;
        border: 1px solid #fff;
        overflow: hidden;
        float: left;
    }

    .anfez {
        margin: 4px;
        background-color: #E31710;
        border-radius: 4px;
        border: 1px solid #fff;
        overflow: hidden;
        float: left;
    }

    @media (max-width: 720px) {
        .rp-modulos {
            width: 100%;
            display: block;
        }
    }
</style>

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
                    <li><a href="<?= $voltar ?>home"><i class="fa fa-home"></i> Home</a></li>
                    <li><a href="<?= $voltar ?>page/pg"><i class="fa fa-group"></i> PG</a></li>
                    <li class="active">Progresso</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <!-- CRIANÇAS -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><i class="fa fa-heart"></i> Tempo de Conversa</h3>

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

                                $id_modulo = $pg['modulo_devocional'];
                                $n_licao = $pg['licao_devocional'];

                                $devocionais = $devocionais_consulta;

                                //$dataHjTrocada = date('m/d/Y');

                                $dataHj = date('m/d/Y');

                                if ($diaComecou == '') {

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
                                                <form action="atualizar_data_pg" method="get" id="form__submit">
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

                                        <div class="col-md-12">
                                            <div class="callout callout-danger">
                                                <h4>
                                                    Estamos trabalhando nisso
                                                </h4>
                                                <p>Tente novamente mais tarde!
                                                </p>
                                            </div>
                                        </div>
                                <?php
                                    }
                                }
                                ?>
                            </div>
                            <!-- /.item -->
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
                                <i class="fa fa-bar-chart"></i> Progresso
                            </h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                            </div>
                        </div>

                        <div class="box-body chat" id="chat-box">
                            <div class="item">
                                <h4 style="text-align: center; font-weight: bold;"> PG - <?= $nome_pg; ?></h4>
                            </div>

                            <div class="item rp-modulos">
                                <?php

                                $modulos = $this->FConsultas_model->consultarModuloAno($pg['ano']);

                                if ($modulos) {
                                    foreach ($modulos as $key => $m) {
                                        if ($consultaCriancas['row'] == 0) {
                                ?>
                                            <div class="cat action zerado">
                                                <label>
                                                    <input type="button" value="<?= $m['id_modulo']; ?>"><span><?= $m['nome_modulo']; ?></span>
                                                </label>
                                            </div>
                                        <?php
                                        } else {
                                        ?>
                                            <input type="hidden" id="controllerClickModulo_<?php echo $m['id_modulo']; ?>" value="0">

                                            <div class="cat action">
                                                <label class="habilitados">
                                                    <input type="checkbox" value="<?= $m['id_modulo']; ?>" id="modulos_escolhidos_<?php echo $m['id_modulo']; ?>" name="modulos_escolhidos" onclick="atualizarProgresso('<?= $m['id_modulo']; ?>','<?= $id_usuario; ?>','<?= $pg['id_pg']; ?>');"><span><?= $m['nome_modulo']; ?></span>
                                                </label>
                                            </div>
                                        <?php
                                        }
                                        ?>
                                <?php
                                    }
                                }
                                ?>
                            </div>

                            <div class="item">
                                <div id="conteudos_table"></div>
                            </div>

                            <div class="item rp-licoes">
                                <div id="linha_licoes">
                                    <?php

                                    $modulos = $this->FConsultas_model->consultarModuloId($pg['id_modulo']);

                                    if ($modulos) {
                                        $totalLicao = $modulos['n_licao'];

                                        for ($i = 1; $i <= $totalLicao; $i++) {
                                            if ($consultaCriancas['row'] == 0) {
                                    ?>
                                                <div class="cat action zerado">
                                                    <label>
                                                        <input type="button" value="<?= $m['id_modulo']; ?>"><span>Lição <?= $i; ?></span>
                                                    </label>
                                                </div>
                                                <?php
                                            } else {
                                                if ($i == $pg['n_licao']) {
                                                ?>
                                                    <div class="cat action atual licao">
                                                        <label>
                                                            <span>Lição <?= $i; ?></span>
                                                        </label>
                                                    </div>
                                                <?php
                                                } else if ($i < $pg['n_licao']) {
                                                ?>
                                                    <div class="cat action jafez licao">
                                                        <label>
                                                            <span>Lição <?= $i; ?></span>
                                                        </label>
                                                    </div> <?php
                                                        } else if ($pg['n_licao'] != $pg['licao_devocional'] && $i == $pg['licao_devocional']) {
                                                            ?>
                                                    <div class="cat action anfez licao">
                                                        <label>
                                                            <span>Lição <?= $i; ?></span>
                                                        </label>
                                                    </div>
                                                <?php
                                                        } else {
                                                ?>
                                                    <div class="cat action zerado licao">
                                                        <label>
                                                            <span>Lição <?= $i; ?></span>
                                                        </label>
                                                    </div>
                                    <?php

                                                        }
                                                    }
                                                }
                                            }
                                    ?>
                                </div>
                            </div>
                            <!-- /.item -->

                        </div>
                        <!-- /.item -->
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
        <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->
    <!-- Links JavaScript -->
    <?php
    $this->load->view('partes/scripts2');
    ?>
</body>

</html>