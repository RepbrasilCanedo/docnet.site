<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
//echo "<pre>"; var_dump($this->data['select']['cliente']);
//echo "<pre>"; var_dump($this->data['select']['produto']);
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Abertura Chamado </span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_cham']) {
                    echo "<a href='" . URLADM . "list-cham/index' class='btn-info'>Listar</a> ";
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
                        <label class="title-input">Contato:<span class="text-danger">*</span></label>
                        <input type="text" name="contato" id="contato" class="input-adm" placeholder="Digite o nome do contato" value="<?php $contato ?>" required>
                    </div>
                    <div class="column">
                        <label class="title-input">Telefone/WhatsApp (Ex: 00 00000 0000):<span class="text-danger">*</span></label>
                        <input type="text" name="tel_contato" id="tel_contato" class="input-adm" placeholder="## ##### ####" value="<?php $tel_contato ?>" required>
                    </div>

                    <div class="column">
                        <label class="title-input">Cliente:<span class="text-danger">*</span></label>
                        <select name="cliente_id" id="cliente_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['cliente'] as $nome_emp) {
                                extract($nome_emp);
                                if (isset($valorForm['cliente_id']) and $valorForm['cliente_id'] == $id) {
                                    echo "<option value='$id' selected>$nome_fantasia</option>";
                                } else {
                                    echo "<option value='$id'>$nome_fantasia</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="column">
                        <label class="title-input">Tipo de Chamado:<span class="text-danger">*</span></label>
                        <select name="type_cham" id="type_cham" class="input-adm" required>
                            <option value="">Selecione</option>
                            <option value="Telefonico">Telefônico</option>
                            <option value="Remoto">Remoto</option>
                            <option value="Presencial">Presencial</option>
                            <option value="Outros">Outros</option>
                        </select>
                    </div>
                    <div class="column">
                        <label class="title-input">Produto:<span class="text-danger">*</span></label>
                        <select name="prod_id" id="prod_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['produto'] as $nome) {
                                extract($nome);
                                if (isset($valorForm['id']) and $valorForm['id'] == $id) {
                                    echo "<option value='$id' selected>$name</option>";
                                } else {
                                    echo "<option value='$id'>$name</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                </div>

                <div class="column">
                    <?php
                    $inf_cham = "";
                    if (isset($valorForm['inf_cham'])) {
                        $inf_cham = $valorForm['inf_cham'];
                    }
                    ?>
                    <label class="title-input">Problema Apresentado:<span class="text-danger">*</span></label>
                    <textarea name="inf_cham" id="inf_cham" rows="5" cols="50" class="input-adm" placeholder="Problema Apresentado" value="<?php echo $inf_cham; ?>" required></textarea>

                </div>

                <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>

                <button type="submit" name="SendAddCham" class="btn-success" value="Cadastrar">Cadastrar</button>

            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->