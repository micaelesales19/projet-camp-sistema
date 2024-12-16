<!DOCTYPE html>
<html>

<?php
$this->load->view('partes/head');
?>

<style>
  .img-bandeira {
    width: 20px;
    height: 20px;
    margin-left: 10px;
    margin-bottom: 5px;
  }

  .login-center {
    display: flex;
    justify-content: center;
  }

  .field-icon {
    float: right;
    margin-left: -25px;
    margin-top: -25px;
    position: relative;
    z-index: 2;
  }
</style>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="content">
    <section class="content-header">
      <center>
        <h1>
          <a href="https://site.campbrasil.com/"><b>CAMP</b>Brasil |</a>
          <small> Entre para iniciar sua sessão</small>
        </h1>
      </center>
    </section>

    <section class="col-lg-12 login-center">
      <div class="row">
        <!-- /.box-header -->
        <div class="box-body chat">
          <div class="nav-tabs-custom">

            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_brasil" data-toggle="tab">Brasil <img src="import//bandeiras/bandeira-do-brasil.png" class="img-bandeira"></a></li>
              <li><a href="#tab_africa" data-toggle="tab">África <img src="import//bandeiras/bandeira-mocambique.png" class="img-bandeira"></a></li>
            </ul>

            <div class="tab-content">

              <div class="tab-pane active" id="tab_brasil">

                <p class="login-box-msg">Se você não tiver cadastrado sua senha, utilize o CPF</p>

                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#usar_cpf" data-toggle="tab">Usar CPF</a></li>
                    <li><a href="#usar_senha" data-toggle="tab">Usar Senha</a></li>
                  </ul>

                  <div class="tab-content">
                    <div class="tab-pane active" id="usar_cpf">
                      <div class="content">
                        <form action="acesso" method="POST">
                          <input type="hidden" name="opc" value="1">
                          <div class="col-lg-12">
                            <input class="form-control" name="email" type="email" placeholder="E-mail" value="coordenador@gmail.com">
                            <!-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
                          </div>

                          <br><br>

                          <div class="col-lg-12">
                            <input class="form-control" id="id_cpfs" name="cpf" maxlength="14" type="text" placeholder="CPF (000.000.000-00)" value="112.233.445-55">
                            <!-- <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->
                          </div>

                          <?php

                          if ($x == "") {
                            $x .= 1;
                          } else {
                          }
                          ?>
                          <input type="hidden" value="<?= $x; ?>" name="x_ir">
                          <br><br>
                          <center>
                            <div class="col-xs-4">
                              <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                            </div>
                          </center>
                        </form>
                      </div>
                    </div>

                    <div class="tab-pane" id="usar_senha">
                      <div class="content">
                        <form action="acesso" method="POST">
                          <input type="hidden" name="opc" value="2">
                          <div class="col-lg-12">
                            <input class="form-control" name="email" type="email" placeholder="E-mail">
                            <!-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
                          </div>

                          <br><br>

                          <div class="col-lg-12">
                            <input id="password-field" type="password" class="form-control" name="senha" placeholder="Senha">
                            <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                          </div>

                          <?php

                          if ($x == "") {
                            $x .= 1;
                          } else {
                          }
                          ?>
                          <input type="hidden" value="<?= $x; ?>" name="x_ir">

                          <br><br>
                          <div class="col-xs-4">
                            <!-- <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button> -->
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="tab-pane" id="tab_africa">

                <p class="login-box-msg">Se você não tiver cadastrado seu e-mail, utilize só o Nome</p>


                <div class="nav-tabs-custom">
                  <ul class="nav nav-tabs">
                    <li class="active"><a href="#usar_nome" data-toggle="tab">Usar Nome</a></li>
                    <li><a href="#usar_email" data-toggle="tab">Usar E-mail</a></li>
                  </ul>

                  <div class="tab-content">
                    <div class="tab-pane active" id="usar_nome">
                      <div class="content">
                        <form action="acesso" method="POST">
                          <input type="hidden" name="opc" value="3">
                          <div class="col-lg-12">
                            <input class="form-control" name="nome" type="text" placeholder="Nome">
                            <!-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
                          </div>

                          <br><br>

                          <div class="col-lg-12">
                            <input id="password2-field" type="password" class="form-control" name="senha" placeholder="Senha">
                            <span toggle="#password2-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                          </div>

                          <?php

                          if ($x == "") {
                            $x .= 1;
                          } else {
                          }
                          ?>
                          <input type="hidden" value="<?= $x; ?>" name="x_ir">
                          <br><br>
                          <center>
                            <div class="col-xs-4">
                              <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                            </div>
                          </center>
                        </form>
                      </div>
                    </div>

                    <div class="tab-pane" id="usar_email">
                      <div class="content">
                        <form action="acesso" method="POST">
                          <input type="hidden" name="opc" value="4">
                          <div class="col-lg-12">
                            <input class="form-control" name="email" type="email" placeholder="E-mail">
                            <!-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
                          </div>

                          <br><br>

                          <div class="col-lg-12">
                            <input id="password3-field" type="password" class="form-control" name="senha" placeholder="Senha">
                            <span toggle="#password3-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                          </div>

                          <?php

                          if ($x == "") {
                            $x .= 1;
                          } else {
                          }
                          ?>
                          <input type="hidden" value="<?= $x; ?>" name="x_ir">

                          <br><br>
                          <div class="col-xs-4">
                            <!-- <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button> -->
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.table-responsive -->
        </div>
      </div>

    </section>
    <!-- /.login-box-body -->
  </div>

  <?php
  $this->load->view('partes/scripts');
  ?>
  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });
    });

    $(".toggle-password").click(function() {

      $(this).toggleClass("fa-eye fa-eye-slash");
      var input = $($(this).attr("toggle"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
  </script>
</body>

</html>