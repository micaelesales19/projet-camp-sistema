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
          <th style="display: <?= $isImpar ?>;">Semanário</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Consulta Criança                                                         
        $sqlC = "SELECT * FROM criancas WHERE lider LIKE :ID_LIDER AND id_pg LIKE :ID_PG AND ativo = 1";
        $consultaC = $pdo->prepare($sqlC);
        $consultaC->bindValue(":ID_LIDER", $id_lider);
        $consultaC->bindValue(":ID_PG", $id_pg);
        $consultaC->execute();
        $rowC = $consultaC->rowCount();

        $sqlPG = "SELECT * FROM pg WHERE id_pg LIKE :ID_PG";
        $consultaPG = $pdo->prepare($sqlPG);
        $consultaPG->bindValue(":ID_PG", $id_pg);
        $consultaPG->execute();
        $dadosPG = $consultaPG->fetch(PDO::FETCH_ASSOC);

        if ($rowC == 0) {
          echo "<b>Nenhuma Criança</b>";
        } else {
          for ($i = 0; $i < $rowC; $i++) {
            $dadosCrianca = $consultaC->fetch(PDO::FETCH_ASSOC);
            $sqlProgresso = "SELECT * FROM progresso_pg WHERE id_crianca_presente LIKE :ID_USUARIO AND numero_licao LIKE :LICAO AND id_modulo LIKE :MODULO";
            $consultaProgresso = $pdo->prepare($sqlProgresso);
            $consultaProgresso->bindValue(":ID_USUARIO", $dadosCrianca['id_crianca']);
            $consultaProgresso->bindValue(":LICAO", $licao);
            $consultaProgresso->bindValue(":MODULO", $modulo);
            $consultaProgresso->execute();
            $dadosCriancas = $consultaProgresso->fetch(PDO::FETCH_ASSOC);
            $contagem = $consultaProgresso->rowCount();

            if ($contagem != 0) {
        ?>
              <input type="hidden" name="id_lider" value="<?= $id_lider; ?>">
              <tr>
                <td></td>
                <td><?= $dadosCrianca['nome_crianca']; ?></td>
                <td><label>Dados já preenchidos</label></td>
              </tr>
            <?php
            } else {
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
              </tr>
        <?php }
          }
        } ?>
      </tbody>
    </table>
  </div>
</div>