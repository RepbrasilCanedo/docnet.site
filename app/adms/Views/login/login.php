<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

?>
<div class="container-login">
    <div class="wrapper-login">
        <div class="logo">
            <img src="<?php echo URLADM; ?>app/adms/assets/image/logo/logo.png" width="200px" alt="Docnet">
        </div>
        
        
        <div class="title">
            <h5 class="help_desk">Help Desk</h5>
        </div>

        <div class="msg-alert">
            <?php
            if (isset($_SESSION['msg'])) {
                echo "<span id='msg'> " . $_SESSION['msg'] . "</span>";
                unset($_SESSION['msg']);
            } else {
                echo "<span id='msg'></span>";
            }
            ?>

        </div>

        <form method="POST" action="" id="form-login" class="form-login">
            <?php
            $user = "";
            if (isset($valorForm['user'])) {
                $user = $valorForm['user'];
            }
            ?>
            <div class="row">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="user" id="user" placeholder="Digite o usuário" value="<?php echo $user; ?>" required>
            </div>

            <?php
            $password = "";
            if (isset($valorForm['password'])) {
                $password = $valorForm['password'];
            }
            ?>
            <div class="row">
                <i class="fa-solid fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Digite a senha" autocomplete="on" value="<?php echo $password; ?>" required>
            </div>

            <div class="link-novo-login">
                <a href="https://www.repbrasil.salvador.br/contato" target="_blank">Esqueci minha senha</a>
            </div>

            <div class="row button">
                <button type="submit" name="SendLogin" value="Acessar">Acessar</button>
            </div>
        </form>
    </div>

</div>