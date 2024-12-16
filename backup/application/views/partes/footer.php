<footer class="main-footer">

  <div class="pull-right hidden-xs">
    <b>Version</b> 3.0.0
  </div>
  <strong>CAMP Brasil &copy;
    <?php
    date_default_timezone_set('America/Sao_Paulo');
    $ano = date('Y');
    ?>
    <?= $ano; ?>.
  </strong>
  <!-- ini versão para o celular -->
  <?php
  if (isset($_POST['btn_desktop'])) {
  } else {
  ?>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php } ?>
  <?php
  if (isset($_POST['btn_cll'])) {
  ?>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <?php
  } else {
  ?>
  <?php } ?>
  <style>
    .btn_d {
      border: none;
      background-color: white;
    }
  </style>
  <form action="#" method="POST">
    <button name="btn_desktop" type="submit" class="btn_d">Versão para Computador</button>
  </form>

  <form action="#" method="POST">
    <button name="btn_cll" type="submit" class="btn_d">Versão para Celular</button>
  </form>
  <!-- fim versão para o celular -->
</footer>