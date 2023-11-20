<?php
if (!isset($_SESSION['id_usuario'])) {
  header("location: index");
}

/** @var \$this */

$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
$id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";
?>
<header class="main-header">
  <!-- Logo -->
  <a href="<?= $voltar; ?>home" class="logo">
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>CAMP</b>Brasil | Pais</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
      <span class="sr-only">MENU</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <?php
        $query_usuario = $this->db->select('*')
          ->from('direcao')
          ->where('id_direcao', $id_usuario)
          ->get();
        $dados_usuario = $query_usuario->row_array();
        $nome_usuario = $dados_usuario['nome_direcao'];
        $foto_usuario = base_url('import/sistema/' . $dados_usuario['foto']);
        ?>

        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?= $foto_usuario; ?>" class="user-image" alt="User Image">
            <span class="hidden-xs"><?= $nome_usuario; ?></span>
          </a>

          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header">
              <img src="<?= $foto_usuario; ?>" class="img-circle" alt="User Image">
              <p><?= $nome_usuario; ?></p>
            </li>

            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="<?= $voltar; ?>pagina_editar_pessoal" class="btn btn-default btn-flat">Editar de Dados</a>
              </div>
              <div class="pull-right">
                <a href="../<?= $voltar; ?>sair?id_usuario=<?= $id_usuario_2; ?>" class="btn btn-default btn-flat">Sair</a>
              </div>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
</header>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
      <div class="pull-left image">
        <img src="<?= $foto_usuario; ?>" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?= $nome_usuario; ?></p>
        <?php

        $query_usuario = $this->db->select('*')
          ->from('usuario')
          ->where('id_usuario', $id_usuario_2)
          ->get();
        $d_usua = $query_usuario->row_array();
        $ativo = $d_usua['ativo'];
        if ($ativo == 0) {
        ?>
          <a href="#"><i class="fa fa-circle text-danger"></i>Offline</a>
        <?php
        } else {
        ?>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        <?php } ?>
      </div>
    </div>
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <li class="header">MENU</li>
      <li>
        <a href="<?= $voltar; ?>home">
          <i class="fa fa-home"></i>
          <span>Home</span>
        </a>
      </li>
      <li>
        <a href="<?= $voltar; ?>devocionais/mostrar">
          <i class="fa fa-book"></i>
          <span>Devocionais</span>
        </a>
      </li>
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>