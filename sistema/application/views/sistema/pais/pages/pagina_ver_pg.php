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
    </style>
    <!DOCTYPE html>
    <html>
    <!-- Head -->
    <?php
    $this->load->view('partes/head');
    ?>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <!-- Menu -->
            <?php
            $this->load->view('sistema/pais/partes/menu_lateral', $array);
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
                                                    <input type="hidden" name="nivel" value="1">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">Nome para o PG</label>
                                                            <input class="form-control" type="text" name="nome_pg" aria-describedby="emailHelp" placeholder="Informe o nome para o PG" required>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Data de Início</label>
                                                            <p style="color: black;"><input type="text" autocomplete="off" name="data_inicio" placeholder="DD/MM/AAAA" class="form-control" id="datepicker" required></p>
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
                                $consultarPG = $this->FConsultas_model->mostrarPG($id_usuario, 1);

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

                                        $criancas = $this->FConsultas_model->mostrarCriancasPaisPg($id_usuario, $id_pg, 1);
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
                                                                        <input type="hidden" name="fotoOriginal" value="<?= $dadosPG['foto']; ?>">
                                                                        <input type="hidden" name="nivel" value="1">
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
                                                                        <input type="hidden" name="nivel" value="1">
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
                                                        <li><a href="../page/criancas">Crianças <span class="pull-right badge bg-red"><?= $total_crianca ?></span></a></li>
                                                        <li><a href="pg/progresso?id_pg=<?= $dadosPG['id_pg'] ?>&id_lider=<?= $id_lider; ?>">Progresso <span class="pull-right badge bg-<?= $color_modulo; ?>"><?= $nome_modulo ?></span></a></li>
                                                        <li><a href="pg/licoes?id_pg=<?= $dadosPG['id_pg'] ?>&id_lider=<?= $id_lider; ?>&ano=<?= $id_ano; ?>">Preencher Relatório <span class="pull-right badge bg-<?= $color_modulo; ?>"><?= $nome_modulo ?> - Lição <?= $n_licao; ?></span></a></li>
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
                <!-- /.content -->
            </div>


            <script>
                $(function() {
                    $("#datepicker").datepicker({
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
<?php } ?>