<!DOCTYPE html>
<?php
/** @var \$this */
?>
<html lang="en">
<!-- Head -->
<?php
$this->load->view('partes/head');
?>
<style>
    h1 {
        text-align: center;
    }

    #table {
        display: flex;
        flex-direction: row;
        justify-content: center;
        align-items: center;
    }
</style>

<body>
    <div class="col-lg-12">
        <h1>Devocionais (PT/IN)</h1>
        <a href="cadastrar" class="btn btn-success" id="table">Cadastrar +</a>

        <div class="col-lg-12" id="table">
            <table id="table_devocionais" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Módulo</th>
                        <th>Lição</th>
                        <th>Dia</th>
                        <th>Texto</th>
                        <th>Ação</th>
                        <th>Ação</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    foreach ($devocionais as $key => $dados) {

                        $id_modulo = $dados['id_modulo'];
                        $nome_modulo = '';

                        switch ($id_modulo) {
                            case 1:
                                $nome_modulo = 'Trilha';
                                break;
                            case 2:
                                $nome_modulo = 'Mergulho';
                                break;
                            case 3:
                                $nome_modulo = 'Santuário';
                                break;
                            case 4:
                                $nome_modulo = 'Arco';
                                break;
                            case 5:
                                $nome_modulo = 'Estação Final';
                                break;
                            case 6:
                                $nome_modulo = 'Os Segredos';
                                break;
                            case 7:
                                $nome_modulo = 'Os Sobreviventes';
                                break;
                            case 8:
                                $nome_modulo = 'Os Exploradores';
                                break;
                            case 9:
                                $nome_modulo = 'A Colheita';
                                break;
                            case 10:
                                $nome_modulo = 'A Evolução';
                                break;
                            default:
                                $nome_modulo = '';
                                break;
                        }
                    ?>
                        <tr>
                            <td><?= $nome_modulo; ?></td>
                            <td><?= $dados['n_licao']; ?></td>
                            <td><?= $dados['dia']; ?></td>
                            <td><?= $dados['texto']; ?></td>
                            <td><input type="subtmi" class="btn btn-info" value="Editar"></td>
                            <td><input type="subtmi" class="btn btn-danger" value="Delete"></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>