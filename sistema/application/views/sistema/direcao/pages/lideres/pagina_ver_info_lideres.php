<script>
    const idpg = [];
    const idmodulo = [];
    const idmoduloslist = [];
    const anomodulo = [];
    const datasemana = [];
</script>

<?php
if (!isset($_SESSION['usuario'])) {
    header("location: https://sistemas.campbrasil.com/sistema/index");
} else {

    $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
    $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";
    $url_redirecionamento = current_url() . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '');

    if ($x == 'is_page_supervisor_coordenador') {
        $voltar = "../../../../";
    } else if ($x == 'is_page_coordenador') {
        $voltar = "../../../";
    } else {
        $voltar = "../../";
    }

    if ($x == 'is_page_supervisor_coordenador') {
        $voltar_2 = "../../../";
    } else if ($x == 'is_page_coordenador') {
        $voltar_2 = "../../";
    } else {
        $voltar_2 = "../";
    }

    if ($x == 'is_page_supervisor_coordenador') {
        $red_page_licao = "super";
    } else if ($x == 'is_page_coordenador') {
        $red_page_licao = "coord";
    } else {
        $red_page_licao = "lider";
    }

    $array = array('voltar' => $voltar);

    $dados_lider = $dados_do_lider['dados'];

    if ($dados_do_lider['row'] == 0) {
        // escrever uma mensagem
        $this->FConsultas_model->mensagem('danger', 'Erro!', ['Os dados do líder não foi encontrado, tente novamente!']);
        if ($x == 'is_page_supervisor_coordenador') {
            $funcao = $this->FConsultas_model->red("../../../lideres", 2000, []);
        } else {
            $funcao = $this->FConsultas_model->red("../lideres", 2000, []);
        }
        echo $funcao;
    } else {
        // id lider // opc // ativo
        $check_ativo = true;

        if ($dados_lider['confirmado'] == 0) {
            // cadastro incompleto
        } else if ($dados_lider['confirmado'] == 1) {
            // precisando liberação
        } else if ($dados_lider['confirmado'] == 3) {
            // desativado
            $check_ativo = false;
        } else {
        }
        $consultarPG = $this->PG->query([$dados_lider['id_lider']], 'query_pg_id_lider_all', 0);

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
    }
