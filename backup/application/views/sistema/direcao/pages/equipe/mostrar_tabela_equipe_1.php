<table class="table table-hover" width="100%" cellspacing="0">
    <thead>
        <tr>
            <!-- <th id="clicar" onclick="list_sregionais(this);">S. Regionais <i class="fa fa-hand-pointer-o"></i></th>
            <th id="clicar" onclick="list_sregionais_ativos(this);">S. Regionais Ativos <i class="fa fa-hand-pointer-o"></i></th>
             -->
            <th>S. Regionais</i></th>
            <th>S. Regionais Ativos</i></th>
            <th>%</th>
            <th>S. Locais</i></th>
            <th>S. Locais Ativos</i></th>
            <th>%</th>
            <th>Coordenadores</i></th>
            <th>Coordenadores Ativos</i></th>
            <th>%</th>
            <th>Líderes</i></th>
            <th>Líderes Ativos</i></th>
            <th>%</th>
            <th>Crianças</i></th>
            <th>Crianças Ativas</i></th>
            <th>%</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_sregionais = $dados_sregional;
        $total_sregionais_ativos = $dados_sregional_ativos;

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

        if ($total_sregionais == 0 || $total_sregionais_ativos == 0) {
            $porcentagem_sregionais = 0;
            $class5 = 'danger';
        } else {
            $x = ($total_sregionais_ativos * 100) / $total_sregionais;
            $porcentagem_sregionais = round($x, 2, PHP_ROUND_HALF_UP);
            $class5 = $this->FConsultas_model->checkPorcentagem($x);
        }

        $comparacao_sregionais = "";
        $comparacao_sregionais_ativos = "";
        $comparacao_slocais = "";
        $comparacao_slocais_ativos = "";
        $comparacao_coordenadores = "";
        $comparacao_coordenadores_ativos = "";
        $comparacao_lider = "";
        $comparacao_lider_ativos = "";
        $comparacao_criancas = "";
        $comparacao_criancas_ativas = "";

        if ($mostrar_comparacao == 'sim') {
            $comparacao_sregionais = "/" . $comparacao[0]['row'];
            $comparacao_sregionais_ativos = "/" . $comparacao_ativos[0]['row'];
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
            <td><?= $total_sregionais; ?><?= $comparacao_sregionais; ?></td>
            <td><?= $total_sregionais_ativos; ?><?= $comparacao_sregionais_ativos; ?></td>
            <td><span class="label label-<?= $class5; ?>"><?= $porcentagem_sregionais; ?>%</span></td>

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
        </tr>
    </tbody>
</table>