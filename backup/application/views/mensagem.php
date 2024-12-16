<?php

/** @var \$this */

$codigo =  $this->uri->segment(1);

$this->load->view('partes/head');
?>

<div class="box-body chat"><br>
    <div class="callout callout-<?= $class; ?>">
        <h4>
            <?= $titulo; ?>
        </h4>
        <p>
            <?php
            foreach ($mensagem as $key => $value) {
                echo $value . " ";
            }
            ?>
        </p>
    </div>
</div>

<?php

$this->load->view('partes/scripts2');
?>