<!DOCTYPE html>
<html>

<?php
$this->load->view('partes/head');
?>


<style>
  /* ===== RESET ===== */
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
  }

  /* ===== BACKGROUND ===== */
  body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: linear-gradient(180deg, #43c6ff, #005cff);
  }

  /* ===== CARD ===== */
  .card {
    background: #fff;
    width: 400px;
    padding: 50px 40px;
    border-radius: 35px;
    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
  }

  .title {
    font-size: 36px;
    font-weight: 600;
    color: #1d2b4f;
    line-height: 1.2;
    margin-bottom: 25px;
  }

  /* ===== INPUTS ===== */
  .input-field {
    width: 100%;
    margin-bottom: 20px;
  }

  .input-field input {
    width: 100%;
    padding: 15px;
    background: #eaeaea;
    border: none;
    border-radius: 25px;
    font-size: 15px;
    outline: none;
  }

  /* ===== OPTIONS ===== */
  .options {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
    margin-bottom: 25px;
  }

  .options label {
    display: flex;
    align-items: center;
    gap: 5px;
  }

  .options a {
    color: #1d2b4f;
    text-decoration: none;
  }

  /* ===== BUTTON ===== */
  .btn {
    width: 100%;
    padding: 14px;
    border: none;
    color: white;
    font-size: 16px;
    font-weight: 600;
    border-radius: 25px;
    cursor: pointer;
    background: linear-gradient(90deg, #006bff, #00c8ff);
    transition: 0.2s;
  }

  .input-wrapper {
    position: relative;
    width: 100%;
  }

  .field-icon {
    position: absolute;
    top: 50%;
    right: 15px;
    transform: translateY(-50%);
    cursor: pointer;
    color: #555;
    font-size: 18px;
  }

  .btn:hover {
    opacity: 0.9;
  }

  /* ===== SIGN UP ===== */
  .signup {
    margin-top: 20px;
    text-align: center;
    font-size: 14px;
    color: #333;
  }

  .signup a {
    color: #006bff;
    text-decoration: none;
    font-weight: 600;
  }
</style>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="content">


    <div class="card">

      <div class="title">
        <h1>
          <a href="https://site.campbrasil.com/"><b>CAMP</b>Brasil |</a>
          <small> Bem Vindo de volta</small>
        </h1>
      </div>

      <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#usar_cpf" data-toggle="tab">Usar CPF</a></li>
          <li><a href="#usar_senha" data-toggle="tab">Usar Senha</a></li>
          <li><a href="#usar_nome" data-toggle="tab">Usar Nome</a></li>
        </ul>


        <div class="tab-content">
          <div class="tab-pane active" id="usar_cpf">
            <div class="content">
              <form action="acesso" method="POST">
                <input type="hidden" name="opc" value="1">

                <div class="input-field">
                  <input name="email" type="email" placeholder="E-mail" value="">
                </div>

                <div class="input-field">
                  <input id="id_cpfs" name="cpf" maxlength="14" type="text" placeholder="CPF (000.000.000-00)" value="">
                </div>

                <?php
                if ($x == "") {
                  $x .= 1;
                } else {
                }
                ?>
                <input type="hidden" value="<?= $x; ?>" name="x_ir">
                <center>
                  <button type="submit" class="btn btn-primary btn-block btn-flat btn">Entrar</button>
                </center>
              </form>
            </div>
          </div>

          <div class="tab-pane" id="usar_senha">
            <div class="content">
              <form action="acesso" method="POST">
                <input type="hidden" name="opc" value="2">

                <div class="input-field">
                  <input name="email" type="email" placeholder="E-mail" value="">
                </div>

                <div class="input-field input-wrapper">
                  <input id="password-field" type="password" name="senha" placeholder="Senha">
                  <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>

                <?php
                if ($x == "") {
                  $x .= 1;
                } else {
                }
                ?>
                <input type="hidden" value="<?= $x; ?>" name="x_ir">
                <center>
                  <button type="submit" class="btn btn-primary btn-block btn-flat btn">Entrar</button>
                </center>
              </form>
            </div>
          </div>

          <div class="tab-pane" id="usar_nome">
            <div class="content">
              <form action="acesso" method="POST">
                <input type="hidden" name="opc" value="3">

                <div class="input-field">
                  <input name="nome" type="text" placeholder="Nome" value="">
                </div>

                <div class="input-field input-wrapper">
                  <input id="password-field" type="password" name="senha" placeholder="Senha">
                  <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                </div>

                <?php
                if ($x == "") {
                  $x .= 1;
                } else {
                }
                ?>
                <input type="hidden" value="<?= $x; ?>" name="x_ir">
                <center>
                  <button type="submit" class="btn btn-primary btn-block btn-flat btn">Entrar</button>
                </center>
              </form>
            </div>
          </div>
        </div>
      </div>

      <!-- <div class="input-field">
        <input type="email" placeholder="Email address">
      </div>

      <div class="input-field">
        <input type="password" placeholder="Password">
      </div>

      <div class="options">
        <label>
          <input type="checkbox"> Remember me
        </label>

        <a href="#">Forgot password?</a>
      </div>

      <button class="btn">LOGIN</button>

      <div class="signup">
        Don't have account? <a href="#">Sign up</a>
      </div> -->

    </div>
  </div>

  <?php
  $this->load->view('partes/scripts');
  ?>
  <script>
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
