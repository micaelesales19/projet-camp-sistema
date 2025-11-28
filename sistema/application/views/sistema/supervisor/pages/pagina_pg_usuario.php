<script>
    const idpg = [];
    const idmodulo = [];
    const idmoduloslist = [];
    const anomodulo = [];
    const datasemana = [];
</script>

<?php

// se quiser a query string também:
$url_redirecionamento = current_url() . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '');

/** @var \$this */
if (!isset($_SESSION['usuario'])) {
    header("location: https://sistemas.campbrasil.com/sistema/index");
} else {

    $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
    $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

    $voltar = "../";
    $array = array('voltar' => $voltar);

    $dados_supervisor = $this->Supervisores->infos([$id_usuario], 'info_supervisor', '', '');

    // id lider // opc // ativo
    $consultarPG = $this->PG->query([$id_usuario], 'query_lider_ativo_order_by_nome_pg_asc', 1);

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
    <!DOCTYPE html>
    <html>

    <?php
    $this->load->view('partes/head');
    ?>

    <style>
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
                        Meu PG
                        <small>Painel de Controle</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="../home"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Meu PG</li>
                    </ol>
                </section>
                <?php

                $pg = $this->PG->query([$id_usuario], 'query_lider_ativo_order_by_nome_pg_asc', 1);
                $pg_desativados = $this->PG->query([$id_usuario], 'query_pg_id_lider_all_ativo_or_no', 0);

                if ($pg['row'] == 0 && $pg_desativados['row'] == 0) {
                ?>
                    <div class="box-body chat"><br>
                        <div class="callout callout-danger">
                            <h4>
                                Você não tem nenhum PG!
                            </h4>
                            <p>Cadastre</p>
                        </div>
                        <center>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cadastro_pg">Cadastrar +</button>
                        </center>
                    </div>
                <?php
                } else if ($pg['row'] == 0 && $pg_desativados['row'] != 0) {
                ?> <div class="box-body chat"><br>
                        <div class="callout callout-danger">
                            <h4>
                                Você não tem nenhum PG Ativo! Mas tem PG Desativado!
                            </h4>
                            <p>Cadastre</p>
                        </div>
                        <center>
                            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cadastro_pg">Cadastrar +</button>
                            <button type="button" style="margin-left: 5px;" class="btn btn-light pull-rigth" data-toggle="modal" data-target="#pg_desativados">PG Desativados</button>
                        </center>


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
                                                    <form action="pg/exclusao/ativar" method="POST">
                                                        <input type="hidden" name="id_pg" id="id_pg_escolhido_1" value="<?= $pg_desativados['dados'][0]['id_pg']; ?>">
                                                        <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                        <input type="hidden" name="idLider" value="<?= $id_usuario; ?>">
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
                                                    <form action="pg/exclusao/permanente" method="POST">
                                                        <input type="hidden" name="id_pg" id="id_pg_escolhido_2" value="<?= $pg_desativados['dados'][0]['id_pg']; ?>">
                                                        <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                        <input type="hidden" name="idLider" value="<?= $id_usuario; ?>">
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
                                                                                <form action="pg/exclusao/ativar" method="POST">
                                                                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                                                                                    <input type="hidden" name="id_pg" id="id_pg_escolhido_1" value="<?= $pg_desativados['dados'][0]['id_pg']; ?>">
                                                                                    <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                                                    <input type="hidden" name="idLider" value="<?= $id_usuario; ?>">
                                                                                    <center>
                                                                                        <label for="opc">Opção 1:</label><br>
                                                                                        <input type="submit" class="btn btn-success" value="Ativar">
                                                                                    </center>
                                                                                </form>
                                                                            </div>
                                                                        </div>

                                                                        <div class="col-lg-4">
                                                                            <div class="form-group">
                                                                                <form action="pg/exclusao/permanente" method="POST">
                                                                                    <input type="hidden" name="id_pg" id="id_pg_escolhido_2" value="<?= $pg_desativados['dados'][0]['id_pg']; ?>">
                                                                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                                                                                    <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                                                                                    <input type="hidden" name="idLider" value="<?= $id_usuario; ?>">
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

                                                    $dados_criancas = $this->Criancas->query([$id_usuario], 'query_id_lider');

                                                    $disabled = $dados_criancas['row'] == 1 ? 'disabled' : '';

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
                                                                            <form action="pg/edicao/salvar" method="post" enctype="multipart/form-data">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="modal-title">Edição | PG</h4>
                                                                                </div>
                                                                                <div class="box-body">

                                                                                    <input type="hidden" name="idPg" id="id_pg<?= $i ?>" value="<?= $dadosPG['id_pg']; ?>">
                                                                                    <input type="hidden" name="fotoOriginal" value="<?= $dadosPG['foto']; ?>">
                                                                                    <input type="hidden" name="idLider" value="<?= $id_usuario; ?>">

                                                                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

                                                                                    <div class="col-lg-12" style="display: flex; justify-content: center;">
                                                                                        <div class="col-lg-4">
                                                                                            <div class="form-group">
                                                                                                <label for="exampleInputEmail1">Foto (Opcional)</label>

                                                                                                <div class="imageContainer">
                                                                                                    <img src="<?= $foto; ?>" alt="Selecione uma imagem" style="width: 200px; height: 200px;" class="imgPhoto1" id="imgPhoto1<?= $i; ?>">
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
                                                                            <form action="pg/exclusao/desativar" method="post">
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
                                                                <a href="#" class="btn btn-info pull-left" onclick="document.getElementById('form_preencher_relatorio<?= $i; ?>').submit();">Preencher Relatório </a>

                                                                <form action="pg/licoes" id="form_preencher_relatorio<?= $i; ?>" method="post">
                                                                    <input type="hidden" name="id_pg" value="<?= $dadosPG['id_pg']; ?>">
                                                                    <input type="hidden" name="id_lider" value="<?= $id_usuario; ?>">
                                                                    <input type="hidden" name="ano" value="<?= $dadosPG['ano']; ?>">
                                                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                                                                    <input type="hidden" name="routa" value="pg">
                                                                </form>
                                                            </td>

                                                            <td>
                                                                <button type="button" class="btn btn-light pull-left" data-toggle="modal" data-target="#<?= $dadosPG['id_pg']; ?>_troca_de_lider_pg">Troca Liderança</button>

                                                                <div class="modal fade" id="<?= $dadosPG['id_pg']; ?>_troca_de_lider_pg">
                                                                    <div class="modal-dialog modal-light">
                                                                        <form action="trocar-liderenca" method="POST" id="trocar_lider_de_pg">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span></button>
                                                                                    <h4 class="modal-title">Troca de Líder de PG</h4>
                                                                                </div>
                                                                                <div class="box-body">
                                                                                    <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                                                                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                                                                    <input type="hidden" name="id_lider" value="<?= $id_usuario; ?>">
                                                                                    <input type="hidden" name="id_pg" value="<?= $dadosPG['id_pg']; ?>">

                                                                                    <input type="hidden" name="id_lider_novo" id="idLiderNovo">

                                                                                    <label for="id_lider_troca">Selecione a nova liderança para esse PG:</label>

                                                                                    <!-- Caixa de pesquisa -->
                                                                                    <input type="text" id="pesquisarLider" class="form-control mb-3" placeholder="Pesquisar Líder..."><br>

                                                                                    <!-- Lista de líderes -->
                                                                                    <div id="listaLideres" style="max-height: 300px; overflow-y: auto;">
                                                                                        <?php
                                                                                        // exemplo: buscando do banco
                                                                                        /*$lideres = $this->db->query("SELECT id_lider, nome_lider FROM lider WHERE id_supervisorR = $id_usuario ORDER BY nome_lider ASC")->result_array();

                                                                                            foreach ($lideres as $l) {*/

                                                                                        $query = $this->db->query(" SELECT id_lider AS id, nome_lider AS nome, 'Líder' AS tipo FROM lider WHERE id_supervisorR = $id_usuario UNION SELECT id_coordenador AS id, nome_coordenador AS nome, 'Coordenador' AS tipo FROM coordenador WHERE id_supervisorR = $id_usuario ORDER BY nome ASC");
                                                                                        $lista = $query->result_array();
                                                                                        foreach ($lista as $l):
                                                                                        ?>
                                                                                            <div class="form-check">
                                                                                                <input class="form-check-input checkbox-lider" type="checkbox" value="<?= $l['id']; ?>" id="coord<?= $l['id']; ?>">
                                                                                                <label class="form-check-label" for="coord<?= $l['id']; ?>">
                                                                                                    <?= htmlspecialchars($l['nome']); ?>
                                                                                                </label>
                                                                                            </div>
                                                                                        <?php
                                                                                        endforeach; ?>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                                                                                    <input type="submit" id="btn_solicitar_2" class="btn btn-default pull-right" value="Solicitar">
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
                                                $criancas_desativadas = $this->Criancas->query([$id_usuario, 0, 'asc'], 'query_id_lider_ativo_order_by_nome_crianca');
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
                                                                                <form action="criancas/exclusao/ativar" method="POST">
                                                                                    <input type="hidden" name="opc" id="id_crianca_escolhido_1" value="<?= $criancas_desativadas['dados'][0]['id_crianca']; ?>">
                                                                                    <input type="hidden" name="idLider" value="<?= $id_usuario; ?>">
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
                                                                                <form action="criancas/exclusao/permanente" method="POST">
                                                                                    <input type="hidden" name="opc" id="id_crianca_escolhido_2" value="<?= $criancas_desativadas['dados'][0]['id_crianca']; ?>">
                                                                                    <input type="hidden" name="idLider" value="<?= $id_usuario; ?>">
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
                                                                    <input type="submit" class="btn btn-default pull-right" value="Ativar">
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

                                            if ($dados_criancas['row'] == 0) {
                                            ?>

                                                <div class="box-body chat"><br>
                                                    <div class="callout callout-warning">
                                                        <h4>
                                                            Você não tem nenhuma criança!
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

                                                            $consultaCriancas = $this->Criancas->query([$id_usuario, $dadosPG['id_pg'], 1, 'asc'], 'query_id_lider_id_pg_ativo_order_by_nome_crianca');

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
                                                                            <form action="criancas/edicao/salvar" method="post">
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
                                                                                                    $nome_pai = $dados_supervisor['dados']['nome_supervisorR'];

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
                                                                                                            input_1.value = "<?php echo $dados_supervisor['dados']['nome_supervisorR']; ?>";
                                                                                                            input_2.value = "<?php echo $dados_supervisor['dados']['email']; ?>";
                                                                                                            input_3.value = "<?php echo $dados_supervisor['dados']['telefone_whatsapp']; ?>";

                                                                                                            input_1_desativados.value = "<?php echo $dados_supervisor['dados']['nome_supervisorR']; ?>";
                                                                                                            input_2_desativados.value = "<?php echo $dados_supervisor['dados']['email']; ?>";
                                                                                                            input_3_desativados.value = "<?php echo $dados_supervisor['dados']['telefone_whatsapp']; ?>";

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
                                                            <form action="criancas/gerar/relatorio" target="_blank" method="post">
                                                                <input type="hidden" name="id" value="<?= $id_usuario; ?>">
                                                                <input type="hidden" name="nivel" value="2">
                                                                <input type="hidden" name="iscood" value="true">

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
                                    $total_crianca = $this->Criancas->query([$id_usuario, 1, 'asc'], 'query_id_lider_ativo_order_by_nome_crianca');
                                    ?>
                                    <div class="item">
                                        <h4 style="text-align: center; font-weight: bold;"> PG - <?= $dadosPG['nome_pg']; ?></h4>
                                        <h4 style="text-align: center;"> Quantidade de Crianças - <?= $total_crianca['row']; ?></h4>
                                    </div>

                                    <div id="conteudos_table"></div>
                                </div>
                                <!-- /.item -->
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </section>
                <?php } ?>
            </div>
            <?php
            $this->load->view('partes/footer');
            ?>
        </div>

        <!-- /.content -->

        <!-- Footer -->
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
                    <form action="criancas/cadastro/salvar" method="POST">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Cadastro | Crianças</h4>
                        </div>
                        <div class="box-body">
                            <input type="hidden" name="id_lider" value="<?= $id_usuario; ?>">
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
                                            $consultarPG = $this->PG->query([$id_usuario], 'query_pg_id_lider_all', '');

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
                                            <option value="<?= $dados_supervisor['dados']['nome_supervisorR'] ?>" selected><?= $dados_supervisor['dados']['nome_supervisorR'] ?></option>
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

                    $(conteudo).append('<br><hr><div class="col-lg-12"><div class="form-group"><label for="nomeCrianca">Nome da Criança</label><input class="form-control" id="nomeCrianca" type="text" name="nome[]" placeholder="Nome da Criança" required></div></div><div class="col-lg-12"><div class="form-group"><label for="dataDeNascimento">Data de Nascimento (DD/MM/YYYY)</label><input class="form-control" type="text" id="dataDeNascimento" name="nascimento[]" placeholder="Data de Nascimento (DD/MM/YYYY)" maxlength="10" minlength="10"></div></div><div class="col-lg-12"><div class="col-lg-6"><div class="form-group"><label for="exampleInputEmail1">É Cristão?</label><select name="opcao[]" class="form-control" required><option value="0" selected>Escolha uma opção</option><option value="1">Sim</option><option value="2">Não</option></select></div></div><div class="col-lg-6"><div class="form-group"><label for="exampleInputEmail1">Responsável da Criança:</label><select name="responsavel_crianca[]" id="isRespon_' + i + '" onchange="mostrarCamposPais(' + i + ');" class="form-control" required><option value="<?= $dados_supervisor['dados']['nome_supervisorR'] ?>" selected><?= $dados_supervisor['dados']['nome_supervisorR'] ?></option><option value="outro">Outro</option></select></div></div></div><div class="col-lg-12" id="' + linhaResponsaveis + '" style="display: none;"><div class="col-lg-4"><div class="form-group"><label for="exampleInputEmail1">Nome do Responsável (Obrigatório):</label><input class="form-control" type="text" minlength="5" name="nome_responsavel[]" placeholder="Nome do Responsável"></div></div><div class="col-lg-4"><div class="form-group"><label for="exampleInputEmail1">E-mail do Responsável:</label><input class="form-control" type="text" name="email_responsavel[]" placeholder="E-mail do Responsável"></div></div><div class="col-lg-4"><div class="form-group"><label for="exampleInputEmail1">Telefone do Responsável:</label><input class="form-control" type="text" name="telefone_responsavel[]" minlength="11" placeholder="Telefone do Responsável"></div></div></div><div class="col-lg-12"><label for="observacao">Observação</label><textarea id="observacao" name="obs[]" class="form-control"></textarea></div><hr><br><input type="hidden" value="1" id="total_cri" name="total[]">');
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

        <?php
        $this->load->view('partes/scripts2');
        ?>
        <!-- Links JavaScript -->

        <div class="control-sidebar-bg"></div>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
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
            });
        </script>
    </body>

    </html>
<?php
} ?>
