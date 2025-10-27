<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>CAMP Brasil</title>
  <link rel="icon" href="<?php echo base_url('import/logo/android/android-launchericon-512-512.png'); ?>" type="image/x-icon" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('import/sistema/bower_components/bootstrap/dist/css/bootstrap.min.css'); ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('import/sistema/bower_components/font-awesome/css/font-awesome.min.css'); ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('import/sistema/bower_components/Ionicons/css/ionicons.min.css'); ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('import/sistema/dist/css/AdminLTE.css'); ?>">
  <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="<?php echo base_url('import/sistema/dist/css/skins/_all-skins.min.css'); ?>">
  <!-- Morris chart -->
  <link rel="stylesheet" href="<?php echo base_url('import/sistema/bower_components/morris.js/morris.css'); ?>">
  <!-- jvectormap -->
  <link rel="stylesheet" href="<?php echo base_url('import/sistema/bower_components/jvectormap/jquery-jvectormap.css'); ?>">
  <!-- Date Picker -->
  <link rel="stylesheet" href="<?php echo base_url('import/sistema/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css'); ?>">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="<?php echo base_url('import/sistema/bower_components/bootstrap-daterangepicker/daterangepicker.css'); ?>">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="<?php echo base_url('import/sistema/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'); ?>">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="<?php echo base_url('import/sistema/bower_components/fullcalendar/dist/fullcalendar.min.css'); ?>">
  <link rel="stylesheet" href="<?php echo base_url('import/sistema/bower_components/fullcalendar/dist/fullcalendar.print.min.css'); ?>" media="print">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- jQuery 3 -->
  <script src="<?php echo base_url('import/sistema/bower_components/jquery/dist/jquery.min.js'); ?>"></script>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">

  <script src="<?php echo base_url('import/sistema/plugins/datatables/jquery.dataTables.js') ?>"></script>
  <link href="<?php echo base_url('import/sistema/plugins/datatables/dataTables.bootstrap4.css') ?>" rel="stylesheet">
  <script src="<?php echo base_url('import/sistema/plugins/datatables/dataTables.bootstrap4.js') ?>"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#table_criancas_pais').DataTable();
      $('#table_devocionais').DataTable();
      $('#table_lideres').DataTable();
      var x = window.matchMedia("(max-width: 480px)")
      responsive_function(x) // Call listener function at run time
      //x.addListener(responsive_function)
    });

    function responsive_function(x) {
      if (x.matches) { // If media query matches
        document.getElementById('colxs8').classList.remove('col-xs-8');
        document.getElementById('colxs8').classList.add('col-lg-12');
        document.getElementById('colxs4').classList.remove('col-xs-4');
        document.getElementById('colxs4').classList.add('col-lg-12');
      } else {
        document.getElementById('colxs8').classList.remove('col-lg-12');
        document.getElementById('colxs8').classList.add('col-xs-8');
        document.getElementById('colxs4').classList.remove('col-lg-12');
        document.getElementById('colxs4').classList.add('col-xs-4');
      }
    }

    function formataCPF(cpf) {
      const elementoAlvo = cpf
      const cpfAtual = cpf.value

      let cpfAtualizado;

      cpfAtualizado = cpfAtual.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/,
        function(regex, argumento1, argumento2, argumento3, argumento4) {
          return argumento1 + '.' + argumento2 + '.' + argumento3 + '-' + argumento4;
        })
      elementoAlvo.value = cpfAtualizado;
    }

    function mascara_data(campo, valor) {
      var mydata = '';
      mydata = mydata + valor;
      if (mydata.length == 2) {
        mydata = mydata + '/';
        campo.value = mydata;
      }

      if (mydata.length == 5) {
        mydata = mydata + '/';
        campo.value = mydata;
      }
    }
  </script>

  <style>
    #p_legenda {
      display: inline;
    }
  </style>

</head>
