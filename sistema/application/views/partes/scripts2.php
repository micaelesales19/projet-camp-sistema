<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('import/sistema/bower_components/bootstrap/dist/js/bootstrap.min.js'); ?>"></script>
<!-- FastClick -->
<script src="<?php echo base_url('import/sistema/bower_components/fastclick/lib/fastclick.js'); ?>"></script>
<script src="<?php echo base_url('import/sistema/dist/js/adminlte.min.js'); ?>"></script>
<script src="<?php echo base_url('import/sistema/dist/js/demo.js'); ?>"></script>
<!-- ChartJS -->
<script src="<?php echo base_url('import/sistema/bower_components/chart.js/Chart.js'); ?>"></script>
<script>
  $(function() {
    $("#datepicker").datepicker({
      dateFormat: 'dd/mm/yy',
      closeText: "Fechar",
      prevText: "&#x3C;Anterior",
      nextText: "Próximo&#x3E;",
      currentText: "Hoje",
      monthNames: ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"],
      monthNamesShort: ["Jan", "Fev", "Mar", "Abr", "Mai", "Jun", "Jul", "Ago", "Set", "Out", "Nov", "Dez"],
      dayNames: ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"],
      dayNamesShort: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
      dayNamesMin: ["Dom", "Seg", "Ter", "Qua", "Qui", "Sex", "Sáb"],
      weekHeader: "Sm",
      firstDay: 1,
      minDate: 0,
    });
  });
</script>