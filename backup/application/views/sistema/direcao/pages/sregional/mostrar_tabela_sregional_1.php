<table class="table table-hover" width="100%" cellspacing="0">
    <thead>
        <tr>
            <!-- <th id="clicar" onclick="list_sregionais(this);">S. Locais <i class="fa fa-hand-pointer-o"></i></th>
            <th id="clicar" onclick="list_slocais_ativos(this);">S. Locais Ativos <i class="fa fa-hand-pointer-o"></i></th>
             -->
            <th>S. Locais</th>
            <th>S. Locais Ativos</th>
            <th>%</th>
            <th id="clicar">Coordenadores</i></th>
            <th id="clicar">Coordenadores Ativos</i></th>
            <th>%</th>
            <th id="clicar">Líderes</i></th>
            <th id="clicar">Líderes Ativos</i></th>
            <th>%</th>
            <th id="clicar">Crianças</i></th>
            <th id="clicar">Crianças Ativas</i></th>
            <th>%</th>
            <?php
            $dados_sregional = $this->FConsultas_model->getInfoSRegionalId($id_user);
            if ($dados_sregional['row'] == 0) {
            } else {
            ?>
                <th width="10px;">Ação</th>
                <th width="10px;">Ação</th>
            <?php } ?>
        </tr>
    </thead>
    <tbody>
        <?php

        $total_slocais = $dados_slocal_gerais;
        $total_slocais_ativos = $dados_slocal_ativos;

        $total_coordenadores = $dados_coordenadores_gerais;
        $total_coordenadores_ativos = $dados_coordenadores_ativos;

        $total_lideres = $dados_lideres_gerais;
        $total_lideres_ativos = $dados_lideres_ativos;

        if ($total_lideres_ativos == 0 || $total_lideres == 0) {
            $porcentagem_lideres = 0;
            $class1 = 'danger';
        } else {
            $x = ($total_lideres_ativos * 100) / $total_lideres;
            $porcentagem_lideres = round($x, 2, PHP_ROUND_HALF_UP);
            $class1 = $this->FConsultas_model->checkPorcentagem($x);
        }

        if ($dados_criancas_ativos == 0 || $dados_criancas_gerais == 0) {
            $porcentagem_criancas = 0;
            $class2 = 'danger';
        } else {
            $y = ($dados_criancas_ativos * 100) / $dados_criancas_gerais;
            $porcentagem_criancas = round($y, 2, PHP_ROUND_HALF_UP);

            $class2 = $this->FConsultas_model->checkPorcentagem($y);
        }

        if ($total_coordenadores_ativos == 0 || $total_coordenadores == 0) {
            $porcentagem_coordenadores = 0;
            $class3 = 'danger';
        } else {
            $x = ($total_coordenadores_ativos * 100) / $total_coordenadores;
            $porcentagem_coordenadores = round($x, 2, PHP_ROUND_HALF_UP);
            $class3 = $this->FConsultas_model->checkPorcentagem($x);
        }

        if ($total_slocais == 0 || $total_slocais_ativos == 0) {
            $porcentagem_slocais = 0;
            $class4 = 'danger';
        } else {
            $x = ($total_slocais_ativos * 100) / $total_slocais;
            $porcentagem_slocais = round($x, 2, PHP_ROUND_HALF_UP);
            $class4 = $this->FConsultas_model->checkPorcentagem($x);
        }

        $comparacao_slocais = "";
        $comparacao_slocais_ativos = "";
        $comparacao_coordenadores = "";
        $comparacao_coordenadores_ativos = "";
        $comparacao_lider = "";
        $comparacao_lider_ativos = "";
        $comparacao_criancas = "";
        $comparacao_criancas_ativas = "";

        if ($mostrar_comparacao == 'sim') {
            $comparacao_slocais = "/" . $comparacao[1]['row'];
            $comparacao_slocais_ativos = "/" . $comparacao_ativos[1]['row'];
            $comparacao_coordenadores = "/" . $comparacao[2]['row'];
            $comparacao_coordenadores_ativos = "/" . $comparacao_ativos[2]['row'];
            $comparacao_lider = "/" . $comparacao[3]['row'];
            $comparacao_lider_ativos = "/" . $comparacao_ativos[3]['row'];
            $comparacao_criancas = "/" . $comparacao[4];
            $comparacao_criancas_ativas = "/" . $comparacao_ativos[4];
        } else {
        }
        ?>
        <tr>
            <td><?= $total_slocais; ?><?= $comparacao_slocais; ?></td>
            <td><?= $total_slocais_ativos; ?><?= $comparacao_slocais_ativos; ?></td>
            <td><span class="label label-<?= $class4; ?>"><?= $porcentagem_slocais; ?>%</span></td>

            <td><?= $total_coordenadores; ?><?= $comparacao_coordenadores; ?></td>
            <td><?= $total_coordenadores_ativos; ?><?= $comparacao_coordenadores_ativos; ?></td>
            <td><span class="label label-<?= $class3; ?>"><?= $porcentagem_coordenadores; ?>%</span></td>

            <td><?= $total_lideres; ?><?= $comparacao_lider; ?></td>
            <td><?= $total_lideres_ativos; ?><?= $comparacao_lider_ativos; ?></td>
            <td><span class="label label-<?= $class1; ?>"><?= $porcentagem_lideres; ?>%</span></td>

            <td><?= $dados_criancas_gerais; ?><?= $comparacao_criancas; ?></td>
            <td><?= $dados_criancas_ativos; ?><?= $comparacao_criancas_ativas; ?></td>
            <td><span class="label label-<?= $class2; ?>"><?= $porcentagem_criancas; ?>%</span></td>
            <?php
            if ($dados_sregional['row'] == 0) {
            } else {
            ?>
                <td>
                    <form action="detalhes/<?= $dados_sregional['dados']['id_supervisorEs']; ?>" method="post">
                        <input type="submit" class="btn btn-info" value="Detalhes" />
                    </form>
                </td>
                <td id="clicar" onclick="enviar_whatsapp('<?= $dados_sregional['dados']['telefone_whatsapp']; ?>');"><input type="submit" class="btn btn-success" value="Enviar Mensagem" /></td>
            <?php } ?>
        </tr>
    </tbody>
</table>