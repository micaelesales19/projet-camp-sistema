<script type="text/javascript">
    $(document).ready(function() {
        $('#table_lideres').DataTable();
    });
</script>
<div style="overflow-x:auto;">
    <table class="table table-hover" id="table_lideres" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Crianças</th>
                <th>Crianças Ativas</th>
                <th>Módulo</th>
                <th>Progresso</th>
                <th>Ação</th>
                <th>Ação</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $total_lideres = $dados_lideres_gerais['row'];
            $dados_lideres = $dados_lideres_gerais['dados'];
            $total_lideres_ativos = $dados_lideres_ativos['row'];

            $data = date('Y-m-d');

            foreach ($dados_lideres as $key => $lider) {
                $id_lider = $lider['id_lider'];
                $data_cadastro = $lider['data_cadastro'];
                $data_mais_um_mes = date('Y-m-d', strtotime('+1 month', strtotime($data_cadastro)));

                $qtd_criancas = $this->FConsultas_model->mostrarCriancasPais($id_lider, 3);
                $qtd_criancas_ativas = $this->FConsultas_model->mostrarCriancasPaisPg($id_lider, 0, 3);
                $pgs = $this->FConsultas_model->mostrarPG($id_lider, 3);

                $nome_modulo = "";
                $progresso = "";
                $class1 = "danger";

                if (strtotime($data_mais_um_mes) > strtotime($data)) {
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
                    <td><?= $lider['nome_lider']; ?></td>
                    <td><?= $qtd_criancas['row']; ?></td>
                    <td><?= $qtd_criancas_ativas['row']; ?></td>
                    <td><?= $nome_modulo; ?></td>
                    <td><span class="label label-<?= $class1; ?>"><?= $progresso; ?></span></td>
                    <td><input type="submit" class="btn btn-info" value="Visualizar" /></td>
                    <td><input type="submit" class="btn btn-success" value="Enviar Mensagem" /></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>