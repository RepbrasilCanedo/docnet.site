<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
unset($_SESSION["status_chamado"]);
//unset($_SESSION["status_ticket"]);
//$_SESSION['img_contr']='';
//$_SESSION['img_contr']= $this->data['logoContrato'][0]['logo_clie'];
//var_dump($this->data['countChamFinal']);
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
            <?php if(($this->data['countCham'][0]['qnt_cham'] > 0) and ($this->data['countCham'][0]['status_id'] == 2)) {?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index" <?php $_SESSION['status_ticket'] = 2;?> >Aberto</a></h6>                                
            <?php } else { ?>
                <h6>Aberto</h6>
            <?php }?>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countAgend'])) { ?>
                    <h5><?= $this->data['countAgend'][0]['qnt_cham'] ?></h5>
                <?php } ?>
            </span>
            <?php if(($this->data['countAgend'][0]['qnt_cham'] > 0) and ($this->data['countAgend'][0]['status_id'] == 9)) {?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index" <?php $_SESSION['status_ticket'] = 9;?>>Agendados</a></h6>
            <?php } else { ?>
                <h6>Agendados</h6>
            <?php }?>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamAtend'])) { ?>
                    <h5><?= $this->data['countChamAtend'][0]['qnt_cham_atend'] ?></h5>
                <?php } ?>
            </span>
            <?php if(($this->data['countChamAtend'][0]['qnt_cham_atend'] > 0) and ($this->data['countChamAtend'][0]['status_id'] == 3)) {?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index"<?php $_SESSION['status_ticket'] = 3;?>>Em Atendimento</a></h6>
            <?php } else { ?>
                <h6>Em Atendimento</h6>
            <?php }?>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamPausa'])) { ?>
                    <h5><?= $this->data['countChamPausa'][0]['qnt_cham_pausa'] ?></h5>
                <?php } ?>
            </span>
            <?php if(($this->data['countChamPausa'][0]['qnt_cham_pausa'] > 0) and ($this->data['countChamPausa'][0]['status_id'] == 5)) {?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index">Pausados Suporte <?php $_SESSION['status_ticket'] = 5;?></a></h6>
            <?php } else { ?>
                <h6>Pausados Suporte</h6>
            <?php }?>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['qnt_cham_com'])) { ?>
                    <h5><?= $this->data['qnt_cham_com'][0]['qnt_cham_com'] ?></h5>
                <?php } ?>
            </span>
            <?php if(($this->data['countChamPausa'][0]['qnt_cham_pausa'] > 0) and ($this->data['qnt_cham_com'][0]['status_id'] == 11)) {?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index">Pausados Comercial <?php $_SESSION['status_ticket'] = 11;?></a></h6>
            <?php } else { ?>
                <h6>Pausados Comercial</h6>
            <?php }?>
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
            <?php if(($this->data['countChamAgua'][0]['qnt_cham_agua'] > 0) and ($this->data['countChamAgua'][0]['status_id'] == 12)) {?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index">Aguardando Outros <?php $_SESSION['status_ticket'] = 12;?></a></h6>
            <?php } else { ?>
                <h6>Aguardando Outros</h6>
            <?php }?>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamFinal'])) { ?>
                    <h5><?= $this->data['countChamFinal'][0]['qnt_cham_final'] ?></h5>
                <?php } ?>
            </span>
            <?php if(($this->data['countChamFinal'][0]['qnt_cham_final'] > 0)) {?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index" <?php $_SESSION['status_ticket'] = 6;?>>Concluidos</a></h6>
            <?php } else { ?>
                <h6>Concluidos</h6>
            <?php }?>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamRepr'])) { ?>
                    <h5><?= $this->data['countChamRepr'][0]['qnt_cham_repr'] ?></h5>
                <?php } ?>
            </span>
            <?php if(($this->data['countChamRepr'][0]['qnt_cham_repr'] > 0) and ($this->data['countChamRepr'][0]['status_id'] == 7)) {?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index" <?php $_SESSION['status_ticket'] = 7;?>>Reprovados</a></h6>
            <?php } else { ?>
                <h6>Reprovados</h6>
            <?php }?>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamApro'])) { ?>
                    <h5><?= $this->data['countChamApro'][0]['qnt_cham_apro'] ?></h5>
                <?php } ?>
            </span>
            <?php if(($this->data['countChamApro'][0]['qnt_cham_apro'] > 0) and ($this->data['countChamApro'][0]['status_id'] == 8)) {?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index" <?php $_SESSION['status_ticket'] = 8;?>>Aprovados</a></h6>
            <?php } else { ?>
                <h6>Aprovados</h6>
            <?php }?>
        </div>
    </div>
</div>
<!-- Fim  dos box do dashboard -->