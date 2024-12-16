<header>
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

    <script src="<?php echo base_url('import/sistema/plugins/datatables/jquery.dataTables.js') ?>"></script>
    <link href="<?php echo base_url('import/sistema/plugins/datatables/dataTables.bootstrap4.css') ?>" rel="stylesheet">
    <script src="<?php echo base_url('import/sistema/plugins/datatables/dataTables.bootstrap4.js') ?>"></script>
</header>


<script type="text/javascript">
    $(document).ready(function() {
        $('#table_lider').DataTable();
    });
</script>

<table class="table table-bordered table-hover" id="table_lider" width="100%">
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
        $dados_coordenadores = $dados_coordenadores_gerais['dados'];

        $data = date('Y-m-d');

        foreach ($dados_coordenadores as $key => $lider) {
            $id_coordenador = $lider['id_coordenador'];
            $ativo = $lider['ativo'];
            $data_cadastro = $lider['data_cadastro'];
            $data_mais_um_mes = date('Y-m-d', strtotime('+1 month', strtotime($data_cadastro)));

            $foto_original = $lider['foto'];

            $foto = base_url('import/sistema/' . $foto_original);
            $telefone = $lider['telefone_whatsapp'];

            $total_lider_coordenador = $this->FConsultas_model->getLideres([$id_coordenador], 1, 1, []);
            $total_lider_ativos_coordenador =  $this->FConsultas_model->lideresAtivos($total_lider_coordenador);

            $total_criancas_geral_coordenador = $this->FConsultas_model->getNumerosCriancas([$id_coordenador], $total_lider_coordenador, 'criancas_coord_1');
            $total_criancas_ativos_coordenador = $this->FConsultas_model->getNumerosCriancas([$id_coordenador], $total_lider_ativos_coordenador, 'criancas_coord_1');

            $progresso = "";
            $class1 = "danger";

            if ($ativo == 0) {
                $progresso = "Inativo";
                $class1 = "danger";
            } else if ($total_lider_coordenador['row'] == 0) {
                $progresso = "Inativo";
                $class1 = "danger";
            } else if ($total_lider_ativos_coordenador['row'] == 0) {
                $progresso = "Inativo";
                $class1 = "warning";
            } else if ($total_criancas_geral_coordenador == 0) {
                $progresso = "Inativo";
                $class1 = "danger";
            } else if ($total_criancas_ativos_coordenador == 0) {
                $progresso = "Inativo";
                $class1 = "warning";
            } else {
                $progresso = "Ativo";
                $class1 = "success";
            }
        ?>
            <tr>
                <td>
                    <img src="<?= $foto; ?>" alt="" id="imgPhoto_usuario"> <?= $lider['nome_coordenador']; ?>
                </td>
                <td><?= $total_lider_coordenador['row']; ?></td>
                <td><?= $total_lider_ativos_coordenador['row']; ?></td>
                <td><?= $total_criancas_geral_coordenador; ?></td>
                <td><?= $total_criancas_ativos_coordenador; ?></td>
                <td><span class="label label-<?= $class1; ?>"><?= $progresso; ?></span></td>
                <td>
                    <form action="lideres" method="post">
                        <input type="hidden" name="id_user" value="<?= $lider['id_coordenador']; ?>">
                        <input type="submit" class="btn btn-info" value="Visualizar" />
                    </form>
                </td>
                <td id="clicar" onclick="enviar_whatsapp('<?= $telefone; ?>');"><input type="submit" class="btn btn-success" value="Enviar Mensagem" /></td>
            </tr>
        <?php } ?>
    </tbody>
</table>