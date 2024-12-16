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
            <th width="200px;">S. Regional</th>
            <th width="10px;">S. Locais</th>
            <th width="10px;">S. Locais Ativos</th>
            <th width="10px;">Coordenadores</th>
            <th width="10px;">Coordenadores Ativos</th>
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

        foreach ($lista as $key => $dados) {
            $id_sregional = $dados['id_supervisorEs'];
            $crianca_sregional = $this->FConsultas_model->mostrarCriancasPais($id_sregional, 3);

            $ativo = $dados['ativo'];
            $data_cadastro = $dados['data_cadastro'];
            $data_mais_um_mes = date('Y-m-d', strtotime('+1 month', strtotime($data_cadastro)));

            $foto_original = $dados['foto'];

            $datas = $this->FSistema_model->format_dates($opc1, $opc2, $dataInicio, $dataFim);

            $foto = base_url('import/sistema/' . $foto_original);
            $telefone = $dados['telefone_whatsapp'];

            $slocal_do_sregional = $this->FConsultas_model->getSLocal(['', '', $id_sregional], $opc1, $opc2, $datas);

            $total_slocal_do_sregional = $slocal_do_sregional['row'];
            $total_slocal_do_sregional_ativos = $slocal_do_sregional[0]['row'];

            $coordenadores_do_sregional = $this->FConsultas_model->getCoordenador(['sregional', '', $id_sregional], $opc1, $opc2, $datas);

            $total_coordenadores_do_sregional = $coordenadores_do_sregional['row'];
            $total_coordenadores_do_sregional_ativos = $coordenadores_do_sregional[0]['row'];

            $lideres_do_sregional = $this->FConsultas_model->getLideres(['sregional', '', $id_sregional], $opc1, $opc2, $datas);

            $total_lider_sregional = $lideres_do_sregional['row'];
            $total_lider_ativos_sregional = $lideres_do_sregional[0]['row'];

            $lista_de_id_1 = $this->FSistema_model->retornando_so_id('id_supervisorR', $slocal_do_sregional['dados']);
            $lista_de_id_2 = $this->FSistema_model->retornando_so_id('id_coordenador', $coordenadores_do_sregional['dados']);
            $id_gerais = array_merge($lista_de_id_1, $lista_de_id_2);

            $lista_de_id_1_ativos = $this->FSistema_model->retornando_so_id('id_supervisorR', $slocal_do_sregional[0]['dados']);
            $lista_de_id_2_ativos = $this->FSistema_model->retornando_so_id('id_coordenador', $coordenadores_do_sregional[0]['dados']);
            $id_gerais_ativos = array_merge($lista_de_id_1_ativos, $lista_de_id_2_ativos);

            $total_criancas_geral_sregional = $crianca_sregional['row'] + $lideres_do_sregional[1] + $this->FConsultas_model->getNumerosCriancas($id_user, $id_gerais, 'direcao');
            $total_criancas_ativos_sregional = $crianca_sregional['row'] + $lideres_do_sregional[2] + $this->FConsultas_model->getNumerosCriancas($id_user, $id_gerais_ativos, 'direcao');

            $progresso = "";
            $class1 = "danger";

            if ($ativo == 0) {
                $progresso = "Inativo";
                $class1 = "danger";
            } else if ($total_slocal_do_sregional < 1 || $total_coordenadores_do_sregional < 3 || $total_lider_sregional < 1 || $total_criancas_geral_sregional < 2) {
                $progresso = "Ativo";
                $class1 = "danger";
            } else if ($total_slocal_do_sregional_ativos < 1 || $total_coordenadores_do_sregional_ativos < 3 || $total_lider_ativos_sregional < 1 || $total_criancas_ativos_sregional < 2) {
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
                    <img src="<?= $foto; ?>" alt="" id="imgPhoto_usuario"> <?= $dados['nome_supervisorE']; ?>
                </td>
                <td><?= $total_slocal_do_sregional; ?></td>
                <td><?= $total_slocal_do_sregional_ativos; ?></td>
                <td><?= $total_coordenadores_do_sregional; ?></td>
                <td><?= $total_coordenadores_do_sregional_ativos; ?></td>
                <td><?= $total_lider_sregional; ?></td>
                <td><?= $total_lider_ativos_sregional; ?></td>
                <td><?= $total_criancas_geral_sregional; ?></td>
                <td><?= $total_criancas_ativos_sregional; ?></td>
                <td><span class="label label-<?= $class1; ?>"><?= $progresso; ?></span></td>
                <td>
                    <form action="sregional/<?= $dados['id_supervisorEs']; ?>" method="post">
                        <input type="hidden" name="id_user" value="<?= $dados['id_supervisorEs']; ?>">
                        <input type="submit" class="btn btn-info" value="Visualizar" />
                    </form>
                </td>
                <td id="clicar" onclick="enviar_whatsapp('<?= $telefone; ?>');"><input type="submit" class="btn btn-success" value="Enviar Mensagem" /></td>
            </tr>
        <?php } ?>
    </tbody>
</table>