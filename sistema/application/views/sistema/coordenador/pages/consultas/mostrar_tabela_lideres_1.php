<table class="table table-hover" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th>Perfil</th>
            <th onclick="list_lideres(this);">Líderes <i class="fa fa-hand-pointer-o"></i></th>
            <th>Líderes Ativos <i class="fa fa-hand-pointer-o"></i></th>
            <th>% L.A.</th>
            <th>Crianças <i class="fa fa-hand-pointer-o"></i></th>
            <th>Crianças Ativas <i class="fa fa-hand-pointer-o"></i></th>
            <th>% C.A.</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_lideres = $dados_lideres_gerais['row'];
        $total_lideres_ativos = $dados_lideres_ativos['row'];

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

        $comparacao_lider = "";
        $comparacao_lider_ativos = "";
        $comparacao_criancas = "";
        $comparacao_criancas_ativas = "";

        if ($mostrar_comparacao == 'sim') {
            $comparacao = $dados_lideres_gerais['comparacao'];
            $comparacao_lider = " /" . $comparacao['lideres'];
            $comparacao_lider_ativos = " /" . $comparacao['lideres_ativos'];
            $comparacao_criancas = " /" . $comparacao['criancas'];
            $comparacao_criancas_ativas = " /" . $comparacao['criancas_ativas'];
        } else {
        }
        ?>
        <tr>
            <td><?= $dados_coordenador['dados']['nome_coordenador']; ?></td>
            <td><?= $total_lideres; ?><?= $comparacao_lider; ?></td>
            <td><?= $total_lideres_ativos; ?><?= $comparacao_lider_ativos; ?></td>
            <td><span class="label label-<?= $class1; ?>"><?= $porcentagem_lideres; ?>%</span></td>
            <td><?= $dados_criancas_gerais; ?><?= $comparacao_criancas; ?></td>
            <td><?= $dados_criancas_ativos; ?><?= $comparacao_criancas_ativas; ?></td>
            <td><span class="label label-<?= $class2; ?>"><?= $porcentagem_criancas; ?>%</span></td>
        </tr>
    </tbody>
</table>