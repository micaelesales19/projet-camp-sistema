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

    $dadosPais = $this->FConsultas_model->consultaDadosPaisId($id_usuario, 2);

?>
    <!DOCTYPE html>
    <html>
    <?php
    $this->load->view('partes/head');
    ?>

    <style>
        #texto_alerta {
            display: none;
        }

        @media (max-width: 480px) {
            #texto_alerta {
                display: inline-block;
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
                        Crianças
                        <small>Cadastro</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="<?= $voltar ?>home"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active"> Crianças</li>
                    </ol>
                </section>

                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <!-- CRIANÇAS -->
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-plus"></i> Cadastre suas Crianças</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="box-body chat" id="chat-box">
                                <?php

                                $consultarPG = $this->FConsultas_model->mostrarPG($id_usuario, 2);

                                if ($consultarPG['row'] == 0) {
                                ?>

                                    <script>
                                        function alerta() {
                                            if (window.confirm("Você ainda não cadastrou seu PG! Cadastre Agora!")) {
                                                window.location = "pg";
                                            } else {
                                                window.location = "pg";
                                            }
                                        }
                                    </script>

                                <?php
                                } else {
                                ?>

                                    <!-- form start -->
                                    <form action="criancas/cadastro/salvar" role="form" method="POST" enctype="multipart/form-data">
                                        <div class="box-body">
                                            <input class="form-control" id="id_lider" type="hidden" name="id_lider" value="<?= $id_usuario; ?>">
                                            <input type="hidden" name="nivel" value="2">

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="nomeCrianca">Nome da Criança</label>
                                                    <input class="form-control" id="nomeCrianca" type="text" name="nome[]" placeholder="Nome da Criança" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">PG</label>
                                                    <select name="id_pg" id="id_pg" class="form-control">
                                                        <optgroup label="Seu PG">
                                                            <?php
                                                            $consultarPG = $this->FConsultas_model->mostrarPG($id_usuario, 2);

                                                            foreach ($consultarPG['dados'] as $key => $val) {
                                                            ?>
                                                                <option value="<?= $val['id_pg'] ?>"><?= $val['nome_pg'] ?></option>
                                                            <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="dataDeNascimento">Data de Nascimento (DD/MM/YYYY)</label>
                                                    <input class="form-control" type="text" id="dataDeNascimento" name="nascimento[]" placeholder="Data de Nascimento (DD/MM/YYYY)" maxlength="10" minlength="10" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">É Cristão?</label>
                                                        <select name="opcao[]" class="form-control" required>
                                                            <option value="0" selected>Escolha uma opção</option>
                                                            <option value="1">Sim</option>
                                                            <option value="0">Não</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Responsável da Criança:</label>
                                                        <select name="responsavel_crianca[]" id="isRespon_1" onchange="mostrarCamposPais(1);" class="form-control" required>
                                                            <option value="<?= $dadosPais['nome_lider'] ?>" selected><?= $dadosPais['nome_lider'] ?></option>
                                                            <option value="outro">Outro</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <script>
                                                function mostrarCamposPais(i) {
                                                    //var i = document.getElementById('controller').value;
                                                    var isRespon = document.getElementById('isRespon_' + i).value;

                                                    if (isRespon == 'outro') {
                                                        document.getElementById('linhaResponsaveis' + i).style.display = 'inline';
                                                    } else {
                                                        document.getElementById('linhaResponsaveis' + i).style.display = 'none';
                                                    }
                                                }
                                            </script>

                                            <div class="col-lg-12" id="linhaResponsaveis1" style="display: none;">
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Nome do Responsável (Obrigatório):</label>
                                                        <input class="form-control" type="text" name="nome_responsavel[]" minlength="5" placeholder="Nome do Responsável">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">E-mail do Responsável:</label>
                                                        <input class="form-control" type="text" name="email_responsavel[]" placeholder="E-mail do Responsável">
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Telefone do Responsável:</label>
                                                        <input class="form-control" type="text" name="telefone_responsavel[]" minlength="11" placeholder="Telefone do Responsável">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <label for="observacao">Observação</label>
                                                <textarea id="observacao" name="obs[]" class="form-control"></textarea>
                                            </div><br><br><br>

                                            <div id="conteudo"></div>
                                        </div>

                                        <div class="col-lg-12">
                                            <center><br><br>
                                                <input type="button" class="btn btn-danger" id="remove" value="Remover">
                                            </center>
                                        </div>

                                        <input type="hidden" value="1" id="total" name="total[]"><br>
                                        <input type="hidden" value="1" id="controller"><br>

                                        <div class="box-footer">
                                            <div class="pull-right">
                                                <input type="button" class="btn btn-info" value="Adicionar" id="add">
                                                <button type="submit" id="button" class="btn btn-success">Salvar</button>
                                            </div>
                                        </div>
                                    </form>
                                <?php } ?>
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
                                <h3 class="box-title"><i class="fa fa-table"></i> Suas Crianças</h3>

                                <?php
                                $criancas_desativadas = $this->FConsultas_model->mostrarCriancasDesativadas($id_usuario, 2);
                                if ($criancas_desativadas['row'] == 0) {
                                } else {
                                ?>
                                    <button type="button" style="margin-right: 50px;" class="btn btn-warning pull-right" data-toggle="modal" data-target="#criancas_desativadas">Crianças Desativadas</button>
                                <?php }
                                ?>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="box-body chat" id="chat-box">
                                <div class="table-responsive">
                                    <div class="item">
                                        <div id="texto_alerta">
                                            <p style="font-size: 11px; padding:10px"><i>*Arraste para o lado para vê mais opções</i></p>
                                        </div>
                                        <table class="table table-bordered" id="table_criancas_pais" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>Nome</th>
                                                    <th>PG</th>
                                                    <th>Nascimento</th>
                                                    <th>Observação</th>
                                                    <th>Editar</th>
                                                    <th>Excluir</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                foreach ($consultarPG['dados'] as $key => $dadosPG) {

                                                    $consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPg($id_usuario, $dadosPG['id_pg'], 2);

                                                    if ($consultaCriancas) {
                                                        $i = 0;
                                                        foreach ($consultaCriancas['dados'] as $key => $linha) {

                                                            if ($linha['nome_crianca'] == "") {
                                                                $linha['nome_crianca'] = "-";
                                                            }
                                                            if ($linha['observacao'] == "") {
                                                                $linha['observacao'] = "-";
                                                            }
                                                            if ($linha['nascimento'] == 0) {
                                                                $linha['nascimento'] = "-";
                                                            }
                                                ?>
                                                            <tr>
                                                                <td>
                                                                    <?= $linha['nome_crianca']; ?>
                                                                </td>
                                                                <td>
                                                                    <?= $dadosPG['nome_pg']; ?>
                                                                </td>
                                                                <td>
                                                                    <?= $linha['nascimento']; ?>
                                                                </td>
                                                                <td>
                                                                    <?= $linha['observacao']; ?>
                                                                </td>

                                                                <td>
                                                                    <button type="button" class="btn btn-info pull-left" data-toggle="modal" data-target="<?= "#" . $linha['id_crianca']; ?>editar_crianca">
                                                                        Editar
                                                                    </button>
                                                                </td>

                                                                <td>
                                                                    <button type="button" class="btn btn-danger pull-left" data-toggle="modal" data-target="<?= "#" . $linha['id_crianca']; ?>desativar_crianca">
                                                                        Desativar
                                                                    </button>
                                                                </td>
                                                            </tr>

                                                            <div class="modal fade" id="<?= $linha['id_crianca']; ?>editar_crianca">
                                                                <div class="modal-dialog modal-info">
                                                                    <div class="modal-content">
                                                                        <form action="criancas/edicao/salvar" method="post">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="modal-title">Edição | Criança</h4>
                                                                            </div>
                                                                            <div class="box-body">
                                                                                <input type="hidden" name="idCrianca" value="<?= $linha['id_crianca']; ?>">
                                                                                <input type="hidden" name="idLider" value="<?= $linha['lider']; ?>">
                                                                                <input type="hidden" name="nivel" value="2">

                                                                                <div class="col-lg-12">
                                                                                    <div class="form-group">
                                                                                        <label for="nome">Nome da Criança</label>
                                                                                        <input class="form-control" type="text" name="nome" placeholder="Nome da Criança" value="<?= $linha['nome_crianca']; ?>" required>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-12">
                                                                                    <div class="form-group">
                                                                                        <label for="ativo">PG</label>
                                                                                        <select name="idPg" class="form-control">
                                                                                            <?php
                                                                                            foreach ($consultarPG['dados'] as $key => $value) {
                                                                                                $idPgLista = $value['id_pg'];
                                                                                                if ($idPgLista == $idPg) {
                                                                                            ?>
                                                                                                    <option value="<?= $value['id_pg']; ?>" selected><?= $value['nome_pg']; ?></option>
                                                                                                <?php
                                                                                                } else {
                                                                                                ?>
                                                                                                    <option value="<?= $value['id_pg']; ?>"><?= $value['nome_pg']; ?></option>
                                                                                            <?php
                                                                                                }
                                                                                            }
                                                                                            ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-12">
                                                                                    <div class="form-group">
                                                                                        <label for="nome">Data de Nascimento (DD/MM/YYYY)</label>
                                                                                        <input class="form-control" type="text" name="nascimento" placeholder="Data de Nascimento (DD/MM/YYYY)" value="<?= $linha['nascimento']; ?>" maxlength="10" minlength="10" required>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-12">
                                                                                    <div class="form-group">
                                                                                        <label for="nome">É Cristão?</label>
                                                                                        <select name="opcao" class="form-control" required>
                                                                                            <?php
                                                                                            $opcao = $linha['cristao'];
                                                                                            if ($opcao == 0) {
                                                                                            ?>
                                                                                                <option value="0" selected>Escolha uma opção</option>
                                                                                                <option value="1">Sim</option>
                                                                                                <option value="2">Não</option>
                                                                                            <?php } else if ($opcao == 1) { ?>
                                                                                                <option value="0">Escolha uma opção</option>
                                                                                                <option value="1" selected>Sim</option>
                                                                                                <option value="2">Não</option>
                                                                                            <?php } else if ($opcao == 2) { ?>
                                                                                                <option value="0">Escolha uma opção</option>
                                                                                                <option value="1">Sim</option>
                                                                                                <option value="2" selected>Não</option>
                                                                                            <?php } ?>
                                                                                        </select>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-lg-12">
                                                                                    <label for="observacao">Observação</label>
                                                                                    <textarea id="observacao" name="obs" class="form-control"><?= $linha['observacao']; ?></textarea>
                                                                                </div>

                                                                                <div class="col-lg-12"><br>
                                                                                    <div class="col-lg-6">
                                                                                        <div class="form-group">
                                                                                            <label for="nome">Responsável?</label>
                                                                                            <select name="isResponsavel" id="isResponsavel_<?= $i; ?>" class="form-control" onchange="habilitar('<?= $i; ?>');">
                                                                                                <?php
                                                                                                $nome_responsavel = $linha['nome_responsavel'];
                                                                                                $nome_pai = $dadosPais['nome_lider'];

                                                                                                if ($nome_responsavel == $nome_pai) {
                                                                                                    $disabled = "disabled";
                                                                                                ?>
                                                                                                    <option value="0" selected>Eu</option>
                                                                                                    <option value="1">Outro</option>
                                                                                                <?php
                                                                                                } else {
                                                                                                    $disabled = "";
                                                                                                ?>
                                                                                                    <option value="2">Eu</option>
                                                                                                    <option value="1" selected>Outro</option>
                                                                                                <?php } ?>
                                                                                            </select>

                                                                                            <script>
                                                                                                function habilitar(x) {
                                                                                                    var i = document.getElementById('isResponsavel_' + x).value;
                                                                                                    var input_1 = document.querySelector("#pais_campos_1" + x);
                                                                                                    var input_2 = document.querySelector("#pais_campos_2" + x);
                                                                                                    var input_3 = document.querySelector("#pais_campos_3" + x);

                                                                                                    var input_1_desativados = document.querySelector("#pais_campos_desativados_1" + x);
                                                                                                    var input_2_desativados = document.querySelector("#pais_campos_desativados_2" + x);
                                                                                                    var input_3_desativados = document.querySelector("#pais_campos_desativados_3" + x);

                                                                                                    if (i == 0) {
                                                                                                        input_1.disabled = true;
                                                                                                        input_2.disabled = true;
                                                                                                        input_3.disabled = true;
                                                                                                    } else if (i == 1) {
                                                                                                        input_1.disabled = false;
                                                                                                        input_2.disabled = false;
                                                                                                        input_3.disabled = false;
                                                                                                    } else if (i == 2) {
                                                                                                        input_1.value = "<?php echo $dadosPais['nome_lider']; ?>";
                                                                                                        input_2.value = "<?php echo $dadosPais['email']; ?>";
                                                                                                        input_3.value = "<?php echo $dadosPais['telefone_whatsapp']; ?>";

                                                                                                        input_1_desativados.value = "<?php echo $dadosPais['nome_lider']; ?>";
                                                                                                        input_2_desativados.value = "<?php echo $dadosPais['email']; ?>";
                                                                                                        input_3_desativados.value = "<?php echo $dadosPais['telefone_whatsapp']; ?>";

                                                                                                        input_1.disabled = true;
                                                                                                        input_2.disabled = true;
                                                                                                        input_3.disabled = true;
                                                                                                    }
                                                                                                }
                                                                                            </script>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-lg-6">
                                                                                        <div class="form-group">
                                                                                            <label for="exampleInputEmail1">Nome do Responsável (Obrigatório):</label>
                                                                                            <input class="form-control" type="text" minlength="5" id="pais_campos_1<?= $i; ?>" name="nome_responsavel" value="<?= $linha['nome_responsavel']; ?>" placeholder="Nome do Responsável" <?= $disabled ?>>
                                                                                            <input type="hidden" id="pais_campos_desativados_1<?= $i; ?>" name="nome_responsavel_1" value="<?= $linha['nome_responsavel']; ?>">
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="col-lg-6">
                                                                                        <div class="form-group">
                                                                                            <label for="exampleInputEmail1">E-mail do Responsável:</label>
                                                                                            <input class="form-control" type="email" id="pais_campos_2<?= $i; ?>" name="email_responsavel" value="<?= $linha['email_responsavel']; ?>" placeholder="E-mail do Responsável" <?= $disabled ?>>
                                                                                            <input type="hidden" id="pais_campos_desativados_2<?= $i; ?>" name="email_responsavel_1" value="<?= $linha['email_responsavel']; ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-lg-6">
                                                                                        <div class="form-group">
                                                                                            <label for="exampleInputEmail1">Telefone do Responsável:</label>
                                                                                            <input class="form-control" type="text" id="pais_campos_3<?= $i; ?>" name="telefone_responsavel'" value="<?= $linha['telefone_responsavel']; ?>" minlength="11" placeholder="Telefone do Responsável" <?= $disabled ?>>
                                                                                            <input type="hidden" id="pais_campos_desativados_3<?= $i; ?>" name="telefone_responsavel_1" value="<?= $linha['telefone_responsavel']; ?>">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                                                                                <input type="submit" class="btn btn-default" value="Salvar">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>

                                                            <div class="modal fade" id="<?= $linha['id_crianca']; ?>desativar_crianca">
                                                                <div class="modal-dialog modal-danger">
                                                                    <div class="modal-content">
                                                                        <form action="criancas/exclusao/desativar" method="post">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                    <span aria-hidden="true">&times;</span></button>
                                                                                <h4 class="modal-title">Desativar | Criança</h4>
                                                                            </div>
                                                                            <div class="box-body">
                                                                                <input type="hidden" name="idResponsavel" value="<?= $id_usuario; ?>">
                                                                                <input type="hidden" name="idLider" value="<?= $linha['lider']; ?>">
                                                                                <input type="hidden" name="idCrianca" value="<?= $linha['id_crianca']; ?>">
                                                                                <input type="hidden" name="nomeCrianca" value="<?= $linha['nome_crianca']; ?>">
                                                                                <input type="hidden" name="nivel" value="2">

                                                                                <div class="form-group">
                                                                                    <label for="exampleInputEmail1">Deseja realmente desativar essa Criança?</label>
                                                                                    <label for="exampleInputPassword1">Conte-nos o motivo:</label>
                                                                                    <textarea name="motivo" maxlength="50" class="form-control"></textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                                                                                <input type="submit" class="btn btn-default" value="Desativar">
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                    <!-- /.modal-content -->
                                                                </div>
                                                                <!-- /.modal-dialog -->
                                                            </div>
                                                        <?php $i++;
                                                        } ?>
                                            </tbody>
                                    <?php
                                                    } else {
                                                    }
                                                }
                                    ?>
                                        </table>
                                    </div>
                                    <!-- /.item -->
                                </div>
                            </div>
                            <!-- /.item -->

                            <div class="modal fade" id="criancas_desativadas">
                                <div class="modal-dialog modal-warning">
                                    <div class="modal-content">
                                        <form action="criancas/ativar" method="POST">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Ativar | Crianças</h4>
                                            </div>

                                            <div class="box-body" style="height: 150px;">

                                                <input type="hidden" name="idLider" value="<?= $id_usuario; ?>">
                                                <input type="hidden" name="nivel" value="2">
                                                <div class="col-lg-12" style="position: relative;top: 50%; transform: translateY(-50%);">
                                                    <div class="form-group">
                                                        <label for="opc">Selecione a Criança:</label>
                                                        <select name="opc" class="form-control">
                                                            <?php
                                                            foreach ($criancas_desativadas['dados'] as $key => $dadosCriancas) {
                                                            ?>
                                                                <option value="<?= $dadosCriancas['id_crianca']; ?>"><?= $dadosCriancas['nome_crianca']; ?> </option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                                                <input type="submit" class="btn btn-default pull-right" value="Ativar">
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
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
                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title"><i class="fa fa-book"></i> PDF</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="box-body chat" id="chat-box">
                                <div class="item">
                                    <center>
                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#gerar_relatorio">
                                            Gerar PDF
                                        </button>
                                    </center>
                                    <div class="modal fade" id="gerar_relatorio">
                                        <div class="modal-dialog modal-warning">
                                            <div class="modal-content">
                                                <form action="criancas/gerar/relatorio" target="_blank" method="post">
                                                    <input type="hidden" name="id" value="<?= $id_usuario; ?>">
                                                    <input type="hidden" name="nivel" value="2">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span></button>
                                                        <h4 class="modal-title">PDF | Criança</h4>
                                                    </div>
                                                    <div class="box-body" style="height: 250px;">
                                                        <div class="col-lg-12" style="position: relative;top: 50%; transform: translateY(-50%);">
                                                            <div class="form-group">
                                                                <label for="opc">Selecione</label>
                                                                <select name="opc" class="form-control">
                                                                    <optgroup label="Informações Gerais">
                                                                        <option value="1">Completo</option>
                                                                    </optgroup>
                                                                    <optgroup label="Personalizado">
                                                                        <option value="2">Ativas</option>
                                                                        <option value="3">Desativadas</option>
                                                                    </optgroup>
                                                                    <optgroup label="PG">
                                                                        <?php
                                                                        foreach ($consultarPG['dados'] as $key => $dadosPG) {
                                                                        ?>
                                                                            <option value="pg <?= $dadosPG['id_pg']; ?>"> PG - <?= $dadosPG['nome_pg']; ?> </option>
                                                                        <?php } ?>
                                                                    </optgroup>
                                                                    <optgroup label="Por Pontuação">
                                                                        <?php
                                                                        foreach ($consultarPG['dados'] as $key => $dadosPG) {
                                                                        ?>
                                                                            <option value="pontuacao <?= $dadosPG['id_pg']; ?>">PG - <?= $dadosPG['nome_pg']; ?> </option>
                                                                        <?php } ?>
                                                                    </optgroup>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                                                        <input type="submit" class="btn btn-default" value="Gerar">
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- /.modal-content -->
                                        </div>
                                        <!-- /.modal-dialog -->
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

            <!-- /.content-wrapper -->
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
        <?php $this->load->view('partes/scripts2');
        ?>

        <script>
            $(document).ready(function() {
                var i = 1;

                document.getElementById('remove').style.display = 'none';

                $("#add").click(function() {
                    i = i + 1;
                    var conteudo = "#conteudo" + i;
                    var conteudo2 = "conteudo" + i;
                    var linhaResponsaveis = "linhaResponsaveis" + i;

                    document.getElementById('controller').value = i;

                    var iInicial = document.getElementById('controller').value;

                    if (iInicial == 1) {
                        document.getElementById('remove').style.display = 'none';
                    } else {
                        document.getElementById('remove').style.display = 'inline';
                    }

                    $("#conteudo").append('<div id="' + conteudo2 + '"></div>');

                    $(conteudo).append('<br><hr><div class="col-lg-12"><div class="form-group"><label for="nomeCrianca">Nome da Criança</label><input class="form-control" id="nomeCrianca" type="text" name="nome[]" placeholder="Nome da Criança" required></div></div><div class="col-lg-6"><div class="form-group"><label for="dataDeNascimento">Data de Nascimento (DD/MM/YYYY)</label><input class="form-control" type="text" id="dataDeNascimento" name="nascimento[]" placeholder="Data de Nascimento (DD/MM/YYYY)" maxlength="10" minlength="10"></div></div><div class="col-lg-6"><div class="col-lg-6"><div class="form-group"><label for="exampleInputEmail1">É Cristão?</label><select name="opcao[]" class="form-control" required><option value="0" selected>Escolha uma opção</option><option value="1">Sim</option><option value="0">Não</option></select></div></div><div class="col-lg-6"><div class="form-group"><label for="exampleInputEmail1">Responsável da Criança:</label><select name="responsavel_crianca[]" id="isRespon_' + i + '" onchange="mostrarCamposPais(' + i + ');" class="form-control" required><option value="<?= $dadosPais['nome_lider'] ?>" selected><?= $dadosPais['nome_lider'] ?></option><option value="outro">Outro</option></select></div></div></div><div class="col-lg-12" id="' + linhaResponsaveis + '" style="display: none;"><div class="col-lg-4"><div class="form-group"><label for="exampleInputEmail1">Nome do Responsável (Obrigatório):</label><input class="form-control" type="text" minlength="5" name="nome_responsavel[]" placeholder="Nome do Responsável"></div></div><div class="col-lg-4"><div class="form-group"><label for="exampleInputEmail1">E-mail do Responsável:</label><input class="form-control" type="text" name="email_responsavel[]" placeholder="E-mail do Responsável"></div></div><div class="col-lg-4"><div class="form-group"><label for="exampleInputEmail1">Telefone do Responsável:</label><input class="form-control" type="text" name="telefone_responsavel[]" minlength="11" placeholder="Telefone do Responsável"></div></div></div><div class="col-lg-12"><label for="observacao">Observação</label><textarea id="observacao" name="obs[]" class="form-control"></textarea></div><hr><br><input type="hidden" value="1" id="total" name="total[]">');
                    return false;
                });

                $("#remove").click(function() {
                    var iInicial = document.getElementById('controller').value;

                    var novoI = document.getElementById('controller').value = i;

                    var Novoconteudo = "#conteudo" + novoI;

                    $(Novoconteudo).empty('');

                    i = i - 1;
                    document.getElementById('controller').value = i;
                    var iInicial = document.getElementById('controller').value;

                    if (iInicial == 1) {
                        document.getElementById('remove').style.display = 'none';
                    } else {
                        document.getElementById('remove').style.display = 'inline';
                    }

                    return false;
                });
            });
        </script>

    </body>

    </html>
<?php } ?>