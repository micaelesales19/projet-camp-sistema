<?php

/** @var \$this */

$voltar = "";
$array = array('voltar' => $voltar);

if (!isset($_SESSION['usuario'])) {
  header("location: ../$voltar/index");
} else {

  $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
  $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

  $dados_slocal = $this->FConsultas_model->getInfoSLocalId($id_usuario);

  if ($dados_slocal['row'] == 0) {
    $data = [];
    $this->FConsultas_model->mensagem('danger', 'Erro!', ['O sistema dectou algum erro em seu cadastro! Entre em contato com o suporte!']);
    $funcao = $this->FConsultas_model->red("../$voltar/index", 2000, $data);
    echo $funcao;
  } else {

    $id_pastor = "2000";
    $id_coord = "3000";
    $id_sr = $id_usuario;
    $id_se = $dados_slocal['dados']['id_supervisorE'];

    $link = "http://campbrasil.com/sistema/php/cadastro_lider.php?um=$id_pastor&dois=$id_coord&tres=$id_sr&quatro=$id_se";
?>

    <!DOCTYPE html>
    <html>
    <!-- Head -->
    <?php
    $this->load->view('partes/head');
    ?>

    <style>
      .bg {
        color: white;
      }

      #consultar_endereco {
        display: none;
      }

      #escrever_endereco {
        display: none;
      }
    </style>

    <script>
      function aparecer_select() {
        var opc = document.getElementById('pais').value;
        if (opc == "br") {
          document.getElementById('estaods2').value = '';
          document.getElementById('cidades2').value = '';
          document.getElementById('consultar_endereco').style.display = "inline";
          document.getElementById('escrever_endereco').style.display = "none";
        }

        if (opc == "outro") {
          document.getElementById('estados').value = '';
          document.getElementById('cidades').value = '';
          document.getElementById('escrever_endereco').style.display = "inline";
          document.getElementById('consultar_endereco').style.display = "none";
        }
      }
    </script>

    <body class="hold-transition skin-blue sidebar-mini">
      <div class="wrapper">
        <!-- Menu -->
        <?php

        $this->load->view('sistema/slocal/partes/menu_lateral', $array);
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
              <!-- CONSULTAR COORDENADORES -->
              <div class="col-lg-4">
                <!-- small box -->
                <div class="small-box bg" style="background-color: #39cccc;">
                  <?php
                  $consultarCoordenador = $this->FConsultas_model->getCoordenador([$id_usuario], 1, 1, []);
                  $total = $consultarCoordenador['row'];
                  ?>
                  <div class="inner">
                    <h4><?= $total; ?></h4>
                    <p>Coordenadores</p>
                    <a href="#" data-toggle="modal" data-target="#cadastro_coord" style="color:white;" class="small-box-footer">
                      <p>Cadastrar +</p>
                    </a>

                    <div class="modal fade" id="cadastro_coord">
                      <div class="modal-dialog modal-success">
                        <div class="modal-content">
                          <form action="page/coordenadores/salvar" method="POST">
                            <input type="hidden" name="id_slocal" value="<?= $id_usuario; ?>">
                            <input type="hidden" name="id_sregional" value="<?= $id_se; ?>">
                            <input type="hidden" name="red" value="slocal">
                            <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title">Cadastro | Coordenador</h4>
                            </div>
                            <div class="box-body">

                              <div class="col-lg-12">
                                <div class="form-group has-feedback">
                                  <input type="text" class="form-control" name="nome" minlength="5" placeholder="Nome" required>
                                  <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group has-feedback">
                                  <input type="email" class="form-control" placeholder="Email" name="email" required>
                                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group has-feedback">
                                  <input type="text" class="form-control" placeholder="CPF" minlength="11" name="cpf" minlength="11" required>
                                  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group has-feedback">
                                  <input type="text" class="form-control" placeholder="Telefone do Colíder (DDD + Telefone)" minlength="11" name="telefone" required>
                                  <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                                </div>
                              </div>

                              <div class="col-lg-6">
                                <div class="form-group has-feedback">
                                  <input type="text" class="form-control" placeholder="Data de Nascimento (DD/MM/YYYY)" minlength="10" maxlength="10" name="nascimento" required>
                                  <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
                                </div>
                              </div>

                              <div class="col-lg-12">
                                <div class="col-lg-4">
                                  <div class="form-group has-feedback">
                                    <select id="pais" name="pais" class="form-control" onchange="aparecer_select(this)">
                                      <option value="" selected>País</option>
                                      <option value="br">Brasil</option>
                                      <option value="outro">Outros</option>
                                    </select>
                                    <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                  </div>
                                </div>
                                <div id="escrever_endereco">
                                  <div class="col-lg-4">
                                    <div class="form-group has-feedback">
                                      <input type="text" id="estaods2" class="form-control" placeholder="Estado" name="estados2">
                                      <span id="icon_outros" class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                    </div>
                                  </div>
                                  <div class="col-lg-4">
                                    <div class="form-group has-feedback">
                                      <input type="text" id="cidades2" class="form-control" placeholder="Cidade" name="cidades2">
                                      <span id="icon_outros" class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                    </div>
                                  </div>
                                </div>

                                <div id="consultar_endereco">
                                  <div class="col-lg-4">
                                    <div class="form-group has-feedback">
                                      <select id="estados" name="estados" class="form-control">
                                        <option value=""></option>
                                      </select>
                                      <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                    </div>
                                  </div>
                                  <div class="col-lg-4">
                                    <div class="form-group has-feedback">
                                      <select id="cidades" name="cidades" class="form-control">
                                      </select>
                                      <span class="glyphicon glyphicon-map-marker form-control-feedback"></span>
                                    </div>
                                  </div>
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

                  </div>
                  <div class="icon">
                    <i class="fa fa-users"></i>
                  </div>
                  <a href="page/coordenadores" class="small-box-footer">Ver Mais <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              <!-- ./col -->

              <!-- CONSULTAR LÍDERES -->
              <div class="col-lg-4">
                <!-- small box -->
                <div class="small-box bg" style="background-color: #52A3D9;">
                  <?php
                  $consultarLider = $this->FConsultas_model->getLideres([$id_usuario], 2, 1, []);
                  $total = $consultarLider['row'];
                  ?>
                  <div class="inner">
                    <h4><?= $total; ?></h4>
                    <p>Líderes</p>

                    <a href="#" data-toggle="modal" data-target="#cadastro_lider_link" style="color:white;" class="small-box-footer">
                      <p>Copiar Link de Cadastro <i class="fa fa-link"></i></p>
                    </a>

                    <div class="modal fade" id="cadastro_lider_link">
                      <div class="modal-dialog modal-success">
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Gerar Link | Líder</h4>
                          </div>
                          <div class="box-body">
                            <input type="hidden" id="link_user" value="<?= $link; ?>">
                            <div class="col-lg-12">
                              <div class="form-group has-feedback">
                                <label for="">Selecione o Coordenador</label>
                                <select class="form-control" onclick="criar_link();" name="id_coord" id="id_coord">
                                  <?php
                                  $coordenadores = $this->FConsultas_model->getCoordenador([$id_usuario], 1, 1, []);

                                  if ($coordenadores['row'] == 0) {
                                  ?>
                                    <option value="3000">Você não tem coordenadores cadastrados</option>
                                  <?php
                                  } else {
                                  ?>
                                    <option value="3000" selected>Selecione um coordenador</option>
                                    <option value="3000">Ainda não tem coordenador</option>
                                    <?php
                                    foreach ($coordenadores['dados'] as $key => $coord) {
                                    ?>
                                      <option value="<?= $coord['id_coordenador']; ?>"><?= $coord['nome_coordenador']; ?></option>
                                  <?php }
                                  } ?>
                                </select>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                            <input type="submit" class="btn btn-default pull-right" onclick="copiarTexto()" data-dismiss="modal" value="Gerar">
                          </div>
                        </div>
                        <!-- /.modal-content -->
                      </div>
                      <!-- /.modal-dialog -->
                    </div>

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
              $query_consulta_pg = $this->db->query("SELECT * FROM pg_2 WHERE id_lider LIKE $id_usuario AND ativo = 1");
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
          $query_consulta_pg = $this->db->query("SELECT * FROM pg_2 WHERE id_lider LIKE $id_usuario AND ativo = 1 ORDER BY id_modulo ASC LIMIT 1");
          $consultar_pg = $query_consulta_pg->result_array();

          foreach ($consultar_pg as $key => $pg) {
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
        function criar_link() {
          var id_pastor = "2000";
          var id_coord = document.getElementById('id_coord').value;
          var id_sr = '<?= $id_usuario; ?>';
          var id_se = '<?= $dados_slocal['dados']['id_supervisorE']; ?>';

          var link = "http://campbrasil.com/sistema/php/cadastro_lider.php?um=" + id_pastor + "&dois=" + id_coord + "&tres=" + id_sr + "&quatro=" +
            id_se;

          document.getElementById('link_user').value = link;
        }

        let copiarTexto = () => {

          var texto = document.getElementById('link_user').value;

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

        $(document).ready(function() {
          $.getJSON('<?php echo base_url('import/sistema/dist/js/estados_cidades.json'); ?>', function(data) {
            var items = [];
            var options = '<option value="">escolha um estado</option>';
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
    </body>

    </html>
<?php }
} ?>