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
//var_dump($this->data['countEquipVenc']);
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
            <?php if (($this->data['countCham'][0]['qnt_cham'] > 0) and ($this->data['countCham'][0]['status_id'] == 2)) { ?>
                <?php if ($this->data['countCham'][0]['qnt_cham'] > 1) { ?>
                    <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=2">Abertos</a></h6>
                <?php } else {?>
                    <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=2">Aberto</a></h6>
                <?php }?>
            <?php } else { ?>
                <h6>Aberto</h6>
            <?php } ?>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countAgend'])) { ?>
                    <h5><?= $this->data['countAgend'][0]['qnt_cham'] ?></h5>
                <?php } ?>
            </span>
            <?php if (($this->data['countAgend'][0]['qnt_cham'] > 0) and ($this->data['countAgend'][0]['status_id'] == 9)) { ?>                
                <?php if ($this->data['countAgend'][0]['qnt_cham'] > 1) { ?>
                    <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=9">Agendados</a></h6>
                <?php } else {?>
                    <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=9">Agendado</a></h6>
                <?php }?>
            <?php } else { ?>
                <h6>Agendado</h6>
            <?php } ?>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countReagend'])) { ?>
                    <h5><?= $this->data['countReagend'][0]['qnt_cham'] ?></h5>
                <?php } ?>
            </span>
            <?php if (($this->data['countReagend'][0]['qnt_cham'] > 0) and ($this->data['countReagend'][0]['status_id'] == 13)) { ?>
                <?php if ($this->data['countReagend'][0]['qnt_cham'] > 1) { ?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=13">Reagendados</a></h6>
                <?php } else {?>
                    <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=13">Reagendado</a></h6>
                <?php }?>
            <?php } else { ?>
                <h6>Reagendado</h6>
            <?php } ?>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamAtend'])) { ?>
                    <h5><?= $this->data['countChamAtend'][0]['qnt_cham_atend'] ?></h5>
                <?php } ?>
            </span>
            <?php if (($this->data['countChamAtend'][0]['qnt_cham_atend'] > 0) and ($this->data['countChamAtend'][0]['status_id'] == 3)) { ?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=3">Em Atendimento</a></h6>
            <?php } else { ?>
                <h6>Em Atendimento</h6>
            <?php } ?>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamPausa'])) { ?>
                    <h5><?= $this->data['countChamPausa'][0]['qnt_cham_pausa'] ?></h5>
                <?php } ?>
            </span>
            <?php if (($this->data['countChamPausa'][0]['qnt_cham_pausa'] > 0) and ($this->data['countChamPausa'][0]['status_id'] == 5)) { ?>
                <?php if ($this->data['countChamPausa'][0]['qnt_cham_pausa'] > 1) { ?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=5">Pausados Suporte</a></h6>
                <?php } else {?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=5">Pausado Suporte</a></h6>
                <?php }?>
            <?php } else { ?>
                <h6>Pausado Suporte</h6>
            <?php } ?>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['qnt_cham_com'])) { ?>
                    <h5><?= $this->data['qnt_cham_com'][0]['qnt_cham_com'] ?></h5>
                <?php } ?>
            </span>
            <?php if (($this->data['qnt_cham_com'][0]['qnt_cham_com'] > 0) and ($this->data['qnt_cham_com'][0]['status_id'] == 11)) { ?>
                <?php if ($this->data['qnt_cham_com'][0]['qnt_cham_com'] > 1) { ?>
                    <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=11">Pausados Comercial</a></h6>
                <?php } else {?>
                    <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=11">Pausado Comercial</a></h6>
                <?php }?>
            <?php } else { ?>
                <h6>Pausado Comercial</h6>
            <?php } ?>
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

        </div>
        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamAgua'])) { ?>
                    <h5><?= $this->data['countChamAgua'][0]['qnt_cham_agua'] ?></h5>
                <?php } ?>
            </span>
            <?php if (($this->data['countChamAgua'][0]['qnt_cham_agua'] > 0) and ($this->data['countChamAgua'][0]['status_id'] == 12)) { ?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=12">Aguardando Outros</a></h6>
            <?php } else { ?>
                <h6>Aguardando Outros</h6>
            <?php } ?>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamFinal'])) { ?>
                    <h5><?= $this->data['countChamFinal'][0]['qnt_cham_final'] ?></h5>
                <?php } ?>
            </span>
            <?php if (($this->data['countChamFinal'][0]['qnt_cham_final'] > 0)) { ?>
                <?php if ($this->data['countChamFinal'][0]['qnt_cham_final'] > 1) { ?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=6">Concluidos</a></h6>
                <?php } else {?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=6">Concluido</a></h6>
                <?php }?>
            <?php } else { ?>
                <h6>Concluidos</h6>
            <?php } ?>
        </div>
        <!-- Verifica se o usuarioe usuario final, se for não visualiza o Box -->
        <?php if (($_SESSION['adms_access_level_id'] <> 14)) {?>            
            <div class="box">
                <h6>Equipamentos</h6>
                <span>
                    <?php
                    if (!empty($this->data['countEquipVenc'])) { ?>
                        <h5><?= $this->data['countEquipVenc'][0]['qnt_equip'] ?></h5>
                    <?php } ?>
                </span>
                <?php if ($this->data['countEquipVenc'][0]['qnt_equip'] > 0) { ?>
                    <?php if ($this->data['countEquipVenc'][0]['qnt_equip'] > 1) { ?>
                        <h6><a href="<?php echo URLADM; ?>list-prod/index">Contratos Vencidos</a></h6>
                    <?php } else {?>
                        <h6><a href="<?php echo URLADM; ?>list-prod/index">Contrato Vencido</a></h6>
                    <?php }?>
                <?php } else { ?>
                    <h6>Vencido</h6>
                <?php } ?>
            </div>
        <?php } ?>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamRepr'])) { ?>
                    <h5><?= $this->data['countChamRepr'][0]['qnt_cham_repr'] ?></h5>
                <?php } ?>
            </span>
            <?php if (($this->data['countChamRepr'][0]['qnt_cham_repr'] > 0) and ($this->data['countChamRepr'][0]['status_id'] == 7)) { ?>
                <?php if ($this->data['countChamRepr'][0]['qnt_cham_repr'] > 1) { ?>
                    <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=7">Reprovados</a></h6>
                <?php } else {?>
                    <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=7">Reprovado</a></h6>
                <?php }?>
            <?php } else { ?>
                <h6>Reprovado</h6>
            <?php } ?>
        </div>

        <div class="box">
            <h6>Tickets</h6>
            <span>
                <?php
                if (!empty($this->data['countChamApro'])) { ?>
                    <h5><?= $this->data['countChamApro'][0]['qnt_cham_apro'] ?></h5>
                <?php } ?>
            </span>
            <?php if (($this->data['countChamApro'][0]['qnt_cham_apro'] > 0) and ($this->data['countChamApro'][0]['status_id'] == 8)) { ?>
                <?php if ($this->data['countChamApro'][0]['qnt_cham_apro'] > 1) { ?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=8">Aprovados</a></h6>
                <?php } else {?>
                <h6><a href="<?php echo URLADM; ?>list-cham/index?status_ticket=8">Aprovado</a></h6>
                <?php }?>
            <?php } else { ?>
                <h6>Aprovado</h6>
            <?php } ?>
        </div>
    </div>


    <!--  inicio do carroussel da assistencia tecnica -->
    <section class="top-carr">
        <div class="row">
            <div class="col-md-12">
                <div id="carouselExampleIndicators" class="carousel slide carousel-fade">                    
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
                    </div>
                    <div class="carousel-inner">                        
                        <div class="carousel-item active">
                            <div class="carousel-caption d-none d-md-block">                                
                                <a href="https://www.instagram.com/repbrasilcomunicacaovisual" target="_blank">
                                    <i class="fab fa-instagram btn-lg btn-danger mt-3" data-toggle="tooltip" data-placement="top" title="Conheça nossa linha de produtos gráfico através de nosso Instagram"></i> 
                                </a>
                            </div>
                            <img src="<?php echo URL; ?>app/adms/assets/image/marketing/carrousel/1.jpg" class="d-block w-100" alt="Marketing Grafico">
                        
                        </div>

                        <div class="carousel-item">
                            <div class="carousel-caption d-none d-md-block">                                
                                <a href="https://www.instagram.com/repbrasilcomunicacaovisual" target="_blank">
                                    <i class="fab fa-instagram btn-lg btn-danger mt-3" data-toggle="tooltip" data-placement="top" title="Conheça nossa linha de produtos gráfico através de nosso Instagram"></i>
                                </a>
                            </div>
                            <img src="<?php echo URL; ?>app/adms/assets/image/marketing/carrousel/2.jpg" class="d-block w-100" alt="Marketing Grafico">
                        </div>

                        <div class="carousel-item">
                            <div class="carousel-caption d-none d-md-block">                                
                                <a href="https://www.instagram.com/repbrasilcomunicacaovisual" target="_blank">
                                    <i class="fab fa-instagram btn-lg btn-danger mt-3" data-toggle="tooltip" data-placement="top" title="Conheça nossa linha de produtos gráfico através de nosso Instagram"></i>
                                </a>
                            </div>
                            <img src="<?php echo URL; ?>app/adms/assets/image/marketing/carrousel/3.jpg" class="d-block w-100" alt="Marketing Grafico">
                        </div>

                        <div class="carousel-item">
                            <div class="carousel-caption d-none d-md-block">                                
                                <a href="https://www.instagram.com/repbrasilcomunicacaovisual" target="_blank">
                                    <i class="fab fa-instagram btn-lg btn-danger mt-3" data-toggle="tooltip" data-placement="top" title="Conheça nossa linha de produtos gráfico através de nosso Instagram"></i>
                                </a>
                            </div>
                            <img src="<?php echo URL; ?>app/adms/assets/image/marketing/carrousel/4.jpg" class="d-block w-100" alt="Marketing Grafico">
                        </div>

                        <div class="carousel-item">
                            <div class="carousel-caption d-none d-md-block">                                
                                <a href="https://www.instagram.com/repbrasilcomunicacaovisual" target="_blank">
                                    <i class="fab fa-instagram btn-lg btn-danger mt-3" data-toggle="tooltip" data-placement="top" title="Conheça nossa linha de produtos gráfico através de nosso Instagram"></i>
                                </a>
                            </div>
                            <img src="<?php echo URL; ?>app/adms/assets/image/marketing/carrousel/5.jpg" class="d-block w-100" alt="Marketing Grafico">
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="whatsapp-box">
            <a href="https://api.whatsapp.com/send?phone=5571981376244&text=Ol%C3%A1,%20tudo%20bem?%20Estou%20interessado%20em%20saber%20mais%20sobre%20seus%20produtos%20Graficos,%20conforme%20publicado%20no%20DOCNET!" data-title="Atendimento via WhatsApp" class="tooltip-link" target="_blank" id="whatsapp-icon">
            <img src="<?php echo URL; ?>app/adms/assets/image/whatsapp-logo.png" alt="WhatsApp" /></a>
        </div>

    </section>
    <!--  final do carroussel da assistencia tecnica -->




</div>
<!-- Fim  dos box do dashboard -->