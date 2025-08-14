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
 //var_dump($valorForm);
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Editar Imagem do Orçamento: </span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_orcam']) {
                    echo "<a href='" . URLADM . "list-orcam/index' class='btn-primary'>Listar</a> ";
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
            <form method="POST" action="" id="form-edit-prof-img-orcam" class="form-adm" enctype="multipart/form-data">

                <div class="row-input">
                    <div class="column">
                        <?php
                        $id = "";
                        if (isset($valorForm['id'])) {
                            $id = $valorForm['id'];
                        }
                        ?>
                        <input type="file" name="new_image_orcam" id="new_image_orcam" class="input-adm" onchange="inputFileValImgOrcam()">
                    </div>                  
                
                <div class="view-det-adm">
                    <?php
                     if ((!empty($image)) and (file_exists("app/adms/assets/image/orcamentos" . "/$id"))) {?>
                        <a href="<?php echo URLADM; ?>app/adms/assets/image/orcamentos/<?php echo $id ?>/<?php echo $image ?>"  target="_blank">Clique aqui para Visualizar orçamento em PDF.</a>
                    <?php }  ?>
                </div>
                
                </div>

                <button type="submit" name="SendEditProfImageOrcam" class="btn-warning" value="Salvar">Anexar</button>

            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->