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
        <div class="content-adm-alert">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <span id="msg"></span>
        </div>

        <div class="logo">
            <img src="<?php echo URLADM; ?>app/adms/assets/image/logo/logo.png" width="200px" alt="Docnet">
        </div>
        <div class="title-senha">
            <h5>Cadastre seu e-mail e WhatsApp e aguarde o contato para envio de uma nova senha</h5>
        </div>

        <form method="POST" action="" id="form-new-user" class="form-login">
           
            <div class="row">
                <i class="fa-solid fa-user"></i>
                <input type="text" name="email" id="email" placeholder="Usuario Cadastrado no Sistema" required>
            </div>

            
            <div class="row">
                <i class="fa-solid fa-phone"></i>
                <input type="tel" name="tel" id="tel" placeholder="Digite Tel/WhatsApp de Contato"required>
            </div>

            <span id="msgViewStrength"></span>

            <div class="row button">
                <button type="submit" name="SendNewUser" value="Cadastrar">Solicitar</button>
            </div>

            <div class="signup-link">
                <a href="<?php echo URLADM; ?>">Clique aqui</a> para acessar
            </div>

        </form>
        
    </div>
</div>