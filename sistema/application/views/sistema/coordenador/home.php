<?php

/** @var \$this */

$voltar = "";
$array = array('voltar' => $voltar);

if (!isset($_SESSION['usuario'])) {
  header("location: ../$voltar/index");
} else {

  $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
  $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";
  $dados_coordenador = $this->Coordenadores->infos([$id_usuario], 'info_coordenador', '', '', '');
?>

  <!DOCTYPE html>
  <html>
  <!-- Head -->
  <?php
  $this->load->view('partes/head');
  ?>

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
            Página Incial
            <small>Painel de Controle</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Página Inicial</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <!-- CADASTRAR CRIANÇA -->
            <div class="col-lg-4">
              <!-- small box -->
              <div class="small-box bg-aqua">
                <div class="inner">
                  <h4>Líderes</h4>
                  <br>
                  <a href="#" onclick="gerarELCopiarLinkCoordenador('<?= $id_usuario; ?>')" style="color:white;" class="small-box-footer">
                    <p>Copiar Link de Cadastro <i class="fa fa-link"></i></p>
                  </a>
                  <p id="text_sucess"></p>
                </div>
                <div class="icon">
                  <i class="fa fa-users"></i>
                </div>
                <a href="page/lideres" class="small-box-footer">Ver Mais <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-4 col-lg-offset-8"></div>

            <!-- PG -->
            <?php

            $dados = $this->PG->query([$id_usuario], 'query_pg_id_lider_all_ativo_or_no', 1);

            foreach ($dados['dados'] as $key => $dados_pg) {

              $id_pg_tabela = $dados_pg['id_pg'];
              $id_lider = $dados_pg['id_lider'];
              $id_ano = $dados_pg['ano'];
              $id_modulo = $dados_pg['id_modulo'];
              $n_licao = $dados_pg['n_licao'];
              $nome_pg = $dados_pg['nome_pg'];

              $color_modulo = '';
              $nome_modulo = '';

              switch ($id_modulo) {
                case 1:
                  $color_modulo = 'green';
                  $nome_modulo = 'Trilha';
                  break;
                case 2:
                  $color_modulo = 'blue';
                  $nome_modulo = 'Mergulho';
                  break;
                case 3:
                  $color_modulo = 'gray';
                  $nome_modulo = 'Santuário';
                  break;
                case 4:
                  $color_modulo = 'red';
                  $nome_modulo = 'Arco';
                  break;
                case 5:
                  $color_modulo = 'yellow';
                  $nome_modulo = 'Estação Final';
                  break;
                case 6:
                  $color_modulo = 'orange-active';
                  $nome_modulo = 'Os Segredos';
                  break;
                case 7:
                  $color_modulo = 'orange';
                  $nome_modulo = 'Os Sobreviventes';
                  break;
                case 8:
                  $color_modulo = 'navy';
                  $nome_modulo = 'Os Exploradores';
                  break;
                case 9:
                  $color_modulo = 'brown';
                  $nome_modulo = 'A Colheita';
                  break;
                case 10:
                  $color_modulo = 'brown-active';
                  $nome_modulo = 'A Evolução';
                  break;
                default:
                  $color_modulo = 'green';
                  $nome_modulo = '';
                  break;
              }
            ?>
              <div class="col-lg-4">
                <!-- small box -->
                <div class="small-box bg-<?= $color_modulo; ?>">
                  <div class="inner">
                    <h4>PG's</h4><br>
                    <p>
                      <?= $nome_modulo; ?>
                    </p>
                  </div>
                  <div class="icon">
                    <i class="ion ion-heart"></i>
                  </div>
                  <a href="page/pg" class="small-box-footer">Ver Mais <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
            <?php } ?>

            <div class="col-lg-4 col-lg-offset-8"></div>

            <!-- Download do Material -->
            <div class="col-lg-4">
              <!-- small box -->
              <div class="small-box bg-yellow">
                <div class="inner">
                  <h4>Download</h4><br>
                  <p>Download do Material</p>
                </div>
                <div class="icon">
                  <i class="fa fa-download"></i>
                </div>
                <a href="page/download" class="small-box-footer">Ver Mais <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
          </div>
          <!-- /.row -->

          <?php
          $check_situacao_cadastro_lider = $this->Lideres->infos([$id_usuario, 1], 'check_lider_situacao_cadastro_id_coordenador', '', '', '');

          if ($check_situacao_cadastro_lider['row'] == 0) {
          } else {
          ?>

            <div class="row">
              <div class="col-md-12">
                <div class="box box-default">
                  <div class="box-header with-border">
                    <i class="fa fa-warning"></i>

                    <h3 class="box-title">Alertas</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">

                    <input type="hidden" id="btn_enviar_c" value="">

                    <?php
                    if ($check_situacao_cadastro_lider['row'] == 0) {
                    } else {
                    ?>
                      <div class="alert alert-info alert-dismissible">
                        <h4><i class="icon fa fa-info"></i> Novo líder cadastrado</h4>
                        <?php
                        foreach ($check_situacao_cadastro_lider['dados'] as $key => $dados_l) {
                        ?>
                          <?= $dados_l['nome_lider']; ?>, se cadastrou no sistema
                          <a href="#" style="text-decoration: none;" data-toggle="modal" data-target="#modal-default-<?= $dados_l['id_lider'] ?>">
                            <span class="label label-default">Liberar</span>
                          </a>
                          <div class="modal fade" id="modal-default-<?= $dados_l['id_lider'] ?>">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                  <?php
                                  $date1 = date('d/m/Y', strtotime($dados_l['data_cadastro']));
                                  ?>
                                  <h4 class="modal-title" style="color: black;">Autorizar Líder (Data de Cadastro <?= $date1; ?>)</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="box-body">
                                    <div class="col-lg-12">
                                      <div class="form-group has-feedback">
                                        <input type="text" class="form-control" name="nome" minlength="5" placeholder="Nome" value="<?= $dados_l['nome_lider']; ?>" disabled>
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                      </div>
                                    </div>

                                    <div class="col-lg-6">
                                      <div class="form-group has-feedback">
                                        <input type="email" class="form-control" placeholder="Email" name="email" value="<?= $dados_l['email']; ?>" disabled>
                                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                      </div>
                                    </div>

                                    <div class="col-lg-6">
                                      <div class="form-group has-feedback">
                                        <input type="text" class="form-control" placeholder="CPF" minlength="11" name="cpf" minlength="11" value="<?= $dados_l['cpf']; ?>" disabled>
                                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                      </div>
                                    </div>

                                    <div class="col-lg-6">
                                      <div class="form-group has-feedback">
                                        <input type="text" class="form-control" placeholder="Telefone do Colíder (DDD + Telefone)" minlength="11" name="telefone" value="<?= $dados_l['telefone_whatsapp']; ?>" disabled>
                                        <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                                      </div>
                                    </div>

                                    <div class="col-lg-6">
                                      <div class="form-group has-feedback">
                                        <input type="text" class="form-control" placeholder="Data de Nascimento (DD/MM/YYYY)" minlength="10" maxlength="10" name="nascimento" value="<?= $dados_l['nascimento']; ?>" disabled>
                                        <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                                      </div>
                                    </div>

                                    <div class="col-lg-12">
                                      <div class="col-lg-4">
                                        <div class="form-group has-feedback">
                                          <?php
                                          $p = $dados_l['pais'];
                                          $nome_pais = "";
                                          if ($p == 'br' ||  $p == '') {
                                            $nome_pais = "Brasil";
                                          } else {
                                            $nome_pais = $p;
                                          }
                                          ?>
                                          <input type="text" id="estaods2" class="form-control" placeholder="Pais" name="pais" value="<?= $nome_pais; ?>" disabled>
                                          <span id="icon_outros" class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                        </div>
                                      </div>
                                      <div class="col-lg-4">
                                        <div class="form-group has-feedback">
                                          <input type="text" id="estaods2" class="form-control" placeholder="Estado" name="estados2" value="<?= $dados_l['estado']; ?>" disabled>
                                          <span id="icon_outros" class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                        </div>
                                      </div>
                                      <div class="col-lg-4">
                                        <div class="form-group has-feedback">
                                          <input type="text" id="cidades2" class="form-control" placeholder="Cidade" name="cidades2" value="<?= $dados_l['cidade']; ?>" disabled>
                                          <span id="icon_outros" class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                        </div>
                                      </div>
                                    </div>

                                    <div class="col-lg-12">
                                      <div class="form-group has-feedback">
                                        <input type="text" class="form-control" placeholder="Igreja" minlength="5" name="igreja" value="<?= $dados_l['igreja']; ?>" disabled>
                                        <span class="glyphicon glyphicon-home form-control-feedback"></span>
                                      </div>
                                    </div>

                                  </div>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                                  <form action="page/lider/liberar" method="post">
                                    <input type="hidden" name="id_lider" value="<?= $dados_l['id_lider']; ?>">
                                    <input type="hidden" name="id_usuario" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="routa" value="home">
                                    <input type="submit" class="btn btn-success" value="Autorizar">
                                  </form>
                                </div>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                          </div>
                          <br>
                        <?php } ?>
                      </div>
                    <?php } ?>

                    <!-- <div class="alert alert-warning alert-dismissible">
                        <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                        Warning alert preview. This alert is dismissable.
                      </div> -->
                    <!--<div class="alert alert-danger alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                      Danger alert preview. This alert is dismissable. A wonderful serenity has taken possession of my entire
                      soul, like these sweet mornings of spring which I enjoy with my whole heart.
                    </div>
                    <div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h4><i class="icon fa fa-check"></i> Alert!</h4>
                      Success alert preview. This alert is dismissable.
                    </div> -->
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /.box -->
              </div>
              <!-- /.col -->
            </div>

          <?php } ?>
          <!-- /.row -->
        </section>

        <?php
        $dados = $this->PG->query([$id_usuario], 'query_id_lider_ativo_order_by_modulo_asc_limit_1_download_material', 1);

        foreach ($dados['dados'] as $key => $pg) {
          $diaComecou = $pg['data_semana'];

          if ($diaComecou == '' || $diaComecou == '00') {
          } else {
        ?>
            <!-- Main content -->
            <section class="content">
              <!-- Small boxes (Stat box) -->
              <div class="row" style="height: 600px;">
                <!-- CRIANÇAS -->
                <div class="box box-info">
                  <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-heart"></i> Tempo de Conversa</h3>

                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="box-body chat" style="height: 600px;">
                    <?php
                    $id_modulo_pg = $pg['id_modulo'];
                    $licao_pg = $pg['n_licao'];

                    $ano_pg = $pg['ano_devocional'];
                    $id_modulo = $pg['modulo_devocional'];
                    $n_licao = $pg['licao_devocional'];

                    $dataHj = date('m/d/Y');

                    $dataSemana = "";

                    $dia = $diaComecou[0] . $diaComecou[1];
                    $mes = $diaComecou[3] . $diaComecou[4];
                    $ano = $diaComecou[6] . $diaComecou[7] . $diaComecou[8] . $diaComecou[9];
                    $data_trocada = $mes . "/" . $dia . "/" . $ano;

                    $dia1 = date('m/d/Y', strtotime('+1 day', strtotime($data_trocada)));
                    $dia2 = date('m/d/Y', strtotime('+2 day', strtotime($data_trocada)));
                    $dia3 = date('m/d/Y', strtotime('+3 day', strtotime($data_trocada)));
                    $dia4 = date('m/d/Y', strtotime('+4 day', strtotime($data_trocada)));
                    $dia5 = date('m/d/Y', strtotime('+5 day', strtotime($data_trocada)));
                    $dia6 = date('m/d/Y', strtotime('+6 day', strtotime($data_trocada)));

                    $check_day_1 = strtotime($dia1) == strtotime($dataHj) ? true : false;
                    $check_day_2 = strtotime($dia2) <= strtotime($dataHj) ? true : false;
                    $check_day_3 = strtotime($dia3) <= strtotime($dataHj) ? true : false;
                    $check_day_4 = strtotime($dia4) <= strtotime($dataHj) ? true : false;
                    $check_day_5 = strtotime($dia5) <= strtotime($dataHj) ? true : false;
                    $check_day_6 = strtotime($dia6) <= strtotime($dataHj) ? true : false;

                    $checkNPreencheu = $licao_pg == $n_licao ? false : true;

                    $diaDevocional = "";

                    if ($check_day_1) {
                      $diaDevocional = 1;
                    } else if ($check_day_2) {
                      $diaDevocional = 2;
                    } else if ($check_day_3) {
                      $diaDevocional = 3;
                    } else if ($check_day_4) {
                      $diaDevocional = 4;
                    } else if ($check_day_5) {
                      $diaDevocional = 5;
                    } else if ($check_day_6) {
                      $diaDevocional = 6;
                    }

                    $dadosDevocionais = $this->FConsultas_model->consultarDevocionalModuloLicaoDia($ano_pg, $id_modulo, $n_licao, 2);
                    $devocionais = $dadosDevocionais;

                    if ($devocionais) {
                      $file = $devocionais['file'];
                    ?>
                      <div>
                        <?php
                        if ($checkNPreencheu) { ?>

                          <div class="col-md-12">
                            <div class="box box-danger">
                              <div class="box-body chat"><br>
                                <div class="callout callout-danger">
                                  <h4>
                                    Lembre-se de manter o relatório atualizado!
                                  </h4>
                                </div>
                              </div>
                            </div>
                            <!-- /.box-body -->
                          </div>

                        <?php
                        } else {
                        }
                        ?>
                      </div>
                      <div class="col-md-12">
                        <img src="<?= base_url($file); ?>" alt="" style="width: 100%; height: 100%; background-size: cover;">
                      </div>

                      <!-- /.tab-content -->
                    <?php } else { ?>

                      <div class="col-md-12">
                        <div class="box box-danger">
                          <div class="box-body chat"><br>
                            <div class="callout callout-danger">
                              <h4>
                                Estamos trabalhando nisso! Adicionando novos Tempos de Conversa!
                              </h4>
                              <p>Tente novamente mais tarde!
                              </p>
                            </div>
                          </div>
                        </div>
                        <!-- /.box-body -->
                      </div>
                    <?php
                    }

                    ?>
                  </div>
                  <!-- /.item -->
                </div>
                <!-- /.box-body -->
              </div>
              <!-- /.box -->
            </section><br>
            <!-- /.content -->
        <?php }
        } ?>
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

    <script>
      function gerarELCopiarLinkCoordenador(id_usuario) {
        fetch(`<?= base_url('Coordenador/criar_link/'); ?>${id_usuario}`)
          .then(response => response.json())
          .then(data => {
            if (data.link) {
              copiarTexto(data.link);
            } else {
              alert('Erro ao gerar o link.');
            }
          })
          .catch(() => alert('Falha na requisição.'));
      }

      function copiarTexto(texto) {
        let inputTest = document.createElement("input");
        inputTest.value = texto;
        document.body.appendChild(inputTest);
        inputTest.select();
        document.execCommand('copy');
        document.body.removeChild(inputTest);

        document.getElementById('text_sucess').innerHTML = 'Código Copiado!';

        setTimeout(() => {
          document.getElementById('text_sucess').innerHTML = '';
        }, 3000);
      }
    </script>

  </body>

  </html>
<?php
} ?>
