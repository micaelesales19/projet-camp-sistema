<script type="text/javascript">
    $(document).ready(function() {
        $('#table_criancas_pais').DataTable();
    });
</script>

<div style="overflow-x:auto;">
    <table class="table table-bordered" id="table_criancas_pais" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Presença</th>
                <th>Versículo</th>
                <th>Mistério</th>
                <th>Pontuação</th>
            </tr>
        </thead>
        <tbody>
            <?php

            $consultaCriancas = $this->FConsultas_model->mostrarCriancasPaisPg($id_lider, $id_pg);

            $qtdPresenca = "0";
            $qtdVersiculo = "0";
            $qtdMisterio = "0";

            if ($consultaCriancas['row'] == 0) {
            } else {

                if ($total == 0) {
                } else if ($total == 1) {
                    $id1 = $id_modulo[0];
                    $consultarModuloId1 = $this->FConsultas_model->consultarModuloId($id1);
                    $qtdPresenca = $qtdPresenca + $consultarModuloId1['n_licao'];
                    $qtdVersiculo = $qtdVersiculo + $consultarModuloId1['qtdVersiculo'];
                    $qtdMisterio = $qtdMisterio + $consultarModuloId1['qtdMisterios'];
                } else if ($total == 2) {
                    $id1 = $id_modulo[0];
                    $id2 = $id_modulo[2];

                    $consultarModuloId1 = $this->FConsultas_model->consultarModuloId($id1);
                    $qtdPresenca = $qtdPresenca + $consultarModuloId1['n_licao'];
                    $qtdVersiculo = $qtdVersiculo + $consultarModuloId1['qtdVersiculo'];
                    $qtdMisterio = $qtdMisterio + $consultarModuloId1['qtdMisterios'];

                    $consultarModuloId2 = $this->FConsultas_model->consultarModuloId($id2);
                    $qtdPresenca = $qtdPresenca + $consultarModuloId2['n_licao'];
                    $qtdVersiculo = $qtdVersiculo + $consultarModuloId2['qtdVersiculo'];
                    $qtdMisterio = $qtdMisterio + $consultarModuloId2['qtdMisterios'];
                } else if ($total == 3) {
                    $id1 = $id_modulo[0];
                    $id2 = $id_modulo[2];
                    $id3 = $id_modulo[4];

                    $consultarModuloId1 = $this->FConsultas_model->consultarModuloId($id1);
                    $qtdPresenca = $qtdPresenca + $consultarModuloId1['n_licao'];
                    $qtdVersiculo = $qtdVersiculo + $consultarModuloId1['qtdVersiculo'];
                    $qtdMisterio = $qtdMisterio + $consultarModuloId1['qtdMisterios'];

                    $consultarModuloId2 = $this->FConsultas_model->consultarModuloId($id2);
                    $qtdPresenca = $qtdPresenca + $consultarModuloId2['n_licao'];
                    $qtdVersiculo = $qtdVersiculo + $consultarModuloId2['qtdVersiculo'];
                    $qtdMisterio = $qtdMisterio + $consultarModuloId2['qtdMisterios'];

                    $consultarModuloId3 = $this->FConsultas_model->consultarModuloId($id3);
                    $qtdPresenca = $qtdPresenca + $consultarModuloId3['n_licao'];
                    $qtdVersiculo = $qtdVersiculo + $consultarModuloId3['qtdVersiculo'];
                    $qtdMisterio = $qtdMisterio + $consultarModuloId3['qtdMisterios'];
                } else if ($total == 4) {
                    $id1 = $id_modulo[0];
                    $id2 = $id_modulo[2];
                    $id3 = $id_modulo[4];
                    $id4 = $id_modulo[6];

                    $consultarModuloId1 = $this->FConsultas_model->consultarModuloId($id1);
                    $qtdPresenca = $qtdPresenca + $consultarModuloId1['n_licao'];
                    $qtdVersiculo = $qtdVersiculo + $consultarModuloId1['qtdVersiculo'];
                    $qtdMisterio = $qtdMisterio + $consultarModuloId1['qtdMisterios'];

                    $consultarModuloId2 = $this->FConsultas_model->consultarModuloId($id2);
                    $qtdPresenca = $qtdPresenca + $consultarModuloId2['n_licao'];
                    $qtdVersiculo = $qtdVersiculo + $consultarModuloId2['qtdVersiculo'];
                    $qtdMisterio = $qtdMisterio + $consultarModuloId2['qtdMisterios'];

                    $consultarModuloId3 = $this->FConsultas_model->consultarModuloId($id3);
                    $qtdPresenca = $qtdPresenca + $consultarModuloId3['n_licao'];
                    $qtdVersiculo = $qtdVersiculo + $consultarModuloId3['qtdVersiculo'];
                    $qtdMisterio = $qtdMisterio + $consultarModuloId3['qtdMisterios'];

                    $consultarModuloId4 = $this->FConsultas_model->consultarModuloId($id4);
                    $qtdPresenca = $qtdPresenca + $consultarModuloId4['n_licao'];
                    $qtdVersiculo = $qtdVersiculo + $consultarModuloId4['qtdVersiculo'];
                    $qtdMisterio = $qtdMisterio + $consultarModuloId4['qtdMisterios'];
                } else if ($total == 5) {
                    $id1 = $id_modulo[0];
                    $id2 = $id_modulo[2];
                    $id3 = $id_modulo[4];
                    $id4 = $id_modulo[6];
                    $id5 = $id_modulo[8];

                    $consultarModuloId1 = $this->FConsultas_model->consultarModuloId($id1);
                    $qtdPresenca = $qtdPresenca + $consultarModuloId1['n_licao'];
                    $qtdVersiculo = $qtdVersiculo + $consultarModuloId1['qtdVersiculo'];
                    $qtdMisterio = $qtdMisterio + $consultarModuloId1['qtdMisterios'];

                    $consultarModuloId2 = $this->FConsultas_model->consultarModuloId($id2);
                    $qtdPresenca = $qtdPresenca + $consultarModuloId2['n_licao'];
                    $qtdVersiculo = $qtdVersiculo + $consultarModuloId2['qtdVersiculo'];
                    $qtdMisterio = $qtdMisterio + $consultarModuloId2['qtdMisterios'];

                    $consultarModuloId3 = $this->FConsultas_model->consultarModuloId($id3);
                    $qtdPresenca = $qtdPresenca + $consultarModuloId3['n_licao'];
                    $qtdVersiculo = $qtdVersiculo + $consultarModuloId3['qtdVersiculo'];
                    $qtdMisterio = $qtdMisterio + $consultarModuloId3['qtdMisterios'];

                    $consultarModuloId4 = $this->FConsultas_model->consultarModuloId($id4);
                    $qtdPresenca = $qtdPresenca + $consultarModuloId4['n_licao'];
                    $qtdVersiculo = $qtdVersiculo + $consultarModuloId4['qtdVersiculo'];
                    $qtdMisterio = $qtdMisterio + $consultarModuloId4['qtdMisterios'];

                    $consultarModuloId5 = $this->FConsultas_model->consultarModuloId($id5);
                    $qtdPresenca = $qtdPresenca + $consultarModuloId5['n_licao'];
                    $qtdVersiculo = $qtdVersiculo + $consultarModuloId5['qtdVersiculo'];
                    $qtdMisterio = $qtdMisterio + $consultarModuloId5['qtdMisterios'];
                }

                foreach ($consultaCriancas['dados'] as $key => $linha) {

                    $pontuacao = 0;
                    $presencaTotal = 0;
                    $versiculoTotal = 0;
                    $misterioTotal = 0;

                    if ($total == 0) {
                    } else if ($total == 1) {
                        $id1 = $id_modulo[0];

                        $consultarProgresso1 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id1);
                        $consultarProgresso = array_merge($consultarProgresso1['dados']);
                    } else if ($total == 2) {
                        $id1 = $id_modulo[0];
                        $id2 = $id_modulo[2];

                        $consultarProgresso1 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id1);
                        $consultarProgresso2 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id2);
                        $consultarProgresso = array_merge($consultarProgresso1['dados'], $consultarProgresso2['dados']);
                    } else if ($total == 3) {
                        $id1 = $id_modulo[0];
                        $id2 = $id_modulo[2];
                        $id3 = $id_modulo[4];

                        $consultarProgresso1 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id1);
                        $consultarProgresso2 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id2);
                        $consultarProgresso3 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id3);
                        $consultarProgresso = array_merge($consultarProgresso1['dados'], $consultarProgresso2['dados'], $consultarProgresso3['dados']);
                    } else if ($total == 4) {
                        $id1 = $id_modulo[0];
                        $id2 = $id_modulo[2];
                        $id3 = $id_modulo[4];
                        $id4 = $id_modulo[6];

                        $consultarProgresso1 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id1);
                        $consultarProgresso2 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id2);
                        $consultarProgresso3 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id3);
                        $consultarProgresso4 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id4);
                        $consultarProgresso = array_merge($consultarProgresso1['dados'], $consultarProgresso2['dados'], $consultarProgresso3['dados'], $consultarProgresso4['dados']);
                    } else if ($total == 5) {
                        $id1 = $id_modulo[0];
                        $id2 = $id_modulo[2];
                        $id3 = $id_modulo[4];
                        $id4 = $id_modulo[6];
                        $id5 = $id_modulo[8];

                        $consultarProgresso1 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id1);
                        $consultarProgresso2 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id2);
                        $consultarProgresso3 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id3);
                        $consultarProgresso4 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id4);
                        $consultarProgresso5 = $this->FConsultas_model->consultarProgressoCriancaIndividual($id_pg, $id_lider, $linha['id_crianca'], $id5);
                        $consultarProgresso = array_merge($consultarProgresso1['dados'], $consultarProgresso2['dados'], $consultarProgresso3['dados'], $consultarProgresso4['dados'], $consultarProgresso5['dados']);
                    }

                    $totalRelatorio = count($consultarProgresso);

                    if ($totalRelatorio == 0) {
                        $pontuacao = $pontuacao;
                    } else {
                        foreach ($consultarProgresso as $key => $progresso) {
                            $presenca = $progresso['presenca'];
                            $versiculo = $progresso['versiculo_memorizado'];
                            $misterio = $progresso['misterio_respondido'];
                            $devocional = $progresso['devocional_respondido'];

                            $presencaTotal = $presencaTotal + $presenca;
                            $versiculoTotal = $versiculoTotal + $versiculo;
                            $misterioTotal = $misterioTotal + $misterio;

                            $pontuacao = ($presenca == 1 ? 5 : 0);
                            $pontuacao = $pontuacao + ($versiculo == 1 ? 10 : 0);
                            $pontuacao = $pontuacao + ($misterio == 1 ? 8 : 0);
                            $pontuacao = $pontuacao + ($devocional   == 1 ? 5 : 0);
                        }
                    }

                    if ($linha['nome_crianca'] == "") {
                        $linha['nome_crianca'] = "-";
                    }
            ?>
                    <tr>
                        <td>
                            <?= $linha['nome_crianca']; ?>
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
                }
            }
            ?>
        </tbody>
    </table>
</div>