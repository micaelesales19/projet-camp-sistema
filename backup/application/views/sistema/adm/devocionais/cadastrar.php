<!DOCTYPE html>
<?php
/** @var \$this */

$voltar = "../";
$array = array('voltar' => $voltar);
?>
<html lang="en">
<!-- Head -->
<?php
$this->load->view('partes/head');
?>

<script type="text/javascript" class="init">
    $(function() {
        mostrar_numeros_rifa();
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

    function mostrar_numeros_rifa() {
        var idRifa = '<?= $rifa['id']; ?>';
        var nome = document.getElementById('nomes').value == '' ? "" : document.getElementById('nomes').value;
        var email = document.getElementById('emails').value == '' ? "" : document.getElementById('emails').value;
        var telefone = document.getElementById('telefones').value == '' ? "" : document.getElementById('telefones').value;

        var clicable = 'false';

        if (nome == '' || telefone == '') {
            clicable = 'false';
        } else {
            clicable = 'true';
        }

        $.get('mostrar_numeros.php?idRifa=' + idRifa + '&nome=' + nome + "&email=" + email + "&telefone=" + telefone + "&clicable=" + clicable, function(numeros) {
            $('#numeros').html(numeros);
        });
    }

    function atualizarNumero(numero, idRifa, nome, email, telefone) {

        var pedido = '<?= $pedido; ?>';

        var controller = document.getElementById('controller_' + numero).value;

        var check = controller == 1 ? 0 : 1;
        let item = document.getElementById('quadrado_' + numero);

        if (check == 1) {
            item.classList.add('checked');
        } else {
            item.classList.remove('checked');
        }

        var ajax = AjaxF();

        ajax.open("GET", "adicionando.php?idRifa=" + idRifa + "&nome=" + nome + "&email=" + email + "&telefone=" + telefone + "&pedido=" + pedido + "&numero=" + numero + "&x=" + check, false);
        ajax.setRequestHeader("Content-Type", "text/html");
        ajax.send();

        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4) {
                document.getElementById('conteudos_rifa').innerHTML = ajax.responseText;
            }
        }

        document.getElementById('controller_' + numero).value = check;
    }

    $(function() {
        mostrar_numeros_rifa();
    });
</script>

<style>
    .form-control-feedback {
        margin-right: 20px;
    }

    #table {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }
</style>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <!-- Menu -->
        <?php
        $this->load->view('sistema/adm/partes/menu_lateral', $array);
        ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    Devocionais
                    <small>Painel de Controle</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                    <li class="active">Devocionais</li>
                </ol>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Cadastro de Devocionais</h3>
                            </div>
                            <form action="salvar" method="post" name="form_cadastro_lider" enctype="multipart/form-data">
                                <div class="box-body">
                                    <div class="col-lg-6" id="table">
                                        <div class="col-lg-4">
                                            <div class="form-group has-feedback">
                                                <label for="">Ano</label>
                                                <select name="id_ano" class="form-control">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                </select>
                                                <span class="glyphicon glyphicon-align-justify form-control-feedback"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group has-feedback">
                                                <label for="">Módulo</label>
                                                <select name="id_modulo" class="form-control">
                                                    <option value="3">Santuário</option>
                                                    <option value="1">Trilha</option>
                                                    <option value="2">Mergulho</option>
                                                    <option value="4">Arco</option>
                                                    <option value="5">Estação Final</option>
                                                </select>
                                                <span class="glyphicon glyphicon-align-justify form-control-feedback"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6" id="table">

                                        <div class="col-lg-4">
                                            <div class="form-group has-feedback">
                                                <label for="">Lição</label>
                                                <select name="n_licao" class="form-control">
                                                    <option value="1">1</option>
                                                    <option value="2">2</option>
                                                    <option value="3">3</option>
                                                    <option value="4">4</option>
                                                    <option value="5">5</option>
                                                    <option value="6">6</option>
                                                    <option value="7">7</option>
                                                    <option value="8">8</option>
                                                    <option value="9">9</option>
                                                    <option value="10">10</option>
                                                </select>
                                                <span class="glyphicon glyphicon-align-justify form-control-feedback"></span>
                                            </div>
                                        </div>

                                        <div class="col-lg-4">
                                            <div class="form-group has-feedback">
                                                <label for="">Dia</label>
                                                <select name="dia" class="form-control">
                                                    <option value="1">01</option>
                                                    <option value="2">02</option>
                                                    <option value="3">03</option>
                                                    <option value="4">04</option>
                                                    <option value="5">05</option>
                                                    <option value="6">06</option>
                                                </select>
                                                <span class="glyphicon glyphicon-align-justify form-control-feedback"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" name="titulo" minlength="5" placeholder="Titulo" value="Construção 1">
                                            <span class="glyphicon glyphicon-text-width form-control-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" name="titulo_ingles" minlength="5" placeholder="Titulo em Inglês" value="Construction 1">
                                            <span class="glyphicon glyphicon-text-width form-control-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" name="texto" minlength="5" placeholder="Texto">
                                            <span class="glyphicon glyphicon-text-width form-control-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" name="texto_ingles" minlength="5" placeholder="Texto em Inglês">
                                            <span class="glyphicon glyphicon-text-width form-control-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" name="imagem_url" minlength="5" placeholder="Imagem URL">
                                            <span class="glyphicon glyphicon-link form-control-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" name="imagem_url_ingles" minlength="5" placeholder="Imagem URL em Inglês">
                                            <span class="glyphicon glyphicon-link form-control-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" name="file" minlength="5" placeholder="File">
                                            <span class="glyphicon glyphicon-floppy-disk form-control-feedback"></span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group has-feedback">
                                            <input type="text" class="form-control" name="file_ingles" minlength="5" placeholder="File em Inglês">
                                            <span class="glyphicon glyphicon-floppy-disk form-control-feedback"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <button type="submit" class="btn btn-success">Salvar</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </section>
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
    $this->load->view('partes/scripts');
    ?>
</body>

</html>