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
                <th>Pontuação</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $modulos = $this->FConsultas_model->consultarModuloAno($ano);

            $somaTotalPresencaModulo = 0;
            $somaTotalVersiculoModulo = 0;
            $somaTotalMisterioModulo = 0;

            $somaTotalPresencaPG = 0;
            $somaTotalVersiculoPG = 0;
            $somaTotalMisterioPG = 0;
            $somaTotalPontuacaoPG = 0;

            if ($modulos) {

                $consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPg($id_lider, $id_pg, 1);

                $qtdPresenca = 0;
                $qtdVersiculo = 0;
                $qtdMisterio = 0;

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

                    $qtdPresenca = $qtdPresenca * $consultaCriancas['row'];
                    $qtdVersiculo = $qtdVersiculo * $consultaCriancas['row'];
                    $qtdMisterio = $qtdMisterio * $consultaCriancas['row'];

                    $somaTotalPresencaModulo = $somaTotalPresencaModulo + $qtdPresenca;
                    $somaTotalVersiculoModulo = $somaTotalVersiculoModulo + $qtdVersiculo;
                    $somaTotalMisterioModulo = $somaTotalMisterioModulo + $qtdMisterio;

                    $pontuacao = 0;
                    $presencaTotal = 0;
                    $versiculoTotal = 0;
                    $misterioTotal = 0;

                    foreach ($consultaCriancas['dados'] as $key => $linha) {
                        $consultarProgresso1 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id_modulos[0], 1);
                        $consultarProgresso2 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id_modulos[1], 1);
                        $consultarProgresso3 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id_modulos[2], 1);
                        $consultarProgresso4 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id_modulos[3], 1);
                        $consultarProgresso5 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id_modulos[4], 1);
                        //$consultarProgresso = array_merge($consultarProgresso1['dados'], $consultarProgresso2['dados'], $consultarProgresso3['dados'], $consultarProgresso4['dados'], $consultarProgresso5['dados'],);
                    }

                    //$totalRelatorio = count($consultarProgresso);

                    $query = [];


                    if ($i == 0) {
                        if ($consultarProgresso1['row'] == 0) {
                            $presencaTotal = 0;
                            $versiculoTotal = 0;
                            $misterioTotal = 0;
                            $pontuacao = 0;
                        } else {
                            $query = $consultarProgresso1['dados'];
                            foreach ($query as $key => $value) {
                                $presenca = $value['presenca'];
                                $versiculo = $value['versiculo_memorizado'];
                                $misterio = $value['misterio_respondido'];
                                $devocional = $value['devocional_respondido'];

                                $presencaTotal = $presencaTotal + $presenca;
                                $versiculoTotal = $versiculoTotal + $versiculo;
                                $misterioTotal = $misterioTotal + $misterio;

                                $pontuacao = $pontuacao + ($presenca == 1 ? 5 : 0);
                                $pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
                                $pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
                                $pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
                            }
                            $somaTotalPresencaPG = $somaTotalPresencaPG + $presencaTotal;
                            $somaTotalVersiculoPG = $somaTotalVersiculoPG + $versiculoTotal;
                            $somaTotalMisterioPG = $somaTotalMisterioPG + $misterioTotal;
                            $somaTotalPontuacaoPG = $somaTotalPontuacaoPG + $pontuacao;
                        }
                    } else  if ($i == 1) {
                        if ($consultarProgresso2['row'] == 0) {

                            $presencaTotal = 0;
                            $versiculoTotal = 0;
                            $misterioTotal = 0;

                            $pontuacao = 0;
                        } else {
                            $query = $consultarProgresso2['dados'];
                            foreach ($query as $key => $value) {

                                $presenca = $value['presenca'];
                                $versiculo = $value['versiculo_memorizado'];
                                $misterio = $value['misterio_respondido'];
                                $devocional = $value['devocional_respondido'];

                                $presencaTotal = $presencaTotal + $presenca;
                                $versiculoTotal = $versiculoTotal + $versiculo;
                                $misterioTotal = $misterioTotal + $misterio;

                                $pontuacao = $pontuacao + ($presenca == 1 ? 5 : 0);
                                $pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
                                $pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
                                $pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
                            }
                            $somaTotalPresencaPG = $somaTotalPresencaPG + $presencaTotal;
                            $somaTotalVersiculoPG = $somaTotalVersiculoPG + $versiculoTotal;
                            $somaTotalMisterioPG = $somaTotalMisterioPG + $misterioTotal;
                            $somaTotalPontuacaoPG = $somaTotalPontuacaoPG + $pontuacao;
                        }
                    } else  if ($i == 2) {
                        if ($consultarProgresso3['row'] == 0) {

                            $presencaTotal = 0;
                            $versiculoTotal = 0;
                            $misterioTotal = 0;

                            $pontuacao = 0;
                        } else {
                            $query = $consultarProgresso3['dados'];
                            foreach ($query as $key => $value) {
                                $presenca = $value['presenca'];
                                $versiculo = $value['versiculo_memorizado'];
                                $misterio = $value['misterio_respondido'];
                                $devocional = $value['devocional_respondido'];

                                $presencaTotal = $presencaTotal + $presenca;
                                $versiculoTotal = $versiculoTotal + $versiculo;
                                $misterioTotal = $misterioTotal + $misterio;

                                $pontuacao = $pontuacao + ($presenca == 1 ? 5 : 0);
                                $pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
                                $pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
                                $pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
                            }
                            $somaTotalPresencaPG = $somaTotalPresencaPG + $presencaTotal;
                            $somaTotalVersiculoPG = $somaTotalVersiculoPG + $versiculoTotal;
                            $somaTotalMisterioPG = $somaTotalMisterioPG + $misterioTotal;
                            $somaTotalPontuacaoPG = $somaTotalPontuacaoPG + $pontuacao;
                        }
                    } else  if ($i == 3) {
                        if ($consultarProgresso4['row'] == 0) {

                            $presencaTotal = 0;
                            $versiculoTotal = 0;
                            $misterioTotal = 0;

                            $pontuacao = 0;
                        } else {
                            $query = $consultarProgresso4['dados'];
                            foreach ($query as $key => $value) {
                                $presenca = $value['presenca'];
                                $versiculo = $value['versiculo_memorizado'];
                                $misterio = $value['misterio_respondido'];
                                $devocional = $value['devocional_respondido'];

                                $presencaTotal = $presencaTotal + $presenca;
                                $versiculoTotal = $versiculoTotal + $versiculo;
                                $misterioTotal = $misterioTotal + $misterio;

                                $pontuacao = $pontuacao + ($presenca == 1 ? 5 : 0);
                                $pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
                                $pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
                                $pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
                            }
                            $somaTotalPresencaPG = $somaTotalPresencaPG + $presencaTotal;
                            $somaTotalVersiculoPG = $somaTotalVersiculoPG + $versiculoTotal;
                            $somaTotalMisterioPG = $somaTotalMisterioPG + $misterioTotal;
                            $somaTotalPontuacaoPG = $somaTotalPontuacaoPG + $pontuacao;
                        }
                    } else  if ($i == 4) {
                        if ($consultarProgresso5['row'] == 0) {

                            $presencaTotal = 0;
                            $versiculoTotal = 0;
                            $misterioTotal = 0;

                            $pontuacao = 0;
                        } else {
                            $query = $consultarProgresso5['dados'];
                            foreach ($query as $key => $value) {
                                $presenca = $value['presenca'];
                                $versiculo = $value['versiculo_memorizado'];
                                $misterio = $value['misterio_respondido'];
                                $devocional = $value['devocional_respondido'];

                                $presencaTotal = $presencaTotal + $presenca;
                                $versiculoTotal = $versiculoTotal + $versiculo;
                                $misterioTotal = $misterioTotal + $misterio;

                                $pontuacao = $pontuacao + ($presenca == 1 ? 5 : 0);
                                $pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
                                $pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
                                $pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
                            }
                            $somaTotalPresencaPG = $somaTotalPresencaPG + $presencaTotal;
                            $somaTotalVersiculoPG = $somaTotalVersiculoPG + $versiculoTotal;
                            $somaTotalMisterioPG = $somaTotalMisterioPG + $misterioTotal;
                            $somaTotalPontuacaoPG = $somaTotalPontuacaoPG + $pontuacao;
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
                <th>
                    <i class="fa fa-dollar"></i>
                    <?= $somaTotalPontuacaoPG; ?>
                </th>
            </tr>
        </tfoot>
    </table>
</div>