<?php

$voltar_index = $id_sregional == '' ? "../../.." : "../../../..";
$voltar = $id_sregional == '' ? "../../" : "../../../";
$array = array('voltar' => $voltar);

if (!isset($_SESSION['usuario'])) {
    header("location: $voltar_index/index");
} else {

    $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
    $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

    $dados_direcao = $this->FConsultas_model->getInfoDirecaoId($id_usuario);

    if ($dados_direcao['row'] == 0) {
        $data = [];
        $this->FConsultas_model->mensagem('danger', 'Erro!', ['O sistema dectou algum erro em seu cadastro! Entre em contato com o suporte!']);
        $funcao = $this->FConsultas_model->red("$voltar_index/index", 2000, $data);
        echo $funcao;
    } else {

        $url_1 = $this->uri->segment(1);
        $url = $this->FConsultas_model->get_url();

        $dados = $dados['dados'];
?>
        <!DOCTYPE html>
        <html>
        <!-- Head -->
        <?php
        $this->load->view('partes/head');
        ?>

        <script>
            $(document).ready(function() {
                var opc = '<?= $dados['pais']; ?>';

                if (opc == "br") {
                    document.getElementById('linha_selecionar').style.display = "inline";
                    document.getElementById('linha_digitar').style.display = "none";
                    document.getElementById('linha_digitar_nome_pais').style.display = "none";
                } else {
                    document.getElementById('linha_selecionar').style.display = "none";
                    document.getElementById('linha_digitar').style.display = "inline";
                    document.getElementById('linha_digitar_nome_pais').style.display = "inline";
                }
            });

            function validar_edicao() {

                var dados = document.form_editar_foto.opc.value;

                if (dados == "Sim" || dados == "Não") {} else {
                    alert("Você não escolheu a opção");
                    return false;
                }
            }

            function aparecer_select() {
                var opc = document.getElementById('pais').value;

                if (opc == "br") {
                    document.getElementById('linha_selecionar').style.display = "inline";
                    document.getElementById('linha_digitar').style.display = "none";
                    document.getElementById('linha_digitar_nome_pais').style.display = "none";
                    document.getElementById('nome_pais').value = "br";
                } else {
                    document.getElementById('linha_selecionar').style.display = "none";
                    document.getElementById('linha_digitar').style.display = "inline";
                    document.getElementById('linha_digitar_nome_pais').style.display = "inline";
                    document.getElementById('nome_pais').value = "";

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
                $this->load->view('sistema/direcao/partes/menu_lateral', $array);
                ?>

                <!-- Content Wrapper. Contains page content -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <h1>
                            <?= $dados['nome_supervisorE']; ?>
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

                                $check_desativado = "";

                                if ($dados['ativo'] == 0) {
                                    $check_desativado = "disabled";
                                ?>

                                    <br>
                                    <div class="callout callout-danger">
                                        <h4>
                                            Esse supervisor regional foi desativado!
                                        </h4>
                                    </div>
                                    <center>
                                        <button type="button" class="btn btn-success" data-toggle="modal" style="margin-bottom: 15px;" data-target="#sregional_desativados">Ativar</button>
                                    </center>
                                    <div class="modal fade" id="sregional_desativados">
                                        <div class="modal-dialog modal-warning">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title">Ativar | Desativar | S. Regional</h4>
                                                </div>

                                                <div class="box-body">
                                                    <div class="col-lg-12">
                                                        <div class="col-lg-5">
                                                            <div class="form-group">
                                                                <label for="opc">S. Regional:</label>
                                                                <input type="text" class="form-control" value="<?= $dados['nome_supervisorE']; ?>" disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <form action="../exclusao/ativar" method="POST">
                                                                    <input type="hidden" name="opc" value="<?= $dados['id_supervisorEs']; ?>">
                                                                    <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">

                                                                    <input type="hidden" name="url" value="<?= $url; ?>">
                                                                    <input type="hidden" name="nivel" value="<?= $url_1; ?>">

                                                                    <center>
                                                                        <label for="opc">Opção 1:</label><br>
                                                                        <input type="submit" class="btn btn-success" value="Ativar">
                                                                    </center>
                                                                </form>
                                                            </div>
                                                        </div>

                                                        <div class="col-lg-4">
                                                            <div class="form-group">
                                                                <form action="../../sregional/exclusao/permanente" method="POST">
                                                                    <input type="hidden" name="opc" value="<?= $dados['id_supervisorEs']; ?>">
                                                                    <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">

                                                                    <input type="hidden" name="url" value="">
                                                                    <input type="hidden" name="nivel" value="<?= $url_1; ?>">

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

                                                $foto_original = $dados['foto'];
                                                //$foto_original = 'fotoU/pais/WhatsApp_Image_2022-12-05_at_08_30_33.jpeg';

                                                $foto = base_url('import/sistema/' . $foto_original);
                                                ?>

                                                <input type="hidden" name="id" aria-describedby="emailHelp" value="<?= $dados['id_supervisorEs']; ?>">

                                                <input type="hidden" name="url" value="<?= $url; ?>">
                                                <input type="hidden" name="nivel" value="<?= $url_1; ?>">

                                                <script type="text/javascript">
                                                    $(document).ready(function() {

                                                        $.getJSON('<?php echo base_url('import/sistema/dist/js/estados_cidades.json'); ?>', function(data) {
                                                            var items = [];
                                                            var options = '<optgroup label="Seu estado escolhido"><option value="<?php echo $dados['estado'] ?>"><?php echo $dados['estado'] ?></option></optgroup>';

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
                                                        <input type="text" class="form-control" id="exampleInputEmail1" name="nome" minlength="5" value="<?= $dados['nome_supervisorE']; ?>" placeholder="Nome" <?= $check_desativado; ?> required>
                                                        <input type="hidden" name="nome_antigo" value="<?= $dados['nome_supervisorE']; ?>">
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">CPF</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" name="cpf" value="<?= $dados['cpf']; ?>" placeholder="CPF" maxlength="14" minlength="11" <?= $check_desativado; ?> required>
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">E-mail</label>
                                                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="<?= $dados['email']; ?>" placeholder="E-mail" <?= $check_desativado; ?> required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Telefone</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" name="telefone" value="<?= $dados['telefone_whatsapp']; ?>" placeholder="Telefone" minlength="11" <?= $check_desativado; ?> required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Data de Nascimento</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" name="nascimento" value="<?= $dados['nascimento']; ?>" maxlength="10" minlength="10" placeholder="Data de Nascimento" <?= $check_desativado; ?> required>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputPassword1">Pais</label>
                                                            <select name="pais" id="pais" class="form-control" onchange="aparecer_select(this);" <?= $check_desativado; ?>>
                                                                <?php
                                                                if ($dados['pais'] == 'br') {
                                                                ?>
                                                                    <option value="br" selected>Brasil</option>
                                                                    <option value="outro">Outro</option>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <option value="br">Brasil</option>
                                                                    <option value="outro" selected>Outro</option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>

                                                            <div class="form-group" id="linha_digitar_nome_pais">
                                                                <label for="exampleInputPassword1">Digite o nome do Pais</label>
                                                                <input type="text" class="form-control" id="nome_pais" name="nome_pais" value="<?= $dados['pais']; ?>" minlength="2" placeholder="Pais" <?= $check_desativado; ?>>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-6">
                                                        <div class="form-group" id="linha_selecionar">
                                                            <label for="exampleInputPassword1">Estado</label>
                                                            <select id="estados" name="estados" class="form-control" <?= $check_desativado; ?>>
                                                                <option value=""></option>
                                                            </select>
                                                        </div>

                                                        <div class="form-group" id="linha_digitar">
                                                            <label for="exampleInputPassword1">Estado</label>
                                                            <input type="text" class="form-control" id="estados2" name="estados2" value="<?= $dados['estado']; ?>" minlength="2" placeholder="Estado" <?= $check_desativado; ?>>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <button type="submit" class="btn btn-info pull-left" style="margin-right: 10px;" <?= $check_desativado; ?>>Salvar</button>
                                                    <center>
                                                        <button type="button" style="margin-right: 10px;" class="btn btn-danger pull-left" data-toggle="modal" data-target="#desativar_sregional" <?= $check_desativado; ?>>Desativar</button>

                                                        <div class="input-group-btn">
                                                            <button type="button" class="btn btn-success pull-left dropdown-toggle" data-toggle="dropdown">Mudar Função
                                                                <span class="fa fa-caret-down"></span></button>
                                                            <ul class="dropdown-menu">
                                                                <li><button type="button" class="btn btn-default" data-toggle="modal" data-target="#tornar_slocal" <?= $check_desativado; ?>>Tornar Supervisor Local</button></li>
                                                                <li><button type="button" class="btn btn-default" data-toggle="modal" data-target="#tornar_coordenador" <?= $check_desativado; ?>>Tornar Coordenador</button></li>
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

                    <div class="modal fade" id="tornar_slocal">
                        <div class="modal-dialog modal-default">
                            <div class="modal-content">
                                <form action="../../../../alerta/solicitar/tornar_de_funcao" method="POST">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Solicitar Mudança | S. Regional para S. Local</h4>
                                    </div>
                                    <div class="box-body">
                                        <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                        <input type="hidden" name="id_change" value="<?= $dados['id_supervisorEs']; ?>">
                                        <input type="hidden" name="funcao_atiga" value="sregional">
                                        <input type="hidden" name="funcao_nova" value="slocal">
                                        <input type="hidden" name="url" value="<?= $url; ?>">
                                        <input type="hidden" name="nivel" value="<?= $url_1; ?>">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <center>
                                                    <label for="id_troca_1">Deseja tornar <?= $dados['nome_supervisorE']; ?> supervisor local?</label>
                                                    <br><i>* observação: para essa nova função, o supervisor terá que ter 3 coordenações.</i>
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

                    <div class="modal fade" id="tornar_coordenador">
                        <div class="modal-dialog modal-default">
                            <div class="modal-content">
                                <form action="../../../../alerta/solicitar/tornar_de_funcao" method="POST">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Solicitar Mudança | S. Regional para Coordenador</h4>
                                    </div>
                                    <div class="box-body">
                                        <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                        <input type="hidden" name="id_change" value="<?= $dados['id_supervisorEs']; ?>">
                                        <input type="hidden" name="funcao_atiga" value="sregional">
                                        <input type="hidden" name="funcao_nova" value="coordenador">
                                        <input type="hidden" name="url" value="<?= $url; ?>">
                                        <input type="hidden" name="nivel" value="<?= $url_1; ?>">

                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <center>
                                                    <label for="id_troca_1">Deseja tornar <?= $dados['nome_supervisorE']; ?> coordenador?</label>
                                                    <br><i>* observação: para essa nova função, o supervisor regional terá que ter 3 líderes.</i>
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
                                <form action="../../../../alerta/solicitar/tornar_de_funcao" method="POST">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Solicitar Mudança | S. Regional para Líder</h4>
                                    </div>
                                    <div class="box-body">
                                        <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                        <input type="hidden" name="id_change" value="<?= $dados['id_supervisorEs']; ?>">
                                        <input type="hidden" name="funcao_atiga" value="sregional">
                                        <input type="hidden" name="funcao_nova" value="lider">
                                        <input type="hidden" name="url" value="<?= $url; ?>">
                                        <input type="hidden" name="nivel" value="<?= $url_1; ?>">


                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <center>
                                                    <label for="id_troca_1">Deseja tornar <?= $dados['nome_supervisorE']; ?> líder?</label>
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

                    <div class="modal fade" id="desativar_sregional">
                        <div class="modal-dialog modal-danger">
                            <div class="modal-content">
                                <form action="../../sregional/desativar" method="post">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Desativar | S Regional</h4>
                                    </div>
                                    <div class="box-body">
                                        <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                        <input type="hidden" name="id_sregional" value="<?= $dados['id_supervisorEs']; ?>">
                                        <input type="hidden" name="nivel" value="<?= $url_1; ?>">
                                        <input type="hidden" name="url" value="<?= $url; ?>">

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
<?php }
} ?>