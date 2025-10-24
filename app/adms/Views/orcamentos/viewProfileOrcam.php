<?php
if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}
//var_dump($this->data['viewProfileOrcam']);
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Anexar Orçamento</span>
            <div class="top-list-right">
                <?php
                if (!empty($this->data['viewProfileOrcam'])) {

                    if ($this->data['button']['list_orcam']) {
                        echo "<a href='" . URLADM . "list-orcam/index' class='btn-info'>Listar</a> ";
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
            if (!empty($this->data['viewProfileOrcam'])) {
                extract($this->data['viewProfileOrcam'][0]);
            ?>

                <div class="view-det-adm">
                    <span class="view-adm-title">Número Orçamento: </span>
                    <span class="view-adm-info"><?php echo $id; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Produto/Serviço: </span>
                    <span class="view-adm-info"><?php echo $prod_serv; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Informções Adicionáis: </span>
                    <span class="view-adm-info"><?php echo $info_prod_serv; ?></span>
                </div>
                
                <?php
                if ($this->data['button']['edit_profile_image_orcam']) {
                    echo "<a href='" . URLADM . "edit-profile-image-orcam/index/$id' class='btn-warning'>Anexar Imagem</a> ";
                }
                ?>

            <?php }?>
                
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->