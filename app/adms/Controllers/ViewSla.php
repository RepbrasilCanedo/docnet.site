<?php

namespace App\adms\Controllers;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar sla
 * @author Daniel Canedo - docan2006@gmail.com
 */
class ViewSla
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Metodo visualizar sla
     * Recebe como parametro o ID que será usado para pesquisar as informações no banco de dados e instancia a MODELS AdmsViewColors
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senão é redirecionado para o listar slaes.
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        if (!empty($id)) {
            $this->id = (int) $id;

            $viewSla = new \App\adms\Models\AdmsViewSla();
            $viewSla->viewSla($this->id);
            if ($viewSla->getResult()) {
                $this->data['viewSla'] = $viewSla->getResultBd();
                $this->viewSla();
            } else {
                $urlRedirect = URLADM . "list-sla/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: sla não encontrada!</p>";
            $urlRedirect = URLADM . "list-sla/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewSla(): void
    {
        $button = ['list_sla' => ['menu_controller' => 'list-sla', 'menu_metodo' => 'index'],
        'edit_sla' => ['menu_controller' => 'edit-sla', 'menu_metodo' => 'index'],
        'delete_sla' => ['menu_controller' => 'delete-sla', 'menu_metodo' => 'index']];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu(); 
        
        $this->data['sidebarActive'] = "list-sla"; 
        $loadView = new \Core\ConfigView("adms/Views/sla/viewSla", $this->data);
        $loadView->loadView();
    }
}
