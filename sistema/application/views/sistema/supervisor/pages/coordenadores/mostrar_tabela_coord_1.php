<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

<table class="table table-hover" width="100%" cellspacing="0">
    <thead>
        <tr>
            <th id="clicar" onclick="voltar_list_coordenadores(this);">Coordenadores <i class="fa fa-hand-pointer-o"></i></th>
            <th id="clicar" onclick="list_coordenadores_ativos(this);">Coordenadores Ativos <i class="fa fa-hand-pointer-o"></i></th>
            <th>% C.A.</th>
            <th>Líderes <i class="fa fa-hand-pointer-o"></i></th>
            <th>Líderes Ativos <i class="fa fa-hand-pointer-o"></i></th>
            <th>% L.A.</th>
            <th>Crianças <i class="fa fa-hand-pointer-o"></i></th>
            <th>Crianças Ativas <i class="fa fa-hand-pointer-o"></i></th>
            <th>% C.A.</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_coordenadores = count($info_coordenadores['dados_coordenadores_gerais']['dados']);

        $total_coordenadores_ativos = $info_coordenadores['total_coordenadores_ativos'];

        $total_lideres =  0;
        $total_lideres_ativos = 0;

        $total_criancas = 0;
        $total_criancas_ativos = 0;

        foreach ($info_coordenadores['dados_coordenadores_gerais']['dados'] as $coordenador) {
            $total_lideres += $coordenador['total_lideres'];
        }

        foreach ($info_coordenadores['dados_coordenadores_gerais']['dados'] as $coordenador) {
            $total_lideres_ativos += $coordenador['total_lideres_ativos'];
        }

        foreach ($info_coordenadores['dados_coordenadores_gerais']['dados'] as $coordenador) {
            $total_criancas += $coordenador['total_criancas'];
        }

        foreach ($info_coordenadores['dados_coordenadores_gerais']['dados'] as $coordenador) {
            $total_criancas_ativos += $coordenador['total_criancas_ativos'];
        }

        //$total_coordenadores = $info_coordenadores['dados_coordenadores_gerais'];
        //$total_lideres_ativos = $info_coordenadores['total_lideres_ativos'];

        //$total_criancas =  $info_coordenadores['total_criancas_lideres'];
        //$total_criancas_ativos = $info_coordenadores['total_criancas_lideres_ativos'];

        if ($total_lideres_ativos == 0 || $total_lideres == 0) {
            $porcentagem_lideres = 0;
            $class2 = 'danger';
        } else {
            $x = ($total_lideres_ativos * 100) / $total_lideres;
            $porcentagem_lideres = round($x, 2, PHP_ROUND_HALF_UP);
            $class2 = $this->FConsultas_model->checkPorcentagem($x);
        }

        if ($total_criancas == 0 || $total_criancas_ativos == 0) {
            $porcentagem_criancas = 0;
            $class3 = 'danger';
        } else {
            $y = ($total_criancas_ativos * 100) / $total_criancas;
            $porcentagem_criancas = round($y, 2, PHP_ROUND_HALF_UP);
            $class3 = $this->FConsultas_model->checkPorcentagem($y);
        }

        if ($total_coordenadores_ativos == 0 || $total_coordenadores == 0) {
            $porcentagem_coordenadores = 0;
            $class1 = 'danger';
        } else {
            $x = ($total_coordenadores_ativos * 100) / $total_coordenadores;
            $porcentagem_coordenadores = round($x, 2, PHP_ROUND_HALF_UP);
            $class1 = $this->FConsultas_model->checkPorcentagem($x);
        }

        $comparacao_coordenadores = "";
        $comparacao_coordenadores_ativos = "";
        $comparacao_lideres = "";
        $comparacao_lideres_ativos = "";
        $comparacao_criancas = "";
        $comparacao_criancas_ativas = "";

        /*if ($mostrar_comparacao == 'sim') {
            $comparacao_1 = $dados_coordenadores_gerais['comparacao'];
            $comparacao_coordenadores = "/" . $comparacao_1['coordenadores'];
            $comparacao_coordenadores_ativos = "/" . $comparacao_1['coordenadores_ativos'];
            $comparacao_2 = $dados_lideres_gerais['comparacao'];
            $comparacao_lider = "/" . $comparacao_2['lideres'];
            $comparacao_lider_ativos = "/" . $comparacao_2['lideres_ativos'];
            $comparacao_criancas = "/" . $comparacao_2['criancas'];
            $comparacao_criancas_ativas = "/" . $comparacao_2['criancas_ativas'];
        } else {
        }*/
        ?>
        <tr>
            <td><?= $total_coordenadores; ?><?= $comparacao_coordenadores; ?></td>
            <td><?= $total_coordenadores_ativos; ?><?= $comparacao_coordenadores_ativos; ?></td>
            <td><span class="label label-<?= $class1; ?>"><?= $porcentagem_coordenadores; ?>%</span></td>

            <td><?= $total_lideres; ?><?= $comparacao_lideres; ?></td>
            <td><?= $total_lideres_ativos; ?><?= $comparacao_lideres_ativos; ?></td>
            <td><span class="label label-<?= $class2; ?>"><?= $porcentagem_lideres; ?>%</span></td>

            <td><?= $total_criancas; ?><?= $comparacao_criancas; ?></td>
            <td><?= $total_criancas_ativos; ?><?= $comparacao_criancas_ativas; ?></td>
            <td><span class="label label-<?= $class3; ?>"><?= $porcentagem_criancas; ?>%</span></td>
        </tr>
    </tbody>
</table>
