<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}
//echo "<pre>"; var_dump($valorForm);
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Editar Imagem de Erro</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_cham']) {
                    echo "<a href='" . URLADM . "list-cham/index' class='btn-primary'>Listar</a> ";
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
            <span id="msg"></span>
        </div>

        <div class="content-adm">
            <form method="POST" action="" id="form-edit-prof-img-cham" class="form-adm" enctype="multipart/form-data">

                <div class="row-input">
                    <div class="column">
                        <?php
                        $id = "";
                        if (isset($valorForm['id'])) {
                            $id = $valorForm['id'];
                        }
                        ?>
                        <label class="title-input">Imagem:<span class="text-danger">*</span> 300x300</label>
                        <input type="file" name="new_image_cham" id="new_image_cham" class="input-adm" onchange="inputFileValImgCham()">
                    </div>
                    <div class="column">
                        <?php
                        if ((!empty($valorForm['image'])) and (file_exists("app/adms/assets/image/chamados/" . $id ."/" . $valorForm['image']))) {
                            $old_image = URLADM . "app/adms/assets/image/chamados/" . $id . "/" . $valorForm['image'];
                        } else {
                            $old_image = URLADM . "app/adms/assets/image/chamados/erro.png";
                        }
                        ?>
                        <span id="preview-img-cham">
                            <img src="<?php echo $old_image; ?>" alt="Imagem" style="width: 100px; height: 100px;">
                        </span>
                    </div>
                </div>

                <button type="submit" name="SendEditProfImageCham" class="btn-warning" value="Salvar">Anexar</button>

            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->