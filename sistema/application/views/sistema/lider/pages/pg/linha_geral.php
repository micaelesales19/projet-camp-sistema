<script type="text/javascript">
    $(document).ready(function() {
        $('#table_progresso').DataTable();
    });
</script>

<div style="overflow-x:auto;">
    <table class="table table-bordered" id="table_progresso" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Módulo</th>
                <th>Presença</th>
                <th>Versículo</th>
                <th>Mistério</th>
                <th>Devocional</th>
                <th>Pontuação</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $modulos = $this->FConsultas_model->consultarModulo();;

            $somaTotalPresencaModulo = 0;
            $somaTotalVersiculoModulo = 0;
            $somaTotalMisterioModulo = 0;
            $somaTotalDevocionalModulo = 0;

            $somaTotalPresencaPG = 0;
            $somaTotalVersiculoPG = 0;
            $somaTotalMisterioPG = 0;
            $somaTotalPontuacaoPG = 0;
            $somaTotalDevocionalPG = 0;

            if ($modulos) {

                $qtdPresenca = 0;
                $qtdVersiculo = 0;
                $qtdMisterio = 0;
                $qtdDevocional = 0;

                $id_modulos  = [];

                foreach ($modulos as $key => $m) {
                    $id_modulos[] = $m['id_modulo'];
                }

                $i = 0;
                foreach ($modulos as $key => $m) {

                    $total_aulas = $m['n_licao'];

                    $consultarModuloId = $this->FConsultas_model->consultarModuloId($m['id_modulo']);
                    $qtdPresenca = $consultarModuloId['n_licao'];
                    $qtdVersiculo =  $consultarModuloId['qtdVersiculo'];
                    $qtdMisterio =  $consultarModuloId['qtdMisterios'];
                    $qtdDevocional =  $qtdPresenca;

                    $qtdPresenca = $qtdPresenca * $consultaCriancas['row'];
                    $qtdVersiculo = $qtdVersiculo * $consultaCriancas['row'];
                    $qtdMisterio = $qtdMisterio * $consultaCriancas['row'];
                    $qtdDevocional = $qtdDevocional * $consultaCriancas['row'];

                    $somaTotalPresencaModulo = $somaTotalPresencaModulo + $qtdPresenca;
                    $somaTotalVersiculoModulo = $somaTotalVersiculoModulo + $qtdVersiculo;
                    $somaTotalMisterioModulo = $somaTotalMisterioModulo + $qtdMisterio;
                    $somaTotalDevocionalModulo = $somaTotalDevocionalModulo + $qtdDevocional;

                    $pontuacao = 0;
                    $presencaTotal = 0;
                    $versiculoTotal = 0;
                    $misterioTotal = 0;
                    $devocionalTotal = 0;

                    if ($consultaCriancas['row'] == 0) {
                    } else {
                        //foreach ($consultaCriancas['dados'] as $key => $linha) {
                        //$id_cri = $linha['id_crianca'];
                        $consultarProgresso1 = $this->PG->consultar_progresso('query_id_pg_id_lider_id_modulo', [$id_pg, $id_lider, $id_modulos[0]]);
                        $consultarProgresso2 = $this->PG->consultar_progresso('query_id_pg_id_lider_id_modulo', [$id_pg, $id_lider, $id_modulos[1]]);
                        $consultarProgresso3 = $this->PG->consultar_progresso('query_id_pg_id_lider_id_modulo', [$id_pg, $id_lider, $id_modulos[2]]);
                        $consultarProgresso4 = $this->PG->consultar_progresso('query_id_pg_id_lider_id_modulo', [$id_pg, $id_lider, $id_modulos[3]]);
                        $consultarProgresso5 = $this->PG->consultar_progresso('query_id_pg_id_lider_id_modulo', [$id_pg, $id_lider, $id_modulos[4]]);
                        //}
                    }

                    $query = [];

                    if ($consultaCriancas['row'] == 0) {
                    } else {
                        if ($i == 0) {
                            if ($consultarProgresso1['row'] == 0) {
                                $presencaTotal = 0;
                                $versiculoTotal = 0;
                                $misterioTotal = 0;
                                $devocionalTotal = 0;
                                $pontuacao = 0;
                            } else {
                                $query = $consultarProgresso1['dados'];

                                foreach ($query as $key => $value) {

                                    $presenca = $value['presenca'] == '' ? 0 : $value['presenca'];
                                    $versiculo = $value['versiculo_memorizado'] == '' ? 0 : $value['versiculo_memorizado'];
                                    $misterio = $value['misterio_respondido'] == '' ? 0 : $value['misterio_respondido'];
                                    $devocional = $value['devocional_respondido'] == '' ? 0 : $value['devocional_respondido'];

                                    $presencaTotal = $presencaTotal + $presenca;
                                    $versiculoTotal = $versiculoTotal + $versiculo;
                                    $misterioTotal = $misterioTotal + $misterio;
                                    $devocionalTotal = $devocionalTotal + $devocional;

                                    $pontuacao = $pontuacao + ($presenca == 1 ? 5 : 0);
                                    $pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
                                    $pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
                                    $pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
                                }
                                $somaTotalPresencaPG = $somaTotalPresencaPG + $presencaTotal;
                                $somaTotalVersiculoPG = $somaTotalVersiculoPG + $versiculoTotal;
                                $somaTotalMisterioPG = $somaTotalMisterioPG + $misterioTotal;
                                $somaTotalDevocionalPG = $somaTotalDevocionalPG + $devocionalTotal;
                                $somaTotalPontuacaoPG = $somaTotalPontuacaoPG + $pontuacao;
                            }
                        } else  if ($i == 1) {
                            if ($consultarProgresso2['row'] == 0) {

                                $presencaTotal = 0;
                                $versiculoTotal = 0;
                                $misterioTotal = 0;
                                $devocionalTotal = 0;
                                $pontuacao = 0;
                            } else {
                                $query = $consultarProgresso2['dados'];
                                foreach ($query as $key => $value) {

                                    $presenca = $value['presenca'] == '' ? 0 : $value['presenca'];
                                    $versiculo = $value['versiculo_memorizado'] == '' ? 0 : $value['versiculo_memorizado'];
                                    $misterio = $value['misterio_respondido'] == '' ? 0 : $value['misterio_respondido'];
                                    $devocional = $value['devocional_respondido'] == '' ? 0 : $value['devocional_respondido'];

                                    $presencaTotal = $presencaTotal + $presenca;
                                    $versiculoTotal = $versiculoTotal + $versiculo;
                                    $misterioTotal = $misterioTotal + $misterio;
                                    $devocionalTotal = $devocionalTotal + $devocional;

                                    $pontuacao = $pontuacao + ($presenca == 1 ? 5 : 0);
                                    $pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
                                    $pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
                                    $pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
                                }
                                $somaTotalPresencaPG = $somaTotalPresencaPG + $presencaTotal;
                                $somaTotalVersiculoPG = $somaTotalVersiculoPG + $versiculoTotal;
                                $somaTotalMisterioPG = $somaTotalMisterioPG + $misterioTotal;
                                $somaTotalDevocionalPG = $somaTotalDevocionalPG + $devocionalTotal;
                                $somaTotalPontuacaoPG = $somaTotalPontuacaoPG + $pontuacao;
                            }
                        } else  if ($i == 2) {
                            if ($consultarProgresso3['row'] == 0) {

                                $presencaTotal = 0;
                                $versiculoTotal = 0;
                                $misterioTotal = 0;
                                $devocionalTotal = 0;

                                $pontuacao = 0;
                            } else {
                                $query = $consultarProgresso3['dados'];
                                foreach ($query as $key => $value) {

                                    $presenca = $value['presenca'] == '' ? 0 : $value['presenca'];
                                    $versiculo = $value['versiculo_memorizado'] == '' ? 0 : $value['versiculo_memorizado'];
                                    $misterio = $value['misterio_respondido'] == '' ? 0 : $value['misterio_respondido'];
                                    $devocional = $value['devocional_respondido'] == '' ? 0 : $value['devocional_respondido'];

                                    $presencaTotal = $presencaTotal + $presenca;
                                    $versiculoTotal = $versiculoTotal + $versiculo;
                                    $misterioTotal = $misterioTotal + $misterio;
                                    $devocionalTotal = $devocionalTotal + $devocional;

                                    $pontuacao = $pontuacao + ($presenca == 1 ? 5 : 0);
                                    $pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
                                    $pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
                                    $pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
                                }
                                $somaTotalPresencaPG = $somaTotalPresencaPG + $presencaTotal;
                                $somaTotalVersiculoPG = $somaTotalVersiculoPG + $versiculoTotal;
                                $somaTotalMisterioPG = $somaTotalMisterioPG + $misterioTotal;
                                $somaTotalDevocionalPG = $somaTotalDevocionalPG + $devocionalTotal;
                                $somaTotalPontuacaoPG = $somaTotalPontuacaoPG + $pontuacao;
                            }
                        } else  if ($i == 3) {
                            if ($consultarProgresso4['row'] == 0) {

                                $presencaTotal = 0;
                                $versiculoTotal = 0;
                                $misterioTotal = 0;
                                $devocionalTotal = 0;

                                $pontuacao = 0;
                            } else {
                                $query = $consultarProgresso4['dados'];
                                foreach ($query as $key => $value) {

                                    $presenca = $value['presenca'] == '' ? 0 : $value['presenca'];
                                    $versiculo = $value['versiculo_memorizado'] == '' ? 0 : $value['versiculo_memorizado'];
                                    $misterio = $value['misterio_respondido'] == '' ? 0 : $value['misterio_respondido'];
                                    $devocional = $value['devocional_respondido'] == '' ? 0 : $value['devocional_respondido'];

                                    $presencaTotal = $presencaTotal + $presenca;
                                    $versiculoTotal = $versiculoTotal + $versiculo;
                                    $misterioTotal = $misterioTotal + $misterio;
                                    $devocionalTotal = $devocionalTotal + $devocional;

                                    $pontuacao = $pontuacao + ($presenca == 1 ? 5 : 0);
                                    $pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
                                    $pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
                                    $pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
                                }
                                $somaTotalPresencaPG = $somaTotalPresencaPG + $presencaTotal;
                                $somaTotalVersiculoPG = $somaTotalVersiculoPG + $versiculoTotal;
                                $somaTotalMisterioPG = $somaTotalMisterioPG + $misterioTotal;
                                $somaTotalDevocionalPG = $somaTotalDevocionalPG + $devocionalTotal;
                                $somaTotalPontuacaoPG = $somaTotalPontuacaoPG + $pontuacao;
                            }
                        } else  if ($i == 4) {
                            if ($consultarProgresso5['row'] == 0) {

                                $presencaTotal = 0;
                                $versiculoTotal = 0;
                                $misterioTotal = 0;
                                $devocionalTotal = 0;

                                $pontuacao = 0;
                            } else {
                                $query = $consultarProgresso5['dados'];
                                foreach ($query as $key => $value) {

                                    $presenca = $value['presenca'] == '' ? 0 : $value['presenca'];
                                    $versiculo = $value['versiculo_memorizado'] == '' ? 0 : $value['versiculo_memorizado'];
                                    $misterio = $value['misterio_respondido'] == '' ? 0 : $value['misterio_respondido'];
                                    $devocional = $value['devocional_respondido'] == '' ? 0 : $value['devocional_respondido'];

                                    $presencaTotal = $presencaTotal + $presenca;
                                    $versiculoTotal = $versiculoTotal + $versiculo;
                                    $misterioTotal = $misterioTotal + $misterio;
                                    $devocionalTotal = $devocionalTotal + $devocional;

                                    $pontuacao = $pontuacao + ($presenca == 1 ? 5 : 0);
                                    $pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
                                    $pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
                                    $pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
                                }
                                $somaTotalPresencaPG = $somaTotalPresencaPG + $presencaTotal;
                                $somaTotalVersiculoPG = $somaTotalVersiculoPG + $versiculoTotal;
                                $somaTotalMisterioPG = $somaTotalMisterioPG + $misterioTotal;
                                $somaTotalDevocionalPG = $somaTotalDevocionalPG + $devocionalTotal;
                                $somaTotalPontuacaoPG = $somaTotalPontuacaoPG + $pontuacao;
                            }
                        }
                    }
            ?>
                    <tr>
                        <td>
                            <?php echo  $m['nome_modulo']; ?>
                        </td>
                        <td>
                            <?= $presencaTotal; ?>/<?= $qtdPresenca; ?>
                        </td>
                        <td>
                            <?= $versiculoTotal; ?>/<?= $qtdVersiculo; ?>
                        </td>
                        <td>
                            <?= $misterioTotal; ?>/<?= $qtdMisterio; ?>
                        </td>
                        <td>
                            <?= $devocionalTotal; ?>/<?= $qtdDevocional; ?>
                        </td>
                        <td>
                            <i class="fa fa-dollar"></i>
                            <?= $pontuacao; ?>
                        </td>
                    </tr>
            <?php
                    $i++;
                }
            }
            ?>
        </tbody>
        <tfoot>
            <tr>
                <th>Total</th>
                <th><?= $somaTotalPresencaPG; ?>/<?= $somaTotalPresencaModulo; ?></th>
                <th><?= $somaTotalVersiculoPG; ?>/<?= $somaTotalVersiculoModulo; ?></th>
                <th><?= $somaTotalMisterioPG; ?>/<?= $somaTotalMisterioModulo; ?></th>
                <th><?= $somaTotalDevocionalPG; ?>/<?= $somaTotalDevocionalModulo; ?></th>
                <th>
                    <i class="fa fa-dollar"></i>
                    <?= $somaTotalPontuacaoPG; ?>
                </th>
            </tr>
        </tfoot>
    </table>
</div>
