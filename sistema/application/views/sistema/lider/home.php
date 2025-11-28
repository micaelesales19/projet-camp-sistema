<?php
$voltar = "";
$array = array('voltar' => $voltar);

if (!isset($_SESSION['usuario'])) {
  header("location: https://sistemas.campbrasil.com/sistema/index");
} else {

  $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
  $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";
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

      $this->load->view('sistema/lider/partes/menu_lateral', $array);
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
              <div class="small-box bg-red">
                <div class="inner">
                  <h4>Crianças</h4><br>
                  <p>Cadastrar</p>
                </div>
                <div class="icon">
                  <i class="fa fa-child"></i>
                </div>
                <?php
                $consultarPG = $this->PG->query([$id_usuario], 'query_pg_id_lider_all_ativo_or_no', 1);

                if ($consultarPG['row'] == 0) {
                ?>
                  <a href="#" onclick="alerta();" class="small-box-footer">Cadastrar <i class="fa fa-arrow-circle-right"></i></a>
                  <script>
                    function alerta() {
                      if (window.confirm("Você ainda não cadastrou seu PG! Cadastre Agora!")) {
                        window.location = "page/pg";
                      } else {
                        window.location = "";
                      }
                    }
                  </script>
                <?php
                } else {
                ?>
                  <a href="page/criancas" class="small-box-footer">Ver Mais <i class="fa fa-arrow-circle-right"></i></a>
                <?php } ?>
              </div>
            </div>
            <!-- ./col -->

            <div class="col-lg-4 col-lg-offset-8"></div>

            <!-- PG -->
            <?php
            $query_consulta_pg = $this->db->query("SELECT * FROM pg WHERE id_lider LIKE $id_usuario AND ativo = 1");
            $consultar_pg = $query_consulta_pg->result_array();

            foreach ($consultar_pg as $key => $dados_pg) {

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
        </section>

        <?php

        $dados = $this->PG->query([$id_usuario], 'query_id_lider_ativo_order_by_modulo_asc_limit_1_download_material', 1);

        if ($dados['row'] == 0) {
        } else {

          $pg = $dados['dados'];
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
  </body>

  </html>
<?php } ?>
