<?php

/** @var \$this */
$voltar = "../";
$array = array('voltar' => $voltar);

if (!isset($_SESSION['usuario'])) {
  header("location: ../../index");
} else {

  require_once(APPPATH . '../import/sistema/materiais/materiais_1_trilha.php');
  require_once(APPPATH . '../import/sistema/materiais/materiais_2_mergulho.php');
  require_once(APPPATH . '../import/sistema/materiais/materiais_3_santuario.php');
  require_once(APPPATH . '../import/sistema/materiais/materiais_4_arco.php');
  require_once(APPPATH . '../import/sistema/materiais/materiais_5_estacao.php');
  require_once(APPPATH . '../import/sistema/materiais/materiais_6_exped_ani_1_os_segredos.php');

  $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
  $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

  date_default_timezone_set('America/Sao_Paulo');
  $data = date("d/m/Y");

  $id_pg = $this->input->post('id_pg');
  $id_lider = $this->input->post('id_lider');
  $id_modulo = $this->input->post('id_modulo');

  $CI = &get_instance();
  $CI->load->model('FConsultas_model');
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
      $this->load->view('sistema/lider/partes/menu_lateral', $array);
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
            <li><a href="<?= $voltar ?>page/download"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Download do Material | CAMP Brasil</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">

          <div class="row">
            <?php

            $consultarPG = $this->FConsultas_model->mostrarPGDownload($id_usuario, 2);
            $dadosModulos = $this->FConsultas_model->consultarModuloId($id_modulo);

            $nome_modulo = $dadosModulos['nome_modulo'];
            $aprenderemos = $dadosModulos['aprenderemos'];
            $descricao = $dadosModulos['descricao'];

            $color_h3 = 'black';

            $materialCapa = array();
            $materialCards = array();
            $materialLicao = array();

            switch ($id_modulo) {
              case 1:
                array_push($materialCapa, $materialCapaTrilha);
                array_push($materialCapa, $materialContraCapaTrilha);
                array_push($materialCards, $materialCardsTrilha);
                array_push($materialCards, $materialSemanarioTrilha);
                array_push($materialLicao, $materialIntroducaoTrilha);
                array_push($materialLicao, $materialLicaoTrilha);
                array_push($materialLicao, $materialLicaoVisuaisTrilha2);
                array_push($materialLicao, $materialLicaoVisuaisTrilha1);
                break;
              case 2:
                array_push($materialCapa, $materialCapaMergulho);
                array_push($materialCapa, $materialContraCapaMergulho);
                array_push($materialCards, $materialCardsMergulho);
                array_push($materialCards, $materialSemanarioMergulho);
                array_push($materialLicao, $materialIntroducaoMergulho);
                array_push($materialLicao, $materialLicaoMergulho);
                array_push($materialLicao, $materialLicaoVisuaisMergulho2);
                array_push($materialLicao, $materialLicaoVisuaisMergulho1);
                break;
              case 3:
                array_push($materialCapa, $materialCapaSantuario);
                array_push($materialCapa, $materialContraCapaSantuario);
                array_push($materialCards, $materialCardsSantuario);
                array_push($materialCards, $materialSemanarioSantuario);
                array_push($materialLicao, $materialIntroducaoSantuario);
                array_push($materialLicao, $materialLicaoSantuario);
                array_push($materialLicao, $materialLicaoVisuaisSantuario2);
                array_push($materialLicao, $materialLicaoVisuaisSantuario1);
                break;
              case 4:
                array_push($materialCapa, $materialCapaArco);
                array_push($materialCapa, $materialContraCapaArco);
                array_push($materialCards, $materialCardsArco);
                array_push($materialCards, $materialSemanarioArco);
                array_push($materialLicao, $materialIntroducaoArco);
                array_push($materialLicao, $materialLicaoArco);
                array_push($materialLicao, $materialLicaoVisuaisArco2);
                array_push($materialLicao, $materialLicaoVisuaisArco1);
                break;
              case 5:
                array_push($materialCapa, $materialCapaEstacao);
                array_push($materialCapa, $materialContraCapaEstacao);
                array_push($materialCards, $materialCardsEstacao);
                array_push($materialCards, $materialSemanarioEstacao);
                array_push($materialLicao, $materialIntroducaoEstacao);
                array_push($materialLicao, $materialLicaoEstacao);
                array_push($materialLicao, $materialLicaoVisuaisEstacao2);
                array_push($materialLicao, $materialLicaoVisuaisEstacao1);
                break;
              case 6:
                array_push($materialCapa, $materialCapaSegredos);
                array_push($materialCapa, $materialContraCapaSegredos);
                array_push($materialCards, $materialCardsSegredos);
                array_push($materialCards, $materialSemanarioSegredos);
                array_push($materialLicao, $materialIntroducaoSegredos);
                array_push($materialLicao, $materialLicaoSegredos);
                array_push($materialLicao, $materialLicaoVisuaisSegredos2);
                array_push($materialLicao, $materialLicaoVisuaisSegredos1);
                break;
              case 7:
                $color_modulo = 'orange';
                $color_h3 = 'black';
                break;
              case 8:
                $color_modulo = 'navy';
                $color_h3 = 'black';
                break;
              case 9:
                $color_modulo = 'brown';
                $color_h3 = 'black';
                break;
              case 10:
                $color_modulo = 'brown-active';
                $color_h3 = 'black';
                break;
              default:
                $color_modulo = 'green';
                $color_h3 = 'black';
                break;
            }

            $xPG = $consultarPG['row'];
            if ($xPG == 0) {
            ?>

              <div class="col-md-12">
                <div class="box box-danger">
                  <div class="box-body chat"><br>
                    <div class="callout callout-danger">
                      <h4>
                        Você não tem nenhum PG Cadastrado!
                      </h4>
                      <p>Cadastre para fazer o download do material</p>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>

              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="box bg-info">
                    <div class="box-header with-border">
                      <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | <?= $aprenderemos; ?></h3>
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
                      <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-list"></i> <?= $nome_modulo; ?> | Lições</h3>
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
                      <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Capa e Contra Capa</h3>
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
                          <div class="succ not-active">
                            <div class="img-center">
                              <img src="<?php echo base_url($capas['capa']); ?>" title="Capa" class="img-capa" alt="User Image">
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
                      <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Lição</h3>
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
                          <div class="succ not-active">
                            <div class="img-center">
                              <img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>" class="img-capa" alt="User Image">
                            </div>
                            <label for=""><?= $licao['nome_visivel']; ?></label>
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
              if ($materialCards) {
              ?>
                <div class="col-md-6">
                  <div class="small-box bg-info">
                    <div class="box-header with-border">
                      <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Versículos e Mistérios e Devocional Diário</h3>
                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                      </div>
                    </div>
                    <div class="box-body chat" id="linha">
                      <?php
                      foreach ($materialCards as $key => $cards) {
                      ?>
                        <div class="succ not-active">
                          <div class="img-center">
                            <img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $cards['nome']; ?>" class="img-capa" alt="User Image">
                          </div>
                          <label for=""><?= $cards['nome']; ?></label>
                        </div>
                      <?php } ?>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>
              <?php } else {
              } ?>

            <?php } else { ?>
              <?php

              $idPG = $consultarPG['dados']['id_pg'];

              $consultarCriancas = $this->FConsultas_model->mostrarCriancasPaisPg($id_usuario, $idPG, 2);
              $xChildren = $consultarCriancas['row'];
              if ($xChildren == 0) {
              ?>
                <div class="col-md-12">
                  <div class="box box-danger">
                    <div class="box-body chat"><br>
                      <div class="callout callout-danger">
                        <h4>
                          Você não tem nenhuma criança cadastrada!
                        </h4>
                        <p>Cadastre pelo menos uma criança para ter acesso ao material.</p>
                      </div>
                    </div>
                  </div>
                  <!-- /.box-body -->
                </div>

                <div class="col-md-12">
                  <div class="col-md-6">
                    <div class="box bg-info">
                      <div class="box-header with-border">
                        <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | <?= $aprenderemos; ?></h3>
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
                        <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-list"></i> <?= $nome_modulo; ?> | Lições</h3>
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
                        <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Capa e Contra Capa</h3>
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
                            <div class="succ not-active">
                              <div class="img-center">
                                <img src="<?php echo base_url($capas['capa']); ?>" title="Capa" class="img-capa" alt="User Image">
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
                        <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Lição</h3>
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
                            <div class="succ not-active">
                              <div class="img-center">
                                <img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>" class="img-capa" alt="User Image">
                              </div>
                              <label for=""><?= $licao['nome_visivel']; ?></label>
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
                if ($materialCards) {
                ?>
                  <div class="col-md-6">
                    <div class="small-box bg-info">
                      <div class="box-header with-border">
                        <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Versículos e Mistérios e Devocional Diário</h3>
                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                        </div>
                      </div>
                      <div class="box-body chat" id="linha">
                        <?php
                        foreach ($materialCards as $key => $cards) {
                        ?>
                          <div class="succ not-active">
                            <div class="img-center">
                              <img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $cards['nome']; ?>" class="img-capa" alt="User Image">
                            </div>
                            <label for=""><?= $cards['nome']; ?></label>
                          </div>
                        <?php } ?>
                      </div>
                    </div>
                    <!-- /.box-body -->
                  </div>
                <?php } else {
                } ?>

                <?php
              } else {

                $idModuloPG = $consultarPG['dados']['id_modulo'];

                if ($idModuloPG < $id_modulo) {
                ?>

                  <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="box bg-info">
                        <div class="box-header with-border">
                          <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | <?= $aprenderemos; ?></h3>
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
                          <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-list"></i> <?= $nome_modulo; ?> | Lições</h3>
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
                          <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Capa e Contra Capa</h3>
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
                              <div class="succ not-active">
                                <div class="img-center">
                                  <img src="<?php echo base_url($capas['capa']); ?>" title="Capa" class="img-capa" alt="User Image">
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
                          <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Lição</h3>
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
                              <div class="succ not-active">
                                <div class="img-center">
                                  <img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>" class="img-capa" alt="User Image">
                                </div>
                                <label for=""><?= $licao['nome_visivel']; ?></label>
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
                  if ($materialCards) {
                  ?>
                    <div class="col-md-6">
                      <div class="small-box bg-info">
                        <div class="box-header with-border">
                          <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Versículos e Mistérios e Devocional Diário</h3>
                          <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                          </div>
                        </div>
                        <div class="box-body chat" id="linha">
                          <?php
                          foreach ($materialCards as $key => $cards) {
                          ?>
                            <div class="succ not-active">
                              <div class="img-center">
                                <img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $cards['nome']; ?>" class="img-capa" alt="User Image">
                              </div>
                              <label for=""><?= $cards['nome']; ?></label>
                            </div>
                          <?php } ?>
                        </div>
                      </div>
                      <!-- /.box-body -->
                    </div>
                  <?php } else {
                  } ?>

                <?php
                } else {
                ?>
                  <!-- ATIVO -->
                  <div class="col-md-12">
                    <div class="col-md-6">
                      <div class="box bg-info">
                        <div class="box-header with-border">
                          <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | <?= $aprenderemos; ?></h3>
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
                          <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-list"></i> <?= $nome_modulo; ?> | Lições</h3>
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
                          <h3 class="box-title" style="color: <?= $color_h3; ?>;"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Capa e Contra Capa</h3>
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
                          <h3 class="box-title" style="color: <?= $color_h3; ?>; word-break: normal;"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Lição</h3>
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
                              if ($licao['id'] == 2 && $consultarPG['dados']['data_inicio'] == '') {
                          ?>
                                <div class="succ">
                                  <a data-toggle="modal" data-target="<?= "#" . $licao['id']; ?>download" href="#">
                                    <div class="img-center">
                                      <img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>" class="img-capa" alt="User Image">
                                    </div>
                                    <label for=""><?= $licao['nome_visivel']; ?></label>
                                  </a>
                                </div>

                                <div class="modal fade" id="<?= $licao['id']; ?>download">
                                  <div class="modal-dialog modal-info">
                                    <div class="modal-content">
                                      <form action="../../download_material" method="post" target="_blank" id="form__submit">
                                        <input type="hidden" name="id" value="<?= $licao['id']; ?>">
                                        <input type="hidden" name="id_lider" value="<?= $id_usuario; ?>">
                                        <input type="hidden" name="id_pg" value="<?= $idPG; ?>">
                                        <input type="hidden" name="title" value="<?= $licao['nome']; ?>" style="color: black;">
                                        <input type="hidden" name="download" value="<?= $licao['arquivo']; ?>" style="color: black;">

                                        <div class="modal-header">
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                          <h4 class="modal-title">Download do Material | <?= $nome_modulo; ?></h4>
                                        </div>
                                        <div class="box-body">
                                          <div class="form-group" style="text-align: center;">
                                            <label for="exampleInputEmail1">Digite a data de início do PG</label>
                                            <p style="color: black;">Data: <input type="text" name="data" id="datepicker" autocomplete="off" required></p>
                                          </div>
                                        </div>
                                        <div class="modal-footer">
                                          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Sair</button>
                                          <input type="submit" class="btn btn-default" onclick="fecharModal();" value="Baixar">
                                        </div>

                                        <script>
                                          function fecharModal() {
                                            let form = document.getElementById("form__submit");
                                            form.submit();
                                            $('.modal').modal('hide');
                                            window.location.reload(true);
                                          }
                                        </script>
                                      </form>
                                    </div>
                                    <!-- /.modal-content -->
                                  </div>
                                  <!-- /.modal-dialog -->
                                </div>
                              <?php } else { ?>
                                <div class="succ">
                                  <form action="../../download_material" method="post" target="_blank" download>
                                    <input type="hidden" name="id" value="<?= $licao['id']; ?>">
                                    <input type="hidden" name="id_lider" value="<?= $id_usuario; ?>">
                                    <input type="hidden" name="id_pg" value="<?= $idPG; ?>">
                                    <input type="hidden" name="title" value="<?= $licao['nome']; ?>">
                                    <input type="hidden" name="download" value="<?= $licao['arquivo']; ?>">
                                    <div class="img-center">
                                      <button type="submit" style="background-color: transparent; border: none;">
                                        <img src="<?php echo base_url($licao['imagem']); ?>" title="<?= $licao['nome']; ?>" class="img-responsive img-capa" alt="User Image">
                                      </button>
                                    </div>
                                    <label for=""><?= $licao['nome_visivel']; ?></label>
                                  </form>
                                </div>
                              <?php } ?>
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
                          <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | Versículos e Mistérios e Devocional Diário</h3>
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
                                  <img src="<?php echo base_url('import/sistema/img/documento.png'); ?>" title="<?= $cards['nome']; ?>" class="img-capa" alt="User Image">
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
                <?php } ?>
              <?php } ?>
            <?php } ?>
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
      $(document).ready(function() {
        $("#todos").click(function() {
          var val = this.checked;
          $(".lista_sim").each(function() {
            $(this).prop('checked', val);
          });
        });
      });
    </script>
  </body>

  </html>
<?php } ?>