?>
    <!DOCTYPE html>
    <html>
    <!-- Head -->
    <?php
    $this->load->view('partes/head');
    ?>

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
            aparecer_select();
            var confirmado = <?= $dados_lider['confirmado'] ?>;
            var is_ativo = true;

            if (confirmado == 1) {} else if (confirmado == 2) {} else if (confirmado == 3) {
                is_ativo = false;
            }

            if (is_ativo) {
                //document.getElementById('btn_solicitar_1').disabled = true;
                //document.getElementById('btn_solicitar_2').disabled = true;
                document.getElementById('remove_cri').style.display = 'none';
            }

            var count = idpg.length;

            if (count == 0) {} else {

                var id_lider = '<?= $dados_do_lider['dados']['id_lider']; ?>';

                for (let index = 0; index < count; index++) {
                    const id_pg = idpg[index];
                    const id_modulo = idmodulo[index];
                    const check = datasemana[index];
                    const ano = anomodulo[index];

                    mostrarProgressoInicial(id_modulo, id_lider, id_pg, ano, index);
                }
            }
        });

        function validar_edicao() {

            var dados = document.form_editar_foto.opc.value;

            if (dados == "Sim" || dados == "Não") {} else {
                alert("Você não escolheu a opção");
                return false;
            }
        }

        /*function trocar_lider() {
            const opc = document.getElementById('id_lider_troca').value;

            if (opc == 0) {
                document.getElementById('btn_solicitar_2').disabled = true;
                document.getElementById('btn_solicitar_2').disabled = false;
            } else {

            }
        }*/

        function mostrarProgressoInicial(idModulo, idLider, idPg, ano, index) {
            var moduloAtual = idmodulo[index];
            var respostas = idmoduloslist;

            respostas.push(moduloAtual);

            var radio = document.getElementsByName('modulos_escolhidos');

            var total = 1;

            var ajax = AjaxF();

            var nome_tabela = "conteudos_table_" + idPg;

            ajax.onreadystatechange = function() {
                if (ajax.readyState == 4) {
                    document.getElementById(nome_tabela).innerHTML = ajax.responseText;
                }
            }

            var x = '<?= $x; ?>';

            if (x == 'is_page_supervisor_coordenador') {
                ajax.open("GET", "../../../pg/consultarProgresso?id_lider=" + idLider + "&id_pg=" + idPg + "&id_modulo=" + respostas + "&total=" + total + "&ano=" + ano + "&page=geral&ativo=0", false);
            } else if (x == 'is_page_coordenador') {
                ajax.open("GET", "../../pg/consultarProgresso?id_lider=" + idLider + "&id_pg=" + idPg + "&id_modulo=" + respostas + "&total=" + total + "&ano=" + ano + "&page=geral&ativo=0", false);
            } else {
                ajax.open("GET", "../pg/consultarProgresso?id_lider=" + idLider + "&id_pg=" + idPg + "&id_modulo=" + respostas + "&total=" + total + "&ano=" + ano + "&page=geral&ativo=0", false);
            }

            ajax.setRequestHeader("Content-Type", "text/html");
            ajax.send();
        }

        function aparecer_select() {
            var opc = document.getElementById('pais').value;

            if (opc == "br") {
                document.getElementById('estados2').value = '';
                document.getElementById('cidades2').value = '';
                document.getElementById('consultar_endereco').style.display = "inline";
                document.getElementById('escrever_endereco').style.display = "none";

                document.getElementById('precisa_cpf').style.display = "inline";

                document.getElementById('cpf').setAttribute('required', 'true');
            } else {
                document.getElementById('estados').value = '';
                document.getElementById('cidades').value = '';
                document.getElementById('escrever_endereco').style.display = "inline";
                document.getElementById('consultar_endereco').style.display = "none";

                document.getElementById('precisa_cpf').style.display = "none";
                document.getElementById('cpf').value = '';
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
                        <?php
                        if ($x == 'is_page_supervisor_coordenador') {
                        ?>
                            <li><a href="<?= $voltar; ?>home"><i class="fa fa-home"></i> Home</a></li>
                            <li><a href="<?= $voltar; ?>page/supervisores"><i class="fa fa-group"></i> Supervisores</a></li>
                            <li><a href="<?= $voltar; ?>page/supervisor/<?= $dados_lider['id_supervisorR']; ?>"><i class="fa fa-group"></i> Coordenador</a></li>
                            <li><a href="<?= $voltar; ?>page/supervisor/coordenador/lideres/<?= $dados_lider['id_coordenador']; ?>"><i class="fa fa-group"></i> Líderes</a></li>
                        <?php } else if ($x == 'is_page_coordenador') { ?>
                            <li><a href="<?= $voltar; ?>home"><i class="fa fa-home"></i> Home</a></li>
                            <li><a href="<?= $voltar; ?>page/coordenadores"><i class="fa fa-group"></i> Coordenadores</a></li>
                            <li><a href="<?= $voltar; ?>page/coordenador/lideres/<?= $dados_lider['id_coordenador']; ?>"><i class="fa fa-group"></i> Líderes</a></li>
                        <?php } else { ?>
                            <li><a href="<?= $voltar; ?>home"><i class="fa fa-home"></i> Home</a></li>
                            <li><a href="<?= $voltar; ?>page/lideres"><i class="fa fa-group"></i> Líderes</a></li>
                        <?php } ?>
                        <li class="active">Informações</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="box box-info">

                            <?php
                            if ($check_ativo) {
                            } else {
                            ?>
                                <div class="col-lg-12">
                                    <div class="box-body chat"><br>
                                        <div class="callout callout-info">
                                            <h4>
                                                Esse líder está desativado!
                                            </h4>
                                            <p>Reative ou Exclua Permanentemente</p>
                                            <center>
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#reativar_lider">Reative</button>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#excluir_lider_permantemente">Exclua Permanentemente</button>
                                            </center>
                                        </div>
                                    </div>
                                </div>

                            <?php } ?>

                            <!-- form start -->
                            <form action="<?= $voltar_2; ?>lider/salvar" role="form" method="POST" enctype="multipart/form-data" name="form_editar_foto">
                                <div class="col-lg-6">
                                    <div class="box-body chat" id="chat-box">
                                        <div class="box-footer">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Dados Pessoais | Líder</h3>
                                            </div> <br>
                                            <?php
                                            $foto_original = $dados_lider['foto'];
                                            //$foto_original = 'fotoU/pais/WhatsApp_Image_2022-12-05_at_08_30_33.jpeg';

                                            $email = $dados_lider['email'];
                                            $cpf = $dados_lider['cpf'];

                                            $info_usuario = $this->Lideres->infos([$email, $cpf], 'info_usuario_and_email_cpf', '', '');

                                            $disabled_inputs = "";
                                            if (!$check_ativo) {
                                                $disabled_inputs = "disabled";
                                            }

                                            $foto = base_url('import/sistema/' . $foto_original);
                                            ?>

                                            <input type="hidden" name="id_usuario" value="<?= $info_usuario['dados']['id_usuario']; ?>">
                                            <input type="hidden" name="id" value="<?= $dados_lider['id_lider']; ?>">
                                            <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

                                            <div class="col-lg-12">
                                                <center>
                                                    <div class="form-group">
                                                        <?php
                                                        if ($check_ativo) {
                                                        ?>
                                                            <div class="form-group">
                                                                <label for="nome">Editar Foto?</label>
                                                                <div class="imageContainer">
                                                                    <img src="<?= $foto; ?>" alt="Imagem não encontrada" id="imgPhoto_usuario">
                                                                </div>
                                                                <input type="file" name="files[]" id="fileImage_usuario">
                                                                <input type="hidden" name="foto_antiga" value="<?= $foto_original; ?>">
                                                            </div>
                                                        <?php } else { ?>
                                                            <label for="nome">Editar Foto?</label>
                                                            <div class="imageContainer">
                                                                <img src="<?= $foto; ?>" alt="Imagem não encontrada" id="imgPhoto_usuario">
                                                            </div>
                                                        <?php } ?>
                                                    </div>
                                                </center>
                                            </div>

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

                                            <div class="col-lg-6">
                                                <div class="form-group has-feedback">
                                                    <label for="exampleInputPassword1">País</label>
                                                    <select id="pais" name="pais" class="form-control" onchange="aparecer_select(this)" <?= $disabled_inputs; ?>>
                                                        <?php
                                                        if ($dados_lider['pais'] == '' || $dados_lider['pais'] == 'br' || $dados_lider['pais'] == 'Brasil') {
                                                        ?>
                                                            <option value="">País</option>
                                                            <option value="br" selected>Brasil</option>
                                                            <option value="Moçambique">Moçambique</option>
                                                            <option value="outro">Outros</option>
                                                        <?php } else if ($dados_lider['pais'] == 'Moçambique') { ?>
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
                                                <div class="form-group col-lg-6">
                                                    <label for="exampleInputPassword1">Pais</label>
                                                    <input type="text" class="form-control" placeholder="Pais" value="Brasil" disabled>
                                                </div>

                                                <div class="form-group col-lg-6" id="form-group">
                                                    <label for="exampleInputPassword1">Estado</label>
                                                    <select id="estados" name="estados" class="form-control" <?= $disabled_inputs; ?>>
                                                        <option value=""></option>
                                                    </select>
                                                </div>

                                                <div class="form-group col-lg-6" id="form-group">
                                                    <label for="exampleInputPassword1">Cidade</label>
                                                    <select id="cidades" name="cidades" class="form-control" <?= $disabled_inputs; ?>></select>
                                                </div>
                                            </div>

                                            <div id="escrever_endereco">
                                                <div class="form-group col-lg-6">
                                                    <label for="exampleInputPassword1">Pais</label>
                                                    <input type="text" id="pais2" class="form-control" placeholder="Pais" name="nome_pais" value="<?= $dados_lider['pais']; ?>" <?= $disabled_inputs; ?>>
                                                </div>

                                                <div class="form-group col-lg-6">
                                                    <label for="exampleInputPassword1">Estado/Província/Região</label>
                                                    <input type="text" id="estados2" class="form-control" placeholder="Estado/Província/Região" name="estados2" value="<?= $dados_lider['estado']; ?>" <?= $disabled_inputs; ?>>
                                                </div>

                                                <div class="form-group col-lg-6">
                                                    <label for="exampleInputPassword1">Cidade/Município/Distrito</label>
                                                    <input type="text" id="cidades2" class="form-control" placeholder="Cidade/Município/Distrito" name="cidades2" value="<?= $dados_lider['cidade']; ?>" <?= $disabled_inputs; ?>>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Nome</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="nome" minlength="5" value="<?= $dados_lider['nome_lider']; ?>" placeholder="Nome" required <?= $disabled_inputs; ?>>
                                                    <input type="hidden" name="nome_antigo" value="<?= $dados_lider['nome_lider']; ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-6" id="precisa_cpf">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">CPF</label>
                                                    <input type="text" class="form-control" name="cpf" id="cpf" value="<?= $dados_lider['cpf']; ?>" placeholder="CPF" maxlength="14" minlength="11" required <?= $disabled_inputs; ?>>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">E-mail</label>
                                                    <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="<?= $dados_lider['email']; ?>" placeholder="E-mail" required <?= $disabled_inputs; ?>>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Telefone</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="telefone" value="<?= $dados_lider['telefone_whatsapp']; ?>" placeholder="Telefone" minlength="11" required <?= $disabled_inputs; ?>>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Igreja</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="igreja" value="<?= $dados_lider['igreja']; ?>" placeholder="Igreja" minlength="5" required <?= $disabled_inputs; ?>>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Data de Nascimento</label>
                                                    <input type="text" class="form-control" id="exampleInputEmail1" name="nascimento" value="<?= $dados_lider['nascimento']; ?>" maxlength="10" minlength="10" placeholder="Data de Nascimento" required <?= $disabled_inputs; ?>>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group">
                                                    <label for="exampleInputEmail1">Senha</label>
                                                    <input type="password" class="form-control" id="senha" name="senha" value="<?= $info_usuario['dados']['senha']; ?>" placeholder="Senha" required <?= $disabled_inputs; ?>>
                                                    <span onclick="toggleSenha()" style="position: absolute; right: 20px; top: 55%; transform: translateY(-50%); cursor: pointer;">👁️</span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group" id="form-group">
                                                    <label for="exampleInputPassword1">Coordenador</label>
                                                    <select name="id_coordenador" class="form-control" <?= $disabled_inputs; ?>>
                                                        <?php
                                                        $id_coordenador = $dados_lider['id_coordenador'];
                                                        $info_coordenadores = $this->Coordenadores->infos([], 'query_coordenadores_order_by_nome_coordenador', 'asc', '');

                                                        foreach ($info_coordenadores['dados'] as $key => $c) {
                                                            if ($c['id_coordenador'] == $id_coordenador) {
                                                        ?>
                                                                <option value="<?= $c['id_coordenador']; ?>" selected><?= $c['nome_coordenador']; ?></option>
                                                            <?php } else { ?>
                                                                <option value="<?= $c['id_coordenador']; ?>"><?= $c['nome_coordenador']; ?></option>
                                                        <?php
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6">
                                                <div class="form-group" id="form-group">
                                                    <label for="exampleInputPassword1">Supervisor(você)</label>
                                                    <select name="id_supervisor" class="form-control" <?= $disabled_inputs; ?>>
                                                        <?php
                                                        $id_sr = $dados_lider['id_supervisorR'];
                                                        $info_coordenadores = $this->Supervisores->infos([], 'query_supervisor_order_by_nome', 'asc', '');

                                                        foreach ($info_coordenadores['dados'] as $key => $c) {
                                                            if ($c['id_supervisorR'] == $id_sr) {
                                                        ?>
                                                                <option value="<?= $c['id_supervisorR']; ?>" selected><?= $c['nome_supervisorR']; ?></option>
                                                            <?php } else { ?>
                                                                <option value="<?= $c['id_supervisorR']; ?>"><?= $c['nome_supervisorR']; ?></option>
                                                        <?php
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <?php
                                            if ($check_ativo) {
                                            ?>

                                                <div class="col-lg-12">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-danger pull-left dropdown-toggle mg_r_10" data-toggle="dropdown">Desativar
                                                            <span class="fa fa-caret-down"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li style="margin-bottom: 5px;">
                                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#desativar_lider">Desativar Líder</button>
                                                            </li>
                                                            <li style="margin-bottom: 5px;">
                                                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#excluir_lider_permantemente">Excluir Permanentemente</button>
                                                            </li>
                                                        </ul>
                                                    </div>


                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-success pull-left dropdown-toggle" data-toggle="dropdown">Mudar Função
                                                            <span class="fa fa-caret-down"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <li style="margin-bottom: 5px;">
                                                                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#tornar_coordenador">Tornar Coordenador</button>
                                                            </li>
                                                            <li style="margin-bottom: 5px;">
                                                                <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#tornar_supervisor">Tornar Supervisor</button>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>

                                            <?php } else {
                                            } ?>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="box-body chat" id="chat-box">
                                        <div class="box-footer">
                                            <div class="box-header with-border">
                                                <h3 class="box-title">Colíder</h3>
                                                <?php
                                                $colideres_desativados = $this->Lideres->mostrar_colider_do_lider_desativados($dados_lider['id_lider']);
                                                $dados = $this->Lideres->mostrar_colider_do_lider($dados_lider['id_lider']);
                                                if ($check_ativo) {
                                                ?>
                                                    <?php
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
                                                            <?php
                                                            if ($check_ativo) {
                                                            ?>
                                                                <div class="form-group">
                                                                    <label for="nome">Editar Foto?</label>
                                                                    <div class="imageContainer">
                                                                        <img src="<?= $foto_colider; ?>" alt="Imagem não encontrada" id="imgPhoto_colider">
                                                                    </div>
                                                                    <input type="file" name="filesColider[]" id="fileImage_colider">
                                                                    <input type="hidden" name="foto_antiga_colider" value="<?= $foto_original_colider; ?>">
                                                                </div>
                                                            <?php } else { ?>
                                                                <label for="nome">Editar Foto?</label>
                                                                <div class="imageContainer">
                                                                    <img src="<?= $foto_colider; ?>" alt="Imagem não encontrada" id="imgPhoto_colider">
                                                                </div>
                                                            <?php } ?>
                                                        </div>
                                                    </center>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Nome</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" name="nome_colider" minlength="5" value="<?= $dados['nome_colider']; ?>" placeholder="Nome" required <?= $disabled_inputs; ?>>
                                                    </div>
                                                </div>

                                                <?php
                                                if ($dados_lider['pais'] == '' || $dados_lider['pais'] == 'br' || $dados_lider['pais'] == 'Brasil') {
                                                ?>
                                                    <div class="col-lg-6">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1">CPF</label>
                                                            <input type="text" class="form-control" id="exampleInputEmail1" name="cpf_colider" value="<?= $dados['cpf']; ?>" placeholder="CPF" maxlength="14" minlength="11" required <?= $disabled_inputs; ?>>
                                                        </div>
                                                    </div>
                                                <?php } else {
                                                } ?>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">E-mail</label>
                                                        <input type="email" class="form-control" id="exampleInputEmail1" name="email_colider" value="<?= $dados['email']; ?>" placeholder="E-mail" required <?= $disabled_inputs; ?>>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Telefone</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" name="telefone_colider" value="<?= $dados['telefone_whatsapp']; ?>" placeholder="Telefone" minlength="11" required <?= $disabled_inputs; ?>>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1">Data de Nascimento</label>
                                                        <input type="text" class="form-control" id="exampleInputEmail1" name="nascimento_colider" value="<?= $dados['nascimento']; ?>" maxlength="10" minlength="10" placeholder="Data de Nascimento" required <?= $disabled_inputs; ?>>
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
                                                    </div>

                                                    <?php
                                                    if ($check_ativo) {
                                                    ?>
                                                        <center>
                                                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cadastro_colider">Cadastrar +</button>
                                                        </center>
                                                    <?php } else {
                                                    } ?>

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

                $pg = $this->PG->query([$dados_lider['id_lider']], 'query_pg_id_lider_all', '');
                $pg_ativos =  $this->PG->query([$dados_lider['id_lider']], 'query_pg_id_lider_all_ativo_or_no', 1);
                $pg_desativados =  $this->PG->query([$dados_lider['id_lider']], 'query_pg_id_lider_all_ativo_or_no', 0);

                if ($pg['row'] == 0) {
                ?>
                    <div class="box-body chat"><br>
                        <div class="callout callout-danger">
                            <h4>
                                Esse líder não tem nenhum PG!
                            </h4>
                        </div>
                        <?php
                        if ($check_ativo) {
                        ?>
                            <center>
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cadastro_pg">Cadastrar +</button>
                            </center>
                        <?php } else {
                        } ?>
                    </div>
                <?php
                } else {
                ?>
                    <?php
                    if ($check_ativo) {
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
                                                                                    <form action="<?= $voltar_2; ?>pg/exclusao/ativar" method="POST">
                                                                                        <input type="hidden" name="id_pg" id="id_pg_escolhido_1" value="<?= $pg_desativados['dados'][0]['id_pg']; ?>">
                                                                                        <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                                                        <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
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
                                                                                    <form action="<?= $voltar_2; ?>pg/exclusao/permanente" method="POST">
                                                                                        <input type="hidden" name="id_pg" id="id_pg_escolhido_2" value="<?= $pg_desativados['dados'][0]['id_pg']; ?>">
                                                                                        <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                                                        <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                                                                        <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
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
                                                </div><br><br>
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

                                                        $disabled = $pg_ativos['row'] == 1 ? 'disabled' : '';

                                                        foreach ($pg_ativos['dados'] as $key => $dadosPG) {
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
                                                                                <form action="<?= $voltar_2; ?>pg/edicao/salvar" method="post" enctype="multipart/form-data">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span></button>
                                                                                        <h4 class="modal-title">Edição | PG</h4>
                                                                                    </div>
                                                                                    <div class="box-body">
                                                                                        <input type="hidden" name="idPg" id="id_pg<?= $i ?>" value="<?= $dadosPG['id_pg']; ?>">
                                                                                        <input type="hidden" name="fotoOriginal" value="<?= $dadosPG['foto']; ?>">
                                                                                        <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                                                                        <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

                                                                                        <div class="col-lg-12" style="display: flex; justify-content: center;">
                                                                                            <div class="col-lg-4">
                                                                                                <div class="form-group">
                                                                                                    <label for="exampleInputEmail1">Foto (Opcional)</label>

                                                                                                    <div class="imageContainer">
                                                                                                        <img src="<?= $foto; ?>" alt="Selecione uma imagem" class="imgPhoto1" id="imgPhoto1<?= $i; ?>" style="width: 150px; height: 150px;">
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
                                                                                <form action="<?= $voltar_2; ?>pg/exclusao/desativar" method="post">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span></button>
                                                                                        <h4 class="modal-title">Desativar | PG</h4>
                                                                                    </div>
                                                                                    <div class="box-body">
                                                                                        <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                                                                                        <input type="hidden" name="idResponsavel" value="<?= $id_usuario; ?>">
                                                                                        <input type="hidden" name="idLider" value="<?= $dadosPG['id_lider']; ?>">
                                                                                        <input type="hidden" name="idPg" value="<?= $dadosPG['id_pg']; ?>">
                                                                                        <input type="hidden" name="nomePg" value="<?= $dadosPG['nome_pg']; ?>">
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

                                                                    <form action="<?= $voltar_2; ?>pg/licoes" id="form_preencher_relatorio" method="post">
                                                                        <input type="hidden" name="id_pg" value="<?= $dadosPG['id_pg']; ?>">
                                                                        <input type="hidden" name="id_lider" value="<?= $dados_lider['id_lider']; ?>">
                                                                        <input type="hidden" name="ano" value="<?= $dadosPG['ano']; ?>">
                                                                        <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                                                                        <input type="hidden" name="routa" value="<?= $red_page_licao; ?>">
                                                                    </form>
                                                                </td>
                                                                <td>
                                                                    <button type="button" class="btn btn-light pull-left" data-toggle="modal" data-target="#<?= $dadosPG['id_pg']; ?>_troca_de_lider_pg">Troca Liderança</button>

                                                                    <div class="modal fade" id="<?= $dadosPG['id_pg']; ?>_troca_de_lider_pg">
                                                                        <div class="modal-dialog modal-light">
                                                                            <form action="<?= $voltar_2; ?>lider/trocar-liderenca" method="POST" id="trocar_lider_de_pg">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span></button>
                                                                                        <h4 class="modal-title">Troca de Líder de PG</h4>
                                                                                    </div>
                                                                                    <div class="box-body">
                                                                                        <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                                                                                        <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                                                                        <input type="hidden" name="id_lider" value="<?= $dados_lider['id_lider']; ?>">
                                                                                        <input type="hidden" name="id_pg" value="<?= $dadosPG['id_pg']; ?>">

                                                                                        <input type="hidden" name="id_lider_novo" id="idLiderNovo">

                                                                                        <label for="id_lider_troca">Selecione a nova liderança para esse PG:</label>

                                                                                        <!-- Caixa de pesquisa -->
                                                                                        <input type="text" id="pesquisarLider" class="form-control mb-3" placeholder="Pesquisar Líder..."><br>

                                                                                        <!-- Lista de líderes -->
                                                                                        <div id="listaLideres" style="max-height: 300px; overflow-y: auto;">
                                                                                            <?php
                                                                                            $d_coordenador = $this->Coordenadores->infos([$dados_lider['id_coordenador']], 'info_coordenador', '', '');
                                                                                            ?>
                                                                                            <div class="form-check">
                                                                                                <input class="form-check-input checkbox-lider" type="checkbox" value="<?= $d_coordenador['dados']['id_coordenador']; ?>" id="coord<?= $d_coordenador['dados']['id_coordenador']; ?>">
                                                                                                <label class="form-check-label" for="coord<?= $d_coordenador['dados']['id_coordenador']; ?>">
                                                                                                    <?= htmlspecialchars($d_coordenador['dados']['nome_coordenador']); ?> (para seu coordenador)
                                                                                                </label>
                                                                                            </div>
                                                                                            <?php
                                                                                            $d_supervisor = $this->Supervisores->infos([$dados_lider['id_supervisorR']], 'info_supervisor', '', '');
                                                                                            ?>
                                                                                            <div class="form-check">
                                                                                                <input class="form-check-input checkbox-lider" type="checkbox" value="<?= $d_supervisor['dados']['id_supervisorR']; ?>" id="coord<?= $d_supervisor['dados']['id_supervisorR']; ?>">
                                                                                                <label class="form-check-label" for="coord<?= $d_supervisor['dados']['id_supervisorR']; ?>">
                                                                                                    <?= htmlspecialchars($d_supervisor['dados']['nome_supervisorR']); ?> (para seu supervisor)
                                                                                                </label>
                                                                                            </div>
                                                                                            <?php
                                                                                            // exemplo: buscando do banco
                                                                                            $lideres = $this->db->query("SELECT id_lider, nome_lider,id_coordenador,id_supervisorR FROM lider ORDER BY nome_lider ASC")->result_array();

                                                                                            foreach ($lideres as $l) {
                                                                                                if ($l['id_lider'] == $dados_lider['id_lider']) {
                                                                                                } else {
                                                                                                    $dados_do_coordenador = $this->Coordenadores->infos([$l['id_coordenador']], 'info_coordenador', '', '');
                                                                                                    $dados_do_supervisor = $this->Supervisores->infos([$l['id_supervisorR']], 'info_supervisor', '', '');
                                                                                            ?>
                                                                                                    <div class="form-check">
                                                                                                        <input class="form-check-input checkbox-lider" type="checkbox" value="<?= $l['id_lider']; ?>" id="coord<?= $l['id_lider']; ?>">
                                                                                                        <label class="form-check-label" for="coord<?= $l['id_lider']; ?>">
                                                                                                            <?= htmlspecialchars($l['nome_lider']); ?> (
                                                                                                            <?= htmlspecialchars($dados_do_coordenador['dados']['nome_coordenador'] ?? "coordenador não encontrado"); ?>,
                                                                                                            <?= htmlspecialchars($dados_do_supervisor['dados']['nome_supervisorR'] ?? "supervisor não encontrado"); ?>)
                                                                                                        </label>
                                                                                                    </div>
                                                                                            <?php }
                                                                                            } ?>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                                                                                        <input type="submit" id="btn_solicitar_2" class="btn btn-default pull-right" value="Trocar">
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                        <!-- /.modal-content -->
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
                    <?php } else {
                        // mostrando só as informações dos pgs
                    ?>
                        <!-- Main content -->
                        <section class="content">
                            <div class="row">
                                <div class="box box-info">
                                    <div class="box-body chat" id="chat-box">
                                        <div class="box-footer">
                                            <div class="table-responsive">
                                                <div id="texto_alerta">
                                                    <p style="font-size: 11px; padding:10px"><i>*Arraste para o lado para vê mais opções</i></p>
                                                </div>
                                                <table class="table table-bordered table-hover" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Nome</th>
                                                            <th>Módulo</th>
                                                            <th>Situação</th>
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
                                                            $ativo = $dadosPG['ativo'];

                                                            $foto = base_url($dadosPG['foto']);
                                                        ?>
                                                            <tr>
                                                                <td><img src="<?= $foto; ?>" alt="" id="imgPhoto_pg"> <?= $dadosPG['nome_pg']; ?></td>
                                                                <td><?= $nome_modulo; ?></td>
                                                                <td><?php echo $ativo == 0 ? "Desativado" : "Ativo"; ?></td>
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
                    <?php
                    } ?>

                    <?php
                    if ($check_ativo) {
                    ?>
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
                                                    $criancas_desativadas = $this->Criancas->query([$dados_lider['id_lider'], 0, 'asc'], 'query_id_lider_ativo_order_by_nome_crianca');
                                                    if ($criancas_desativadas['row'] == 0) {
                                                    } else {
                                                    ?>
                                                        <button type="button" style="margin-left: 5px;" class="btn btn-light pull-rigth" data-toggle="modal" data-target="#criancas_desativadas">Crianças Desativados</button>

                                                        <div class="modal fade" id="criancas_desativadas">
                                                            <div class="modal-dialog modal-warning">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span></button>
                                                                        <h4 class="modal-title">Ativar | Desativar | Crianças</h4>
                                                                    </div>

                                                                    <div class="box-body">

                                                                        <script>
                                                                            function trocar_id_crianca() {
                                                                                var id_cri = document.getElementById('opc_id_crianca').value;

                                                                                document.getElementById('id_crianca_escolhido_1').value = id_cri;
                                                                                document.getElementById('id_crianca_escolhido_2').value = id_cri;
                                                                            }
                                                                        </script>

                                                                        <div class="col-lg-12">

                                                                            <div class="col-lg-5">
                                                                                <div class="form-group">
                                                                                    <label for="opc">Criança:</label>
                                                                                    <select name="opc" id="opc_id_crianca" onchange="trocar_id_crianca()" class="form-control">
                                                                                        <?php
                                                                                        foreach ($criancas_desativadas['dados'] as $key => $dadosCriancas) {
                                                                                        ?>
                                                                                            <option value="<?= $dadosCriancas['id_crianca']; ?>"><?= $dadosCriancas['nome_crianca']; ?> </option>
                                                                                        <?php } ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-lg-3">
                                                                                <div class="form-group">
                                                                                    <form action="<?= $voltar_2; ?>criancas/exclusao/ativar" method="POST">
                                                                                        <input type="hidden" name="opc" id="id_crianca_escolhido_1" value="<?= $criancas_desativadas['dados'][0]['id_crianca']; ?>">
                                                                                        <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                                                        <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
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
                                                                                    <form action="<?= $voltar_2; ?>criancas/exclusao/permanente" method="POST">
                                                                                        <input type="hidden" name="opc" id="id_crianca_escolhido_2" value="<?= $criancas_desativadas['dados'][0]['id_crianca']; ?>">
                                                                                        <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                                                                        <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                                                        <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
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
                                                </div><br><br>
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
                                                $dados_criancas = $this->Criancas->query([$dados_lider['id_lider'], 1, 'asc'], 'query_id_lider_ativo_order_by_nome_crianca');

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

                                                                $consultaCriancas = $this->Criancas->query([$dados_lider['id_lider'], $dadosPG['id_pg'], 1, 'asc'], 'query_id_lider_id_pg_ativo_order_by_nome_crianca');
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
                                                                                <form action="<?= $voltar_2; ?>criancas/edicao/salvar" method="post">
                                                                                    <div class="modal-header">
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                            <span aria-hidden="true">&times;</span></button>
                                                                                        <h4 class="modal-title">Edição | Criança</h4>
                                                                                    </div>
                                                                                    <div class="box-body">
                                                                                        <input type="hidden" name="idCrianca" value="<?= $linha['id_crianca']; ?>">
                                                                                        <input type="hidden" name="idLider" value="<?= $linha['lider']; ?>">
                                                                                        <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

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
                                                                                <form action="<?= $voltar_2; ?>criancas/exclusao/desativar" method="post">
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
                                                                                        <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

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

                                                <div class="item">
                                                    <center>
                                                        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#gerar_relatorio">
                                                            Gerar PDF
                                                        </button>
                                                    </center>
                                                    <div class="modal fade" id="gerar_relatorio">
                                                        <div class="modal-dialog modal-warning">
                                                            <div class="modal-content">
                                                                <form action="<?= $voltar_2; ?>criancas/gerar/relatorio" target="_blank" method="post">
                                                                    <input type="hidden" name="id" value="<?= $dados_lider['id_lider']; ?>">
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
                                                                                        foreach ($pg['dados'] as $key => $dadosPG) {
                                                                                        ?>
                                                                                            <option value="pg <?= $dadosPG['id_pg']; ?>"> PG - <?= $dadosPG['nome_pg']; ?> </option>
                                                                                        <?php } ?>
                                                                                    </optgroup>
                                                                                    <optgroup label="Por Pontuação">
                                                                                        <?php
                                                                                        foreach ($pg['dados'] as $key => $dadosPG) {
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
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- /.row -->
                    <?php } else {
                        // mostrando só as informações das crianças
                    ?>
                        <!-- Main content -->
                        <section class="content">
                            <div class="row">
                                <div class="box box-info">
                                    <div class="box-body chat" id="chat-box">
                                        <div class="box-footer">
                                            <div class="table-responsive">
                                                <script type="text/javascript">
                                                    $(document).ready(function() {
                                                        $('#table_criancas').DataTable();
                                                    });
                                                </script>

                                                <div id="texto_alerta">
                                                    <p style="font-size: 11px; padding:10px"><i>*Arraste para o lado para vê mais opções</i></p>
                                                </div>

                                                <table class="table table-bordered table-hover" id="table_criancas" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th>Nome</th>
                                                            <th>PG</th>
                                                            <th>Nascimento</th>
                                                            <th>Situação</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        foreach ($pg['dados'] as $key => $dadosPG) {

                                                            $consultaCriancas = $this->Criancas->query([$dados_lider['id_lider']], 'query_id_lider');
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
                                                                        <?php echo $linha['ativo'] == 0 ? "Desativada" : "Ativa"; ?>
                                                                    </td>
                                                                </tr>
                                                        <?php $i++;
                                                            }
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
                    <?php
                    } ?>
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
                                    <?php

                                    foreach ($pg_ativos['dados'] as $key => $dados_pg_progresso) {
                                        $total_crianca_pg = $this->Criancas->query([$dados_lider['id_lider'], $dados_pg_progresso['id_pg'], 'asc'], 'query_id_lider_id_pg_geral_order_by_nome_crianca');

                                        $id_pgsss = $dados_pg_progresso['id_pg'];
                                    ?>
                                        <div class="item">
                                            <h4 style="text-align: center; font-weight: bold;"> PG - <?= $dados_pg_progresso['nome_pg']; ?></h4>
                                            <h4 style="text-align: center;"> Quantidade de Crianças - <?= $total_crianca_pg['row']; ?></h4>
                                        </div>

                                        <div id="conteudos_table_<?= $dados_pg_progresso['id_pg']; ?>"></div>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <!-- /.item -->
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </section>

                <?php } ?>

                <?php
                if ($dados) {
                ?>
                    <div class="modal fade" id="<?= $dados['id_colider']; ?>desativar_colider">
                        <div class="modal-dialog modal-danger">
                            <div class="modal-content">
                                <form action="<?= $voltar; ?>colider/desativar" method="POST">
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
                                        <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

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
                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

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
                                                <form action="<?= $voltar; ?>colider/ativar" method="POST">
                                                    <input type="hidden" name="opc" id="id_colider_escolhido_1" value="<?= $colideres_desativados['dados'][0]['id_colider']; ?>">
                                                    <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                    <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
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
                                                <form action="<?= $voltar; ?>colider/exclusao/permanente" method="POST">
                                                    <input type="hidden" name="opc" id="id_colider_escolhido_2" value="<?= $colideres_desativados['dados'][0]['id_colider']; ?>">
                                                    <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                    <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
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
                            <form action="<?= $voltar; ?>colider/cadastro/salvar" method="POST">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Cadastro | Colíder</h4>
                                </div>
                                <div class="box-body">
                                    <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

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

                                    <?php
                                    if ($dados_lider['pais'] == '' || $dados_lider['pais'] == 'br' || $dados_lider['pais'] == 'Brasil') {
                                    ?>
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback">
                                                <input type="text" class="form-control" placeholder="CPF do Colíder" minlength="11" name="cpfColider">
                                                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                            </div>
                                        </div>
                                    <?php } else {
                                    } ?>

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

                <div class="modal fade" id="desativar_lider">
                    <div class="modal-dialog modal-danger">
                        <div class="modal-content">
                            <form action="<?= $voltar_2; ?>lider/desativar" method="POST">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Desativar Líder</h4>
                                </div>

                                <div class="box-body" style="height: 150px;">

                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="id_lider" value="<?= $dados_lider['id_lider']; ?>">
                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

                                    <div class="col-lg-12" style="position: relative;top: 50%; transform: translateY(-50%);">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Conte-nos o motivo:</label>
                                            <textarea name="motivo" class="form-control"></textarea>
                                        </div>

                                        <div class="form-group txt_center">
                                            <label for="exampleInputEmail1">Deseja realmente desativar esse Líder?</label>
                                        </div>
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

                <div class="modal fade" id="reativar_lider">
                    <div class="modal-dialog modal-success">
                        <div class="modal-content">
                            <form action="<?= $voltar_2; ?>lider/reativar" method="POST">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Ativar Líder</h4>
                                </div>

                                <div class="box-body" style="height: 150px;">

                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="id_lider" value="<?= $dados_lider['id_lider']; ?>">
                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

                                    <div class="col-lg-12" style="position: relative;top: 50%; transform: translateY(-50%);">
                                        <div class="form-group txt_center">
                                            <label for="exampleInputEmail1">Deseja realmente ativar esse Líder?</label>
                                        </div>
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

                <div class="modal fade" id="excluir_lider_permantemente">
                    <div class="modal-dialog modal-danger">
                        <div class="modal-content">
                            <form action="<?= $voltar_2; ?>lider/excluir" id="form_exclusao_lider_permanentemente" method="POST">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Excluir Líder Permanentemente</h4>
                                </div>

                                <div class="box-body">
                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="id_lider" value="<?= $dados_lider['id_lider']; ?>">
                                    <?php if ($x == 'is_page_supervisor_coordenador') { ?>
                                        <input type="hidden" name="red" value="https://sistemas.campbrasil.com/sistema/direcao/page/supervisor/coordenador/lideres/<?= $dados_lider['id_coordenador']; ?>">
                                    <?php } else if ($x == 'is_page_coordenador') { ?>
                                        <input type="hidden" name="red" value="https://sistemas.campbrasil.com/sistema/direcao/page/coordenador/lideres/<?= $dados_lider['id_coordenador']; ?>">
                                    <?php } else { ?>
                                        <input type="hidden" name="red" value="https://sistemas.campbrasil.com/sistema/direcao/page/lideres">
                                    <?php } ?>
                                    <input type="hidden" name="id_novo_lider" id="idLiderNovoTroca" value="0">

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Conte-nos o motivo:</label>
                                            <textarea name="motivo" class="form-control"></textarea>
                                        </div>

                                        <div class="form-group txt_center">
                                            <label for="exampleInputEmail1">Deseja realmente excluir esse Líder permanente?</label>
                                        </div>

                                        <?php
                                        if ($pg['row'] == 0) {
                                        } else {
                                        ?>
                                            <label for="id_lider_troca">Selecione a nova liderança para esse PG:</label>

                                            <!-- Caixa de pesquisa -->
                                            <input type="text" id="pesquisarLider_2" class="form-control mb-3" placeholder="Pesquisar Líder...">

                                            <!-- Lista de líderes -->
                                            <div id="listaLideres_2" style="max-height: 300px; overflow-y: auto;">

                                                <div class="form-check">
                                                    <input class="form-check-input checkbox-lider_2" type="checkbox" value="0" id="coord0">
                                                    <label class="form-check-label" for="coord0">
                                                        Sem liderança
                                                    </label>
                                                </div>

                                                <?php
                                                // exemplo: buscando do banco
                                                $lideres = $this->db->query("SELECT id_lider, nome_lider FROM lider ORDER BY nome_lider ASC")->result_array();
                                                foreach ($lideres as $l) {
                                                    if ($l['id_lider'] == $dados_lider['id_lider']) {
                                                    } else {
                                                ?>
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox-lider_2" type="checkbox" value="<?= $l['id_lider']; ?>" id="coord<?= $l['id_lider']; ?>">
                                                            <label class="form-check-label" for="coord<?= $l['id_lider']; ?>">
                                                                <?= htmlspecialchars($l['nome_lider']); ?>
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

                <div class="modal fade" id="cadastro_pg">
                    <div class="modal-dialog modal-success">
                        <div class="modal-content">
                            <form action="<?= $voltar_2; ?>pg/cadastro/salvar" method="POST">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Cadastro | PG</h4>
                                </div>
                                <div class="box-body">
                                    <input type="hidden" name="idLider" value="<?= $dados_lider['id_lider']; ?>">
                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

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
                            <form action="<?= $voltar_2; ?>criancas/cadastro/salvar" method="POST">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Cadastro | Crianças</h4>
                                </div>
                                <div class="box-body">
                                    <input type="hidden" name="id_lider" value="<?= $dados_lider['id_lider']; ?>">
                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

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
                                                    $consultarPG = $this->PG->query([$dados_lider['id_lider']], 'query_pg_id_lider_all', '');

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

                <div class="modal fade" id="tornar_coordenador">
                    <div class="modal-dialog modal-default">
                        <div class="modal-content">
                            <form action="<?= $voltar; ?>../tornar/tornar_lider_to_coordenador" method="POST" id="form_tornar_coordenador">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Solicitar Mudança Líder - Coordenador</h4>
                                </div>
                                <div class="box-body">
                                    <input type="hidden" name="funcao_atiga" value="lider">
                                    <input type="hidden" name="funcao_nova" value="coordenador">
                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="id_change" value="<?= $dados_lider['id_lider']; ?>">
                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                                    <input type="hidden" name="ids_lideres" id="idsLideres">

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <center>
                                                <label for="id_troca_1">Deseja tornar <?= $dados_lider['nome_lider']; ?> coordenador?</label>
                                                <br><i>* observação: para essa nova função, o lider tem que ter 3 novos líderes.</i>
                                            </center>
                                            <!-- Caixa de pesquisa -->
                                            <input type="text" id="pesquisaLider_coord" class="form-control mb-3" placeholder="Pesquisar Lider..."><br>

                                            <label class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="cadastro_depois">
                                                <span class="form-check-label">Cadastrar líderes depois</span>
                                            </label>

                                            <!-- Lista de Lideres -->
                                            <div id="listaLideres_coord" style="max-height: 300px; overflow-y: auto;">
                                                <?php
                                                // exemplo: buscando do banco
                                                $lideres = $this->db->query("SELECT id_lider, nome_lider FROM lider ORDER BY nome_lider ASC")->result_array();

                                                foreach ($lideres as $c) {
                                                    if ($c['id_lider'] == $dados_lider['id_lider']) {
                                                    } else {
                                                ?>
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox-lider_coord" type="checkbox" value="<?= $c['id_lider']; ?>" id="lider<?= $c['id_lider']; ?>">
                                                            <label class="form-check-label" for="lider<?= $c['id_lider']; ?>">
                                                                <?= htmlspecialchars($c['nome_lider']); ?>
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

                <div class="modal fade" id="tornar_supervisor">
                    <div class="modal-dialog modal-default">
                        <div class="modal-content">
                            <form action="<?= $voltar; ?>../tornar/tornar_lider_to_supervisor" method="POST" id="tornar_lider_to_supervisor">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Solicitar Mudança Líder - Supervisor</h4>
                                </div>
                                <div class="box-body">
                                    <input type="hidden" name="funcao_atiga" value="lider">
                                    <input type="hidden" name="funcao_nova" value="supervisor">
                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="id_change" value="<?= $dados_lider['id_lider']; ?>">
                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                                    <input type="hidden" name="ids_coordenadores" id="idsCoordenadoresSupervisao">

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <center>
                                                <label for="id_troca_1">Deseja tornar <?= $dados_lider['nome_lider']; ?> supervisor?</label>
                                                <br><i>* observação: para essa nova função, o lider tem que ter 3 coordenações.</i>
                                            </center>
                                            <!-- Caixa de pesquisa -->
                                            <input type="text" id="pesquisaCoord_super" class="form-control mb-3" placeholder="Pesquisar Lider..."><br>

                                            <!-- Lista de Lideres -->
                                            <div id="listaSupervisores_tonvfuncao" style="max-height: 300px; overflow-y: auto;">
                                                <?php
                                                // exemplo: buscando do banco
                                                $coordenadores = $this->db->query("SELECT id_coordenador, nome_coordenador FROM coordenador ORDER BY nome_coordenador ASC")->result_array();

                                                foreach ($coordenadores as $c) {
                                                    if ($c['id_coordenador'] == $dados_lider['id_lider']) {
                                                    } else {
                                                ?>
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox-coord-supervisao" type="checkbox" value="<?= $c['id_coordenador']; ?>" id="lider<?= $c['id_coordenador']; ?>">
                                                            <label class="form-check-label" for="lider<?= $c['id_coordenador']; ?>">
                                                                <?= htmlspecialchars($c['nome_coordenador']); ?>
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

            </div>
            <!-- Footer -->
            <?php
            $this->load->view('partes/footer');
            ?>
        </div>
        <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
        <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->
        <!-- Links JavaScript -->
        <?php
        $this->load->view('partes/scripts2');
        ?>
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

            document.addEventListener("DOMContentLoaded", function() {
                // modal - tornar supervisor
                const pesquisarInput_super = document.getElementById('pesquisaCoord_super');
                if (pesquisarInput_super) {
                    pesquisarInput_super.addEventListener('input', function() {
                        const filtro = this.value.toLowerCase();
                        document.querySelectorAll('#listaSupervisores_tonvfuncao .form-check').forEach(div => {
                            const texto = div.innerText.toLowerCase();
                            div.style.display = texto.includes(filtro) ? '' : 'none';
                        });
                    });
                }

                const form_tornar_supervisor = document.querySelector('form#tornar_lider_to_supervisor');
                if (!form_tornar_supervisor) return; // evita erro se o formulário não existir

                // Pega todos os checkboxes
                const checkboxes_coord_supervisao = document.querySelectorAll('.checkbox-coord-supervisao');
                const inputHidden_coord_que_vao_para_supervisao = document.getElementById('idsCoordenadoresSupervisao');

                // Função para atualizar o campo hidden
                function atualizarIdsSelecionados_coord_new_supervisao() {
                    const selecionados = Array.from(checkboxes_coord_supervisao)
                        .filter(cb => cb.checked)
                        .map(cb => cb.value);

                    inputHidden_coord_que_vao_para_supervisao.value = selecionados.join(',');
                    console.log('IDs atualizados:', inputHidden_coord_que_vao_para_supervisao.value);
                }

                // Adiciona o evento de mudança (check/uncheck) em cada checkbox
                checkboxes_coord_supervisao.forEach(cb => {
                    cb.addEventListener('change', atualizarIdsSelecionados_coord_new_supervisao);
                });

                // Validação antes do envio
                form_tornar_supervisor.addEventListener('submit', function(e) {
                    const selecionados = inputHidden_coord_que_vao_para_supervisao.value.split(',').filter(v => v !== '');
                    if (selecionados.length < 3) {
                        e.preventDefault(); // impede o envio
                        Swal.fire({
                            title: 'Atenção!',
                            text: 'Você precisa selecionar pelo menos 3 coordenadores.',
                            icon: 'warning',
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#198754', // cor do botão principal (verde bootstrap)
                            background: '#fefefe', // cor de fundo
                            color: '#333', // cor do texto
                            iconColor: '#f39c12', // cor do ícone
                        });
                    }
                });

                // modal - tornar coordenador
                const pesquisarInput_coord = document.getElementById('pesquisaLider_coord');
                if (pesquisarInput_coord) {
                    pesquisarInput_coord.addEventListener('input', function() {
                        const filtro = this.value.toLowerCase();
                        document.querySelectorAll('#listaLideres_coord .form-check').forEach(div => {
                            const texto = div.innerText.toLowerCase();
                            div.style.display = texto.includes(filtro) ? '' : 'none';
                        });
                    });
                }

                const form_coord = document.querySelector('form#form_tornar_coordenador');
                if (!form_coord) return; // evita erro se o formulário não existir
                const cadastroDepois = document.querySelector('#cadastro_depois');

                // Pega todos os checkboxes
                const checkboxes_coord = document.querySelectorAll('.checkbox-lider_coord');
                const inputHidden_coord = document.getElementById('idsLideres');

                // Função para atualizar o campo hidden
                function atualizarIdsSelecionados_coord() {
                    const selecionados = Array.from(checkboxes_coord)
                        .filter(cb => cb.checked)
                        .map(cb => cb.value);

                    inputHidden_coord.value = selecionados.join(',');
                    console.log('IDs atualizados:', inputHidden_coord.value);
                }

                // Adiciona o evento de mudança (check/uncheck) em cada checkbox
                checkboxes_coord.forEach(cb => {
                    cb.addEventListener('change', atualizarIdsSelecionados_coord);
                });

                // Validação antes do envio
                form_coord.addEventListener('submit', function(e) {
                    // Se marcou "cadastrar depois", não valida
                    if (cadastroDepois.checked) return;

                    const selecionados = inputHidden_coord.value.split(',').filter(v => v !== '');
                    if (selecionados.length < 3) {
                        e.preventDefault(); // impede o envio
                        Swal.fire({
                            title: 'Atenção!',
                            text: 'Você precisa selecionar pelo menos 3 líderes.',
                            icon: 'warning',
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#198754', // cor do botão principal (verde bootstrap)
                            background: '#fefefe', // cor de fundo
                            color: '#333', // cor do texto
                            iconColor: '#f39c12', // cor do ícone
                        });
                    }
                });

                // líderes 2
                const pesquisarInput_3 = document.getElementById('pesquisarLider_2');
                if (pesquisarInput_3) {
                    pesquisarInput_3.addEventListener('input', function() {
                        const filtro = this.value.toLowerCase();
                        document.querySelectorAll('#listaLideres_2 .form-check').forEach(div => {
                            const texto = div.innerText.toLowerCase();
                            div.style.display = texto.includes(filtro) ? '' : 'none';
                        });
                    });
                }

                const form_3 = document.querySelector('form#form_exclusao_lider_permanentemente');
                if (!form_3) return; // evita erro se o formulário não existir

                const checkboxes_3 = document.querySelectorAll('.checkbox-lider_2');
                const inputHidden_3 = document.getElementById('idLiderNovoTroca');

                function atualizarSelecaoUnica_3(event) {
                    checkboxes_3.forEach(cb => {
                        if (cb !== event.target) cb.checked = false;
                    });
                    const selecionado = Array.from(checkboxes_3)
                        .filter(cb => cb.checked)
                        .map(cb => cb.value)
                        .join(',');
                    inputHidden_3.value = selecionado;
                    console.log('Selecionado:', inputHidden.value);
                }

                checkboxes_3.forEach(cb => cb.addEventListener('change', atualizarSelecaoUnica_3));

                form_3.addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (!inputHidden_3.value) {
                        Swal.fire({
                            title: 'Atenção!',
                            text: 'Você precisa selecionar 1 líder.',
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

                // líderes
                const pesquisarInput = document.getElementById('pesquisarLider');
                if (pesquisarInput) {
                    pesquisarInput.addEventListener('input', function() {
                        const filtro = this.value.toLowerCase();
                        document.querySelectorAll('#listaLideres .form-check').forEach(div => {
                            const texto = div.innerText.toLowerCase();
                            div.style.display = texto.includes(filtro) ? '' : 'none';
                        });
                    });
                }

                const form = document.querySelector('form#trocar_lider_de_pg');
                if (!form) return; // evita erro se o formulário não existir

                const checkboxes = document.querySelectorAll('.checkbox-lider');
                const inputHidden = document.getElementById('idLiderNovo');

                function atualizarSelecaoUnica(event) {
                    checkboxes.forEach(cb => {
                        if (cb !== event.target) cb.checked = false;
                    });
                    const selecionado = Array.from(checkboxes)
                        .filter(cb => cb.checked)
                        .map(cb => cb.value)
                        .join(',');
                    inputHidden.value = selecionado;
                    console.log('Selecionado:', inputHidden.value);
                }

                checkboxes.forEach(cb => cb.addEventListener('change', atualizarSelecaoUnica));

                form.addEventListener('submit', function(e) {
                    e.preventDefault();

                    if (!inputHidden.value) {
                        Swal.fire({
                            title: 'Atenção!',
                            text: 'Você precisa selecionar 1 líder.',
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
                                form.submit();
                            }
                        });
                    }
                });

                // supervisores
                const pesquisarInput_2 = document.getElementById('pesquisarSupervisor');

                if (pesquisarInput_2) {
                    pesquisarInput_2.addEventListener('input', function() {
                        const filtro = this.value.toLowerCase();
                        document.querySelectorAll('#listaSupervisores .form-check').forEach(div => {
                            const texto = div.innerText.toLowerCase();
                            div.style.display = texto.includes(filtro) ? '' : 'none';
                        });
                    });
                }

                const form_2 = document.querySelector('form#troca_de_coordenador_supervisor');
                if (!form_2) return; // evita erro se o formulário não existir

                const checkboxes_2 = document.querySelectorAll('.checkbox-supervisor');
                const inputHidden_2 = document.getElementById('id_troca_2');

                function atualizarSelecaoUnica_2(event) {
                    checkboxes_2.forEach(cb => {
                        if (cb !== event.target) cb.checked = false;
                    });
                    const selecionado = Array.from(checkboxes_2)
                        .filter(cb => cb.checked)
                        .map(cb => cb.value)
                        .join(',');
                    inputHidden_2.value = selecionado;
                    console.log('Selecionado:', inputHidden_2.value);
                }

                checkboxes_2.forEach(cb => cb.addEventListener('change', atualizarSelecaoUnica_2));

                form_2.addEventListener('submit', function(e) {
                    if (!inputHidden_2.value) {
                        e.preventDefault();
                        Swal.fire({
                            title: 'Atenção!',
                            text: 'Você precisa selecionar 1 líder.',
                            icon: 'warning',
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#198754',
                        });
                    }
                });
            });
        </script>

        <script src="<?php echo base_url('import/sistema/dist/js/fotos.js'); ?>"></script>
    </body>

    </html>
<?php }
?>
