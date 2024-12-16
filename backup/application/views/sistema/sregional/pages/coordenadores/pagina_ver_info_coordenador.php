<?php
if (!isset($_SESSION['usuario'])) {
    header("location: ../../../../index");
} else {

    $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
    $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

    $voltar = "../../";
    $array = array('voltar' => $voltar);
?>
    <!DOCTYPE html>
    <html>
    <!-- Head -->
    <?php
    $this->load->view('partes/head');
    ?>

    <script>
        $(document).ready(function() {
            document.getElementById('btn_solicitar_1').disabled = true;
            document.getElementById('btn_solicitar_2').disabled = true;


            document.getElementById('remove_cri').style.display = 'none';
        });

        function validar_edicao() {

            var dados = document.form_editar_foto.opc.value;

            if (dados == "Sim" || dados == "Não") {} else {
                alert("Você não escolheu a opção");
                return false;
            }
        }

        function trocar_nome() {
            const str = document.getElementById('id_troca_1').value;
            const opc = str.split(' ');

            if (opc[0] == 0) {
                document.getElementById('opcao_escolhida').innerHTML = "Escolha uma opção acima e digite o nome";
                document.getElementById('btn_solicitar_1').disabled = true;
            } else if (opc[0] == "sl") {
                document.getElementById("opcao_escolhida").innerHTML = "Digite o nome do Supervisor Local";
                document.getElementById('btn_solicitar_1').disabled = false;
            } else if (opc[0] == "sr") {
                document.getElementById("opcao_escolhida").innerHTML = "Digite o nome do Supervisor Regional";
                document.getElementById('btn_solicitar_1').disabled = false;
            }
        }

        function trocar_lider() {
            const opc = document.getElementById('id_lider_troca').value;

            if (opc == 0) {
                document.getElementById('btn_solicitar_2').disabled = true;
            } else {
                document.getElementById('btn_solicitar_2').disabled = false;
            }
        }
    </script>

    <style>
        #imgPhoto_usuario,
        #imgPhoto_colider {
            margin-top: 1%;
            width: 150px;
            height: 150px;
            padding: 10px;
            background-color: #eee;
            border: 5px solid #ccc;
            border-radius: 50%;
            cursor: pointer;
            transition: background .3s;
        }

        #imgPhoto_usuario:hover,
        #imgPhoto_colider:hover {
            background-color: rgb(180, 180, 180);
            border: 5px solid #111;
        }
    </style>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <!-- Menu -->
            <?php
            $this->load->view('sistema/slocal/partes/menu_lateral', $array);
            ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Líderes
                        <small>Painel de Controle</small>
                    </h1>

                    <ol class="breadcrumb">
                        <?php
                        foreach ($pages as $key => $value) {
                        ?>
                            <li><a href="<?= $value['red']; ?>"><i class="<?= $value['icon']; ?>"></i> <?= $value['name']; ?></a></li>
                        <?php
                        }
                        ?>
                        <li class="active">Informações</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="box box-info">
                            <?php

                            $dados_lider = $dados_do_coordenador['dados'];
                            $check_desativado = "";

                            if ($dados_lider['ativo'] == 0) {
                                $check_desativado = "disabled";
                            ?>

                                <br>
                                <div class="callout callout-danger">
                                    <h4>
                                        Esse coordenador foi desativado!
                                    </h4>
                                </div>
                                <center>
                                    <button type="button" class="btn btn-success" data-toggle="modal" style="margin-bottom: 15px;" data-target="#lideres_desativados">Ativar</button>
                                </center>
                                <div class="modal fade" id="lideres_desativados">
                                    <div class="modal-dialog modal-warning">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Ativar | Desativar | Coordenador</h4>
                                            </div>

                                            <div class="box-body">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label for="opc">Líder:</label>
                                                            <input type="text" class="form-control" value="<?= $dados_lider['nome_coordenador']; ?>" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <form action="../../coordenadores/exclusao/ativar" method="POST">
                                                                <input type="hidden" name="opc" value="<?= $dados_lider['id_coordenador']; ?>">
                                                                <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                                <input type="hidden" name="red" value="coordenador/detalhes">
                                                                <center>
                                                                    <label for="opc">Opção 1:</label><br>
                                                                    <input type="submit" class="btn btn-success" value="Ativar">
                                                                </center>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <form action="../../coordenadores/exclusao/permanente" method="POST">
                                                                <input type="hidden" name="opc" value="<?= $dados_lider['id_coordenador']; ?>">
                                                                <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                                <input type="hidden" name="red" value="coordenador/detalhes">
                                                                <center>
                                                                    <label for="opc">Opção 2:</label><br>
                                                                    <input type="submit" class="btn btn-danger" value="Excluir (Permanentemente)">
                                                                </center>
                                                            </form>
                                                        </div>
                                                    </div>
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

                            <?php } else {
                            } ?>

                            <!-- form start -->
                            <form action="../salvar" role="form" method="POST" enctype="multipart/form-data" name="form_editar_foto">
                                <div class="col-lg-12">
                                    <div class="box-body chat" id="chat-box">
                                        <div class="box-footer">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Dados Pessoais</h3>
                                            </div> <br>
                                            <?php

                                            $foto_original = $dados_lider['foto'];
                                            //$foto_original = 'fotoU/pais/WhatsApp_Image_2022-12-05_at_08_30_33.jpeg';

                                            $foto = base_url('import/sistema/' . $foto_original);
                                            ?>

                                            <input type="hidden" name="id" aria-describedby="emailHelp" value="<?= $dados_lider['id_coordenador']; ?>">

                                            <script type="text/javascript">
                                                $(document).ready(function() {

                                                    $.getJSON('<?php echo base_url('import/sistema/dist/js/estados_cidades.json'); ?>', function(data) {
                                                        var items = [];
                                                        var options = '<optgroup label="Seu estado escolhido"><option value="<?php echo $dados_lider['estado'] ?>"><?php echo $dados_lider['estado'] ?></option></optgroup>';

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
                                                                    options_cidades += '<optgroup label="Sua cidade escolhida"><option value="<?php echo $dados_lider['cidade'] ?>"><?php echo $dados_lider['cidade'] ?></option></optgroup>';
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

                                            <div class="col-lg-12">
                                                <center>
                                                    <div class="form-group">
                                                        <div class="form-group">
                                                            <label for="nome">Editar Foto?</label>
                                                            <div class="imageContainer">
                                                                <img src="<?= $foto; ?>" alt="Imagem não encontrada" id="imgPhoto_usuario">
                                                            </div>
                                                            <input type="file" name="files[]" id="fileImage_usuario">
                                                            <input type="hidden" name="foto_antiga" value="<?= $foto_original; ?>">
                                                        </div>
                                                    </div>
                                                </center>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nome</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="nome" minlength="5" value="<?= $dados_lider['nome_coordenador']; ?>" placeholder="Nome" <?= $check_desativado; ?> required>
                                                    <input type="hidden" name="nome_antigo" value="<?= $dados_lider['nome_coordenador']; ?>">
                                                </div>

                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">CPF</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="cpf" value="<?= $dados_lider['cpf']; ?>" placeholder="CPF" maxlength="14" minlength="11" <?= $check_desativado; ?> required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">E-mail</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="<?= $dados_lider['email']; ?>" placeholder="E-mail" <?= $check_desativado; ?> required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Telefone</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="telefone" value="<?= $dados_lider['telefone_whatsapp']; ?>" placeholder="Telefone" minlength="11" <?= $check_desativado; ?> required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Data de Nascimento</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="nascimento" value="<?= $dados_lider['nascimento']; ?>" maxlength="10" minlength="10" placeholder="Data de Nascimento" <?= $check_desativado; ?> required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group" id="form-group">
                                                    <label for="exampleInputPassword1">Estado</label>
                                                    <select id="estados" name="estados" class="form-control" <?= $check_desativado; ?>>
                                                        <option value=""></option>
                                                    </select>
                                                </div>

                                                <div class="form-group" id="form-group">
                                                    <label for="exampleInputPassword1">Cidade</label>
                                                    <select id="cidades" name="cidades" class="form-control" <?= $check_desativado; ?>></select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group" id="form-group">
                                                    <label for="exampleInputPassword1">Supervisor Local</label>
                                                    <?php
                                                    $id_sr = $dados_lider['id_supervisorR'];
                                                    $info_sLocal = $this->FConsultas_model->getInfoSLocalId($id_sr);
                                                    ?>
                                                    <input type="hidden" name="id_sl" value="<?= $id_sr; ?>">
                                                    <select name="id_sLocal" class="form-control" <?= $check_desativado; ?>>
                                                        <option value="<?= $id_sr; ?>" selected><?= $info_sLocal['dados']['nome_supervisorR']; ?> (você)</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group" id="form-group">
                                                    <label for="exampleInputPassword1">Supervisor Regional</label>
                                                    <?php
                                                    $id_se = $dados_lider['id_supervisorE'];
                                                    $info_sRegional = $this->FConsultas_model->getInfoSRegionalId($id_se);
                                                    ?>
                                                    <input type="hidden" name="id_sr" value="<?= $id_se; ?>">
                                                    <select name="id_sRegional" class="form-control" <?= $check_desativado; ?>>
                                                        <option value="<?= $id_se; ?>" selected><?= $info_sRegional['dados']['nome_supervisorE']; ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <button type="submit" class="btn btn-danger pull-left" style="margin-right: 10px;" <?= $check_desativado; ?>>Salvar</button>
                                                <center>
                                                    <button type="button" style="margin-right: 10px;" class="btn btn-light pull-left" data-toggle="modal" data-target="#troca_de_coord_super" <?= $check_desativado; ?>>Solicitar Troca</button>
                                                    <button type="button" style="margin-right: 10px;" class="btn btn-danger pull-left" data-toggle="modal" data-target="#desativar_coordenador" <?= $check_desativado; ?>>Desativar</button>

                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-success pull-left dropdown-toggle" data-toggle="dropdown">Mudar Função
                                                            <span class="fa fa-caret-down"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li><button type="button" class="btn btn-default" data-toggle="modal" data-target="#tornar_coordenador" <?= $check_desativado; ?>>Tornar Supervisor</button></li>
                                                            <li><button type="button" class="btn btn-default" data-toggle="modal" data-target="#tornar_lider" <?= $check_desativado; ?>>Tornar Líder</button></li>
                                                        </ul>
                                                    </div>
                                                </center>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- form start -->
                    </div>
                    <!-- /.box -->
                </section>



                <div class="modal fade" id="troca_de_coord_super">
                    <div class="modal-dialog modal-light">
                        <div class="modal-content">
                            <form action="../../../../alerta/solicitar/troca_de_css" method="POST">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Solicitar Troca de Supervisor</h4>
                                </div>

                                <div class="box-body" style="height: 150px;">

                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="id_lider" value="<?= $dados_lider['id_coordenador']; ?>">
                                    <input type="hidden" name="red" value="slocal/coord">

                                    <div class="col-lg-12" style="position: relative;top: 50%; transform: translateY(-50%);">
                                        <div class="form-group">
                                            <label for="id_troca_1">Selecione quem você deseja trocar:</label>
                                            <select name="id_troca_1" id="id_troca_1" class="form-control" onchange="trocar_nome();" required>
                                                <option value="0" selected>Selecione uma opção</option>
                                                <?php
                                                $id_sr = $dados_lider['id_supervisorR'];
                                                $info_sLocal = $this->FConsultas_model->getInfoSLocalId($id_sr);

                                                $id_se = $dados_lider['id_supervisorE'];
                                                $info_sRegional = $this->FConsultas_model->getInfoSRegionalId($id_se);
                                                ?>
                                                <option value="sl <?= $id_sr; ?>">S. Local: <?= $info_sLocal['dados']['nome_supervisorR']; ?> (você)</option>
                                                <option value="sr <?= $id_se; ?>">S. Regional: <?= $info_sRegional['dados']['nome_supervisorE']; ?></option>
                                            </select>

                                            <br>
                                            <label for="id_troca_2" id="opcao_escolhida">Escolha uma opção acima e digite o nome</label>
                                            <input type="text" class="form-control" name="id_troca_2" required>

                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                                    <input type="submit" id="btn_solicitar_1" class="btn btn-default pull-right" value="Solicitar">
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="tornar_coordenador">
                    <div class="modal-dialog modal-default">
                        <div class="modal-content">
                            <form action="../../../../alerta/solicitar/tornar_slocal" method="POST">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Solicitar Mudança Coordenador - Super. Local</h4>
                                </div>
                                <div class="box-body">
                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="id_coordenador" value="<?= $dados_lider['id_coordenador']; ?>">
                                    <input type="hidden" name="red" value="slocal/coord">

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <center>
                                                <label for="id_troca_1">Deseja tornar <?= $dados_lider['nome_coordenador']; ?> supervisor local?</label>
                                                <br><i>* observação: para essa nova função, o coordenador tem que ter 3 novas coordenações.</i>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Não</button>
                                    <input type="submit" id="btn_solicitar_1" class="btn btn-default pull-right" value="Solicitar">
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="tornar_lider">
                    <div class="modal-dialog modal-default">
                        <div class="modal-content">
                            <form action="../../../../alerta/solicitar/tornar_coord_lider" method="POST">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Solicitar Mudança Coordenador - Líder</h4>
                                </div>
                                <div class="box-body">
                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="id_coordenador" value="<?= $dados_lider['id_coordenador']; ?>">
                                    <input type="hidden" name="red" value="slocal/coord">

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <center>
                                                <label for="id_troca_1">Deseja tornar <?= $dados_lider['nome_coordenador']; ?> líder?</label>
                                            </center>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Não</button>
                                    <input type="submit" id="btn_solicitar_1" class="btn btn-default pull-right" value="Solicitar">
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="desativar_coordenador">
                    <div class="modal-dialog modal-danger">
                        <div class="modal-content">
                            <form action="../../coordenadores/desativar" method="post">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Desativar | Coordenador</h4>
                                </div>
                                <div class="box-body">
                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="id_coordenador" value="<?= $dados_lider['id_coordenador']; ?>">
                                    <input type="hidden" name="red" value="coordenador">

                                    <div class="form-group">
                                        <center>
                                            <label for="exampleInputEmail1">Deseja realmente desativar esse Líder?</label>
                                        </center>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Não</button>
                                    <input type="submit" class="btn btn-default" value="Sim">
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

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

        <script src="<?php echo base_url('import/sistema/dist/js/fotos.js'); ?>"></script>
    </body>

    </html>
<?php } ?>