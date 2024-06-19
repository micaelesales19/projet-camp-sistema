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
            } else if (opc[0] == "coord") {
                document.getElementById("opcao_escolhida").innerHTML = "Digite o nome do Coordenador";
                document.getElementById('btn_solicitar_1').disabled = false;
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

        #imgPhoto_pg {
            margin-top: 1%;
            width: 50px;
            height: 50px;
            padding: 1px;
            background-color: #eee;
            border: 1px solid #ccc;
            border-radius: 50%;
            transition: background .3s;
        }

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
            $this->load->view('sistema/coordenador/partes/menu_lateral', $array);
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
                        <li><a href="../../../home"><i class="fa fa-home"></i> Home</a></li>
                        <li><a href="../../lideres"><i class="fa fa-group"></i> Líderes</a></li>
                        <li class="active">Informações</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="box box-info">
                            <!-- form start -->
                            <form action="../salvar" role="form" method="POST" enctype="multipart/form-data" name="form_editar_foto">
                                <div class="col-lg-6">
                                    <div class="box-body chat" id="chat-box">
                                        <div class="box-footer">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Dados Pessoais</h3>
                                            </div> <br>
                                            <?php
                                            $dados_lider = $dados_do_lider['dados'];

                                            $foto_original = $dados_lider['foto'];
                                            //$foto_original = 'fotoU/pais/WhatsApp_Image_2022-12-05_at_08_30_33.jpeg';

                                            $foto = base_url('import/sistema/' . $foto_original);
                                            ?>

                                            <input type="hidden" name="id" aria-describedby="emailHelp" value="<?= $dados_lider['id_lider']; ?>">

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

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nome</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="nome" minlength="5" value="<?= $dados_lider['nome_lider']; ?>" placeholder="Nome" required>
                                                    <input type="hidden" name="nome_antigo" value="<?= $dados_lider['nome_lider']; ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">CPF</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="cpf" value="<?= $dados_lider['cpf']; ?>" placeholder="CPF" maxlength="14" minlength="11" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">E-mail</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="<?= $dados_lider['email']; ?>" placeholder="E-mail" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Telefone</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="telefone" value="<?= $dados_lider['telefone_whatsapp']; ?>" placeholder="Telefone" minlength="11" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Igreja</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="igreja" value="<?= $dados_lider['igreja']; ?>" placeholder="Igreja" minlength="5" required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Data de Nascimento</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="nascimento" value="<?= $dados_lider['nascimento']; ?>" maxlength="10" minlength="10" placeholder="Data de Nascimento" required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group" id="form-group">
                                                    <label for="exampleInputPassword1">Estado</label>
                                                    <select id="estados" name="estados" class="form-control">
                                                        <option value=""></option>
                                                    </select>
                                                </div>

                                                <div class="form-group" id="form-group">
                                                    <label for="exampleInputPassword1">Cidade</label>
                                                    <select id="cidades" name="cidades" class="form-control"></select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group" id="form-group">
                                                    <label for="exampleInputPassword1">Coordenador</label>
                                                    <?php
                                                    $id_coordenador = $dados_lider['id_coordenador'];
                                                    $info_coordenador = $this->FConsultas_model->getInfoCoordenadorId($id_coordenador);
                                                    ?>
                                                    <input type="hidden" name="id_coordenador" value="<?= $id_coordenador; ?>">
                                                    <select name="id_coordenador" class="form-control">
                                                        <option value="<?= $id_coordenador; ?>" selected><?= $info_coordenador['dados']['nome_coordenador']; ?> (você)</option>
                                                    </select>
                                                </div>

                                                <div class="form-group" id="form-group">
                                                    <label for="exampleInputPassword1">Supervisor Regional</label>
                                                    <?php
                                                    $id_se = $dados_lider['id_supervisorE'];
                                                    $info_sRegional = $this->FConsultas_model->getInfoSRegionalId($id_se);
                                                    ?>
                                                    <input type="hidden" name="id_sr" value="<?= $id_se; ?>">
                                                    <select name="id_sRegional" class="form-control">
                                                        <option value="<?= $id_se; ?>" selected><?= $info_sRegional['dados']['nome_supervisorE']; ?></option>
                                                    </select>
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
                                                    <select name="id_sLocal" class="form-control">
                                                        <option value="<?= $id_sr; ?>" selected><?= $info_sLocal['dados']['nome_supervisorR']; ?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <button type="button" class="btn btn-light pull-left" data-toggle="modal" data-target="#troca_de_coord_super">Solicitar Troca</button>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="box-body chat" id="chat-box">
                                        <div class="box-footer">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Colíder</h3>
                                                <?php
                                                $colideres_desativados = $this->FConsultas_model->mostrarColiderDoLiderDesativados($dados_lider['id_lider']);
                                                $dados = $this->FConsultas_model->mostrarColiderDoLider($dados_lider['id_lider']);

                                                if ($colideres_desativados['row'] == 0) {
                                                } else {
                                                ?>
                                                    <button type="button" class="btn btn-warning pull-right" data-toggle="modal" data-target="#colideres_desativados">Colíderes Desativados</button>
                                                <?php }
                                                if ($dados) {
                                                ?>
                                                    <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="<?= "#" . $dados['id_colider']; ?>desativar_colider">Desativar Colíder</button>

                                                <?php } else {
                                                } ?>
                                            </div>
                                            <?php
                                            if ($dados) {
                                            ?>
                                                <?php

                                                $foto_original_colider = $dados['foto'];

                                                $foto_colider = base_url('import/sistema/' . $foto_original_colider);
                                                ?>

                                                <input class="form-control" id="exampleInputText1" type="hidden" name="id_colider" aria-describedby="emailHelp" value="<?= $dados['id_colider'] ?>">

                                                <div class="col-lg-12">
                                                    <center>
                                                        <div class="form-group">
                                                            <div class="form-group">
                                                                <label for="nome">Editar Foto?</label>
                                                                <div class="imageContainer">
                                                                    <img src="<?= $foto_colider; ?>" alt="Imagem não encontrada" id="imgPhoto_colider">
                                                                </div>
                                                                <input type="file" name="filesColider[]" id="fileImage_colider">
                                                                <input type="hidden" name="foto_antiga_colider" value="<?= $foto_original_colider; ?>">
                                                            </div>
                                                        </div>
                                                    </center>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Nome</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" name="nome_colider" minlength="5" value="<?= $dados['nome_colider']; ?>" placeholder="Nome" required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">CPF</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" name="cpf_colider" value="<?= $dados['cpf']; ?>" placeholder="CPF" maxlength="14" minlength="11" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">E-mail</label>
                                                        <input type="email" class="form-control" id="exampleInputEmail1" name="email_colider" value="<?= $dados['email']; ?>" placeholder="E-mail" required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Telefone</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" name="telefone_colider" value="<?= $dados['telefone_whatsapp']; ?>" placeholder="Telefone" minlength="11" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Data de Nascimento</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" name="nascimento_colider" value="<?= $dados['nascimento']; ?>" maxlength="10" minlength="10" placeholder="Data de Nascimento" required>
                                                    </div>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <div class="box-body chat"><br>
                                                    <div class="callout callout-warning">
                                                        <h4>
                                                            Esse líder não tem nenhum colíder!
                                                        </h4>
                                                        <p>Cadastre</p>
                                                    </div>

                                                    <center>
                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cadastro_colider">Cadastrar +</button>
                                                    </center>
                                                </div>
                                            <?php
                                            } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-danger pull-right">Salvar</button>
                                </div>
                            </form>
                        </div>
                        <!-- form start -->
                    </div>
                    <!-- /.box -->
                </section>

                <?php

                $pg = $this->FConsultas_model->mostrarPG($dados_lider['id_lider'], 2);
                $pg_desativados = $this->FConsultas_model->mostrarPGDesativados($dados_lider['id_lider'], 2);

                if ($pg['row'] == 0) {
                ?>
                    <div class="box-body chat"><br>
                        <div class="callout callout-danger">
                            <h4>
                                Esse líder não tem nenhum PG!
                            </h4>
                            <p>Cadastre</p>
                        </div>
                        <center>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cadastro_pg">Cadastrar +</button>
                        </center>
                    </div>
                <?php
                } else {
                ?>
                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                            <div class="box box-info">
                                <div class="box-body chat" id="chat-box">
                                    <div class="box-footer">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">PG</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-success pull-rigth" data-toggle="modal" data-target="#cadastro_pg">Cadastrar PG</button>
                                                <?php
                                                if ($pg_desativados['row'] == 0) {
                                                } else {
                                                ?>
                                                    <button type="button" style="margin-left: 5px;" class="btn btn-light pull-rigth" data-toggle="modal" data-target="#pg_desativados">PG Desativados</button>

                                                    <div class="modal fade" id="pg_desativados">
                                                        <div class="modal-dialog modal-success">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span></button>
                                                                    <h4 class="modal-title">Ativar | Desativar | PG</h4>
                                                                </div>
                                                                <div class="box-body">

                                                                    <script>
                                                                        function trocar_id_pg() {
                                                                            var id_pg = document.getElementById('opc_id_pg').value;

                                                                            document.getElementById('id_pg_escolhido_1').value = id_pg;
                                                                            document.getElementById('id_pg_escolhido_2').value = id_pg;
                                                                        }
                                                                    </script>

                                                                    <div class="col-lg-12">

                                                                        <div class="col-lg-5">
                                                                            <div class="form-group">
                                                                                <label for="opc">PG:</label>
                                                                                <select name="opc" id="opc_id_pg" onchange="trocar_id_pg()" class="form-control">
                                                                                    <?php
                                                                                    foreach ($pg_desativados['dados'] as $key => $dadosPGDesativados) {
                                                                                    ?>
                                                                                        <option value="<?= $dadosPGDesativados['id_pg']; ?>"><?= $dadosPGDesativados['nome_pg']; ?> </option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-3">
                                                                            <div class="form-group">
                                                                                <form action="../../pg/exclusao/ativar" method="POST">
                                                                                    <input type="hidden" name="id_pg" id="id_pg_escolhido_1" value="<?= $pg_desativados['dados'][0]['id_pg']; ?>">
                                                                                    <input type="hidden" name="nivel" value="2">
                                                                                    <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                                                    <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                                                                    <input type="hidden" name="red" value="lideres/detalhes">
                                                                                    <center>
                                                                                        <label for="opc">Opção 1:</label><br>
                                                                                        <input type="submit" class="btn btn-success" value="Ativar">
                                                                                    </center>
                                                                                </form>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <form action="../../pg/exclusao/permanente" method="POST">
                                                                                    <input type="hidden" name="id_pg" id="id_pg_escolhido_2" value="<?= $pg_desativados['dados'][0]['id_pg']; ?>">
                                                                                    <input type="hidden" name="nivel" value="2">
                                                                                    <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                                                    <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                                                                    <input type="hidden" name="red" value="lideres/detalhes">
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
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="table-responsive">

                                            <div id="texto_alerta">
                                                <p style="font-size: 11px; padding:10px"><i>*Arraste para o lado para vê mais opções</i></p>
                                            </div>
                                            <table class="table table-bordered table-hover" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Nome</th>
                                                        <th>Módulo</th>
                                                        <th>Ação</th>
                                                        <th>Ação</th>
                                                        <th>Ação</th>
                                                        <th>Ação</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $i = 0;

                                                    $disabled = $pg['row'] == 1 ? 'disabled' : '';

                                                    foreach ($pg['dados'] as $key => $dadosPG) {
                                                        $id_modulo = $dadosPG['id_modulo'] ?? 1;
                                                        $modulo = $this->FConsultas_model->consultarModuloId($id_modulo);
                                                        $nome_modulo = $modulo['nome_modulo'];
                                                        $n_licao = $modulo['n_licao'];

                                                        $foto = base_url($dadosPG['foto']);
                                                    ?>
                                                        <tr>
                                                            <td><img src="<?= $foto; ?>" alt="" id="imgPhoto_pg"> <?= $dadosPG['nome_pg']; ?></td>
                                                            <td><?= $nome_modulo; ?></td>
                                                            <td>
                                                                <button type="button" data-toggle="modal" class="btn btn-warning pull-left" data-target="<?= "#" . $dadosPG['id_pg']; ?>editar_pg">
                                                                    Editar
                                                                </button>

                                                                <div class="modal fade" id="<?= $dadosPG['id_pg']; ?>editar_pg">
                                                                    <div class="modal-dialog modal-warning">
                                                                        <div class="modal-content">
                                                                            <form action="../../pg/edicao/salvar" method="post" enctype="multipart/form-data">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="modal-title">Edição | PG</h4>
                                                                                </div>
                                                                                <div class="box-body">
                                                                                    <input type="hidden" name="idPg" id="id_pg<?= $i ?>" value="<?= $dadosPG['id_pg']; ?>">
                                                                                    <input type="hidden" name="fotoOriginal" value="<?= $dadosPG['foto']; ?>">
                                                                                    <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                                                                    <input type="hidden" name="red" value="lideres/detalhes">
                                                                                    <input type="hidden" name="nivel" value="2">
                                                                                    <div class="col-lg-12" style="display: flex; justify-content: center;">
                                                                                        <div class="col-lg-4">
                                                                                            <div class="form-group">
                                                                                                <label for="exampleInputEmail1">Foto (Opcional)</label>

                                                                                                <div class="imageContainer">
                                                                                                    <img src="<?= $foto; ?>" alt="Selecione uma imagem" class="imgPhoto1" id="imgPhoto1<?= $i; ?>">
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
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-danger pull-left" <?= $disabled; ?> style="margin-left: 10px;" data-toggle="modal" data-target="<?= "#" . $dadosPG['id_pg']; ?>desativar_pg">
                                                                    Desativar
                                                                </button>

                                                                <div class="modal fade" id="<?= $dadosPG['id_pg']; ?>desativar_pg">
                                                                    <div class="modal-dialog modal-danger">
                                                                        <div class="modal-content">
                                                                            <form action="../../pg/exclusao/desativar" method="post">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="modal-title">Desativar | PG</h4>
                                                                                </div>
                                                                                <div class="box-body">
                                                                                    <input type="hidden" name="red" value="lideres/detalhes">
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
                                                            </td>
                                                            <td>
                                                                <a href="#" class="btn btn-info pull-left" onclick="document.getElementById('form_preencher_relatorio').submit();">Preencher Relatório </a>

                                                                <form action="../../pg/licoes" id="form_preencher_relatorio" method="post">
                                                                    <input type="hidden" name="id_pg" value="<?= $dadosPG['id_pg']; ?>">
                                                                    <input type="hidden" name="id_lider" value="<?= $dados_lider['id_lider']; ?>">
                                                                    <input type="hidden" name="ano" value="<?= $dadosPG['ano']; ?>">
                                                                </form>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-light pull-left" data-toggle="modal" data-target="#<?= $dadosPG['id_pg']; ?>troca_de_lider_pg">Solicitar Troca</button>

                                                                <div class="modal fade" id="<?= $dadosPG['id_pg']; ?>troca_de_lider_pg">
                                                                    <div class="modal-dialog modal-light">
                                                                        <div class="modal-content">
                                                                            <form action="../../../../alerta/solicitar/troca_de_lider_pg" method="POST">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="modal-title">Solicitar Troca de Líder de PG</h4>
                                                                                </div>

                                                                                <div class="box-body" style="height: 150px;">

                                                                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                                                                    <input type="hidden" name="id_lider" value="<?= $dados_lider['id_lider']; ?>">
                                                                                    <input type="hidden" name="id_pg" value="<?= $dadosPG['id_pg']; ?>">

                                                                                    <div class="col-lg-12" style="position: relative;top: 50%; transform: translateY(-50%);">
                                                                                        <div class="form-group">
                                                                                            <label for="id_lider_troca">Selecione para quem você deseja trocar esse PG:</label>
                                                                                            <select name="id_lider_troca" onchange="trocar_lider();" id="id_lider_troca" class="form-control" required>
                                                                                                <option value="0" selected>Selecione uma opção</option>
                                                                                                <?php
                                                                                                $id_coordenador = $dados_lider['id_coordenador'];
                                                                                                $consultarLideres = $this->FConsultas_model->getLideres([$id_coordenador], 1, 1, []);
                                                                                                //$consultarLideresAtivos = $this->FConsultas_model->lideresAtivos($consultarLideres);

                                                                                                if ($consultarLideres['row'] == 0) {
                                                                                                ?>
                                                                                                    <option value="0" selected>Você não tem líder</option>
                                                                                                    <?php
                                                                                                }
                                                                                                foreach ($consultarLideres['dados'] as $key => $lider) {
                                                                                                    if ($dados_lider['id_lider'] == $lider['id_lider']) {
                                                                                                    } else {
                                                                                                    ?>
                                                                                                        <option value="<?= $lider['id_lider']; ?>"><?= $lider['nome_lider']; ?></option>
                                                                                                <?php }
                                                                                                } ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                                                                                    <input type="submit" id="btn_solicitar_2" class="btn btn-default pull-right" value="Solicitar">
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <!-- /.modal-content -->
                                                                    </div>
                                                                    <!-- /.modal-dialog -->
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                        $i++;
                                                    } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /.row -->

                    <!-- Main content -->
                    <section class="content">
                        <div class="row">
                            <div class="box box-info">
                                <div class="box-body chat" id="chat-box">
                                    <div class="box-footer">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Crianças</h3>
                                            <div class="box-tools pull-right">
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cadastro_criancas">Cadastrar +</button>
                                                <?php
                                                $criancas_desativadas = $this->FConsultas_model->mostrarCriancasDesativadas($dados_lider['id_lider'], 2);
                                                if ($criancas_desativadas['row'] == 0) {
                                                } else {
                                                ?>
                                                    <button type="button" style="margin-left: 5px;" class="btn btn-light pull-rigth" data-toggle="modal" data-target="#criancas_desativadas">Crianças Desativados</button>

                                                    <div class="modal fade" id="criancas_desativadas">
                                                        <div class="modal-dialog modal-warning">
                                                            <div class="modal-content">
                                                                <form action="../../criancas/exclusao/ativar" method="POST">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title">Ativar | Crianças</h4>
                                                                    </div>

                                                                    <div class="box-body" style="height: 150px;">
                                                                        <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                                                        <input type="hidden" name="nivel" value="2">
                                                                        <input type="hidden" name="red" value="lideres/detalhes">
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
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <script type="text/javascript">
                                                $(document).ready(function() {
                                                    $('#table_criancas').DataTable();
                                                });
                                            </script>

                                            <div id="texto_alerta">
                                                <p style="font-size: 11px; padding:10px"><i>*Arraste para o lado para vê mais opções</i></p>
                                            </div>

                                            <?php
                                            $dados_criancas = $this->FConsultas_model->mostrarCriancasPais($dados_lider['id_lider'], 2);

                                            if ($dados_criancas['row'] == 0) {
                                            ?>

                                                <div class="box-body chat"><br>
                                                    <div class="callout callout-warning">
                                                        <h4>
                                                            Esse líder não tem nenhuma criança!
                                                        </h4>
                                                        <p>Cadastre</p>
                                                    </div>

                                                    <center>
                                                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cadastro_criancas">Cadastrar +</button>
                                                    </center>
                                                </div>
                                            <?php
                                            } else {
                                            ?>
                                                <table class="table table-bordered table-hover" id="table_criancas" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Nome</th>
                                                            <th>PG</th>
                                                            <th>Nascimento</th>
                                                            <th>Ação</th>
                                                            <th>Ação</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($pg['dados'] as $key => $dadosPG) {

                                                            $consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPg($dados_lider['id_lider'], $dadosPG['id_pg'], 2);
                                                            $idPg = $dadosPG['id_pg'];

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
                                                                            <form action="../../criancas/edicao/salvar" method="post">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="modal-title">Edição | Criança</h4>
                                                                                </div>
                                                                                <div class="box-body">
                                                                                    <input type="hidden" name="idCrianca" value="<?= $linha['id_crianca']; ?>">
                                                                                    <input type="hidden" name="idLider" value="<?= $linha['lider']; ?>">
                                                                                    <input type="hidden" name="nivel" value="2">
                                                                                    <input type="hidden" name="red" value="lideres/detalhes">

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
                                                                                                foreach ($pg['dados'] as $key => $value) {
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
                                                                                                    $nome_pai = $dados_lider['nome_lider'];

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
                                                                                                            input_1.value = "<?php echo $dados_lider['nome_lider']; ?>";
                                                                                                            input_2.value = "<?php echo $dados_lider['email']; ?>";
                                                                                                            input_3.value = "<?php echo $dados_lider['telefone_whatsapp']; ?>";

                                                                                                            input_1_desativados.value = "<?php echo $dados_lider['nome_lider']; ?>";
                                                                                                            input_2_desativados.value = "<?php echo $dados_lider['email']; ?>";
                                                                                                            input_3_desativados.value = "<?php echo $dados_lider['telefone_whatsapp']; ?>";

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
                                                                            <form action="../../criancas/exclusao/desativar" method="post">
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
                                                                                    <input type="hidden" name="red" value="lideres/detalhes">

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
                                                            }
                                                        } ?>
                                                    </tbody>
                                                </table>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- /.row -->
                <?php } ?>
            </div>

            <?php
            if ($dados) {
            ?>
                <div class="modal fade" id="<?= $dados['id_colider']; ?>desativar_colider">
                    <div class="modal-dialog modal-danger">
                        <div class="modal-content">
                            <form action="../../../colider/desativar" method="POST">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Desativar | Colíder</h4>
                                </div>

                                <div class="box-body">

                                    <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                    <input type="hidden" name="idColider" value="<?= $dados['id_colider']; ?>">
                                    <input type="hidden" name="nomeColider" value="<?= $dados['nome_colider']; ?>">
                                    <input type="hidden" name="idResponsavel" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="red" value="lideres/detalhes">

                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Deseja realmente desativar o colíder do projeto CAMP?</label>
                                        <label for="exampleInputPassword1">Conte-nos o motivo:</label>
                                        <textarea name="motivo" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                                    <input type="submit" class="btn btn-default pull-right" value="Desativar">
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            <?php } ?>

            <?php
            if ($colideres_desativados['row'] == 0) {
            } else {
            ?>
                <div class="modal fade" id="colideres_desativados">
                    <div class="modal-dialog modal-warning">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Ativar | Desativar | Colíder</h4>
                            </div>

                            <div class="box-body" style="height: 150px;">

                                <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                <input type="hidden" name="red" value="lideres/detalhes">

                                <script>
                                    function trocar_id_colider_desativado() {
                                        var id_colider = document.getElementById('opc_id_colider').value;

                                        document.getElementById('id_colider_escolhido_1').value = id_colider;
                                        document.getElementById('id_colider_escolhido_2').value = id_colider;
                                    }
                                </script>

                                <div class="col-lg-12">

                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label for="opc">Colíder:</label>
                                            <select name="opc" id="opc_id_colider" onchange="trocar_id_colider_desativado()" class="form-control">
                                                <?php
                                                foreach ($colideres_desativados['dados'] as $key => $dadosColiderDesativados) {
                                                ?>
                                                    <option value="<?= $dadosColiderDesativados['id_colider']; ?>"><?= $dadosColiderDesativados['nome_colider']; ?> </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <form action="../../../colider/ativar" method="POST">
                                                <input type="hidden" name="opc" id="id_colider_escolhido_1" value="<?= $colideres_desativados['dados'][0]['id_colider']; ?>">
                                                <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                                <input type="hidden" name="red" value="lideres/detalhes">
                                                <center>
                                                    <label for="opc">Opção 1:</label><br>
                                                    <input type="submit" class="btn btn-success" value="Ativar">
                                                </center>
                                            </form>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="form-group">
                                            <form action="../../../colider/exclusao/permanente" method="POST">
                                                <input type="hidden" name="opc" id="id_colider_escolhido_2" value="<?= $colideres_desativados['dados'][0]['id_colider']; ?>">
                                                <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                                <input type="hidden" name="red" value="lideres/detalhes">
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
            <?php } ?>

            <div class="modal fade" id="cadastro_colider">
                <div class="modal-dialog modal-success">
                    <div class="modal-content">
                        <form action="../../../colider/cadastro/salvar" method="POST">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Cadastro | Colíder</h4>
                            </div>
                            <div class="box-body">
                                <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                <input type="hidden" name="red" value="lideres/detalhes">

                                <div class="col-lg-12">
                                    <div class="form-group has-feedback">
                                        <input type="text" class="form-control" name="nomeColider" minlength="5" placeholder="Nome do Colíder">
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group has-feedback">
                                        <input type="email" class="form-control" placeholder="Email do Colíder" name="emailColider">
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group has-feedback">
                                        <input type="text" class="form-control" placeholder="CPF do Colíder" minlength="11" name="cpfColider">
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group has-feedback">
                                        <input type="text" class="form-control" placeholder="Telefone do Colíder (DDD + Telefone)" minlength="11" name="telefoneColider">
                                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group has-feedback">
                                        <input type="text" class="form-control" placeholder="Data de Nascimento do Colíder (DD/MM/YYYY)" minlength="10" maxlength="10" name="nascimentoColider">
                                        <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
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

            <!-- OK -->
            <div class="modal fade" id="troca_de_coord_super">
                <div class="modal-dialog modal-light">
                    <div class="modal-content">
                        <form action="../../../../alerta/solicitar/troca_de_css" method="POST">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Solicitar Troca de Coordenador / Supervisor</h4>
                            </div>

                            <div class="box-body" style="height: 150px;">

                                <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                <input type="hidden" name="id_lider" value="<?= $dados_lider['id_lider']; ?>">

                                <div class="col-lg-12" style="position: relative;top: 50%; transform: translateY(-50%);">
                                    <div class="form-group">
                                        <label for="id_troca_1">Selecione quem você deseja trocar:</label>
                                        <select name="id_troca_1" id="id_troca_1" class="form-control" onchange="trocar_nome();" required>
                                            <option value="0" selected>Selecione uma opção</option>
                                            <?php
                                            $id_coordenador = $dados_lider['id_coordenador'];
                                            $info_coordenador = $this->FConsultas_model->getInfoCoordenadorId($id_coordenador);

                                            $id_sr = $dados_lider['id_supervisorR'];
                                            $info_sLocal = $this->FConsultas_model->getInfoSLocalId($id_sr);

                                            $id_se = $dados_lider['id_supervisorE'];
                                            $info_sRegional = $this->FConsultas_model->getInfoSRegionalId($id_se);
                                            ?>

                                            <option value="coord <?= $id_coordenador; ?>">Coordenador(a): <?= $info_coordenador['dados']['nome_coordenador']; ?> (você)</option>
                                            <option value="sl <?= $id_sr; ?>">S. Local: <?= $info_sLocal['dados']['nome_supervisorR']; ?></option>
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

            <div class="modal fade" id="cadastro_pg">
                <div class="modal-dialog modal-success">
                    <div class="modal-content">
                        <form action="../../pg/cadastro/salvar" method="POST">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Cadastro | PG</h4>
                            </div>
                            <div class="box-body">
                                <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                <input type="hidden" name="nivel" value="2">
                                <input type="hidden" name="red" value="lideres/detalhes">

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

            <div class="modal fade" id="cadastro_criancas">
                <div class="modal-dialog modal-success">
                    <div class="modal-content">
                        <form action="../../criancas/cadastro/salvar" method="POST">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title">Cadastro | Crianças</h4>
                            </div>
                            <div class="box-body">
                                <input type="hidden" name="id_lider" value="<?= $dados_lider['id_lider']; ?>">
                                <input type="hidden" name="nivel" value="2">
                                <input type="hidden" name="red" value="lideres/detalhes">

                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label for="nomeCrianca">Nome da Criança</label>
                                        <input class="form-control" id="nomeCrianca" type="text" name="nome[]" placeholder="Nome da Criança" required>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">PG</label>
                                        <select name="id_pg" id="id_pg" class="form-control">
                                            <optgroup label="Seu PG">
                                                <?php
                                                $consultarPG = $this->FConsultas_model->mostrarPG($dados_lider['id_lider'], 2);

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

                                <div class="col-lg-12">
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">É Cristão?</label>
                                            <select name="opcao[]" class="form-control" required>
                                                <option value="0" selected>Escolha uma opção</option>
                                                <option value="1">Sim</option>
                                                <option value="2">Não</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Responsável da Criança:</label>
                                            <select name="responsavel_crianca[]" id="isRespon_1" onchange="mostrarCamposPais(1);" class="form-control" required>
                                                <option value="<?= $dados_lider['nome_lider'] ?>" selected><?= $dados_lider['nome_lider'] ?></option>
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

                                <div id="conteudo_cri"></div>

                                <div class="col-lg-12">
                                    <center><br><br>
                                        <input type="button" class="btn btn-info" value="Adicionar" id="add_cri">
                                        <input type="button" class="btn btn-danger" id="remove_cri" value="Remover">
                                    </center>
                                </div>

                                <input type="hidden" value="1" id="total_cri" name="total[]"><br>
                                <input type="hidden" value="1" id="controller_cri"><br>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                                <button type="submit" id="button" class="btn btn-info pull-left">Salvar</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>

            <!-- Footer -->
            <?php
            $this->load->view('partes/footer');
            ?>
        </div>

        <script>
            $(document).ready(function() {
                var i = 1;

                $("#add_cri").click(function() {
                    i = i + 1;
                    var conteudo = "#conteudo_cri" + i;
                    var conteudo2 = "conteudo_cri" + i;
                    var linhaResponsaveis = "linhaResponsaveis" + i;

                    document.getElementById('controller_cri').value = i;

                    var iInicial = document.getElementById('controller_cri').value;

                    if (iInicial == 1) {
                        document.getElementById('remove_cri').style.display = 'none';
                    } else {
                        document.getElementById('remove_cri').style.display = 'inline';
                    }

                    $("#conteudo_cri").append('<div id="' + conteudo2 + '"></div>');

                    $(conteudo).append('<br><hr><div class="col-lg-12"><div class="form-group"><label for="nomeCrianca">Nome da Criança</label><input class="form-control" id="nomeCrianca" type="text" name="nome[]" placeholder="Nome da Criança" required></div></div><div class="col-lg-12"><div class="form-group"><label for="dataDeNascimento">Data de Nascimento (DD/MM/YYYY)</label><input class="form-control" type="text" id="dataDeNascimento" name="nascimento[]" placeholder="Data de Nascimento (DD/MM/YYYY)" maxlength="10" minlength="10"></div></div><div class="col-lg-12"><div class="col-lg-6"><div class="form-group"><label for="exampleInputEmail1">É Cristão?</label><select name="opcao[]" class="form-control" required><option value="0" selected>Escolha uma opção</option><option value="1">Sim</option><option value="2">Não</option></select></div></div><div class="col-lg-6"><div class="form-group"><label for="exampleInputEmail1">Responsável da Criança:</label><select name="responsavel_crianca[]" id="isRespon_' + i + '" onchange="mostrarCamposPais(' + i + ');" class="form-control" required><option value="<?= $dados_lider['nome_lider'] ?>" selected><?= $dados_lider['nome_lider'] ?></option><option value="outro">Outro</option></select></div></div></div><div class="col-lg-12" id="' + linhaResponsaveis + '" style="display: none;"><div class="col-lg-4"><div class="form-group"><label for="exampleInputEmail1">Nome do Responsável (Obrigatório):</label><input class="form-control" type="text" minlength="5" name="nome_responsavel[]" placeholder="Nome do Responsável"></div></div><div class="col-lg-4"><div class="form-group"><label for="exampleInputEmail1">E-mail do Responsável:</label><input class="form-control" type="text" name="email_responsavel[]" placeholder="E-mail do Responsável"></div></div><div class="col-lg-4"><div class="form-group"><label for="exampleInputEmail1">Telefone do Responsável:</label><input class="form-control" type="text" name="telefone_responsavel[]" minlength="11" placeholder="Telefone do Responsável"></div></div></div><div class="col-lg-12"><label for="observacao">Observação</label><textarea id="observacao" name="obs[]" class="form-control"></textarea></div><hr><br><input type="hidden" value="1" id="total_cri" name="total[]">');
                    return false;
                });

                $("#remove_cri").click(function() {
                    var iInicial = document.getElementById('controller_cri').value;

                    var novoI = document.getElementById('controller_cri').value = i;

                    var Novoconteudo = "#conteudo_cri" + novoI;

                    $(Novoconteudo).empty('');

                    i = i - 1;
                    document.getElementById('controller_cri').value = i;
                    var iInicial = document.getElementById('controller_cri').value;

                    if (iInicial == 1) {
                        document.getElementById('remove_cri').style.display = 'none';
                    } else {
                        document.getElementById('remove_cri').style.display = 'inline';
                    }

                    return false;
                });
            });

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