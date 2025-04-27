<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
unset($_SESSION["status_chamado"]);
//$_SESSION['img_contr']='';
//$_SESSION['img_contr']= $this->data['logoContrato'][0]['logo_clie'];


?>

<!-- Inicio dos box do dashboard -->
<div class="wrapper">
    <div class="row">
        <div class="col-7">
            <h2>DASHBOARD</h2>
        </div>
    </div>

    <div class="row">
        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countCham'])) { ?>
                    <h5><?= $this->data['countCham'][0]['qnt_cham'] ?></h5>
                <?php } ?>
            </span>
            <h6>Aberto</h6>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countAgend'])) { ?>
                    <h5><?= $this->data['countAgend'][0]['qnt_cham'] ?></h5>
                <?php } ?>
            </span>
            <h6>Agendados</h6>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamAtend'])) { ?>
                    <h5><?= $this->data['countChamAtend'][0]['qnt_cham_atend'] ?></h5>
                <?php } ?>
            </span>
            <h6>Em Atendimento</h6>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamPausa'])) { ?>
                    <h5><?= $this->data['countChamPausa'][0]['qnt_cham_pausa'] ?></h5>
                <?php } ?>
            </span>
            <h6>Pausados Suporte</h6>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['qnt_cham_com'])) { ?>
                    <h5><?= $this->data['qnt_cham_com'][0]['qnt_cham_com'] ?></h5>
                <?php } ?>
            </span>
            <h6>Pausados Comercial</h6>
        </div>


        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamClie'])) { ?>
                    <h5><?= $this->data['countChamClie'][0]['qnt_cham_clie'] ?></h5>
                <?php } ?>
            </span>
            <h6>Pausados Cliente</h6>

        </div><div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamAgua'])) { ?>
                    <h5><?= $this->data['countChamAgua'][0]['qnt_cham_agua'] ?></h5>
                <?php } ?>
            </span>
            <h6>Aguardando Outros</h6>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamFinal'])) { ?>
                    <h5><?= $this->data['countChamFinal'][0]['qnt_cham_final'] ?></h5>
                <?php } ?>
            </span>
            <h6>Concluidos</h6>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamRepr'])) { ?>
                    <h5><?= $this->data['countChamRepr'][0]['qnt_cham_repr'] ?></h5>
                <?php } ?>
            </span>
            <h6>Reprovados</h6>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamApro'])) { ?>
                    <h5><?= $this->data['countChamApro'][0]['qnt_cham_apro'] ?></h5>
                <?php } ?>
            </span>
            <h6>Aprovados</h6>
        </div>
    </div>
</div>
<!-- Fim  dos box do dashboard -->