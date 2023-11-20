<!DOCTYPE html>
<?php
/** @var \$this */
?>
<html>

<?php
$this->load->view('partes/head');
?>

<body class="hold-transition login-page">

  <div class="login-box">
    <div class="login-logo">
      <a href="index"><b>CAMP</b>Brasil</a>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body">
      <p class="login-box-msg">Entre para iniciar sua sessão</p>
      <form action="acesso" method="POST">
        <!-- <form action="#" method="POST"> -->
        <div class="form-group has-feedback">
          <input class="form-control" name="email" type="email" placeholder="E-mail">
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input class="form-control" id="id_cpfs" name="cpf" maxlength="14" type="text" placeholder="Digite o CPF (Sem os pontos e o hífem)">
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <?php
        if ($x == "") {
          $x .= 1;
        } else {
        }
        ?>

        <input type="hidden" value="<?= $x; ?>" name="x_ir">
        <div class="row">
          <div class="col-xs-4">
            <!-- <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button> -->
            <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
          </div>
          <!-- /.col -->
        </div>
      </form>
      <!-- /.social-auth-links -->
      <!-- <a href="#">I forgot my password</a><br><a href="register.html" class="text-center">Register a new membership</a> -->
    </div>
    <!-- /.login-box-body -->
  </div>
  <!-- /.login-box -->

  <?php
  $this->load->view('partes/scripts2');
  ?>

  <script>
    $(function() {
      $('input').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' /* optional */
      });
    });
  </script>
</body>

</html>