<?php
if (!isset($_SESSION['usuario'])) {
    header("location: ../../index");
} else {

    $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
    $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

    require_once(APPPATH . '../import/sistema/links_treinamentos.php');

    $voltar = "../";
    $array = array('voltar' => $voltar);

    $dados_usuario = $this->Supervisores->infos([$id_usuario], 'info_supervisor', '', '');

    $carga_horaria = $_SESSION['carga_horaria'] ?? "";
    $data_treinamento = $_SESSION['data_treinamento'] ?? "";

    $dia_de1 = $_SESSION['dia_de_1'] ?? "";
    $dia_a1 = $_SESSION['dia_ate_1'] ?? "";

    date_default_timezone_set('America/Sao_Paulo');
    $ano = date('Y');
    $mes_atual = date('m');

    $mes = array('Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro');
    $i = $mes_atual[0] == '0' ? $mes_atual[1] : $mes_atual;
    $x = $i - 1;

    $ano_session_o = $_SESSION['ano_session'] ?? "";
    $mes_session_o = $_SESSION['mes_session'] ?? "";

    $ano_session_2_o = $_SESSION['ano_session_2'] ?? "";
    $mes_session_2_o = $_SESSION['mes_session_2'] ?? "";

    $ano_session = $_SESSION['ano_session'] ?? $ano;
    $mes_session = $_SESSION['mes_session'] ?? $mes[$x];

    $ano_session_2 = $_SESSION['ano_session_2'] ?? $ano;
    $mes_session_2 = $_SESSION['mes_session_2'] ?? $mes[$x];

    $selected_mes = array('', '', '', '', '', '', '', '', '', '', '', '');
    $selected_mes_2 = array('', '', '', '', '', '', '', '', '', '', '', '');

    $y = 0;

    foreach ($mes as $key => $value) {
        if ($value == $mes_session) {
            $selected_mes[$y] = 'selected';
            $selected_mes_2[$y] = 'selected';
        } else {
        }

        $y++;
    }

    $check_cert_1 = "";
    $check_cert_2 = "";
    $check_cert_3 = "";

    if ($carga_horaria == '' || $data_treinamento == '' || $ano_session == '') {
        $check_cert_1 = "";
    } else {
        $check_cert_1 = "checked";
    }

    if ($dia_de1 == '' || $dia_a1 == '' || $ano_session_o == '' || $mes_session_o == '') {
        $check_cert_2 = "";
    } else {
        $check_cert_2 = "checked";
    }

    if ($ano_session_2 == '' || $mes_session_2_o == '') {
        $check_cert_3 = "";
    } else {
        $check_cert_3 = "checked";
    }
?>
    <!DOCTYPE html>
    <html>

    <?php
    $this->load->view('partes/head');
    ?>

    <script>
        function guardar_informacoes_1() {
            var cg_horaria = document.getElementById('cg_horaria').value;
            var dt_treinamento = document.getElementById('dt_treinamento').value;

            var check = document.getElementById('check_1');

            if (cg_horaria == '' || dt_treinamento == '') {
                alert('Dados Vazios!');
                check.checked = false;
            } else {
                if (check.checked) {
                    let data = {
                        session: 'carga_horaria',
                        valor: cg_horaria,
                    }

                    let data_2 = {
                        session: 'data_treinamento',
                        valor: dt_treinamento,
                    }

                    let ajax = new XMLHttpRequest();
                    let ajax2 = new XMLHttpRequest();

                    ajax.open('post', '../../atualizar_session');
                    ajax2.open('post', '../../atualizar_session');

                    /*ajax.onreadystatechange = function() {
                        if (
                            ajax.readyState == 4 &&
                            ajax.status >= 200 &&
                            ajax.status <= 400
                        ) {
                            let respostaAjax = JSON.parse(ajax.responseText);
                            // Aqui os dados já foram tratados.
                            // Faça o que quiser com eles:
                            console.log(respostaAjax);
                        }
                    }*/

                    ajax.send(JSON.stringify(data));
                    ajax2.send(JSON.stringify(data_2));
                } else {
                    let data = {
                        session: 'carga_horaria',
                        valor: '',
                    }

                    let data_2 = {
                        session: 'data_treinamento',
                        valor: '',
                    }

                    let ajax = new XMLHttpRequest();
                    let ajax2 = new XMLHttpRequest();

                    ajax.open('post', '../../atualizar_session');
                    ajax2.open('post', '../../atualizar_session');

                    ajax.send(JSON.stringify(data));
                    ajax2.send(JSON.stringify(data_2));
                }
            }
        }

        function guardar_informacoes_2() {
            var de_1 = document.getElementById('de_1').value;
            var ate_1 = document.getElementById('ate_1').value;
            var mes_1 = document.getElementById('mes_1').value;
            var ano_1 = document.getElementById('ano_1').value;

            var check = document.getElementById('check_2');

            if (de_1 == '' || ate_1 == '' || mes_1 == '' || ano_1 == '') {
                alert('Dados Vazios!');
                check.checked = false;
            } else {
                if (check.checked) {
                    let data = {
                        session: 'dia_de_1',
                        valor: de_1,
                    }

                    let data_2 = {
                        session: 'dia_ate_1',
                        valor: ate_1,
                    }

                    let data_3 = {
                        session: 'mes_session',
                        valor: mes_1,
                    }

                    let data_4 = {
                        session: 'ano_session',
                        valor: ano_1,
                    }

                    let ajax = new XMLHttpRequest();
                    let ajax2 = new XMLHttpRequest();
                    let ajax3 = new XMLHttpRequest();
                    let ajax4 = new XMLHttpRequest();

                    ajax.open('post', '../../atualizar_session');
                    ajax2.open('post', '../../atualizar_session');
                    ajax3.open('post', '../../atualizar_session');
                    ajax4.open('post', '../../atualizar_session');

                    ajax.send(JSON.stringify(data));
                    ajax2.send(JSON.stringify(data_2));
                    ajax3.send(JSON.stringify(data_3));
                    ajax4.send(JSON.stringify(data_4));
                } else {
                    let data = {
                        session: 'dia_de_1',
                        valor: '',
                    }

                    let data_2 = {
                        session: 'dia_ate_1',
                        valor: '',
                    }

                    let data_3 = {
                        session: 'mes_session',
                        valor: '',
                    }

                    let data_4 = {
                        session: 'ano_session',
                        valor: '',
                    }

                    let ajax = new XMLHttpRequest();
                    let ajax2 = new XMLHttpRequest();
                    let ajax3 = new XMLHttpRequest();
                    let ajax4 = new XMLHttpRequest();

                    ajax.open('post', '../../atualizar_session');
                    ajax2.open('post', '../../atualizar_session');
                    ajax3.open('post', '../../atualizar_session');
                    ajax4.open('post', '../../atualizar_session');

                    ajax.send(JSON.stringify(data));
                    ajax2.send(JSON.stringify(data_2));
                    ajax3.send(JSON.stringify(data_3));
                    ajax4.send(JSON.stringify(data_4));
                }
            }
        }



        function guardar_informacoes_3() {
            var mes_1 = document.getElementById('mes_2').value;
            var ano_1 = document.getElementById('ano_2').value;

            var check = document.getElementById('check_3');

            if (mes_1 == '' || ano_1 == '') {
                alert('Dados Vazios!');
                check.checked = false;
            } else {
                if (check.checked) {

                    let data = {
                        session: 'mes_session',
                        valor: mes_1,
                    }

                    let data_2 = {
                        session: 'ano_session',
                        valor: ano_1,
                    }

                    let ajax = new XMLHttpRequest();
                    let ajax2 = new XMLHttpRequest();

                    ajax.open('post', '../../atualizar_session');
                    ajax2.open('post', '../../atualizar_session');

                    ajax.send(JSON.stringify(data));
                    ajax2.send(JSON.stringify(data_2));
                } else {

                    let data = {
                        session: 'mes_session',
                        valor: '',
                    }

                    let data_2 = {
                        session: 'ano_session',
                        valor: '',
                    }

                    let ajax = new XMLHttpRequest();
                    let ajax2 = new XMLHttpRequest();

                    ajax.open('post', '../../atualizar_session');
                    ajax2.open('post', '../../atualizar_session');

                    ajax.send(JSON.stringify(data));
                    ajax2.send(JSON.stringify(data_2));
                }
            }
        }
    </script>

    <style>
        .centertext a {
            color: white;
            text-align: center;
        }

        .centertext a:hover {
            color: white;
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
                        Material de Apoio para Treinamentos
                        <small>Painel de Controle</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="../home"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Treinamento</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12">
                            <div class="info-box bg-green">
                                <span class="info-box-icon"><i class="fa fa-link"></i></span>
                                <div class="info-box-content">
                                    <h4 class="widget-user-username centertext"><br>
                                        <a href="<?= $link_info_treinamentos; ?>" target="_blank" class="texto">
                                            PDF com Informações sobre Cursos
                                        </a>
                                    </h4>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-md-4">
                            <!-- Widget: user widget style 1 -->
                            <div class="box box-widget widget-user">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-aqua-active">
                                    <h3 class="widget-user-username">LOL 1</h3>
                                    <h5 class="widget-user-desc">Treinamento Automático para Formação de Líderes</h5>
                                </div>
                                <div class="widget-user-image">
                                    <br><img class="img-circle" src="<?php echo base_url('import/logo/logo lol 1.png'); ?>" alt="User Avatar">
                                </div>
                                <div class="box-footer no-padding">
                                    <ul class="nav nav-stacked"><br><br>
                                        <li><a href="<?= $link_lol1_automatico; ?>" target="_blank" onclick="copiarTexto('<?= $link_lol1_automatico; ?>');"><i class="fa fa-link"></i> Link do Curso</a></li>
                                    </ul>

                                    <p id="text_sucess"></p>
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <!-- Widget: user widget style 1 -->
                            <div class="box box-widget widget-user">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-orange-active">
                                    <h3 class="widget-user-username">LOL 2</h3>
                                    <h5 class="widget-user-desc">Curso Intensivo para Solidificação de Líderes de Pequenos Grupos</h5>
                                </div>
                                <div class="widget-user-image">
                                    <br><img class="img-circle" src="<?php echo base_url('import/logo/logo lol 2.png'); ?>" alt="User Avatar">
                                </div>
                                <div class="box-footer no-padding">
                                    <ul class="nav nav-stacked"><br><br>
                                        <li><a href="<?= $link_lol2; ?>" target="_blank" onclick="copiarTexto('<?= $link_lol2; ?>');"><i class="fa fa-link"></i> Link do Curso</a></li>
                                    </ul>
                                    <p id="text_sucess"></p>
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-4">
                            <!-- Widget: user widget style 1 -->
                            <div class="box box-widget widget-user">
                                <!-- Add the bg color to the header using any of the bg-* classes -->
                                <div class="widget-user-header bg-purple-active">
                                    <h3 class="widget-user-username">Presencial</h3>
                                    <h5 class="widget-user-desc">Arquivos para Treinamento Presencial</h5>
                                </div>
                                <div class="widget-user-image">
                                    <br><img class="img-circle" src="<?php echo base_url('import/logo/logo presencial.png'); ?>" alt="User Avatar">
                                </div>
                                <div class="box-footer no-padding">
                                    <ul class="nav nav-stacked"><br><br>
                                        <li><a href="<?= $link_treinamento_presencial; ?>" target="_blank"><i class="fa fa-link"></i> Link dos PDF</a></li>
                                    </ul>
                                    <p id="text_sucess"></p>
                                </div>
                            </div>
                            <!-- /.widget-user -->
                        </div>
                        <!-- /.col -->
                    </div>

                    <!-- row -->
                    <div class="row">
                        <!-- LINE 3 -->
                        <div class="col-md-12">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Certificado Curso LOL 2</h3>
                                </div>
                                <div class="box-body">
                                    <form action="../../gerar_certificado" method="POST">
                                        <input type="hidden" name="opc" value="3">
                                        <input type="hidden" name="img" value="<?= $treinamento_3_1_img; ?>">
                                        <input type="hidden" name="img2" value="<?= $treinamento_3_2_img; ?>">
                                        <div class="col-lg-12">
                                            <div class="col-xs-6">
                                                <label for="">Nome</label>
                                                <input type="text" class="form-control" placeholder="Nome" name="nome" required>
                                            </div>
                                            <div class="col-xs-3">
                                                <label for="">Mês</label>
                                                <select name="mes_2" id="mes_2" class="form-control">
                                                    <?php
                                                    $s = 0;

                                                    foreach ($mes as $key => $value) {
                                                    ?>
                                                        <option value="<?= $value; ?>" <?= $selected_mes_2[$s]; ?>><?= $value; ?></option>
                                                    <?php $s++;
                                                    } ?>
                                                </select>
                                            </div>
                                            <div class="col-xs-3">
                                                <label for="">Ano</label>
                                                <input type="text" class="form-control" placeholder="Ano" minlength="4" maxlength="4" name="ano_2" id="ano_2" value="<?= $ano_session_2; ?>" required>
                                            </div>
                                        </div>

                                        <div class="box-footer">
                                            <br>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="check_3" onclick="guardar_informacoes_3();" <?= $check_cert_3; ?>> Lembrar Informações
                                                </label>
                                            </div>

                                            <button type="submit" class="btn btn-info pull-right">Preenhcer</button>
                                    </form>

                                    <form action="../../download" method="POST">
                                        <input type="hidden" name="nome" value="Certificado Treinamento LOL 2.png">
                                        <input type="hidden" name="download" value="<?= $treinamento_3_1_img; ?>">
                                        <button type="submit" class="btn btn-success">Download Imagem</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- LINE 3 -->

                        <!-- LINE 1 -->
                        <div class="col-md-12">
                            <div class="box box-danger">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Certificado Curso Presencial</h3>
                                </div>
                                <div class="box-body">
                                    <form action="../../gerar_certificado" method="POST">
                                        <input type="hidden" name="opc" value="1">
                                        <input type="hidden" name="img" value="<?= $treinamento_1_img; ?>">
                                        <input type="hidden" name="nome_user" value="<?= $dados_usuario['dados']['nome_supervisorR'] ?>">
                                        <div class="col-xs-5">
                                            <label for="">Nome</label>
                                            <input type="text" class="form-control" placeholder="Nome" name="nome" required>
                                        </div>
                                        <div class="col-xs-4">
                                            <label for="">Carga Horária</label>
                                            <input type="text" class="form-control" placeholder="Carga Horária" name="carga_horaria" id="cg_horaria" value="<?= $carga_horaria; ?>" required>
                                        </div>
                                        <div class="col-xs-3">
                                            <label for="">Data</label>
                                            <input type="text" class="form-control" placeholder="Data (DD/MM/YYYY)" minlength="10" maxlength="10" name="data_treinamento" id="dt_treinamento" value="<?= $data_treinamento; ?>" required>
                                        </div>

                                        <div class="box-footer">
                                            <br>
                                            <div class="checkbox">
                                                <label>
                                                    <input type="checkbox" id="check_1" onclick="guardar_informacoes_1();" <?= $check_cert_1; ?>> Lembrar Informações
                                                </label>
                                            </div>

                                            <button type="submit" class="btn btn-info pull-right">Preenhcer</button>
                                    </form>

                                    <form action="../../download" method="POST">
                                        <input type="hidden" name="nome" value="Certificado Treinamento Presencial.png">
                                        <input type="hidden" name="download" value="<?= $treinamento_1_img; ?>">
                                        <button type="submit" class="btn btn-success">Download Imagem</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- LINE 1 -->
            </div>
            <!-- row -->

            <section class="content">
                <div class="row">
                    <!-- LINE 2 -->
                    <div class="col-md-12">
                        <div class="box box-danger">
                            <div class="box-header with-border">
                                <h3 class="box-title">Certificado Curso LOL 1</h3>
                            </div>
                            <div class="box-body">
                                <form action="../../gerar_certificado" method="POST">
                                    <input type="hidden" name="opc" value="2">
                                    <input type="hidden" name="img" value="<?= $treinamento_2_img; ?>">
                                    <input type="hidden" name="nome_user" value="<?= $dados_usuario['dados']['nome_supervisorR']; ?>">
                                    <input type="hidden" name="estado" value="<?= $dados_usuario['dados']['estado']; ?>">
                                    <input type="hidden" name="cidade" value="<?= $dados_usuario['dados']['cidade']; ?>">
                                    <div class="col-lg-12">
                                        <div class="col-xs-6">
                                            <label for="">Nome</label>
                                            <input type="text" class="form-control" placeholder="Nome" name="nome" required>
                                        </div>
                                        <div class="col-xs-3">
                                            <label for="">De</label>
                                            <input type="text" class="form-control" placeholder="De" minlength="2" maxlength="2" name="de_1" id="de_1" value="<?= $dia_de1; ?>" required>
                                        </div>
                                        <div class="col-xs-3">
                                            <label for="">Até</label>
                                            <input type="text" class="form-control" placeholder="Até" minlength="2" maxlength="2" name="ate_1" id="ate_1" value="<?= $dia_a1; ?>" required>
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="col-xs-6">
                                            <label for="">Mês</label>
                                            <select name="mes_1" id="mes_1" class="form-control">
                                                <?php
                                                $s = 0;

                                                foreach ($mes as $key => $value) {
                                                ?>
                                                    <option value="<?= $value; ?>" <?= $selected_mes[$s]; ?>><?= $value; ?></option>
                                                <?php $s++;
                                                } ?>
                                            </select>
                                        </div>
                                        <div class="col-xs-6">
                                            <label for="">Ano</label>
                                            <input type="text" class="form-control" placeholder="Ano" minlength="4" maxlength="4" name="ano_1" id="ano_1" value="<?= $ano_session; ?>" required>
                                        </div>
                                    </div>

                                    <div class="box-footer">
                                        <br>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" id="check_2" onclick="guardar_informacoes_2();" <?= $check_cert_2; ?>> Lembrar Informações
                                            </label>
                                        </div>

                                        <button type="submit" class="btn btn-info pull-right">Preenhcer</button>
                                </form>

                                <form action="../../download" method="POST">
                                    <input type="hidden" name="nome" value="Certificado Treinamento LOL 1.png">
                                    <input type="hidden" name="download" value="<?= $treinamento_2_img; ?>">
                                    <button type="submit" class="btn btn-success">Download Imagem</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- LINE 2 -->
                </div>
            </section>
            </section>
        </div>
        <!-- /.content -->
        <?php
        $this->load->view('partes/footer');
        ?>
        </div>

        <!-- Footer -->
        <?php
        $this->load->view('partes/scripts2');
        ?>

        <div class="control-sidebar-bg"></div>

        <script>
            let copiarTexto = (texto) => {
                //O texto que será copiado
                //const texto = "00020126470014br.gov.bcb.pix0125campbrasilemail@gmail.com27600016BR.COM.PAGSEGURO013659BAD104-74E5-4E29-8EE8-9738E5D5784A5204000053039865802BR5925CAMP - CENTRO DE APOIO MI6007Caucaia62290525PAGS0000000002404131224896304431F";
                //Cria um elemento input (pode ser um textarea)
                let inputTest = document.createElement("input");
                inputTest.value = texto;
                //Anexa o elemento ao body
                document.body.appendChild(inputTest);
                //seleciona todo o texto do elemento
                inputTest.select();
                //executa o comando copy
                //aqui é feito o ato de copiar para a area de trabalho com base na seleção
                document.execCommand('copy');
                //remove o elemento
                document.body.removeChild(inputTest);

                document.getElementById('text_sucess').innerHTML = 'Código Copiado!';

                function msgEncerramento() {
                    document.getElementById('text_sucess').innerHTML = '';
                }

                setTimeout(msgEncerramento, 3000);
            };
        </script>
    </body>

    </html>
<?php
} ?>
