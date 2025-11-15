<?php
if (!isset($_SESSION['usuario'])) {
  header("location: ../../index");
} else {

  $id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
  $id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

  $voltar = "";
  $array = array('voltar' => $voltar);

  $query = $this->Lideres->infos([$id_usuario], 'info_lider', '', '');
  $dados_pessoal = $query['dados'];

  $info_usuario = $this->Lideres->infos([$id_usuario_2], 'info_usuario_id_usuario', '', '');

  $url_redirecionamento = current_url() . ($_SERVER['QUERY_STRING'] ? '?' . $_SERVER['QUERY_STRING'] : '');
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
      $this->load->view('sistema/lider/partes/menu_lateral', $array);
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
                      //$foto_original = 'fotoU/pais/WhatsApp_Image_2022-12-05_at_08_30_33.jpeg';

                      $foto = base_url('import/sistema/' . $foto_original);
                      ?>

                      <input class="form-control" type="hidden" name="id" value="<?= $dados_pessoal['id_lider'] ?>">
                      <input class="form-control" type="hidden" name="id_coordenador" value="<?= $dados_pessoal['id_coordenador'] ?>">
                      <input class="form-control" type="hidden" name="id_supervisor" value="<?= $dados_pessoal['id_supervisorR'] ?>">
                      <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                      <input type="hidden" name="id_usuario" value="<?= $id_usuario_2; ?>">

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
                          <input type="text" class="form-control" id="exampleInputEmail1" name="nome" minlength="5" value="<?= $dados_pessoal['nome_lider']; ?>" placeholder="Nome" required>
                          <input type="hidden" name="nome_antigo" value="<?= $dados_pessoal['nome_lider']; ?>">
                        </div>
                      </div>

                      <div class="col-lg-6" id="precisa_cpf">
                        <div class="form-group">
                          <label for="exampleInputEmail1">CPF</label>
                          <input type="text" class="form-control" name="cpf" id="cpf" value="<?= $dados_pessoal['cpf']; ?>" placeholder="CPF" maxlength="14" minlength="11" required>
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
                          <label for="exampleInputEmail1">Igreja</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" name="igreja" value="<?= $dados_pessoal['igreja']; ?>" placeholder="Igreja" minlength="5" required>
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
                          <input type="password" class="form-control" id="senha" name="senha" value="<?= $info_usuario['dados']['senha']; ?>" placeholder="Senha" required>
                          <span onclick="toggleSenha()" style="position: absolute; right: 20px; top: 55%; transform: translateY(-50%); cursor: pointer;">👁️</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="box-header with-border">
                    <h3 class="box-title">Colíder</h3>

                    <?php

                    $colideres_desativados = $this->Lideres->mostrar_colider_do_lider_desativados($id_usuario);
                    $dados = $this->Lideres->mostrar_colider_do_lider($id_usuario);

                    if ($colideres_desativados['row'] == 0) {
                    } else {
                    ?>
                      <button type="button" class="btn btn-warning pull-right" data-toggle="modal" data-target="#colideres_desativados">Colíderes Desativados</button>
                    <?php }
                    if ($dados) {
                    ?>
                      <button type="button" class="btn btn-danger pull-right" data-toggle="modal" data-target="<?= "#" . $dados['id_colider']; ?>desativar_colider">Desativar Colíder</button>

                    <?php } else {
                    } ?>
                  </div>
                  <?php
                  if ($dados) {
                  ?>
                    <div class="box-body chat" id="chat-box">
                      <div class="box-footer">
                        <?php

                        $foto_original_colider = $dados['foto'];

                        $foto_colider = base_url('import/sistema/' . $foto_original_colider);
                        ?>

                        <input class="form-control" id="exampleInputText1" type="hidden" name="id_colider" aria-describedby="emailHelp" value="<?= $dados['id_colider'] ?>">

                        <div class="col-lg-12">
                          <center>
                            <div class="form-group">
                              <div class="form-group">
                                <label for="nome">Editar Foto?</label>
                                <div class="imageContainer">
                                  <img src="<?= $foto_colider; ?>" alt="Imagem não encontrada" id="imgPhoto_colider">
                                </div>
                                <input type="file" name="filesColider[]" id="fileImage_colider">
                                <input type="hidden" name="foto_antiga_colider" value="<?= $foto_original_colider; ?>">
                              </div>
                            </div>
                          </center>
                        </div>

                        <div class="col-lg-12">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Nome</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="nome_colider" minlength="5" value="<?= $dados['nome_colider']; ?>" placeholder="Nome" required>
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">CPF</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="cpf_colider" value="<?= $dados['cpf']; ?>" placeholder="CPF" maxlength="14" minlength="11" required>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">E-mail</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" name="email_colider" value="<?= $dados['email']; ?>" placeholder="E-mail" required>
                          </div>
                        </div>

                        <div class="col-lg-6">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Telefone</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="telefone_colider" value="<?= $dados['telefone_whatsapp']; ?>" placeholder="Telefone" minlength="11" required>
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Data de Nascimento</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="nascimento_colider" value="<?= $dados['nascimento']; ?>" maxlength="10" minlength="10" placeholder="Data de Nascimento" required>
                          </div>
                        </div>
                      </div>
                    </div>
                  <?php
                  } else {
                  ?>
                    <div class="box-body chat"><br>
                      <div class="callout callout-warning">
                        <h4>
                          Você não tem nenhum colíder!
                        </h4>
                        <p>Cadastre</p>
                      </div>

                      <center>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#cadastro_colider">Cadastrar +</button>
                      </center>
                    </div>
                  <?php
                  } ?>
                </div>
                <div class="col-lg-12">
                  <button type="submit" class="btn btn-danger pull-right">Salvar</button>
              </form>
            </div>
            <!-- form start -->
          </div>
          <!-- /.box -->
      </div>
      <!-- /.row -->
      </section>

      <?php
      if ($dados) {
      ?>
        <div class="modal fade" id="<?= $dados['id_colider']; ?>desativar_colider">
          <div class="modal-dialog modal-danger">
            <div class="modal-content">
              <form action="colider/desativar" method="POST">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title">Desativar | Colíder</h4>
                </div>

                <div class="box-body">

                  <input type="hidden" name="idLider" value="<?= $id_usuario; ?>">
                  <input type="hidden" name="idColider" value="<?= $dados['id_colider']; ?>">
                  <input type="hidden" name="nomeColider" value="<?= $dados['nome_colider']; ?>">
                  <input type="hidden" name="idResponsavel" value="<?= $id_usuario; ?>">
                  <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

                  <div class="form-group">
                    <label for="exampleInputEmail1">Deseja realmente desativar o colíder do projeto CAMP?</label>
                    <label for="exampleInputPassword1">Conte-nos o motivo:</label>
                    <textarea name="motivo" class="form-control"></textarea>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
                  <input type="submit" class="btn btn-default pull-right" value="Desativar">
                </div>
              </form>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <?php } ?>

      <div class="modal fade" id="cadastro_colider">
        <div class="modal-dialog modal-success">
          <div class="modal-content">
            <form action="colider/cadastro/salvar" method="POST">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Cadastro | Colíder</h4>
              </div>
              <div class="box-body">
                <input type="hidden" name="idLider" value="<?= $id_usuario; ?>">
                <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

                <div class="col-lg-12">
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="nomeColider" minlength="5" placeholder="Nome do Colíder">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group has-feedback">
                    <input type="email" class="form-control" placeholder="Email do Colíder" name="emailColider">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="CPF do Colíder" minlength="11" name="cpfColider">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Telefone do Colíder (DDD + Telefone)" minlength="11" name="telefoneColider">
                    <span class="glyphicon glyphicon-phone form-control-feedback"></span>
                  </div>
                </div>

                <div class="col-lg-6">
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" placeholder="Data de Nascimento do Colíder (DD/MM/YYYY)" minlength="10" maxlength="10" name="nascimentoColider">
                    <span class="glyphicon glyphicon-calendar form-control-feedback"></span>
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

      <?php
      if ($colideres_desativados['row'] == 0) {
      } else {
      ?>
        <div class="modal fade" id="colideres_desativados">
          <div class="modal-dialog modal-warning">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Ativar | Desativar | Colíder</h4>
              </div>

              <div class="box-body" style="height: 150px;">

                <input type="hidden" name="idLider" value="<?= $dados_pessoal['id_lider']; ?>">
                <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">

                <script>
                  function trocar_id_colider_desativado() {
                    var id_colider = document.getElementById('opc_id_colider').value;

                    document.getElementById('id_colider_escolhido_1').value = id_colider;
                    document.getElementById('id_colider_escolhido_2').value = id_colider;
                  }
                </script>

                <div class="col-lg-12">

                  <div class="col-lg-5">
                    <div class="form-group">
                      <label for="opc">Colíder:</label>
                      <select name="opc" id="opc_id_colider" onchange="trocar_id_colider_desativado()" class="form-control">
                        <?php
                        foreach ($colideres_desativados['dados'] as $key => $dadosColiderDesativados) {
                        ?>
                          <option value="<?= $dadosColiderDesativados['id_colider']; ?>"><?= $dadosColiderDesativados['nome_colider']; ?> </option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-3">
                    <div class="form-group">
                      <form action="colider/ativar" method="POST">
                        <input type="hidden" name="opc" id="id_colider_escolhido_1" value="<?= $colideres_desativados['dados'][0]['id_colider']; ?>">
                        <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                        <input type="hidden" name="idLider" value="<?= $dados_pessoal['id_lider']; ?>">
                        <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                        <center>
                          <label for="opc">Opção 1:</label><br>
                          <input type="submit" class="btn btn-success" value="Ativar">
                        </center>
                      </form>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <form action="colider/exclusao/permanente" method="POST">
                        <input type="hidden" name="opc" id="id_colider_escolhido_2" value="<?= $colideres_desativados['dados'][0]['id_colider']; ?>">
                        <input type="hidden" name="idUsuario" value="<?= $id_usuario; ?>">
                        <input type="hidden" name="idLider" value="<?= $dados_pessoal['id_lider']; ?>">
                        <input type="hidden" name="red" value="<?= $url_redirecionamento; ?>">
                        <center>
                          <label for="opc">Opção 2:</label><br>
                          <input type="submit" class="btn btn-danger" value="Excluir (Permanentemente)">
                        </center>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Voltar</button>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
      <?php } ?>
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

    <script src="<?php echo base_url('import/sistema/dist/js/fotos.js'); ?>"></script>
  </body>

  </html>
<?php } ?>
