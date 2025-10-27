<?php

/** @var \$this */
if (!isset($_SESSION['usuario'])) {
    header("location: ../../../index");
} else {

    date_default_timezone_set('America/Sao_Paulo');

    $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
    $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

    $voltar = "../../";
    $array = array('voltar' => $voltar);

    $dados_supervisor = $this->Supervisores->infos([$id_usuario], 'info_supervisor', '', '', '');
    $url_redirecionamento = current_url() . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '');

    if ($dados_supervisor['row'] == 0) {
        $data = [];
        $this->FConsultas_model->mensagem('danger', 'Erro!', ['O sistema dectou algum erro em seu cadastro! Entre em contato com o suporte!']);
        $funcao = $this->FConsultas_model->red("../$voltar/index", 2000, $data);
        echo $funcao;
    } else {
?>

        <!DOCTYPE html>
        <html>
        <!-- Head -->
        <?php
        $this->load->view('partes/head');
        ?>

        <script>
            $("ul.nav li").removeClass('active').addClass('disabledTab');
        </script>

        <style>
            #linha_licoes {
                display: none;
            }

            .disabledTab {
                pointer-events: none;
            }

            .rp-modulos {
                width: 50%;
                margin-left: auto;
                margin-right: auto;
                display: flex;
                justify-content: space-evenly;
            }

            .rp-licoes {
                width: 80%;
                margin-left: auto;
                margin-right: auto;
                display: flex;
                justify-content: space-evenly;
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
        </style>

        <body class="hold-transition skin-blue sidebar-mini">
            <div class="wrapper">
                <!-- Menu -->
                <?php
                $this->load->view('sistema/supervisor/partes/menu_lateral', $array);
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
                            <li class="active">Preenchimento de Relatório</li>
                        </ol>
                    </section>
                    <!-- Main content -->
                    <section class="content">
                        <!-- Small boxes (Stat box) -->

                        <div class="row">
                            <div class="col-md-12">
                                <!-- Progresso -->
                                <div class="box box-success">
                                    <div class="box-header with-border">
                                        <h3 class="box-title"><i class="fa fa-book"></i> Preenchimento de Relatório</h3>
                                        <div class="box-tools pull-right">
                                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <div class="table-responsive">
                                            <div class="nav-tabs-custom">

                                                <?php
                                                if ($modulos) {
                                                ?>

                                                    <ul class="nav nav-tabs">
                                                        <?php

                                                        $checksCriancas = $this->FConsultas_model->checkCriancasPG($id_lider, $id_pg, 2);

                                                        $comparador_modulo = 1;

                                                        $i = 1;

                                                        if ($pg['row'] != 0 || $checksCriancas) {

                                                            $dados_pg = $pg['dados'];

                                                            $id_modulo = $dados_pg['id_modulo'];
                                                            $ano_pg = $dados_pg['ano'];

                                                            if ($ano_pg == 1) {
                                                            } else if ($ano_pg == 2) {
                                                                $i = 6;
                                                            } else {
                                                                $i = 11;
                                                            }

                                                            $comparador_modulo = $id_modulo;
                                                        }


                                                        foreach ($modulos as $key => $m) {
                                                            if ($i == $comparador_modulo) {
                                                        ?>
                                                                <li class="active"><a href="#tab_<?= $i; ?>" data-toggle="tab"><?= $m['nome_modulo']; ?></a></li>

                                                            <?php } else { ?>
                                                                <li><a href="#tab_<?= $i; ?>" data-toggle="tab"><?= $m['nome_modulo']; ?></a></li>
                                                        <?php }
                                                            $i++;
                                                        } ?>
                                                    </ul>

                                                    <div class="tab-content">
                                                        <?php
                                                        $i = 1;

                                                        $dados_pg = $pg['dados'];

                                                        $id_modulo = $dados_pg['id_modulo'];
                                                        $ano_pg = $dados_pg['ano'];

                                                        if ($ano_pg == 1) {
                                                        } else if ($ano_pg == 2) {
                                                            $i = 6;
                                                        } else {
                                                            $i = 11;
                                                        }

                                                        foreach ($modulos as $key => $m) {
                                                            $class = "";
                                                            if ($i == $comparador_modulo) {
                                                                $class = "active";
                                                            } else {
                                                            }
                                                        ?>
                                                            <div class="tab-pane <?= $class; ?>" id="tab_<?= $i; ?>">
                                                                <?php
                                                                if ($pg['row'] == 0) {
                                                                ?>
                                                                    <div class="col-md-12">
                                                                        <div class="callout callout-danger"><br>
                                                                            <h4>
                                                                                Você não cadastrou nenhum PG!
                                                                            </h4><br>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                                                } else {
                                                                    if (!$checksCriancas) {
                                                                    ?>
                                                                        <div class="col-md-12">
                                                                            <div class="callout callout-danger"><br>
                                                                                <h4>
                                                                                    Você não cadastrou nenhuma Criança!
                                                                                </h4><br>
                                                                            </div>
                                                                        </div>
                                                                <?php
                                                                    }
                                                                } ?>

                                                                <table class="table no-margin">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Lição</th>
                                                                            <th>Status</th>
                                                                            <th>Ação</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <?php

                                                                        $ativo = $dados_pg['ativo'];

                                                                        if ($ativo == 0) {
                                                                            echo "Acesso temporariamente negado, peça aos seus superiores para autorizar o acesso.";
                                                                        } else {
                                                                            $nome_pg = $dados_pg['nome_pg'];

                                                                            $nome_modulo = $m['nome_modulo'];
                                                                            $ano = $m['ano'];

                                                                            if ($i == $id_modulo) {
                                                                                $n_licao_tabela = $dados_pg['n_licao'];
                                                                                $n_licao = $m['n_licao'];
                                                                            } else if ($i < $id_modulo || $i > $id_modulo) {
                                                                                $dadosModulos = $this->FConsultas_model->list_modulos_informacoes($ano_pg, $i);
                                                                                $licaoBase = $dadosModulos['n_licao'];
                                                                                $n_licao_tabela = $licaoBase;
                                                                                $n_licao = $licaoBase;
                                                                            } else {
                                                                                $n_licao_tabela = $dados_pg['n_licao'];
                                                                                $n_licao = $m['n_licao'];
                                                                            }

                                                                            for ($i2 = 1; $i2 <= $n_licao; $i2++) {

                                                                                $consultar_progresso = $this->FConsultas_model->consultarProgressoPG($id_pg, $id_lider, $i, $i2, 2);
                                                                                $x = $consultar_progresso['row'];
                                                                                $dados_licao = $this->FConsultas_model->consultarLicaoId($i, $i2);
                                                                                $nome_licao = $dados_licao['nome_licao'];

                                                                                if ($pg['row'] == 0 || !$checksCriancas ||  $i > $id_modulo) {
                                                                        ?>
                                                                                    <tr>
                                                                                        <td><?= $i2; ?> - <?= $nome_licao; ?></td>
                                                                                        <td><span class="label label-danger">Bloqueada</span></td>
                                                                                        <td>
                                                                                            <div class="sparkbar" data-color="#f56954" data-height="20">
                                                                                                <span class="label label-default">Preencher/Visualizar</span>
                                                                                            </div>
                                                                                        </td>
                                                                                    </tr>
                                                                                    <?php
                                                                                } else {
                                                                                    if ($i2 <= $n_licao_tabela) {
                                                                                        if ($x == 0) {
                                                                                    ?>
                                                                                            <tr>
                                                                                                <td><?= $i2; ?> - <?= $nome_licao; ?></td>
                                                                                                <td><span class="label label-info">Liberada</span></td>
                                                                                                <td>
                                                                                                    <div class="sparkbar" data-color="#00c0ef" data-height="20">
                                                                                                        <a href="#" onclick="document.getElementById('form_preencher_pg_<?= $i2; ?>').submit();">
                                                                                                            <span class="label label-warning">Preencher/Visualizar</span>
                                                                                                        </a>

                                                                                                        <form action="../pg/preenchimento" id="form_preencher_pg_<?= $i2; ?>" method="post">
                                                                                                            <input type="hidden" name="id_pg" value="<?= $id_pg; ?>">
                                                                                                            <input type="hidden" name="id_lider" value="<?= $id_lider; ?>">
                                                                                                            <input type="hidden" name="ano" value="<?= $ano; ?>">
                                                                                                            <input type="hidden" name="id_modulo" value="<?= $i; ?>">
                                                                                                            <input type="hidden" name="licao" value="<?= $i2; ?>">
                                                                                                            <input type="hidden" name="routa" value="<?= $routa; ?>">
                                                                                                            <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                                                                                                        </form>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        <?php } else {
                                                                                        ?>
                                                                                            <tr>
                                                                                                <td><?= $i2; ?> - <?= $nome_licao; ?></td>
                                                                                                <td><span class="label label-success">Feita</span></td>
                                                                                                <td>
                                                                                                    <div class="sparkbar" data-color="#00c0ef" data-height="20">
                                                                                                        <a href="#" onclick="document.getElementById('form_editar<?= $i2; ?>').submit();">
                                                                                                            <span class="label label-info">Preencher/Visualizar</span>
                                                                                                        </a>

                                                                                                        <form action="../pg/visualizar" id="form_editar<?= $i2; ?>" method="post">
                                                                                                            <input type="hidden" name="id_pg" value="<?= $id_pg; ?>">
                                                                                                            <input type="hidden" name="id_lider" value="<?= $id_lider; ?>">
                                                                                                            <input type="hidden" name="ano" value="<?= $ano; ?>">
                                                                                                            <input type="hidden" name="id_modulo" value="<?= $i; ?>">
                                                                                                            <input type="hidden" name="licao" value="<?= $i2; ?>">
                                                                                                            <input type="hidden" name="routa" value="<?= $routa; ?>">
                                                                                                            <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                                                                                                        </form>
                                                                                                    </div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        <?php } // fim do x
                                                                                    } else {
                                                                                        ?>
                                                                                        <tr>
                                                                                            <td><?= $i2; ?> - <?= $nome_licao; ?></td>
                                                                                            <td><span class="label label-danger">Bloqueada</span></td>
                                                                                            <td>
                                                                                                <div class="sparkbar" data-color="#f56954" data-height="20">
                                                                                                    <span class="label label-default">Preencher/Visualizar</span>
                                                                                                </div>
                                                                                            </td>
                                                                                        </tr>
                                                                        <?php } // fim do check das lições
                                                                                } // check das crianças
                                                                            } // fim do for
                                                                        }
                                                                        ?>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        <?php
                                                            $i++;
                                                        } ?>
                                                    </div>
                                                    <!-- /.tab-content -->

                                                <?php } ?>
                                            </div>
                                        </div>
                                        <!-- /.table-responsive -->
                                    </div>
                                    <!-- /.box-body -->
                                    <div class="box-footer clearfix">
                                    </div>
                                    <!-- /.box-footer -->
                                </div>
                                <!-- /.box -->

                                <!-- RELATORIOS -->
                                <!-- <div class="box box-warning">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><i class="fa fa-book"></i> Relatórios</h3>

                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                        </button>
                                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                                <div class="box-body chat" id="chat-box">
                                    <div class="col-lg-4">
                                        <label for="">Relatório do Progresso</label><br>
                                        <center><a href="../relatorio/relatorio_aula.php?id_usuario=<?= $id_usuario; ?>" target="_blank" class="btn btn-success">Gerar</a></center>
                                    </div>
                                    <div class="item">
                                    </div>
                                </div>
                            </div> -->
                                <!-- /.box -->

                            </div>
                            <!-- /.col (RIGHT) -->
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
<?php }
} ?>
