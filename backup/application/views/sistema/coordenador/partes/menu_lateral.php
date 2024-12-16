<?php

/** @var \$this */
if (!isset($_SESSION['id_usuario'])) {
  header("location: index");
}

$id_usuario = ($_SESSION["id_usuario"]) ? $_SESSION["id_usuario"] : "";
$id_usuario_2 = ($_SESSION["id_usuario_2"]) ? $_SESSION["id_usuario_2"] : "";

$color = "#39cccc";
?>

<header class="main-header">
  <!-- Logo -->
  <a href="<?= $voltar; ?>home" class="logo" style="background-color: <?= $color; ?>;">
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><b>CAMP</b>Brasil | Coord</span>
  </a>
  <!-- Header Navbar: style can be found in header.less -->
  <nav class="navbar navbar-static-top" style="background-color: <?= $color; ?>;">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" style="background-color: <?= $color; ?>;" data-toggle="push-menu" role="button">
      <span class="sr-only">MENU</span>
    </a>
    <div class="navbar-custom-menu">
      <ul class="nav navbar-nav">
        <?php
        $query_usuario = $this->db->select('*')
          ->from('coordenador')
          ->where('id_coordenador', $id_usuario)
          ->get();
        $dados_usuario = $query_usuario->row_array();
        $nome_usuario = $dados_usuario['nome_coordenador'];
        $foto_usuario = base_url('import/sistema/' . $dados_usuario['foto']);
        ?>

        <li class="dropdown user user-menu">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">
            <img src="<?= $foto_usuario; ?>" class="user-image" alt="User Image">
            <span class="hidden-xs"><?= $nome_usuario; ?></span>
          </a>

          <ul class="dropdown-menu">
            <!-- User image -->
            <li class="user-header" style="background-color: <?= $color; ?>;">
              <img src="<?= $foto_usuario; ?>" class="img-circle" alt="User Image">
              <p><?= $nome_usuario; ?></p>
            </li>

            <!-- Menu Footer-->
            <li class="user-footer">
              <div class="pull-left">
                <a href="#" onclick="document.getElementById('page_editar_dados').submit();" class="btn btn-default btn-flat">Editar de Dados</a>

                <form action="<?= $voltar; ?>pagina_editar_pessoal" id="page_editar_dados" method="post">
                  <input type="hidden" name="x" value="1">
                </form>
              </div>
              <div class="pull-right">
                <a href="#" onclick="document.getElementById('page_sair').submit();" class="btn btn-default btn-flat">Sair</a>

                <form action="../<?= $voltar; ?>sair" id="page_sair" method="post">
                  <input type="hidden" name="id_usuario" value="<?= $id_usuario_2; ?>">
                </form>
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
    </div><br>
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
        <a href="<?= $voltar; ?>page/lideres">
          <i class="fa fa-users"></i>
          <span>Líderes</span>
        </a>
      </li>

      <li>
        <a href="<?= $voltar; ?>page/pg">
          <i class="fa fa-group"></i>
          <span>Seu PG</span>
        </a>
      </li>

      <li>
        <a href="<?= $voltar; ?>page/material-apoio-treinamento">
          <i class="fa fa-book"></i>
          <span>Treinamentos</span>
        </a>
      </li>

      <li>
        <a href="<?= $voltar; ?>page/download">
          <i class="fa fa-download"></i>
          <span>Download de Materiais</span>
        </a>
      </li>

      <li>
        <a href="https://play.google.com/store/apps/details?id=com.campbrasil.the.truth.code" target="_blank">
          <i class="fa fa-gamepad"></i>
          <span>The Truth Code</span>
        </a>
      </li>

      <!-- <li class="treeview">
        <a href="#">
          <i class="fa fa-download"></i>
          <span>Download de Material</span>
          <span class="pull-right-container">
            <span class="label label-default pull-right">9</span>
          </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="../pages/download_apoio.php"><i class="fa fa-circle-o"></i>Todos</a></li>
          <li><a href="../../arquivos/logo.png" download><i class="fa fa-circle-o"></i>Logo do CAMP</a></li>
          <li><a href="../pages/download_apoio_trilha.php"><i class="fa fa-circle-o"></i>Trilha</a></li>
          <li><a href="../pages/download_apoio_mergulho.php"><i class="fa fa-circle-o"></i>Mergulho</a></li>
          <li><a href="../pages/download_apoio_santuario.php"><i class="fa fa-circle-o"></i>Santuário</a></li>
          <li><a href="../pages/download_apoio_arco.php"><i class="fa fa-circle-o"></i>Arco</a></li>
          <li><a href="../pages/download_apoio_estacao.php"><i class="fa fa-circle-o"></i>Estação Final</a>
          </li>
          <li><a href="../pages/download_apoio_segredos.php"><i class="fa fa-circle-o"></i>Os segredos</a>
          </li>
          <li><a href="../pages/download_apoio_sobreviventes.php"><i class="fa fa-circle-o"></i>Os
              sobreviventes</a></li>
          <li><a href="../pages/download_apoio_exploradores.php"><i class="fa fa-circle-o"></i>Os
              Exploradores</a></li>
          <li>
            <a href="../pages/download_apoio_colheita.php">
              <i class="fa fa-circle-o"></i> A Colheita
              <span class="pull-right-container">
                <small class="label pull-right bg-green">new</small>
              </span>
            </a>
          </li>
        </ul>
      </li> -->
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>