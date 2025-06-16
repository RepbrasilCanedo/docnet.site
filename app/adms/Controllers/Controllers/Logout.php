<?php

namespace App\adms\Controllers;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller sair do administrativo.
 * @author Daniel Canedo - docan2006@gmail.com
 */
class Logout
{

    /**
     * Método sair do administrativo.
     * Destruir as sessões do usuário logado
     * 
     * @return void
     */
    public function index(): void
    {
        unset($_SESSION['user_id'], $_SESSION['user_name'], $_SESSION['user_nickname'], $_SESSION['user_email'], $_SESSION['user_image'], $_SESSION['emp_user'], $_SESSION['set_Contr'], $_SESSION['adms_access_level_id']);
        $_SESSION['msg'] = "<p class='alert-success'>Logout realizado com sucesso!</p>";
        
        $urlRedirect = URLADM . "login/index";
        header("Location: $urlRedirect");
    }
}