<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

$sidebar_active = "";
if (isset($this->data['sidebarActive'])) {
    $sidebar_active = $this->data['sidebarActive'];
}
//var_dump($this->data);
/*if(isset($this->data['logoContrato'])){
    $_SESSION['img_contr']='';
    $_SESSION['img_contr']= $this->data['logoContrato'][0]['logo_clie'];
}*/


?>

<!-- Inicio Conteudo -->
<div class="content">
    
    <!-- Inicio da Sidebar -->
    <div class="sidebar">
        
    <div class="logo-adm">
        <?php /*
        if(!empty ($_SESSION['set_clie'])){
            echo "<img src='" . URLADM . "app/adms/assets/image/logo/clientes/". $_SESSION['set_clie']."/logo.png ' width='140' alt='Logo do Cliente'>";
        } else{
            echo "<img src='" . URLADM . "app/adms/assets/image/logo/clientes/icon_user.png' width='140' alt='Logo do Cliente'>";
        }      
        */
        ?>     
    </div>

        <?php

        if ((isset($this->data['menu'])) and ($this->data['menu'])) {
            $count_drop_start = 0;
            $count_drop_end = 0;
            foreach ($this->data['menu'] as $item_menu) {
                extract($item_menu);
                $active_item_menu = "";
                if ($sidebar_active == $menu_controller) {
                    $active_item_menu = "active";
                }

                if ($dropdown == 1) {
                    if ($count_drop_start != $id_itm_men) {
                        if (($count_drop_end == 1) and ($count_drop_start != 0)) {
                            echo "</div>";
                            $count_drop_end = 0;
                        }
                        echo "<button class='dropdown-btn btn-active$id_itm_men'>";
                        echo "<i class='icon $icon_itm_men'></i><span>$name_itm_men</span><i class='fa-solid fa-caret-down'></i>";
                        echo "</button>";

                        echo "<div class='dropdown-container cont-active$id_itm_men'>";
                    }

                    echo "<a href='" . URLADM . "$menu_controller/$menu_metodo' class='sidebar-nav active$id_itm_men $active_item_menu'><i class='icon $icon'></i><span></span>$name_page</a>";

                    $count_drop_start = $id_itm_men;
                    $count_drop_end = 1;
                } else {
                    if ($count_drop_end == 1) {
                        echo "</div>";
                        $count_drop_end = 0;
                    }
                    echo "<a href='" . URLADM . "$menu_controller/$menu_metodo' class='sidebar-nav $active_item_menu'><i class='icon $icon'></i><span></span>$name_page</a>";
                }
            }
            if ($count_drop_end == 1) {
                echo "</div>";
                $count_drop_end = 0;
            }
        }
        ?>
    </div>
    <!-- Fim da Sidebar -->
    <?php //var_dump($this->data['menu']); ?>