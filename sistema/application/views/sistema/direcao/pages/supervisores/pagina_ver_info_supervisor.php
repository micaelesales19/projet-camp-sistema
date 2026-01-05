<?php
if (!isset($_SESSION['usuario'])) {
    header("location: https://sistemas.campbrasil.com/sistema/index");
} else {

    $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
    $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

    $voltar = "../../../";
    $array = array('voltar' => $voltar);
    $url_redirecionamento = current_url() . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '');
?>
    <!DOCTYPE html>
    <html>
    <!-- Head -->
    <?php
    $this->load->view('partes/head');
    ?>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            //document.getElementById('btn_solicitar_1').disabled = true;
            //document.getElementById('btn_solicitar_2').disabled = true;

            // modal - tornar supervisor
            const pesquisarInput = document.getElementById('pesquisaCoordenador');
            if (pesquisarInput) {
                pesquisarInput.addEventListener('input', function() {
                    const filtro = this.value.toLowerCase();
                    document.querySelectorAll('#listaCoordenadores .form-check').forEach(div => {
                        const texto = div.innerText.toLowerCase();
                        div.style.display = texto.includes(filtro) ? '' : 'none';
                    });
                });
            }

            const form = document.querySelector('form#form_tornar_coordenador');
            if (!form) return; // evita erro se o formulário não existir

            // Pega todos os checkboxes
            const checkboxes = document.querySelectorAll('.checkbox-coordenador');
            const inputHidden = document.getElementById('idsSupervisores');

            // Função para atualizar o campo hidden
            function atualizarIdsSelecionados() {
                checkboxes.forEach(cb => {
                    if (cb !== event.target) cb.checked = false;
                });

                const selecionado = Array.from(checkboxes)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value)
                    .join(',');
                inputHidden.value = selecionado;

                console.log('IDs atualizados:', inputHidden.value);
            }

            // Adiciona o evento de mudança (check/uncheck) em cada checkbox
            checkboxes.forEach(cb => {
                cb.addEventListener('change', atualizarIdsSelecionados);
            });

            // Validação antes do envio
            form.addEventListener('submit', function(e) {
                if (!inputHidden.value) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Você precisa selecionar pelo menos 1 supervisores.',
                        icon: 'warning',
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#198754', // cor do botão principal (verde bootstrap)
                        background: '#fefefe', // cor de fundo
                        color: '#333', // cor do texto
                        iconColor: '#f39c12', // cor do ícone
                    });
                }
            });

            // modal - tornar líder
            const pesquisarInput_2 = document.getElementById('pesquisaSupervisor_2');
            if (pesquisarInput_2) {
                pesquisarInput_2.addEventListener('input', function() {
                    const filtro = this.value.toLowerCase();
                    document.querySelectorAll('#listaSupervisores_2 .form-check').forEach(div => {
                        const texto = div.innerText.toLowerCase();
                        div.style.display = texto.includes(filtro) ? '' : 'none';
                    });
                });
            }

            const pesquisarInput_4 = document.getElementById('pesquisaCoordenador_2');
            if (pesquisarInput_4) {
                pesquisarInput_4.addEventListener('input', function() {
                    const filtro = this.value.toLowerCase();
                    document.querySelectorAll('#listaCoordenadores_2 .form-check').forEach(div => {
                        const texto = div.innerText.toLowerCase();
                        div.style.display = texto.includes(filtro) ? '' : 'none';
                    });
                });
            }

            const form_2 = document.querySelector('form#form_tornar_lider');
            if (!form_2) return; // evita erro se o formulário não existir

            // Pega todos os checkboxes
            const checkboxes_2 = document.querySelectorAll('.checkbox-supervisor-2');
            const checkboxes_4 = document.querySelectorAll('.checkbox-coordenador-2');
            const inputHidden_2 = document.getElementById('idsSupervisorTRLD');
            const inputHidden_4 = document.getElementById('idsCoordenadorTRLD');

            // Função para atualizar o campo hidden
            function atualizarIdsSelecionados_2() {
                // deixa apenas o clicado marcado
                checkboxes_2.forEach(cb => {
                    if (cb !== event.target) cb.checked = false;
                });

                const selecionados = Array.from(checkboxes_2)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                inputHidden_2.value = selecionados.join(',');
                console.log('ID atualizado:', inputHidden_2.value);
            }

            function atualizarIdsSelecionados_4() {
                // deixa apenas o clicado marcado
                checkboxes_4.forEach(cb => {
                    if (cb !== event.target) cb.checked = false;
                });

                const selecionados_2 = Array.from(checkboxes_4)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value);

                inputHidden_4.value = selecionados_2.join(',');
                console.log('ID atualizado:', inputHidden_4.value);
            }

            // Adiciona o evento de mudança (check/uncheck) em cada checkbox
            checkboxes_2.forEach(cb => {
                cb.addEventListener('change', atualizarIdsSelecionados_2);
            });

            checkboxes_4.forEach(cb => {
                cb.addEventListener('change', atualizarIdsSelecionados_4);
            });

            // Validação: precisa ter 1 selecionado
            form_2.addEventListener('submit', function(e) {
                if (!inputHidden_2.value || !inputHidden_4.value) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Você precisa selecionar 1 coordenador/supervisor.',
                        icon: 'warning',
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#198754', // cor do botão principal (verde bootstrap)
                        background: '#fefefe', // cor de fundo
                        color: '#333', // cor do texto
                        iconColor: '#f39c12', // cor do ícone
                    });
                }
            });

            // modal - excluir supervisor permanente
            const pesquisarInput_3 = document.getElementById('pesquisaSupervisor');
            if (pesquisarInput_3) {
                pesquisarInput_3.addEventListener('input', function() {
                    const filtro = this.value.toLowerCase();
                    document.querySelectorAll('#listaSupervisores_3 .form-check').forEach(div => {
                        const texto = div.innerText.toLowerCase();
                        div.style.display = texto.includes(filtro) ? '' : 'none';
                    });
                });
            }

            const form_3 = document.querySelector('form#form_exclusao_supervisor_permanentemente');
            if (!form_3) return; // evita erro se o formulário não existir

            const checkboxes_3 = document.querySelectorAll('.checkbox-supervisor-3');
            const inputHidden_3 = document.getElementById('idSupervisorNovoTroca');

            function atualizarSelecaoUnica_3(event) {
                checkboxes_3.forEach(cb => {
                    if (cb !== event.target) cb.checked = false;
                });
                const selecionado = Array.from(checkboxes_3)
                    .filter(cb => cb.checked)
                    .map(cb => cb.value)
                    .join(',');
                inputHidden_3.value = selecionado;
                console.log('Selecionado:', inputHidden_3.value);
            }

            checkboxes_3.forEach(cb => cb.addEventListener('change', atualizarSelecaoUnica_3));

            form_3.addEventListener('submit', function(e) {
                e.preventDefault();

                if (!inputHidden_3.value) {
                    Swal.fire({
                        title: 'Atenção!',
                        text: 'Você precisa selecionar 1 coordenador.',
                        icon: 'warning',
                        confirmButtonText: 'Ok',
                        confirmButtonColor: '#198754',
                    });
                } else {
                    Swal.fire({
                        title: "Cuidado!",
                        text: "Essa alteração é irrevessível.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Continuar",
                        cancelButtonText: "Cancelar",
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form_3.submit();
                        }
                    });
                }
            });

            aparecer_select();
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
                document.getElementById("opcao_escolhida").innerHTML = "Digite o nome do Supervisor";
                document.getElementById('btn_solicitar_1').disabled = false;
            }
        }

        function aparecer_select() {
            var opc = document.getElementById('pais').value;
            if (opc == "br") {
                //document.getElementById('estados2').value = '';
                //document.getElementById('cidades2').value = '';

                document.getElementById('consultar_endereco').style.display = "inline";
                document.getElementById('escrever_endereco').style.display = "none";

                document.getElementById('precisa_cpf').style.display = "inline";

                document.getElementById('cpf').setAttribute('required', 'true');
            } else {
                //document.getElementById('estados').value = '';
                //document.getElementById('cidades').value = '';
                document.getElementById('escrever_endereco').style.display = "inline";
                document.getElementById('consultar_endereco').style.display = "none";

                document.getElementById('precisa_cpf').style.display = "none";
                document.getElementById('cpf').removeAttribute('required');
            }
        }

        function toggleSenha() {
            const campo = document.getElementById("senha");
            campo.type = campo.type === "password" ? "text" : "password";
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

        #precisa_cpf {
            display: none;
        }

        #precisa_cpf_colider {
            display: none;
        }

        #consultar_endereco {
            display: none;
        }

        #escrever_endereco {
            display: none;
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
                        Líderes
                        <small>Painel de Controle</small>
                    </h1>

                    <ol class="breadcrumb">
                        <li><a href="../home"><i class="fa fa-home"></i> Home</a></li>
                        <li><a href="../../supervisores"><i class="fa fa-users"></i> Supervisores</a></li>
                        <li><a href="../../supervisor/<?= $id_supervisor; ?>"><i class="fa fa-users"></i> Coordenadores</a></li>
                        <li class="active">Informações</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="box box-info">
                            <?php

                            $dados_supervisor = $dados_supervisor['dados'];
                            $check_desativado = "";

                            if ($dados_supervisor['ativo'] == 0) {
                                $check_desativado = "disabled";
                            ?>

                                <br>
                                <div class="callout callout-danger">
                                    <h4>
                                        Esse supervisor foi desativado!
                                    </h4>
                                </div>
                                <center>
                                    <button type="button" class="btn btn-success" data-toggle="modal" style="margin-bottom: 15px;" data-target="#supervisor_desativados">Ativar</button>
                                </center>
                                <div class="modal fade" id="supervisor_desativados">
                                    <div class="modal-dialog modal-warning">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title">Ativar | Desativar | Supervisor</h4>
                                            </div>

                                            <div class="box-body">
                                                <div class="col-lg-12">
                                                    <div class="col-lg-5">
                                                        <div class="form-group">
                                                            <label for="opc">Supervisor:</label>
                                                            <input type="text" class="form-control" value="<?= $dados_supervisor['nome_supervisorR']; ?>" disabled>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-3">
                                                        <div class="form-group">
                                                            <form action="../../supervisor/reativar" method="POST">
                                                                <input type="hidden" name="id_supervisor" value="<?= $dados_supervisor['id_supervisorR']; ?>">
                                                                <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                                <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                                                                <center>
                                                                    <label for="opc">Opção 1:</label><br>
                                                                    <input type="submit" class="btn btn-success" value="Ativar">
                                                                </center>
                                                            </form>
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4">
                                                        <div class="form-group">
                                                            <center>
                                                                <label for="opc">Opção 2:</label><br>
                                                                <button type="button" class="btn btn-danger pull-left" data-toggle="modal" data-target="#excluir_supervisor_permantemente">Excluir Permanentemente</button>
                                                            </center>
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
                            <form action="../edicao/salvar" role="form" method="POST" enctype="multipart/form-data" name="form_editar_foto">
                                <div class="col-lg-12">
                                    <div class="box-body chat" id="chat-box">
                                        <div class="box-footer">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Dados Pessoais | Supervisor</h3>
                                            </div> <br>
                                            <?php

                                            $foto_original = $dados_supervisor['foto'];
                                            $foto = base_url('import/sistema/' . $foto_original);

                                            $email = $dados_supervisor['email'];
                                            $cpf = $dados_supervisor['cpf'];
                                            $info_usuario = $this->Lideres->infos([$email, $cpf], 'info_usuario_and_email_cpf', '', '');
                                            $dados_usuario = $info_usuario['dados'];
                                            ?>

                                            <input type="hidden" name="id_usuario" value="<?= $dados_usuario['id_usuario']; ?>">
                                            <input type="hidden" name="id" aria-describedby="emailHelp" value="<?= $dados_supervisor['id_supervisorR']; ?>">
                                            <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

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

                                            <script type="text/javascript">
                                                $(document).ready(function() {

                                                    $.getJSON('<?php echo base_url('import/sistema/dist/js/estados_cidades.json'); ?>', function(data) {
                                                        var items = [];
                                                        var options = '<optgroup label="Seu estado escolhido"><option value="<?php echo $dados_supervisor['estado'] ?>"><?php echo $dados_supervisor['estado'] ?></option></optgroup>';

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
                                                                    options_cidades += '<optgroup label="Sua cidade escolhida"><option value="<?php echo $dados_supervisor['cidade'] ?>"><?php echo $dados_supervisor['cidade'] ?></option></optgroup>';
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

                                            <div class="col-lg-4">
                                                <div class="form-group has-feedback">
                                                    <label for="exampleInputPassword1">País</label>
                                                    <select id="pais" name="pais" class="form-control" onchange="aparecer_select(this)" <?= $check_desativado; ?>>
                                                        <?php
                                                        if ($dados_supervisor['pais'] == '' || $dados_supervisor['pais'] == 'br' || $dados_supervisor['pais'] == 'Brasil') {
                                                        ?>
                                                            <option value="">País</option>
                                                            <option value="br" selected>Brasil</option>
                                                            <option value="Moçambique">Moçambique</option>
                                                            <option value="outro">Outros</option>
                                                        <?php } else if ($dados_supervisor['pais'] == 'Moçambique') { ?>
                                                            <option value="">País</option>
                                                            <option value="br">Brasil</option>
                                                            <option value="Moçambique" selected>Moçambique</option>
                                                            <option value="outro">Outros</option>
                                                        <?php } else { ?>
                                                            <option value="">País</option>
                                                            <option value="br">Brasil</option>
                                                            <option value="Moçambique">Moçambique</option>
                                                            <option value="outro" selected>Outros</option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div id="consultar_endereco">
                                                <div class="form-group col-lg-4" id="form-group">
                                                    <label for="exampleInputPassword1">Estado</label>
                                                    <select id="estados" name="estados" class="form-control" <?= $check_desativado; ?>>
                                                        <option value=""></option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-lg-4" id="form-group">
                                                    <label for="exampleInputPassword1">Cidade</label>
                                                    <select id="cidades" name="cidades" class="form-control" <?= $check_desativado; ?>></select>
                                                </div>
                                            </div>

                                            <div id="escrever_endereco">
                                                <div class="form-group col-lg-2">
                                                    <label for="exampleInputPassword1">Pais</label>
                                                    <input type="text" id="pais2" class="form-control" placeholder="Estado/Província/Região" name="nome_pais" value="<?= $dados_supervisor['pais']; ?>" <?= $check_desativado; ?>>
                                                </div>
                                                <div class="form-group col-lg-2">
                                                    <label for="exampleInputPassword1">Estado/Província/Região</label>
                                                    <input type="text" id="estados2" class="form-control" placeholder="Estado/Província/Região" name="estados2" value="<?= $dados_supervisor['estado']; ?>" <?= $check_desativado; ?>>
                                                </div>

                                                <div class="form-group col-lg-2">
                                                    <label for="exampleInputPassword1">Cidade/Município/Distrito</label>
                                                    <input type="text" id="cidades2" class="form-control" placeholder="Cidade/Município/Distrito" name="cidades2" value="<?= $dados_supervisor['cidade']; ?>" <?= $check_desativado; ?>>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nome</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="nome" minlength="5" value="<?= $dados_supervisor['nome_supervisorR']; ?>" placeholder="Nome" <?= $check_desativado; ?> required>
                                                    <input type="hidden" name="nome_antigo" value="<?= $dados_supervisor['nome_supervisorR']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-6" id="precisa_cpf">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">CPF</label>
                                                    <input type="text" class="form-control" id="cpf" name="cpf" value="<?= $dados_supervisor['cpf']; ?>" placeholder="CPF" maxlength="14" minlength="11" <?= $check_desativado; ?> required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">E-mail</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="<?= $dados_supervisor['email']; ?>" placeholder="E-mail" <?= $check_desativado; ?> required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Telefone</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="telefone" value="<?= $dados_supervisor['telefone_whatsapp']; ?>" placeholder="Telefone" minlength="11" <?= $check_desativado; ?> required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Data de Nascimento</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="nascimento" value="<?= $dados_supervisor['nascimento']; ?>" maxlength="10" minlength="10" placeholder="Data de Nascimento" <?= $check_desativado; ?> required>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Senha</label>
                                                    <input type="password" class="form-control" id="senha" name="senha" value="<?= $dados_usuario['senha']; ?>" placeholder="Senha" <?= $check_desativado; ?> required>
                                                    <span onclick="toggleSenha()" style="position: absolute; right: 20px; top: 55%; transform: translateY(-50%); cursor: pointer;">👁️</span>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">

                                                <button type="submit" class="btn btn-danger pull-left" style="margin-right: 10px;" <?= $check_desativado; ?>>Salvar</button>

                                                <center>
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-success pull-left dropdown-toggle" data-toggle="dropdown">Mudar Função
                                                            <span class="fa fa-caret-down"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li style="margin-bottom: 5px;">
                                                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#tornar_coordenador" <?= $check_desativado; ?>>Tornar Coordenador</button>
                                                            </li>
                                                            <li>
                                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#tornar_lider" <?= $check_desativado; ?>>Tornar Líder</button>
                                                            </li>
                                                        </ul>
                                                    </div>

                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-danger pull-left dropdown-toggle" data-toggle="dropdown">Desativar
                                                            <span class="fa fa-caret-down"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <button type="button" class="btn btn-warning pull-left" data-toggle="modal" data-target="#desativar_supervisor" <?= $check_desativado; ?>>Desativar</button>
                                                            </li><br><br>
                                                            <li>
                                                                <button type="button" class="btn btn-danger pull-left" data-toggle="modal" data-target="#excluir_supervisor_permantemente" <?= $check_desativado; ?>>Excluir Permanentemente</button>
                                                            </li>
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

                <div class="modal fade" id="tornar_coordenador">
                    <div class="modal-dialog modal-default">
                        <div class="modal-content">
                            <form action="../../../../tornar/tornar_supervisor_to_coordenador" method="POST" id="form_tornar_coordenador">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Solicitar Mudança Supervisor - Coordenador</h4>
                                </div>
                                <div class="box-body">
                                    <input type="hidden" name="funcao_atiga" value="supervisor">
                                    <input type="hidden" name="funcao_nova" value="coordenador">
                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="id_change" value="<?= $dados_supervisor['id_supervisorR']; ?>">
                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                                    <input type="hidden" name="id_troca" id="idsSupervisores">

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <center>
                                                <label for="id_troca_1">Deseja tornar <?= $dados_supervisor['nome_supervisorR']; ?> coordenador?</label>
                                                <br><i>* observação: para essa nova função, você precisa adicionar um outro supervisor.</i>
                                            </center>
                                            <!-- Caixa de pesquisa -->
                                            <input type="text" id="pesquisaCoordenador" class="form-control mb-3" placeholder="Pesquisar Supervisor..."><br>

                                            <!-- Lista de coordenadores -->
                                            <div id="listaCoordenadores" style="max-height: 300px; overflow-y: auto;">
                                                <?php
                                                // exemplo: buscando do banco
                                                $supervisores = $this->db->query("SELECT id_supervisorR, nome_supervisorR FROM supervisor_local ORDER BY nome_supervisorR ASC")->result_array();

                                                foreach ($supervisores as $c) {
                                                    if ($c['id_supervisorR'] == $id_supervisor) {
                                                    } else {
                                                ?>
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox-coordenador" type="checkbox" value="<?= $c['id_supervisorR']; ?>" id="coord<?= $c['id_supervisorR']; ?>">
                                                            <label class="form-check-label" for="coord<?= $c['id_supervisorR']; ?>">
                                                                <?= htmlspecialchars($c['nome_supervisorR']); ?>
                                                            </label>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
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
                            <form action="../../../../tornar/tornar_supervisor_to_lider" method="POST" id="form_tornar_lider">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Solicitar Mudança Supervisor - Líder</h4>
                                </div>
                                <div class="box-body">
                                    <input type="hidden" name="funcao_atiga" value="supervisor">
                                    <input type="hidden" name="funcao_nova" value="lider">
                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="id_change" value="<?= $dados_supervisor['id_supervisorR']; ?>">
                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                                    <input type="hidden" name="id_troca_1" id="idsSupervisorTRLD">
                                    <input type="hidden" name="id_troca_2" id="idsCoordenadorTRLD">

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <center>
                                                <label for="id_troca_1">Deseja tornar <?= $dados_supervisor['nome_supervisorR']; ?> líder?</label>
                                                <br><i>* observação: para essa nova função, você precisa selecionar um supervisor para os líderes desse supervisor.</i>
                                            </center>


                                            <div class="nav-tabs-custom">
                                                <ul class="nav nav-tabs">
                                                    <li class="active"><a href="#selecionar_supervisor" data-toggle="tab">Supervisor</a></li>
                                                    <li><a href="#selecionar_coordenador" data-toggle="tab">Coordenador</a></li>
                                                </ul>

                                                <div class="tab-content">
                                                    <div class="tab-pane active" id="selecionar_supervisor">
                                                        <!-- Caixa de pesquisa -->
                                                        <input type="text" id="pesquisaSupervisor_2" class="form-control mb-3" placeholder="Pesquisar Supervisor...">

                                                        <!-- Lista de coordenadores -->
                                                        <div id="listaSupervisores_2" style="max-height: 300px; overflow-y: auto;">
                                                            <?php
                                                            // exemplo: buscando do banco
                                                            $coordenadores = $this->db->query("SELECT id_supervisorR, nome_supervisorR FROM supervisor_local ORDER BY nome_supervisorR ASC")->result_array();

                                                            foreach ($coordenadores as $c) {
                                                                if ($c['id_supervisorR'] == $id_supervisor) {
                                                                } else {
                                                            ?>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input checkbox-supervisor-2" type="checkbox" value="<?= $c['id_supervisorR']; ?>" id="coord<?= $c['id_supervisorR']; ?>">
                                                                        <label class="form-check-label" for="coord<?= $c['id_supervisorR']; ?>">
                                                                            <?= htmlspecialchars($c['nome_supervisorR']); ?>
                                                                        </label>
                                                                    </div>
                                                            <?php }
                                                            } ?>
                                                        </div>
                                                    </div>

                                                    <div class="tab-pane" id="selecionar_coordenador">
                                                        <!-- Caixa de pesquisa -->
                                                        <input type="text" id="pesquisaCoordenador_2" class="form-control mb-3" placeholder="Pesquisar Coordenador...">

                                                        <!-- Lista de coordenadores -->
                                                        <div id="listaCoordenadores_2" style="max-height: 300px; overflow-y: auto;">
                                                            <?php
                                                            $id_supervisor = $dados_supervisor['id_supervisorR'];

                                                            // exemplo: buscando do banco
                                                            $coordenadores = $this->db->query("SELECT id_coordenador, nome_coordenador FROM coordenador ORDER BY nome_coordenador ASC")->result_array();

                                                            foreach ($coordenadores as $c) {
                                                            ?>
                                                                <div class="form-check">
                                                                    <input class="form-check-input checkbox-coordenador-2" type="checkbox" value="<?= $c['id_coordenador']; ?>" id="coord<?= $c['id_coordenador']; ?>">
                                                                    <label class="form-check-label" for="coord<?= $c['id_coordenador']; ?>">
                                                                        <?= htmlspecialchars($c['nome_coordenador']); ?>
                                                                    </label>
                                                                </div>
                                                            <?php
                                                            } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Não</button>
                                    <input type="submit" id="btn_solicitar_2" class="btn btn-default pull-right" value="Solicitar">
                                </div>
                            </form>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="desativar_supervisor">
                    <div class="modal-dialog modal-danger">
                        <div class="modal-content">
                            <form action="../../supervisor/desativar" method="post">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Desativar | Coordenador</h4>
                                </div>
                                <div class="box-body">
                                    <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="id_supervisor" value="<?= $dados_supervisor['id_supervisorR']; ?>">
                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

                                    <div class="form-group">
                                        <center>
                                            <label for="exampleInputEmail1">Deseja realmente desativar esse Coordenador?</label>
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

                <div class="modal fade" id="excluir_supervisor_permantemente">
                    <div class="modal-dialog modal-danger">
                        <div class="modal-content">
                            <form action="../excluir" id="form_exclusao_supervisor_permanentemente" method="POST">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Excluir Supervisor Permanentemente</h4>
                                </div>

                                <div class="box-body">
                                    <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="opc" value="<?= $dados_supervisor['id_supervisorR']; ?>">
                                    <input type="hidden" name="red" value="https://sistemas.campbrasil.com/sistema/direcao/page/supervisores">
                                    <input type="hidden" name="id_novo_supervisor" id="idSupervisorNovoTroca" value="0">

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Conte-nos o motivo:</label>
                                            <textarea name="motivo" class="form-control"></textarea>
                                        </div>

                                        <div class="form-group txt_center">
                                            <label for="exampleInputEmail1">Deseja realmente excluir esse Supervisor permanente?</label>
                                        </div>

                                        <?php
                                        $lideres_do_supervisor = $this->Lideres->infos([$dados_supervisor['id_supervisorR']], 'query_lideres_id_supervisor', '', '');
                                        $coordenadores_do_supervisor = $this->Coordenadores->infos([$dados_supervisor['id_supervisorR']], 'info_coordenador_id_supervisor', '', '');
                                        if ($lideres_do_supervisor['row'] == 0 && $coordenadores_do_supervisor['row'] == 0) {
                                        } else {
                                        ?>
                                            <label for="id_coordenador_troca">Selecione um novo coordenador para os líderes:</label>

                                            <!-- Caixa de pesquisa -->
                                            <input type="text" id="pesquisaSupervisor" class="form-control mb-3" placeholder="Pesquisar Supervisor..."><br>

                                            <!-- Lista de líderes -->
                                            <div id="listaSupervisores_3" style="max-height: 300px; overflow-y: auto;">

                                                <div class="form-check">
                                                    <input class="form-check-input checkbox-supervisor-3" type="checkbox" value="0" id="coord0">
                                                    <label class="form-check-label" for="coord0">
                                                        Sem supervisor
                                                    </label>
                                                </div>

                                                <?php
                                                // exemplo: buscando do banco
                                                $supervisores = $this->db->query("SELECT id_supervisorR, nome_supervisorR FROM supervisor_local ORDER BY nome_supervisorR ASC")->result_array();
                                                foreach ($supervisores as $c) {
                                                    if ($c['id_supervisorR'] == $id_supervisor) {
                                                    } else {
                                                ?>
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox-supervisor-3" type="checkbox" value="<?= $c['id_supervisorR']; ?>" id="coord<?= $c['id_supervisorR']; ?>">
                                                            <label class="form-check-label" for="coord<?= $c['id_supervisorR']; ?>">
                                                                <?= htmlspecialchars($c['nome_supervisorR']); ?>
                                                            </label>
                                                        </div>
                                                <?php }
                                                } ?>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Não</button>
                                    <input type="submit" class="btn btn-default pull-right" value="Sim">
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
