<div class="table-responsive">
  <div class="form-group" style="overflow-x:auto;">
    <table class="table table-bordered" id="table_c" width="100%" cellspacing="0">

      <?php
      $pdo = new PDO("mysql:host=localhost;dbname=u301957058_campbrasil", "u301957058_camp_brasil", "campBr202@");
      /** @var \$this */
      $id_pg = $this->input->get('id_pg');
      $id_lider = $this->input->get('id_lider');
      $ano = $this->input->get('ano');
      $modulo = $this->input->get('modulo');
      $licao = $this->input->get('licao');
      $id_relatorio = $this->input->get('id_relatorio');

      if ($licao == 1 || $licao == 3 || $licao == 5 || $licao == 7 || $licao == 9) {
        $isImpar = "none";
      } else {
        $isImpar = "";
      }
      ?>

      <thead>
        <tr>
          <th>Nome da Criança</th>
          <th>Presença</th>
          <th style="display: <?= $isImpar ?>;">Versículo</th>
          <th style="display: <?= $isImpar ?>;">Mistério</th>
          <th>Semanário</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Consulta Criança                                                         
        $sqlC = "SELECT * FROM criancas WHERE id_pg = $id_pg AND lider = $id_lider";
        $consultaC = $pdo->prepare($sqlC);
        $consultaC->execute();
        $rowC = $consultaC->rowCount();

        if ($rowC == 0) {
          echo "<b>Nenhum Relatório Encontrado</b>";
        } else {
          for ($i = 0; $i < $rowC; $i++) {

            $dadosCrianca = $consultaC->fetch(PDO::FETCH_ASSOC);
            $id_crianca = $dadosCrianca['id_crianca'];

            $sqlProgresso = "SELECT * FROM progresso_pg WHERE id_pg = $id_pg AND id_lider = $id_lider AND id_modulo = $modulo AND numero_licao = $licao AND id_crianca_presente = $id_crianca";
            $consultaProgresso = $pdo->prepare($sqlProgresso);
            $consultaProgresso->execute();
            $contagem = $consultaProgresso->rowCount();

        ?>
            <tr>
              <!-- <td><input type="checkbox" class="lista_sim" name="todos" value="1"><td> -->
              <td><?= $dadosCrianca['nome_crianca']; ?>
                <input type="hidden" name="id_pg" value="<?= $id_pg; ?>">
                <input type="hidden" name="id_crianca[]" value="<?= $dadosCrianca['id_crianca']; ?>">
                <input type="hidden" name="id_lider" value="<?= $id_lider; ?>">
                <input type="hidden" name="qtd_crianca" value="<?= $rowC; ?>">
                <input type="hidden" name="ano" value="<?= $ano; ?>">
                <input type="hidden" name="id_modulo" value="<?= $modulo; ?>">
                <input type="hidden" name="licao" value="<?= $licao; ?>">
              </td>

              <?php
              if ($contagem == 0) {
              ?>
                <input type="hidden" name="id_relatorio[<?= $i; ?>]" value="">

                <td>
                  <input type="radio" class="lista_sim" name="presenca[<?= $i; ?>]" value="1"> Sim<br>
                  <input type="radio" name="presenca[<?= $i; ?>]" value="0"> Não
                </td>
                <td style="display: <?= $isImpar ?>;">
                  <input type="radio" class="lista_sim" name="versiculo[<?= $i; ?>]" value="1"> Sim<br>
                  <input type="radio" name="versiculo[<?= $i; ?>]" value="0"> Não
                </td>
                <td style="display: <?= $isImpar ?>;">
                  <input type="radio" class="lista_sim" name="misterio[<?= $i; ?>]" value="1"> Sim<br>
                  <input type="radio" name="misterio[<?= $i; ?>]" value="0"> Não
                </td>
                <td style="display: <?= $isImpar ?>;">
                  <input type="radio" class="lista_sim" name="devocional[<?= $i; ?>]" value="1"> Sim<br>
                  <input type="radio" name="devocional[<?= $i; ?>]" value="0"> Não
                </td>
              <?php } else {
                $dadosRelatorio = $consultaProgresso->fetch(PDO::FETCH_ASSOC);
                $presenca_sim_check = $dadosRelatorio['presenca'] == 1 ? 'checked' : '';
                $presenca_nao_check = $dadosRelatorio['presenca'] == 0 ? 'checked' : '';
                $versiculo_sim_check = $dadosRelatorio['versiculo_memorizado'] == 1 ? 'checked' : '';
                $versiculo_nao_check = $dadosRelatorio['versiculo_memorizado'] == 0 ? 'checked' : '';
                $misterio_sim_check = $dadosRelatorio['misterio_respondido'] == 1 ? 'checked' : '';
                $misterio_nao_check = $dadosRelatorio['misterio_respondido'] == 0 ? 'checked' : '';
                $devocional_sim_check = $dadosRelatorio['devocional_respondido'] == 1 ? 'checked' : '';
                $devocional_nao_check = $dadosRelatorio['devocional_respondido'] == 0 ? 'checked' : '';
              ?>
                <input type="hidden" name="id_relatorio[<?= $i; ?>]" value="<?= $dadosRelatorio['id_relatorio']; ?>">

                <td>
                  <input type="radio" class="lista_sim" name="presenca[<?= $i; ?>]" value="1" <?= $presenca_sim_check ?>> Sim<br>
                  <input type="radio" name="presenca[<?= $i; ?>]" value="0" <?= $presenca_nao_check ?>> Não
                </td>
                <td style="display: <?= $isImpar ?>;">
                  <input type="radio" class="lista_sim" name="versiculo[<?= $i; ?>]" value="1" <?= $versiculo_sim_check ?>> Sim<br>
                  <input type="radio" name="versiculo[<?= $i; ?>]" value="0" <?= $versiculo_nao_check ?>> Não
                </td>
                <td style="display: <?= $isImpar ?>;">
                  <input type="radio" class="lista_sim" name="misterio[<?= $i; ?>]" value="1" <?= $misterio_sim_check ?>> Sim<br>
                  <input type="radio" name="misterio[<?= $i; ?>]" value="0" <?= $misterio_nao_check ?>> Não
                </td>
                <td>
                  <input type="radio" class="lista_sim" name="devocional[<?= $i; ?>]" value="1" <?= $devocional_sim_check ?>> Sim<br>
                  <input type="radio" name="devocional[<?= $i; ?>]" value="0" <?= $devocional_nao_check ?>> Não
                </td>
              <?php } ?>
            </tr>
        <?php
          }
        } ?>
      </tbody>
    </table>
  </div>
</div>