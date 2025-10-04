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
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Editar Usuário Final</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_users_final']) {
                    echo "<a href='" . URLADM . "list-users-final/index' class='btn-info'>Listar</a> ";
                }
                if (isset($valorForm['id'])) {
                    if ($this->data['button']['view_users_final']) {
                        echo "<a href='" . URLADM . "view-users-final/index/" . $valorForm['id'] . "' class='btn-primary'>Visualizar</a><br><br>";
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
                        $name_usr_final = "";
                        if (isset($valorForm['name_usr_final'])) {
                            $name_usr_final = $valorForm['name_usr_final'];
                        }
                        ?>
                        <label class="title-input">Nome:<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="input-adm" placeholder="Digite o nome completo" value="<?php echo $name_usr_final; ?>" required>
                    </div>

                    <div class="column">
                        <?php
                        $tel_1_usr_final = "";
                        if (isset($valorForm['tel_1_usr_final'])) {
                            $tel_1_usr_final = $valorForm['tel_1_usr_final'];
                        }
                        ?>
                        <label class="title-input">Tel/WhatsApp:<span class="text-danger">*</span></label>
                        <input type="text" name="tel_1" id="tel_1" class="input-adm" placeholder="Digite o seu melhor e-mail" value="<?php echo $tel_1_usr_final; ?>" required>

                    </div>

                    <div class="column">
                        <?php
                        $email_usr_final = "";
                        if (isset($valorForm['email_usr_final'])) {
                            $email_usr_final = $valorForm['email_usr_final'];
                        }
                        ?>
                        <label class="title-input">E-mail:<span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="input-adm" placeholder="Digite o seu melhor e-mail" value="<?php echo $email_usr_final; ?>" required>

                    </div>
                </div>

                <div class="row-input">

                    <div class="column">
                        <?php
                        $nome_fantasia_cli = "";
                        if (isset($valorForm['nome_fantasia_cli'])) {
                            $nome_fantasia_cli = $valorForm['nome_fantasia_cli'];
                        }
                        ?>
                        <label class="title-input">Empresa: <span class="text-danger">*</span></label>
                        <select name="cliente_id" id="cliente_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['emp'] as $emp) {
                                extract($emp);
                                
                                if ((isset($valorForm['nome_fantasia_clie'])) and ($valorForm['nome_fantasia_clie'] == $nome_fantasia_emp)) {
                                    echo "<option value='$id_emp' selected>$nome_fantasia_emp</option>";
                                } else {
                                    echo "<option value='$id_emp'>$nome_fantasia_emp</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="column">
                        <?php
                        $user_usr_final = "";
                        if (isset($valorForm['user_usr_final'])) {
                            $user_usr_final = $valorForm['user_usr_final'];
                        }
                        ?>
                        <label class="title-input">Usuário:<span class="text-danger">*</span></label>
                        <input type="text" name="user" id="user" class="input-adm" placeholder="Digite o usuário para acessar o administrativo" value="<?php echo $user_usr_final; ?>" required>

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
                                if ((isset($valorForm['name_sit'])) and ($valorForm['name_sit'] == $name_sit)) {
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

                <button type="submit" name="SendEditUserFinal" class="btn-warning" value="Salvar">Salvar</button>

            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->