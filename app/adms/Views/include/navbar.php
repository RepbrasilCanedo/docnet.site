<!-- Inicio Navbar -->
<nav class="navbar">
    <div class="navbar-content">
        <div class="bars">
            <i class="fa-solid fa-bars"></i>
        </div>
        <img src="<?php echo URLADM; ?>app/adms/assets/image/logo/docnet_h_255.png" alt="Docnet" class="logo">
    </div>

    <div class="navbar-content">
        <div class="top-list-right">
                <?php echo "<a href='" . URLADM . "add-cham/index' class='btn-success'>Abrir Tiket</a>";?>
                <?php echo "<a href='" . URLADM . "add-cham-agend/index' class='btn-warning'>Agendar Tiket</a>";?>
                <?php echo "<a href='https://www.youtube.com/@repbrasil/videos'class='btn-primary'>Ajuda</a>";?>
        </div>
        <div class="p-3"><?php if (!empty($_SESSION['user_nickname'])){echo $_SESSION['user_nickname'];}else{echo 'Apelido';} ?></div>

        <div class="avatar">
            <?php
            if ((!empty($_SESSION['user_image'])) and (file_exists("app/adms/assets/image/users/" . $_SESSION['user_id'] . "/" . $_SESSION['user_image']))) {
                echo "<img src='" . URLADM . "app/adms/assets/image/users/" . $_SESSION['user_id'] . "/" . $_SESSION['user_image'] . "' width='40' height='40'>";
            } else {
                echo "<img src='" . URLADM . "app/adms/assets/image/users/icon_user.png' width='40' height='40'>";
            }
            ?>
            <div class="dropdown-menu setting">
                <a href="<?php echo URLADM; ?>view-profile/index" class="item">
                    <span class="fa-solid fa-user"></span> Perfil
                </a>
                <a href="<?php echo URLADM; ?>edit-profile/index" class="item">
                    <span class="fa-solid fa-gear"></span> Configuração
                </a>
                <a href="https://www.youtube.com/@repbrasil/videos" class="item">
                    <span class="fa-solid fa-handshake-angle"></span> Ajuda 
                </a>
                <a href="<?php echo URLADM; ?>logout/index" class="item">
                    <span class="fa-solid fa-arrow-right-from-bracket"></span> Sair
                </a>
            </div>
        </div>
    </div>
</nav>
<!-- Fim Navbar -->