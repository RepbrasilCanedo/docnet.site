<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}
//var_dump($this->data);
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Cadastrar Historico</span>
            <div class="top-list-right">
                <?php
                $cham=$_SESSION['set_cham'];
                if ($this->data['button']['edit_cham']) {
                    echo "<a href='" . URLADM . "edit-cham/index/$cham' class='btn-info'>Voltar</a>";
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
            <form method="POST" action="" id="form-add-hist-cham" class="form-adm">
                <div class="row-input">
                    <div class="column">
                        <label class="title-input">Histórico:<span class="text-danger">*</span></label>
                        <textarea type="text" name="obs" id="obs" class="input-adm" placeholder="Digite o Historico do Chamado" rows="10" autofocus required></textarea>
                    </div>
                </div>

                <p class="text-danger mb-5 fs-6">* Campo Obrigatório</p>

                <button type="submit" name="SendAddHistCham"  class="btn-success" value="Cadastrar">Cadastrar</button>

            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->