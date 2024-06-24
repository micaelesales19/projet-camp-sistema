<?php

/** @var \$this */
if (!isset($_SESSION['usuario'])) {
  header("location: ../../index");
} else {

  $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
  $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

  $voltar = "../";
  $array = array('voltar' => $voltar);

  date_default_timezone_set('America/Sao_Paulo');
  $data = date("d/m/Y");

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
    .not-active {
      pointer-events: none;
      cursor: default;
      color: red;
    }

    .quadrados {
      height: 300px;
      margin-bottom: 10px;
    }
  </style>

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
            Download do Material
            <small>Painel de Controle</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?= $voltar ?>home"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Download do Material | CAMP Brasil</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">

            <!-- MATERIAL DE APOIO -->
            <div class="col-md-12">
              <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title"><i class="fa fa-download"></i> Material de Apoio</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <div class="box-body chat">
                  <p style="text-align: center;">Um material extra oferecido pelo CAMP Brasil.</p>
                  <div class="col-md-4">
                    <div class="box box-primary box-solid">
                      <p>
                        <center>
                          <a href="<?php echo base_url('import/sistema/arquivos/logo_jpg.jpg'); ?>" target="_blank" download> Logo CAMP Brasil</a><br>
                        </center>
                      </p>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box box-primary box-solid">
                      <p>
                        <center>
                          <a href="<?php echo base_url('import/sistema/arquivos/logo.png'); ?>" target="_blank" download> Logo CAMP Brasil (Fundo Transparente)</a><br>
                        </center>
                      </p>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="box box-primary box-solid">
                      <p>
                        <center>
                          <a href="<?php echo base_url('import/sistema/arquivos/02/album-figurinhas.pdf'); ?>" target="_blank" download> Álbum de Figurinhas 2º Ciclo</a><br>
                        </center>
                      </p>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
            </div>

            <?php

            $modulos = $this->FConsultas_model->consultarModulo();

            foreach ($modulos as $key => $dadosModulos) {
              $id_modulo = $dadosModulos['id_modulo'];
              $nome_modulo = $dadosModulos['nome_modulo'];
              $aprenderemos = $dadosModulos['aprenderemos'];
              $descricao = $dadosModulos['descricao'];

              $color_modulo = '';
              $color_h3 = '';

              switch ($id_modulo) {
                case 1:
                  $color_modulo = 'green';
                  $color_h3 = 'white';
                  break;
                case 2:
                  $color_modulo = 'blue';
                  $color_h3 = 'white';
                  break;
                case 3:
                  $color_modulo = 'gray';
                  $color_h3 = 'black';
                  break;
                case 4:
                  $color_modulo = 'red';
                  $color_h3 = 'white';
                  break;
                case 5:
                  $color_modulo = 'yellow';
                  $color_h3 = 'white';
                  break;
                case 6:
                  $color_modulo = 'orange-active';
                  $color_h3 = 'white';
                  break;
                case 7:
                  $color_modulo = 'orange';
                  $color_h3 = 'white';
                  break;
                case 8:
                  $color_modulo = 'navy';
                  $color_h3 = 'white';
                  break;
                case 9:
                  $color_modulo = 'brown';
                  $color_h3 = 'white';
                  break;
                case 10:
                  $color_modulo = 'brown-active';
                  $color_h3 = 'white';
                  break;
                default:
                  $color_modulo = 'green';
                  $color_h3 = 'white';
                  break;
              }

            ?>

              <div class="col-md-12" id="quadrado">
                <div class="box bg-<?= $color_modulo; ?>">
                  <div class="box-header with-border">
                    <h3 class="box-title" style="color: <?= $color_h3; ?>"><i class="fa fa-download"></i> <?= $nome_modulo; ?> | <?= $aprenderemos; ?></h3>

                    <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                    </div>
                  </div>
                  <div class="box-body chat" style="position: relative;">
                    <p style="text-align: justify;"><?= $descricao; ?></p>
                    <div class="col-md-4" style="left: 50%;transform: translate( -50%);">
                      <div class="box box-primary box-solid">
                        <p>

                          <center>
                            <a href="#" onclick="document.getElementById('download').submit();">Detalhe do material</a><br>

                            <form action="modulo" id="download" method="post">
                              <input type="hidden" name="id_lider" value="<?= $id_usuario; ?>">
                              <input type="hidden" name="id_modulo" value="<?= $id_modulo; ?>">
                            </form>
                          </center>
                        </p>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- /.box-body -->
              </div>

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