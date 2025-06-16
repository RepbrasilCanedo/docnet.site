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
//echo "<pre>"; var_dump($this->data['select']);echo "</pre>";
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Editar Colaborador(a)</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_users']) {
                    echo "<a href='" . URLADM . "list-users/index' class='btn-info'>Listar</a> ";
                }
                if (isset($valorForm['id'])) {
                    if ($this->data['button']['view_users']) {
                        echo "<a href='" . URLADM . "view-users/index/" . $valorForm['id'] . "' class='btn-primary'>Visualizar</a><br><br>";
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
            <span id="msg"></span>
        </div>

        <div class="content-adm">
            <form method="POST" action="" id="form-edit-user" class="form-adm">
                <?php
                $id = "";
                if (isset($valorForm['id'])) {
                    $id = $valorForm['id'];
                }
                ?>
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

                <div class="row-input">
                    <div class="column">
                        <?php
                        $name = "";
                        if (isset($valorForm['name'])) {
                            $name = $valorForm['name'];
                        }
                        ?>
                        <label class="title-input">Nome:<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="input-adm" placeholder="Digite o nome completo" value="<?php echo $name; ?>" required>
                    </div>

                    <?php if ($_SESSION['adms_access_level_id'] < 2) { ?>

                        <div class="column">
                            <?php
                            $empresa_id = "";
                            if (isset($valorForm['empresa_id'])) {
                                $empresa_id = $valorForm['empresa_id'];
                            }
                            ?>
                            <label class="title-input">Empresa: <span class="text-danger">*</span></label>
                            <select name="empresa_id" id="empresa_id" class="input-adm" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->data['select']['emp'] as $emp) {
                                    extract($emp);
                                    if ((isset($valorForm['adms_sits_user_id'])) and ($valorForm['adms_sits_user_id'] == $id_emp)) {
                                        echo "<option value='$id_emp' selected>$nome_fantasia_emp</option>";
                                    } else {
                                        echo "<option value='$id_emp'>$nome_fantasia_emp</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    <?php } ?>

                    <div class="column">
                        <?php
                        $email = "";
                        if (isset($valorForm['email'])) {
                            $email = $valorForm['email'];
                        }
                        ?>
                        <label class="title-input">E-mail:<span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="input-adm" placeholder="Digite o seu melhor e-mail" value="<?php echo $email; ?>" required>

                    </div>

                    <div class="column">
                        <?php
                        $tel_1 = "";
                        if (isset($valorForm['tel_1'])) {
                            $tel_1 = $valorForm['tel_1'];
                        }
                        ?>
                        <label class="title-input">Telefone Principal: <span class="text-danger">*</span></label>
                        <input type="text" name="tel_1" id="tel_1" class="input-adm" placeholder="Digite o telefone principal" value="<?php echo $tel_1; ?> " required>
                    </div>
                </div>

                <div class="row-input">

                    <div class="column">
                        <?php
                        $tel_2 = "";
                        if (isset($valorForm['tel_2'])) {
                            $tel_2 = $valorForm['tel_2'];
                        }
                        ?>
                        <label class="title-input">Telefone Secundário: <span class="text-danger">*</span></label>
                        <input type="text" name="tel_2" id="tel_2" class="input-adm" placeholder="Digite o telefone" value="<?php echo $tel_2; ?>" required>
                    </div>

                    <div class="column">
                        <?php
                        $user = "";
                        if (isset($valorForm['user'])) {
                            $user = $valorForm['user'];
                        }
                        ?>
                        <label class="title-input">Usuário:<span class="text-danger">*</span></label>
                        <input type="text" name="user" id="user" class="input-adm" placeholder="Digite o usuário para acessar o administrativo" value="<?php echo $user; ?>" required>

                    </div>

                    <div class="column">
                        <?php
                        $adms_sits_user_id = "";
                        if (isset($valorForm['adms_sits_user_id'])) {
                            $adms_sits_user_id = $valorForm['adms_sits_user_id'];
                        }
                        ?>
                        <label class="title-input">Situação:<span class="text-danger">*</span></label>
                        <select name="adms_sits_user_id" id="adms_sits_user_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['sit_user'] as $sit) {
                                extract($sit);
                                if ((isset($valorForm['adms_sits_user_id'])) and ($valorForm['adms_sits_user_id'] == $id_sit)) {
                                    echo "<option value='$id_sit' selected>$name_sit</option>";
                                } else {
                                    echo "<option value='$id_sit'>$name_sit</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row-input">

                    <div class="column">
                        <?php
                        $adms_access_level_id = "";
                        if (isset($valorForm['adms_access_level_id'])) {
                            $adms_access_level_id = $valorForm['adms_access_level_id'];
                        }
                        ?>
                        <label class="title-input">Nível de Acesso:<span class="text-danger">*</span></label>
                        <select name="adms_access_level_id" id="adms_access_level_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['lev'] as $lev) {
                                extract($lev);
                                if ((isset($valorForm['adms_access_level_id'])) and ($valorForm['adms_access_level_id'] == $id_lev)) {
                                    echo "<option value='$id_lev' selected>$name_lev</option>";
                                } else {
                                    echo "<option value='$id_lev'>$name_lev</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="column">
                        <?php
                        $password = "";
                        if (isset($valorForm['password'])) {
                            $password = $valorForm['password'];
                        }
                        ?>
                        <label class="title-input">Senha:<span class="text-danger">*</span></label>
                        <input type="password" name="password" id="password" class="input-adm" placeholder="Digite a senha" onkeyup="passwordStrength()" autocomplete="on" value="<?php echo $password; ?>" required>
                        <span id="msgViewStrength"></span>
                    </div>
                </div>

                <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>

                <button type="submit" name="SendEditUser" class="btn-warning" value="Salvar">Salvar</button>

            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->