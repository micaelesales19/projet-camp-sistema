<?php

/** @var \$this */

$codigo =  $this->uri->segment(1);

$this->load->view('partes/head');
?>
<style>
    /* ===== RESET ===== */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    /* ===== BACKGROUND ===== */
    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: linear-gradient(180deg, #43c6ff, #005cff);
    }
</style>

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
