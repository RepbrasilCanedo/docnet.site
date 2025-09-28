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
            <span class="title-content">Detalhes do SLA</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_sla']) {
                    echo "<a href='" . URLADM . "list-sla/index' class='btn-info'>Listar</a> ";
                }
                if (!empty($this->data['viewSla'])) {
                    if ($this->data['button']['edit_sla']) {
                        echo "<a href='" . URLADM . "edit-sla/index/" . $this->data['viewSla'][0]['id_sla'] . "' class='btn-warning'>Editar</a> ";
                    }
                    if ($this->data['button']['delete_sla']) {
                        echo "<a href='" . URLADM . "delete-sla/index/" . $this->data['viewSla'][0]['id_sla'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")' class='btn-danger'>Apagar</a> ";
                    }
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
            if (!empty($this->data['viewSla'])) {
                extract($this->data['viewSla'][0]);
            ?>

                <div class="view-det-adm">
                    <span class="view-adm-title">ID: </span>
                    <span class="view-adm-info"><?php echo $id_sla; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Nome: </span>
                    <span class="view-adm-info"><?php echo $name; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Primeira Resposta do SLA: </span>
                    <span class="view-adm-info"><?php echo $prim_resp_sla; ?></span>
                </div>
                <div class="view-det-adm">
                    <span class="view-adm-title">Tempo Total SLA: </span>
                    <span class="view-adm-info"><?php echo $final_resp_sla; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Prazo SLA: </span>
                    <span class="view-adm-info"><?php echo $name_temp; ?></span>
                </div>
                

                <div class="view-det-adm">
                    <span class="view-adm-title">Tipo de Urgencia: </span>
                    <span class="view-adm-info"><?php echo $name_ativ; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Dados Adicionais: </span>
                    <span class="view-adm-info"><?php echo $obs_sla; ?></span>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->