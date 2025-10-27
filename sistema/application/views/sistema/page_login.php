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

                <p class="login-box-msg" style="width: 400px;">🚨 Atenção! <br>
                  O sistema está passando por uma atualização e, durante esse processo, podem ocorrer alguns erros ao utilizá-lo. Pedimos a compreensão de todos, pois essas melhorias são importantes para oferecer uma experiência cada vez melhor.<br>

                  🔹 Supervisores: no momento o sistema ainda não está disponível para vocês, pois a atualização está sendo aplicada especificamente no nível de acesso de supervisão.

                  Em breve tudo será normalizado. Obrigado pela paciência! 🙏</p>

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
                            <input class="form-control" name="email" type="email" placeholder="E-mail" value="">
                            <!-- <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
                          </div>

                          <br><br>

                          <div class="col-lg-12">
                            <input class="form-control" id="id_cpfs" name="cpf" maxlength="14" type="text" placeholder="CPF (000.000.000-00)" value="">
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

                <p class="login-box-msg" style="width: 400px;">🚨 Atenção! <br>
                  O sistema está passando por uma atualização e, durante esse processo, podem ocorrer alguns erros ao utilizá-lo. Pedimos a compreensão de todos, pois essas melhorias são importantes para oferecer uma experiência cada vez melhor.<br>

                  🔹 Supervisores: no momento o sistema ainda não está disponível para vocês, pois a atualização está sendo aplicada especificamente no nível de acesso de supervisão.

                  Em breve tudo será normalizado. Obrigado pela paciência! 🙏</p>

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
          <input type="hidden" id="btn_enviar_c" value="">
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


  <script>
    function enviar_whatsapp() {

      var telefone = "5585987169712";
      var mensagem = "Oi, preciso de ajuda com o sistema";

      let isMobile = (function(a) {
        if (/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a) || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0, 4))) {
          return true
        } else {
          return false
        }
      })(navigator.userAgent || navigator.vendor || window.opera)

      const makeLink_c = function(mode) {

        let mount = function() {
          if (isMobile) {
            let target = `whatsapp://send?`
            if (!!telefone && telefone !== '') {
              target += `phone=${encodeURIComponent(telefone)}&`
            }
            if (!!mensagem && mensagem !== '') {
              target += `text=${encodeURIComponent(mensagem)}`
            }
            return target
          } else {
            let target = `https://api.whatsapp.com/send?`
            if (!!telefone && telefone !== '') {
              target += `phone=${encodeURIComponent(telefone)}&`
            }
            if (!!mensagem && mensagem !== '') {
              target += `text=${encodeURIComponent(mensagem)}`
            }
            return target
          }
        }

        document.getElementById('btn_enviar_c').value = mount();

      }

      makeLink_c('link')
      var xx = document.getElementById('btn_enviar_c').value;
      window.open(xx);
    }
  </script>
</body>

</html>
