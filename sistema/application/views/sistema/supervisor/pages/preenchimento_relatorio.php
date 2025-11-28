<?php

/** @var \$this */
if (!isset($_SESSION['usuario'])) {
  header("location: https://sistemas.campbrasil.com/sistema/index");
} else {

  $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
  $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

  $voltar = "../../";
  $array = array('voltar' => $voltar);

  date_default_timezone_set('America/Sao_Paulo');
  $data = date("d/m/Y");
  $url_redirecionamento = current_url() . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '');

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

    function pesquisar_criancas() {
      var ajax = AjaxF();

      ajax.onreadystatechange = function() {
        if (ajax.readyState == 4) {
          document.getElementById('conteudo_crianca').innerHTML = ajax.responseText;
        }
      }

      // Variável com os dados que serão enviados ao PHP
      var dados1 = "id_pg=" + document.getElementById('id_pg').value;
      var dados2 = "id_lider=" + document.getElementById('id_lider').value;
      var dados3 = "ano=" + document.getElementById('ano').value;
      var dados4 = "modulo=" + document.getElementById('modulo').value;
      var dados5 = "licao=" + document.getElementById('licao').value;

      ajax.open("GET", "consultas/retornar_informacoes_criancas_pg?" + dados1 + "&" + dados2 + "&" + dados3 + "&" + dados4 + "&" + dados5, false);

      ajax.setRequestHeader("Content-Type", "text/html");
      ajax.send();
    }

    $(document).ready(function() {
      $('#table_c').DataTable();
      pesquisar_criancas();
    });

    function voltar() {
      var routa = '<?= $routa; ?>';
      if (routa == 'coord') {
        window.location = "../coordenador/lider/<?= $id_lider; ?>";
      } else if (routa == 'lider') {
        window.location = "../lider/<?= $id_lider; ?>";
      } else {
        window.location = "../../page/pg";
      }
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
            PG
            <small>Painel de Controle</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?= $voltar ?>home"><i class="fa fa-home"></i> Home</a></li>
            <?php
            foreach ($pages as $key => $value) {
            ?>
              <li><a href="<?= $value['routa']; ?>"><i class="<?= $value['icon']; ?>"></i> <?= $value['name']; ?></a></li>
            <?php
            }
            ?>
            <li class="active">Preencher</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <!-- CRIANÇAS -->
            <div class="box box-info">
              <div class="box-header with-border">
                <h3 class="box-title"><i class="fa fa-area-chart"></i>Preenchimento de Relatório</h3>

                <div class="box-tools pull-right">
                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
              </div>
              <div class="box-body chat" id="chat-box">
                <input type="hidden" id="id_pg" value="<?= $id_pg; ?>">
                <input type="hidden" id="id_lider" value="<?= $id_lider; ?>">
                <input type="hidden" id="ano" value="<?= $ano; ?>">
                <input type="hidden" id="modulo" value="<?= $id_modulo; ?>">
                <input type="hidden" id="licao" value="<?= $licao; ?>">

                <br>
                <form name="coder" action="preenchimento/salvar" method="post" autocomplete="off">
                  <input type="hidden" name="data_aula" value="<?= $data; ?>">
                  <input type="hidden" name="red" value="<?= $red; ?>">
                  <input type="hidden" name="routa" value="<?= $routa; ?>">

                  <div id="conteudo">
                    <center>
                      <div class="card-body">
                        <div class="table-responsive">
                          <div class="form-group">
                            <center><label for="exampleInputEmail1"><b>Dados das Crianças</b></label></center>
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                              <thead>
                                <tr>
                                  <th><input type="checkbox" id="todos" name="checkTodos" value="t"> Selecionar todos</th>
                                </tr>
                              </thead>
                            </table>
                            <div id="conteudo_crianca"></div>
                          </div>
                          <div>
                          </div>
                    </center>
                    <div class="row" style="float:none;margin:auto; margin-bottom: 20px;">
                      <div class="col-lg-6" style="float:none;margin:auto;">
                        <br><input type="submit" class="btn btn-success btn-block" value="Salvar" /><br>
                </form>
                <a href="#" onclick="voltar();" class="btn btn-primary btn-block">Voltar</a>
              </div>
            </div>
          </div>
      </div>
      <!-- /.box-body -->
    </div>
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
<?php
} ?>
