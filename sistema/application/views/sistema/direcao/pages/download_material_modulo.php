<?php

/** @var \$this */
$voltar = "../";
$array = array('voltar' => $voltar);

if (!isset($_SESSION['usuario'])) {
  header("location: https://sistemas.campbrasil.com/sistema/index");
} else {

  require_once(APPPATH . '../import/sistema/materiais/materiais_1_trilha.php');
  require_once(APPPATH . '../import/sistema/materiais/materiais_2_mergulho.php');
  require_once(APPPATH . '../import/sistema/materiais/materiais_3_santuario.php');
  require_once(APPPATH . '../import/sistema/materiais/materiais_4_arco.php');
  require_once(APPPATH . '../import/sistema/materiais/materiais_5_estacao.php');
  require_once(APPPATH . '../import/sistema/materiais/materiais_6_exped_ani_1_os_segredos.php');
  require_once(APPPATH . '../import/sistema/materiais/materiais_7_exped_ani_2_os_sobreviventes.php');
  require_once(APPPATH . '../import/sistema/materiais/materiais_8_exped_exploradores_do_subsolo.php');
  require_once(APPPATH . '../import/sistema/materiais/materiais_9_exped_verde_2_colheita.php');
  require_once(APPPATH . '../import/sistema/materiais/materiais_10_exped_verde_2_evolucao.php');
  require_once(APPPATH . '../import/sistema/materiais/materiais_11_organelas.php');

  $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
  $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

  date_default_timezone_set('America/Sao_Paulo');
  $data = date("d/m/Y");

  $id_lider = $this->input->post('id_lider');
  $id_modulo = $this->input->post('id_modulo');

  $dadosModulos = $this->FConsultas_model->consultarModuloId($id_modulo);

  $nome_modulo = $dadosModulos['nome_modulo'];
  $aprenderemos = $dadosModulos['aprenderemos'];
  $descricao = $dadosModulos['descricao'];
  ?>
  <!DOCTYPE html>
  <html>
  <!-- Head -->
  <?php
  $this->load->view('partes/head');
  ?>

  <style>
    #linha {
      height: 220px;
      display: flex;
      justify-content: center;
    }

    .not-active {
      /*width: 120px;
        margin: 2px;
        display: table-column;
        justify-content: center;
        align-content: center;
        text-align: center;*/

      pointer-events: none;
      cursor: default;
      color: red;
    }

    .succ {
      width: 120px;
      margin: 2px;
      display: table-column;
      justify-content: center;
      align-content: center;
      text-align: center;
    }

    .img-center {
      width: 100px;
      margin: 0 auto;
    }

    .img-capa {
      width: 100px;
      border-radius: 30px;
      height: 100px;
      display: flex;
      margin: 0 auto;
      justify-content: center;
      align-content: center;
    }

    #quadrado {
      height: 400px;
      margin-bottom: 10px;
    }

    @media (max-width: 360px) {
      #quadrado {
        height: 100%;
      }

      #linha {
        height: 100%;
        display: block;
        justify-content: center;
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
            Download do Material
            <small>Painel de Controle</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?= $voltar ?>home"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="<?= $voltar ?>page/download"><i class="fa fa-download"></i> Download do Material</a></li>
            <li class="active">Download do Material | <?= $nome_modulo; ?></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">

          <div class="row">
            <?php

            $color_h3 = 'black';

            $materialCapa = array();
            $materialCards = array();
            $materialLicao = array();
            $materialExtra = array();

            switch ($id_modulo) {
              case 1:
                array_push($materialCapa, $materialCapaTrilha);
                array_push($materialCapa, $materialContraCapaTrilha);
                array_push($materialCards, $materialCardsTrilha);
                array_push($materialCards, $materialSemanarioTrilha);
                array_push($materialLicao, $materialIntroducaoTrilha);
                array_push($materialLicao, $materialLicaoTrilha);
                array_push($materialLicao, $materialLicaoVisuaisTrilha2);
                array_push($materialLicao, $materialLicaoVisuaisTrilha3);
                array_push($materialLicao, $materialLicaoVisuaisTrilha1);
                array_push($materialExtra, $materialChequinhoTrilha);
                break;
              case 2:
                array_push($materialCapa, $materialCapaMergulho);
                array_push($materialCapa, $materialContraCapaMergulho);
                array_push($materialCards, $materialCardsMergulho);
                array_push($materialCards, $materialSemanarioMergulho);
                array_push($materialLicao, $materialIntroducaoMergulho);
                array_push($materialLicao, $materialLicaoMergulho);
                array_push($materialLicao, $materialLicaoVisuaisMergulho2);
                array_push($materialLicao, $materialLicaoVisuaisMergulho3);
                array_push($materialLicao, $materialLicaoVisuaisMergulho1);
                array_push($materialExtra, $materialChequinhoMergulho);
                break;
              case 3:
                array_push($materialCapa, $materialCapaSantuario);
                array_push($materialCapa, $materialContraCapaSantuario);
                array_push($materialCards, $materialCardsSantuario);
                array_push($materialCards, $materialSemanarioSantuario);
                array_push($materialLicao, $materialIntroducaoSantuario);
                array_push($materialLicao, $materialLicaoSantuario);
                array_push($materialLicao, $materialLicaoVisuaisSantuario2);
                array_push($materialLicao, $materialLicaoVisuaisSantuario3);
                array_push($materialLicao, $materialLicaoVisuaisSantuario1);
                array_push($materialExtra, $materialChequinhoSantuario);
                break;
              case 4:
                array_push($materialCapa, $materialCapaArco);
                array_push($materialCapa, $materialContraCapaArco);
                array_push($materialCards, $materialCardsArco);
                array_push($materialCards, $materialSemanarioArco);
                array_push($materialLicao, $materialIntroducaoArco);
                array_push($materialLicao, $materialLicaoArco);
                array_push($materialLicao, $materialLicaoVisuaisArco2);
                array_push($materialLicao, $materialLicaoVisuaisArco3);
                array_push($materialLicao, $materialLicaoVisuaisArco1);
                array_push($materialExtra, $materialChequinhoArco);
                break;
              case 5:
                array_push($materialCapa, $materialCapaEstacao);
                array_push($materialCapa, $materialContraCapaEstacao);
                array_push($materialCards, $materialCardsEstacao);
                array_push($materialCards, $materialSemanarioEstacao);
                array_push($materialLicao, $materialIntroducaoEstacao);
                array_push($materialLicao, $materialLicaoEstacao);
                array_push($materialLicao, $materialLicaoVisuaisEstacao2);
                array_push($materialLicao, $materialLicaoVisuaisEstacao3);
                array_push($materialLicao, $materialLicaoVisuaisEstacao1);
                array_push($materialExtra, $materialChequinhoEstacao);
                break;
              case 6:
                array_push($materialCapa, $materialCapaSegredos);
                array_push($materialCapa, $materialContraCapaSegredos);
                array_push($materialCards, $materialCardsSegredos);
                array_push($materialCards, $materialSemanarioSegredos);
                array_push($materialLicao, $materialIntroducaoSegredos);
                array_push($materialLicao, $materialLicaoSegredos);
                array_push($materialLicao, $materialLicaoVisuaisSegredos2);
                array_push($materialLicao, $materialLicaoVisuaisSegredos3);
                array_push($materialLicao, $materialLicaoVisuaisSegredos1);
                array_push($materialExtra, $materialChequinhoSegredos);
                break;
              case 7:
                array_push($materialCapa, $materialCapaSobreviventes);
                array_push($materialCapa, $materialContraCapaSobreviventes);
                array_push($materialCards, $materialCardsSobreviventes);
                array_push($materialCards, $materialSemanarioSobreviventes);
                array_push($materialLicao, $materialIntroducaoSobreviventes);
                array_push($materialLicao, $materialLicaoSobreviventes);
                array_push($materialLicao, $materialLicaoVisuaisSobreviventes2);
                array_push($materialLicao, $materialLicaoVisuaisSobreviventes3);
                array_push($materialLicao, $materialLicaoVisuaisSobreviventes1);
                array_push($materialExtra, $materialChequinhoSobreviventes);
                break;
              case 8:
                array_push($materialCapa, $materialCapaTerrarios);
                array_push($materialCapa, $materialContraCapaTerrarios);
                array_push($materialCards, $materialCardsTerrarios);
                array_push($materialCards, $materialSemanarioTerrarios);
                array_push($materialLicao, $materialIntroducaoTerrarios);
                array_push($materialLicao, $materialLicaoTerrarios);
                array_push($materialLicao, $materialLicaoVisuaisTerrarios2);
                array_push($materialLicao, $materialLicaoVisuaisTerrarios3);
                array_push($materialLicao, $materialLicaoVisuaisTerrarios1);
                array_push($materialExtra, $materialChequinhoTerrarios);
                break;
              case 9:
                array_push($materialCapa, $materialCapaOperacao);
                array_push($materialCapa, $materialContraCapaOperacao);
                array_push($materialCards, $materialCardsOperacao);
                array_push($materialCards, $materialSemanarioOperacao);
                array_push($materialLicao, $materialIntroducaoOperacao);
                array_push($materialLicao, $materialLicaoOperacao);
                array_push($materialLicao, $materialLicaoVisuaisOperacao2);
                array_push($materialLicao, $materialLicaoVisuaisOperacao3);
                array_push($materialLicao, $materialLicaoVisuaisOperacao1);
                array_push($materialExtra, $materialChequinhoOperacao);
                break;
              case 10:
                array_push($materialCapa, $materialCapaEvolucao);
                array_push($materialCapa, $materialContraCapaEvolucao);
                array_push($materialCards, $materialCardsEvolucao);
                array_push($materialCards, $materialSemanarioEvolucao);
                array_push($materialLicao, $materialIntroducaoEvolucao);
                array_push($materialLicao, $materialLicaoEvolucao);
                array_push($materialLicao, $materialLicaoVisuaisEvolucao2);
                array_push($materialLicao, $materialLicaoVisuaisEvolucao3);
                array_push($materialLicao, $materialLicaoVisuaisEvolucao1);
                array_push($materialExtra, $materialChequinhoEvolucao);
                break;
              case 11:
                array_push($materialCapa, $materialCapaOrganelas);
                array_push($materialCapa, $materialContraCapaOrganelas);
                array_push($materialCards, $materialCardsOrganelas);
                array_push($materialCards, $materialSemanarioOrganelas);
                array_push($materialCards, $materialVersiculoOrganelas);
                array_push($materialLicao, $materialIntroducaoOrganelas);
                array_push($materialLicao, $materialLicaoOrganelas);
                array_push($materialLicao, $materialLicaoVisuaisOrganelas2);
                array_push($materialLicao, $materialLicaoVisuaisOrganelas1);
                array_push($materialCards, $materialComplementarOrganela);
                array_push($materialExtra, $materialComplementarJogo1);
                array_push($materialExtra, $materialComplementarJogo2);
                array_push($materialExtra, $materialComplementarJogo3);
                array_push($materialExtra, $materialComplementarJogo4);
                break;
              default:
                $color_modulo = 'green';
                $color_h3 = 'black';
                break;
            }

            ?>
            <!-- ATIVO -->
            <div class="col-md-12">
              <div class="col-md-6">
                <div class="box bg-info">
                  <div class="box-header with-border">
                    <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i>
                      <?= $nome_modulo; ?> | <?= $aprenderemos; ?></h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="box-body chat" id="quadrado">
                    <br>
                    <p style="text-align: justify;"><?= $descricao; ?></p>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>

              <div class="col-md-6">
                <div class="box bg-info">
                  <div class="box-header with-border">
                    <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-list"></i> <?= $nome_modulo; ?>
                      | Lições</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="box-body chat" id="quadrado">
                    <div class="tab-content">
                      <div class="tab-pane active">
                        <table class="table no-margin">
                          <tbody>
                            <?php
                            $licoes = $this->FConsultas_model->consultarLicaoModulo($id_modulo);
                            foreach ($licoes as $key => $dadosLicoes) {
                              $numero_licao = $dadosLicoes['numero_licao'];
                              $nome_licao = $dadosLicoes['nome_licao'];
                              ?>
                              <tr>
                                <td><?= $numero_licao; ?> - <?= $nome_licao; ?></td>
                              </tr>
                            <?php } ?>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
              </div>
            </div>

            <?php
            if ($materialCapa) {
              ?>
              <div class="col-md-6">
                <div class="small-box bg-info">
                  <div class="box-header with-border">
                    <h3 class="box-title" style="color: <?= $color_h3; ?>;"><i class="fa fa-download"></i>
                      <?= $nome_modulo; ?> | Capa e Contra Capa</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="box-body chat" id="linha">
                    <?php
                    foreach ($materialCapa as $key => $capas) {
                      if ($capas['capa'] == '') {
                      } else {
                        ?>
                        <div class="succ">
                          <div class="img-center">
                            <a href="<?php echo base_url($capas['capa']); ?>" target="_blank" download>
                              <img src="<?php echo base_url($capas['capa']); ?>" title="Capa" class="img-capa" alt="User Image">
                            </a>
                          </div>
                        </div>
                      <?php }
                    } ?>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            <?php } else {
            } ?>

            <?php
            if ($materialLicao) {
              ?>
              <div class="col-md-6">
                <div class="small-box bg-info">
                  <div class="box-header with-border">
                    <h3 class="box-title" style="color: <?= $color_h3; ?>; word-break: normal;"><i
                        class="fa fa-download"></i> <?= $nome_modulo; ?> | Lição</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="box-body chat" id="linha">
                    <?php
                    foreach ($materialLicao as $key => $licao) {

                      if ($licao['id'] == 0) {
                      } else {
                        ?>
                        <div class="succ">
                          <form action="../../download_material" method="post" target="_blank" download>
                            <input type="hidden" name="id" value="<?= $licao['id']; ?>">
                            <input type="hidden" name="id_lider" value="<?= $id_usuario; ?>">
                            <input type="hidden" name="nivel" value="2">
                            <input type="hidden" name="title" value="<?= $licao['nome']; ?>">
                            <input type="hidden" name="download" value="<?= $licao['arquivo']; ?>">
                            <div class="img-center">
                              <button type="submit" style="background-color: transparent; border: none;">
                                <img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>"
                                  class="img-responsive img-capa" alt="User Image">
                              </button>
                            </div>
                            <label for=""><?= $licao['nome_visivel']; ?></label>
                          </form>
                        </div>
                      <?php } ?>
                    <?php } ?>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            <?php } else {
            } ?>

            <?php
            if ($materialCards) {
              ?>
              <div class="col-md-6">
                <div class="small-box bg-info">
                  <div class="box-header with-border">
                    <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i>
                      <?= $nome_modulo; ?> | Versículos e Mistérios e Devocional Diário (Cards)</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="box-body chat" id="linha">
                    <?php
                    foreach ($materialCards as $key => $cards) {
                      ?>
                      <div class="succ">
                        <a href="<?php echo base_url($cards['arquivo']); ?>" target="_blank" download>
                          <div class="img-center">
                            <img src="<?php echo base_url('import/sistema/img/documento.png'); ?>"
                              title="<?= $cards['nome']; ?>" class="img-capa" alt="User Image">
                          </div>
                          <label for=""><?= $cards['nome']; ?></label>
                        </a>
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            <?php } else {
            } ?>
            <!-- /.box -->

            <?php
            if ($materialExtra) {
              ?>
              <div class="col-md-6">
                <div class="small-box bg-info">
                  <div class="box-header with-border">
                    <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i>
                      <?= $nome_modulo; ?> | Extra</h3>
                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="box-body chat" id="linha">
                    <?php
                    foreach ($materialExtra as $key => $extra) {
                      $link = base_url($extra['arquivo']);
                      if ($extra['id'] == 10) {
                        $link = $extra['arquivo'];
                      } else {
                      }
                      ?>
                      <div class="succ">
                        <a href="<?php echo $link; ?>" target="_blank" download>
                          <div class="img-center">
                            <img src="<?php echo base_url('import/sistema/img/documento.png'); ?>"
                              title="<?= $extra['nome']; ?>" class="img-capa" alt="User Image">
                          </div>
                          <label for=""><?= $extra['nome']; ?></label>
                        </a>
                      </div>
                    <?php } ?>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>
            <?php } else {
            } ?>
            <!-- /.box -->
          </div>
          <!-- /.row -->
        </section>
        <!-- /.content -->
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

    <script type="text/javascript">
      $(document).ready(function () {
        $("#todos").click(function () {
          var val = this.checked;
          $(".lista_sim").each(function () {
            $(this).prop('checked', val);
          });
        });
      });
    </script>
  </body>

  </html>
  <?php
} ?>