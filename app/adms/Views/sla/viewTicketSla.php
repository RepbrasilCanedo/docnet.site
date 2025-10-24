<?php
if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Detalhes do SLA do Ticket</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_ticket_sla']) {
                    echo "<a href='" . URLADM . "list-ticket-sla/index' class='btn-info'>Listar</a> ";
                }
                ?>
            </div>
        </div>

        <div class="content-adm-alert">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
        </div>

        <div class="content-adm">
            <?php
            if (!empty($this->data['viewTicketSla'])) {
                extract($this->data['viewTicketSla'][0]);
            ?>

                <div class="view-det-adm">
                    <span class="view-adm-title">ID: </span>
                    <span class="view-adm-info"><?php echo $id_sla_hist; ?></span>
                </div>
                
                <div class="view-det-adm">
                    <span class="view-adm-title">Cliente: </span>
                    <span class="view-adm-info"><?php echo $nome_fantasia_clie; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Nº Ticket: </span>
                    <span class="view-adm-info"><?php echo $id_ticket_sla_hist; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Data Abertura do Ticket: </span>
                    <span class="view-adm-info"><?php echo date('d/m/Y H:i:s', strtotime($dt_status))?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Tipo: </span>
                    <span class="view-adm-info"><?php echo $name_sla; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Primeira Resposta: </span>
                    <span class="view-adm-info"><?php echo $tempo_sla_prim; ?></span>
                </div>
                <div class="view-det-adm">
                    <span class="view-adm-title">Prazo SLA: </span>
                    <span class="view-adm-info"><?php echo $tempo_sla_fin; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Suporte: </span>
                    <span class="view-adm-info"><?php echo $name_user; ?></span>
                </div>                

                <div class="view-det-adm">
                    <span class="view-adm-title">Status Anterior: </span>
                    <span class="view-adm-info"><?php echo $name_status_id_ant; ?></span>
                </div>                

                <div class="view-det-adm">
                    <span class="view-adm-title">Data Status Anterior: </span>
                    <span class="view-adm-info"><?php echo date('d/m/Y H:i:s', strtotime($dt_status_ant))?></span>
                </div>                

                <div class="view-det-adm">
                    <span class="view-adm-title">Status Atual: </span>
                    <span class="view-adm-info"><?php echo $name_sta_atu; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Data Status Atual: </span>
                    <span class="view-adm-info"><?php echo date('d/m/Y H:i:s', strtotime($dt_status))?></span>
                </div>                

                <div class="view-det-adm">
                    <span class="view-adm-title">Tempo de Sla Status Atual: </span>
                    <span class="view-adm-info"><?php echo date('H:i:s', strtotime($tempo_sla))?></span>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->