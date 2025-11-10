

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Recupera o valor da sessão ou usa 'opc1' como padrão
        var session_opc1 = sessionStorage.getItem('opc1') || 'opc4';

        // Seleciona o radio com o mesmo value e marca como checked
        const radio = document.querySelector(`input[name="opc"][value="${session_opc1}"]`);
        if (radio) {
            radio.checked = true;
        }

        // Recupera as sessões ou define valores padrões
        var dataInicio = sessionStorage.getItem('data_in') || '2018-02-01';
        var dataFinal = sessionStorage.getItem('data_final') || '';

        // Atualiza os inputs se os elementos existirem
        const inputDe = document.getElementById('datepicker_de');
        const inputAte = document.getElementById('datepicker_ate');

        if (inputDe) {
            inputDe.value = dataInicio;
        }

        if (inputAte && dataFinal !== '') {
            inputAte.value = dataFinal;
        }
    });
</script>

<div class="input-group">
    <span class="input-group-addon">
        <input type="radio" id="opc" name="opc" value="opc1" class="radio1"
            onclick="mostrarResultado();" disabled>
    </span>
    <h5 id="label">Último mês</h5>
</div>
<!-- /input-group -->
<div class="input-group">
    <span class="input-group-addon">
        <input type="radio" id="opc" name="opc" value="opc2" class="radio2"
            onclick="mostrarResultado();" checked disabled>
    </span>
    <h5 id="label">Últimos 6 meses</h5>
</div>

<div class="input-group">
    <span class="input-group-addon">
        <input type="radio" id="opc" name="opc" class="radio4" value="opc4"
            onclick="mostrarResultado();" disabled>
    </span>
</div>

<script>
var hoje = new Date();

function mudou() {
    $('.radio4').prop('checked', true);
    var data_1 = document.getElementById('datepicker_de').value;
    var data_2 = document.getElementById('datepicker_ate').value;

    if (data_2 < data_1) {
        alert('A Data (Até) não pode ser menor que a Data (De)');
    } else {
        mostrarResultado();
    }
}
</script>
