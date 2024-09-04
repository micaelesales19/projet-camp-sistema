<header>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="<?php echo base_url('import/sistema/plugins/datatables/jquery.dataTables.js') ?>"></script>
    <link href="<?php echo base_url('import/sistema/plugins/datatables/dataTables.bootstrap4.css') ?>" rel="stylesheet">
    <script src="<?php echo base_url('import/sistema/plugins/datatables/dataTables.bootstrap4.js') ?>"></script>
</header>


<script type="text/javascript">
    $(document).ready(function() {
        $('#table').DataTable();
    });
</script>

<table class="table table-bordered table-hover" id="table" width="100%">
    <thead>
        <tr>
            <th width="200px;">Coordenador</th>
            <th width="10px;">Líderes</th>
            <th width="10px;">Líderes Ativos</th>
            <th width="10px;">Crianças</th>
            <th width="10px;">Crianças Ativas</th>
            <th width="10px;">Situação</th>
            <th width="10px;">Ação</th>
            <th width="10px;">Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $data = date('Y-m-d');
        $id_sregional = $id_user;

        foreach ($lista as $key => $dados) {
            $id_slocal = $dados['id_supervisorR'];
            $ativo = $dados['ativo'];
            $data_cadastro = $dados['data_cadastro'];
            $data_mais_um_mes = date('Y-m-d', strtotime('+1 month', strtotime($data_cadastro)));

            $foto_original = $dados['foto'];

            $datas = $this->FSistema_model->format_dates($opc1, $opc2, $dataInicio, $dataFim);

            $foto = base_url('import/sistema/' . $foto_original);
            $telefone = $dados['telefone_whatsapp'];

            $lideres_do_sregional = $this->FConsultas_model->getLideres(['sregional', 'slocal', $id_sregional, $id_slocal], $opc1, $opc2, $datas);

            $total_lider_sregional = $lideres_do_sregional['row'];
            $total_lider_ativos_sregional = $lideres_do_sregional[0]['row'];

            $total_criancas_geral_sregional =  $lideres_do_sregional[1];
            $total_criancas_ativos_sregional =   $lideres_do_sregional[2];

            $progresso = "";
            $class1 = "danger";

            if ($ativo == 0) {
                $progresso = "Inativo";
                $class1 = "danger";
            } else if ($total_lider_sregional < 1 || $total_criancas_geral_sregional < 2) {
                $progresso = "Ativo";
                $class1 = "danger";
            } else if ($total_lider_ativos_sregional < 1 || $total_criancas_ativos_sregional < 2) {
                $progresso = "Ativo";
                $class1 = "warning";
            } /*else if ($total_slocal_do_sregional_ativos == 0) {
                $progresso = "Inativo";
                $class1 = "warning";
            } else if ($total_criancas_geral_coordenador == 0) {
                $progresso = "Inativo";
                $class1 = "danger";
            } else if ($total_criancas_ativos_coordenador == 0) {
                $progresso = "Inativo";
                $class1 = "warning";
            }*/ else {
                $progresso = "Ativo";
                $class1 = "success";
            }
        ?>
            <tr>
                <td>
                    <img src="<?= $foto; ?>" alt="" id="imgPhoto_usuario"> <?= $dados['nome_coordenador']; ?>
                </td>
                <td><?= $total_lider_sregional; ?></td>
                <td><?= $total_lider_ativos_sregional; ?></td>
                <td><?= $total_criancas_geral_sregional; ?></td>
                <td><?= $total_criancas_ativos_sregional; ?></td>
                <td><span class="label label-<?= $class1; ?>"><?= $progresso; ?></span></td>
                <td>
                    <form action="../sregional/detalhes/<?= $dados['id_coordenador']; ?>" method="post">
                        <input type="hidden" name="id_user" value="<?= $dados['id_coordenador']; ?>">
                        <input type="submit" class="btn btn-info" value="Visualizar" />
                    </form>
                </td>
                <td id="clicar" onclick="enviar_whatsapp('<?= $telefone; ?>');"><input type="submit" class="btn btn-success" value="Enviar Mensagem" /></td>
            </tr>
        <?php } ?>
    </tbody>
</table>