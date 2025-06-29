<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Cadastrar Equipamento</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_prod']) {
                    echo "<a href='" . URLADM . "list-prod/index' class='btn-info'>Listar</a> ";
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
            <form method="POST" action="" id="form-add-prod" class="form-adm">

                <?php if ($_SESSION['adms_access_level_id'] > 2) { ?>

                    <div class="row-input">
                        <div class="column">
                            <?php
                            $name = "";
                            if (isset($valorForm['name'])) {
                                $name = $valorForm['name'];
                            }
                            ?>
                            <label class="title-input">Nome Equipamento:<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="input-adm" placeholder="Nome do produtos" value="<?php echo $name; ?>" required>

                        </div>
                        <div class="column">
                            <label class="title-input">Tipo do Equipamento:<span class="text-danger">*</span></label>
                            <select name="type_id" id="type_id" class="input-adm" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->data['select']['type_equip'] as $tipEquip) {
                                    extract($tipEquip);
                                    if (isset($valorForm['type_id']) and $valorForm['type_id'] == $id_typ) {
                                        echo "<option value='$id_typ' selected>$name_typ</option>";
                                    } else {
                                        echo "<option value='$id_typ'>$name_typ</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="column">
                            <?php
                            $serie = "";
                            if (isset($valorForm['serie'])) {
                                $serie = $valorForm['serie'];
                            }
                            ?>
                            <label class="title-input">Número Série: </span></label>
                            <input type="text" name="serie" id="serie" class="input-adm" placeholder="Serie do produtos" value="<?php echo $serie; ?>" required>

                        </div>
                    </div>

                    <div class="row-input">
                        <div class="column">
                            <?php
                            $modelo_id = "";
                            if (isset($valorForm['modelo_id'])) {
                                $modelo_id = $valorForm['modelo_id'];
                            }
                            ?>
                            <label class="title-input">Modelo do Equipamento:<span class="text-danger">*</span></label>
                            <input type="text" name="modelo_id" id="modelo_id" class="input-adm" placeholder="Modelo do produtos" value="<?php echo $modelo_id; ?>" required>

                        </div>

                        <div class="column">

                            <?php
                            $marca_id = "";
                            if (isset($valorForm['marca_id'])) {
                                $marca_id = $valorForm['marca_id'];
                            }
                            ?>
                            <label class="title-input">Marca do Equipamento:<span class="text-danger">*</span></label>
                            <input type="text" name="marca_id" id="marca_id" class="input-adm" placeholder="Nome do produtos" value="<?php echo $marca_id; ?>" required>

                        </div><div class="column">
                            <label class="title-input">Empresa do Equipamento:<span class="text-danger">*</span></label>
                            <select name="cliente_id" id="cliente_id" class="input-adm" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->data['select']['emp_equip'] as $empEquip) {
                                    extract($empEquip);
                                    if (isset($valorForm['empresa_id']) and $valorForm['empresa_id'] == $id_emp) {
                                        echo "<option value='$id_emp' selected>$nome_fantasia_emp</option>";
                                    } else {
                                        echo "<option value='$id_emp'>$nome_fantasia_emp</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row-input">
                        <div class="column">
                            <label class="title-input">Situação do Equipamento:<span class="text-danger">*</span></label>
                            <select name="sit_id" id="sit_id" class="input-adm" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->data['select']['sit_equip'] as $sitEquip) {
                                    extract($sitEquip);
                                    if (isset($valorForm['sit_id']) and $valorForm['sit_id'] == $id_sit) {
                                        echo "<option value='$id_sit' selected>$name_sit</option>";
                                    } else {
                                        echo "<option value='$id_sit'>$name_sit</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>                        
                        <div class="column">
                            <label class="title-input">Tipo do Contrato:<span class="text-danger">*</span></label>
                            <select name="contr_id" id="contr_id" class="input-adm" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->data['select']['contr_id'] as $contr_id) {
                                    extract($contr_id);
                                    if (isset($valorForm['contr_id']) and $valorForm['contr_id'] == $id) {
                                        echo "<option value='$id' selected>$name</option>";
                                    } else {
                                        echo "<option value='$id'>$name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="column">
                            <?php
                            $venc_contr = "";
                            if (isset($valorForm['venc_contr'])) {
                                $venc_contr = $valorForm['venc_contr'];
                            }
                            ?>
                            <label class="title-input">Vencimento Contrato:<span class="text-danger">*</span></label>
                            <input type=date name="venc_contr" id="venc_contr" class="input-adm" value="<?php echo $venc_contr; ?>" required>
                        </div>
                    </div>
                    <div class="row-input">
                        
                        <div class="column">
                            <?php
                            $inf_adicionais = "";
                            if (isset($valorForm['inf_adicionais'])) {
                                $inf_adicionais = $valorForm['inf_adicionais'];
                            }
                            ?>
                            <label class="title-input">Informações Adicionais:<span class="text-danger">*</span></label>
                            <textarea name="inf_adicionais" id="inf_adicionais" class="input-adm" placeholder="Observações" value="<?php echo $inf_adicionais; ?>" required></textarea>
                        </div>
                    </div>

                <?php } else { ?>

                    <div class="row-input">
                        <div class="column">
                            <?php
                            $name = "";
                            if (isset($valorForm['name'])) {
                                $name = $valorForm['name'];
                            }
                            ?>
                            <label class="title-input">Nome Equipamento:<span class="text-danger">*</span></label>
                            <input type="text" name="name" id="name" class="input-adm" placeholder="Nome do produtos" value="<?php echo $name; ?>" required>

                        </div>
                        <div class="column">
                            <label class="title-input">Tipo do Equipamento:<span class="text-danger">*</span></label>
                            <select name="type_id" id="type_id" class="input-adm" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->data['select']['type_equip'] as $sitEquip) {
                                    extract($sitEquip);
                                    if (isset($valorForm['type_id']) and $valorForm['type_id'] == $id_typ) {
                                        echo "<option value='$id_typ' selected>$name_typ</option>";
                                    } else {
                                        echo "<option value='$id_typ'>$name_typ</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="column">
                            <?php
                            $serie = "";
                            if (isset($valorForm['serie'])) {
                                $serie = $valorForm['serie'];
                            }
                            ?>
                            <label class="title-input">Número Série: </span></label>
                            <input type="text" name="serie" id="serie" class="input-adm" placeholder="Serie do produtos" value="<?php echo $serie; ?>" required>

                        </div>
                    </div>

                    <div class="row-input">
                        <div class="column">
                            <label class="title-input">Modelo do Equipamento:<span class="text-danger">*</span></label>
                            <select name="modelo_id" id="modelo_id" class="input-adm" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->data['select']['mod_equip'] as $modeloEquip) {
                                    extract($modeloEquip);
                                    if (isset($valorForm['modelo_id']) and $valorForm['modelo_id'] == $id_modelo) {
                                        echo "<option value='$id_modelo' selected>$name_modelo</option>";
                                    } else {
                                        echo "<option value='$id_modelo'>$name_modelo</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="column">
                            <label class="title-input">Marca do Equipamento:<span class="text-danger">*</span></label>
                            <select name="marca_id" id="marca_id" class="input-adm" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->data['select']['marca_equip'] as $marcaEquip) {
                                    extract($marcaEquip);
                                    if (isset($valorForm['marca_id']) and $valorForm['marca_id'] == $id_mar) {
                                        echo "<option value='$id_mar' selected>$name_mar</option>";
                                    } else {
                                        echo "<option value='$id_mar'>$name_mar</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div class="row-input">

                        <div class="column">
                            <label class="title-input">Empresa do Equipamento:<span class="text-danger">*</span></label>
                            <select name="empresa_id" id="empresa_id" class="input-adm" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->data['select']['emp_equip'] as $empEquip) {
                                    extract($empEquip);
                                    if (isset($valorForm['empresa_id']) and $valorForm['empresa_id'] == $id_emp) {
                                        echo "<option value='$id_emp' selected>$nome_fantasia_emp</option>";
                                    } else {
                                        echo "<option value='$id_emp'>$nome_fantasia_emp</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="column">
                            <label class="title-input">Situação do Equipamento:<span class="text-danger">*</span></label>
                            <select name="sit_id" id="sit_id" class="input-adm" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->data['select']['sit_equip'] as $sitEquip) {
                                    extract($sitEquip);
                                    if (isset($valorForm['sit_id']) and $valorForm['sit_id'] == $id_sit) {
                                        echo "<option value='$id_sit' selected>$name_sit</option>";
                                    } else {
                                        echo "<option value='$id_sit'>$name_sit</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                <?php } ?>

                <p class="text-danger mb-3 fs-6">* Campo Obrigatório</p>

                <button type="submit" name="SendAddProd" class="btn-success" value="Cadastrar">Cadastrar</button>

            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->