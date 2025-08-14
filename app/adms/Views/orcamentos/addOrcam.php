<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
//echo "<pre>"; var_dump($this->data['select']['cliente']);

?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Solicitação de Orçamento de Produtos ou Serviços </span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_orcam']) {
                    echo "<a href='" . URLADM . "list-orcam/index' class='btn-info'>Listar</a> ";
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
            <form method="POST" action="" id="form-add-cham" class="form-adm">

                <div class="row-input">
                    <div class="column">
                        <?php
                            $contato = "";
                            if (isset($valorForm['contato'])) {
                                $contato = $valorForm['contato'];
                            }
                        ?>
                        <label class="title-input">Contato:<span class="text-danger">*</span></label>
                        <input type="text" name="contato" id="contato" class="input-adm" placeholder="Digite o nome do contato" value="<?php $contato ?>" required>
                    </div>
                    <div class="column">
                        <?php
                            $tel_contato = "";
                            if (isset($valorForm['tel_contato'])) {
                                $tel_contato = $valorForm['tel_contato'];
                            }
                        ?>
                        <label class="title-input">Telefone/WhatsApp (Ex: 00 00000 0000):<span class="text-danger">*</span></label>
                        <input type="text" name="tel_contato" id="tel_contato" class="input-adm" placeholder="## ##### ####" value="<?php $tel_contato ?>" required>
                    </div>
                </div>
                <div class="row-input">
                    <div class="column">
                        <?php
                        $prod_serv = "";
                        if (isset($valorForm['prod_serv'])) {
                            $prod_serv = $valorForm['prod_serv'];
                        }
                        ?>
                        <label class="title-input">Produto /Serviço:<span class="text-danger">*</span></label>
                        <input type="text" name="prod_serv" id="prod_serv" rows="5" cols="50" class="input-adm" placeholder="Informações Adicionais" value="<?php echo $prod_serv; ?>" required>

                    </div>

                    <div class="column">
                        <?php
                        $info_prod_serv = "";
                        if (isset($valorForm['info_prod_serv'])) {
                            $info_prod_serv = $valorForm['info_prod_serv'];
                        }
                        ?>
                        <label class="title-input">Informações Adicionais:<span class="text-danger">*</span></label>
                        <textarea name="info_prod_serv" id="info_prod_serv" rows="5" cols="50" class="input-adm" placeholder="Informações Adicionais" value="<?php echo $info_prod_serv; ?>" required></textarea>

                    </div>
                </div>

                <p class="text-danger mb-5 fs-6">* Campo Obrigatório</p>

                <button type="submit" name="SendAddOrcam" class="btn-success" value="Cadastrar">Cadastrar</button>

            </form>
        </div>
    </div>
</div>

<!-- Fim do conteudo do administrativo -->