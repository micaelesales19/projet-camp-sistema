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
            <th width="200px;">Líder</th>
            <th width="10px;">Crianças</th>
            <th width="10px;">Crianças Ativas</th>
            <th width="10px;">Módulo</th>
            <th width="10px;">Progresso</th>
            <!-- <th width="10px;">Pontuação</th> -->
            <th width="10px;">Ação</th>
            <th width="10px;">Ação</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $dados_lideres = $dados_lideres_gerais['dados'];

        $data = date('Y-m-d');

        foreach ($dados_lideres as $key => $lider) {
            $id_lider = $lider['id_lider'];
            $confirmado = $lider['confirmado'];
            $data_cadastro = $lider['data_cadastro'];
            $data_mais_um_mes = date('Y-m-d', strtotime('+1 month', strtotime($data_cadastro)));

            $foto_original = $lider['foto'];

            $foto = base_url('import/sistema/' . $foto_original);
            $telefone = $lider['telefone_whatsapp'];

            $qtd_criancas = $this->FConsultas_model->mostrarCriancasPais($id_lider, 3);
            $qtd_criancas_ativas = $this->FConsultas_model->mostrarCriancasPaisPg($id_lider, 0, 3);
            $pgs = $this->FConsultas_model->mostrarPG($id_lider, 3);

            $nome_modulo = "";
            $progresso = "";
            $class1 = "danger";

            if ($confirmado == 0 || $confirmado == 1) {
                $progresso = "Cadastro Incompleto";
                $class1 = "primary";
            } else  if (strtotime($data_mais_um_mes) > strtotime($data)) {
                $progresso = "Novo";
                $class1 = "info";
                if ($pgs['row'] == 0) {
                } else {
                    $id_modulo = $pgs['dados']['id_modulo'];
                    $modulo = $this->FConsultas_model->consultarModuloId($id_modulo);
                    $nome_modulo = $modulo['nome_modulo'];
                }
            } else {
                if ($pgs['row'] == 0 && $qtd_criancas_ativas['row'] == 0) {
                    $progresso = "Inativo";
                } else {
                    $id_modulo = $pgs['dados']['id_modulo'] ?? 1;
                    $numero_licao = $pgs['dados']['n_licao'] ?? 1;
                    $id_pg = $pgs['dados']['id_pg'] ?? 0;

                    $modulo = $this->FConsultas_model->consultarModuloId($id_modulo);
                    $nome_modulo = $modulo['nome_modulo'];

                    $progresso = $this->FConsultas_model->consultarProgressoGeral($id_lider, 2);

                    if ($progresso['row'] == 0) {
                        $progresso = "Inativo";
                    } else {
                        $data_ultimo_relatorio = "";
                        $i = 0;
                        foreach ($progresso['dados'] as $key => $p) {
                            $data_ultimo = $p['data_aula'];
                            $i++;
                            if ($i == $progresso['row']) {
                                $data_ultimo_relatorio = $data_ultimo;
                            }
                        }

                        if ($data_ultimo_relatorio == '') {
                            $progresso = "Inativo";
                            $class1 = "warning";
                        } else {

                            $data_convertida = $this->FConsultas_model->converterData($data_ultimo_relatorio);

                            $data_mais_2_meses = date('Y-m-d', strtotime('+2 months', strtotime($data_convertida)));

                            // echo "DULTIMO - " . $data_convertida . " D2MESES - " . $data_mais_2_meses . '<br>';
                            if (strtotime($data_mais_2_meses) < strtotime($data)) {
                                $progresso = "Inativo";
                                $class1 = "warning";
                            } else if ($id_modulo == 10 && $numero_licao == $modulo['n_licao']) {
                                $progresso = "Ativo";
                                $class1 = "success";
                            } else {
                                $progresso = "Ativo";
                                $class1 = "success";
                            }
                        }
                    }
                }
            }

        ?>
            <tr>
                <td>
                    <img src="<?= $foto; ?>" alt="" id="imgPhoto_usuario"> <?= $lider['nome_lider']; ?>
                </td>
                <td><?= $qtd_criancas['row']; ?></td>
                <td><?= $qtd_criancas_ativas['row']; ?></td>
                <td><?= $nome_modulo; ?></td>
                <td><span class="label label-<?= $class1; ?>"><?= $progresso; ?></span></td>
                <?php
                if (!$check_is_coord_query) {
                ?>
                    <td>
                        <form action="lideres/detalhes/<?= $lider['id_lider']; ?>" method="post">
                            <input type="hidden" name="id_lider" value="<?= $lider['id_lider']; ?>">
                            <input type="hidden" name="nivel" value="lider">

                            <input type="submit" class="btn btn-info" value="Visualizar" />
                        </form>
                    </td>
                    <td id="clicar" onclick="enviar_whatsapp('<?= $telefone; ?>');"><input type="submit" class="btn btn-success" value="Enviar Mensagem" /></td>
                <?php
                } else {
                ?>
                    <td>
                        <form action="lideres/detalhes/<?= $lider['id_lider']; ?>" method="post">
                            <input type="hidden" name="id_coord" value="<?= $id_user; ?>">
                            <input type="hidden" name="nivel" value="coordenador">

                            <input type="submit" class="btn btn-info" value="Visualizar" />
                        </form>
                    </td>
                    <td id="clicar" onclick="enviar_whatsapp('<?= $telefone; ?>');"><input type="submit" class="btn btn-success" value="Enviar Mensagem" /></td>
                <?php
                }
                ?>
            </tr>
        <?php } ?>
    </tbody>
</table>