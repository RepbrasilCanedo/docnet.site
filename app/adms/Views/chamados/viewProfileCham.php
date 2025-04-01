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
            <span class="title-content">Anexo de Imagem de Erro do Chamado</span>
            <div class="top-list-right">
                <?php
                if (!empty($this->data['viewProfileCham'])) {

                    if ($this->data['button']['list_cham']) {
                        echo "<a href='" . URLADM . "list-cham/index' class='btn-info'>Listar</a> ";
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
            if (!empty($this->data['viewProfileCham'])) {
                extract($this->data['viewProfileCham'][0]);
            ?>
                <div class="view-det-adm">
                    <span class="view-adm-title">Imagem do Erro: </span>
                    <span class="view-adm-info">
                        <?php
                        if ((!empty($image)) and (file_exists("app/adms/assets/image/chamados" . "/$id"))) {
                            echo "<img src='" . URLADM . "app/adms/assets/image/chamados/" . $id . "/" . "$image'><br><br>";
                        } else {
                            echo "<img src='" . URLADM . "app/adms/assets/image/chamados/erro.png' width='100' height='100'><br><br>";
                        }
                        ?>
                    </span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Número Chamado: </span>
                    <span class="view-adm-info"><?php echo $id; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Erro Apontado: </span>
                    <span class="view-adm-info"><?php echo $inf_cham; ?></span>
                </div>
                <?php
                if ($this->data['button']['edit_profile_image_cham']) {
                    echo "<a href='" . URLADM . "edit-profile-image-cham/index/$id' class='btn-warning'>Anexar Imagem</a> ";
                }
                ?>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->