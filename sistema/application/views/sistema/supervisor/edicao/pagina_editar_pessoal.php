<?php
if (!isset($_SESSION['usuario'])) {
  header("location: ../../index");
} else {

  $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
  $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

  $voltar = "";
  $array = array('voltar' => $voltar);

  $url_redirecionamento = current_url() . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '');

  $query = $this->Supervisores->infos([$id_usuario], 'info_supervisor', '', '');
  $dados_pessoal = $query['dados'];

  $query_usuario = $this->Lideres->infos([$id_usuario_2], 'info_usuario_id_usuario', '', '');
  $dados_usuario = $query_usuario['dados'];
?>

  <!DOCTYPE html>
  <html>
  <!-- Head -->
  <?php
  $this->load->view('partes/head');
  ?>
  <script>
    $(document).ready(function() {
      aparecer_select();
    });

    function validar_edicao() {
      var dados = document.form_editar_foto.opc.value;
      if (dados == "Sim" || dados == "Não") {} else {
        alert("Você não escolheu a opção");
        return false;
      }
    }

    function aparecer_select() {
      var opc = document.getElementById('pais').value;
      if (opc == "br") {
        document.getElementById('estaods2').value = '';
        document.getElementById('cidades2').value = '';
        document.getElementById('consultar_endereco').style.display = "inline";
        document.getElementById('escrever_endereco').style.display = "none";

        document.getElementById('precisa_cpf').style.display = "inline";

        document.getElementById('cpf').setAttribute('required', 'true');
      } else {
        document.getElementById('estados').value = '';
        document.getElementById('cidades').value = '';
        document.getElementById('escrever_endereco').style.display = "inline";
        document.getElementById('consultar_endereco').style.display = "none";

        document.getElementById('precisa_cpf').style.display = "none";
        document.getElementById('cpf').value = '';
        document.getElementById('cpf').removeAttribute('required');
      }
    }

    function toggleSenha() {
      const campo = document.getElementById("senha");
      campo.type = campo.type === "password" ? "text" : "password";
    }
  </script>

  <style>
    #imgPhoto_usuario,
    #imgPhoto_colider {
      margin-top: 1%;
      width: 150px;
      height: 150px;
      padding: 10px;
      background-color: #eee;
      border: 5px solid #ccc;
      border-radius: 50%;
      cursor: pointer;
      transition: background .3s;
    }

    #consultar_endereco {
      display: none;
    }

    #escrever_endereco {
      display: none;
    }

    #precisa_cpf {
      display: none;
    }

    #precisa_cpf_colider {
      display: none;
    }

    #imgPhoto_usuario:hover,
    #imgPhoto_colider:hover {
      background-color: rgb(180, 180, 180);
      border: 5px solid #111;
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
            Dados Pessoais
            <small>Painel de Controle</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="<?= $voltar; ?>home"><i class="fa fa-home"></i> Home</a></li>
            <li class="active">Editar Dados Pessoais</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="box box-danger">

              <!-- form start -->
              <form action="salvar_edicao" role="form" method="POST" enctype="multipart/form-data" name="form_editar_foto">

                <div class="col-lg-6">
                  <div class="box-header with-border">
                    <h3 class="box-title">Dados Pessoais</h3>
                  </div>
                  <div class="box-body chat" id="chat-box">
                    <div class="box-footer">
                      <?php
                      $foto_original = $dados_pessoal['foto'];

                      $foto = base_url('import/sistema/' . $foto_original);

                      $is_br = $dados_pessoal['pais'] == 'br' || '' ? true : false;
                      ?>

                      <input type="hidden" name="id_usuario" value="<?= $id_usuario_2; ?>">
                      <input type="hidden" name="id" value="<?= $dados_pessoal['id_supervisorR'] ?>">
                      <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

                      <div class="col-lg-12">
                        <center>
                          <div class="form-group">
                            <div class="form-group">
                              <label for="nome">Editar Foto?</label>
                              <div class="imageContainer">
                                <img src="<?= $foto; ?>" alt="Imagem não encontrada" id="imgPhoto_usuario">
                              </div>
                              <input type="file" name="files[]" id="fileImage_usuario">
                              <input type="hidden" name="foto_antiga" value="<?= $foto_original; ?>">
                            </div>
                          </div>
                        </center>
                      </div>

                      <script type="text/javascript">
                        $(document).ready(function() {

                          $.getJSON('<?php echo base_url('import/sistema/dist/js/estados_cidades.json'); ?>', function(data) {
                            var items = [];
                            var options = '<optgroup label="Seu estado escolhido"><option value="<?php echo $dados_pessoal['estado'] ?>"><?php echo $dados_pessoal['estado'] ?></option></optgroup>';

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
                                  options_cidades += '<optgroup label="Sua cidade escolhida"><option value="<?php echo $dados_pessoal['cidade'] ?>"><?php echo $dados_pessoal['cidade'] ?></option></optgroup>';
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

                      <div class="col-lg-4">
                        <div class="form-group has-feedback">
                          <label for="exampleInputPassword1">País</label>
                          <select id="pais" name="pais" class="form-control" onchange="aparecer_select(this)">
                            <?php
                            if ($dados_pessoal['pais'] == '' || $dados_pessoal['pais'] == 'br') {
                            ?>
                              <option value="">País</option>
                              <option value="br" selected>Brasil</option>
                              <option value="Moçambique">Moçambique</option>
                              <option value="outro">Outros</option>
                            <?php } else if ($dados_pessoal['pais'] == 'Moçambique') { ?>
                              <option value="">País</option>
                              <option value="br">Brasil</option>
                              <option value="Moçambique" selected>Moçambique</option>
                              <option value="outro">Outros</option>
                            <?php } else { ?>
                              <option value="">País</option>
                              <option value="br">Brasil</option>
                              <option value="Moçambique">Moçambique</option>
                              <option value="outro" selected>Outros</option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>

                      <div id="consultar_endereco">
                        <div class="form-group col-lg-4" id="form-group">
                          <label for="exampleInputPassword1">Estado</label>
                          <select id="estados" name="estados" class="form-control">
                            <option value=""></option>
                          </select>
                        </div>

                        <div class="form-group col-lg-4" id="form-group">
                          <label for="exampleInputPassword1">Cidade</label>
                          <select id="cidades" name="cidades" class="form-control"></select>
                        </div>
                      </div>

                      <div id="escrever_endereco">
                        <div class="form-group col-lg-4">
                          <label for="exampleInputPassword1">Estado/Província/Região</label>
                          <input type="text" id="estaods2" class="form-control" placeholder="Estado/Província/Região" name="estados2" value="<?= $dados_pessoal['estado']; ?>">
                        </div>

                        <div class="form-group col-lg-4">
                          <label for="exampleInputPassword1">Cidade/Município/Distrito</label>
                          <input type="text" id="cidades2" class="form-control" placeholder="Cidade/Município/Distrito" name="cidades2" value="<?= $dados_pessoal['cidade']; ?>">
                        </div>
                      </div>

                      <div class="col-lg-12">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Nome</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" name="nome" minlength="5" value="<?= $dados_pessoal['nome_supervisorR']; ?>" placeholder="Nome" required>
                          <input type="hidden" name="nome_antigo" value="<?= $dados_pessoal['nome_supervisorR']; ?>">
                        </div>
                      </div>

                      <div class="col-lg-6" id="precisa_cpf">
                        <div class="form-group">
                          <label for="exampleInputEmail1">CPF</label>
                          <input type="text" class="form-control" name="cpf" value="<?= $dados_pessoal['cpf']; ?>" placeholder="CPF" maxlength="14" minlength="11" required>
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="exampleInputEmail1">E-mail</label>
                          <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="<?= $dados_pessoal['email']; ?>" placeholder="E-mail" required>
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Telefone</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" name="telefone" value="<?= $dados_pessoal['telefone_whatsapp']; ?>" placeholder="Telefone" minlength="11" required>
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Data de Nascimento</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" name="nascimento" value="<?= $dados_pessoal['nascimento']; ?>" maxlength="10" minlength="10" placeholder="Data de Nascimento" required>
                        </div>
                      </div>

                      <div class="col-lg-6">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Senha</label>
                          <input type="password" class="form-control" id="senha" name="senha" value="<?= $dados_usuario['senha']; ?>" placeholder="Senha" required>
                          <span onclick="toggleSenha()" style="position: absolute; right: 20px; top: 55%; transform: translateY(-50%); cursor: pointer;">👁️</span>
                        </div>
                      </div>

                      <button type="submit" class="btn btn-danger pull-right">Salvar</button>
                    </div>
                  </div>
                </div>
              </form>
            </div>
            <!-- form start -->
          </div>
          <!-- /.box -->
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
    $this->load->view('partes/scripts2');
    ?>

    <script src="<?php echo base_url('import/sistema/dist/js/fotos.js'); ?>"></script>
  </body>

  </html>
<?php } ?>
