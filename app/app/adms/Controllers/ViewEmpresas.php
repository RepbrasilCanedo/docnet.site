<?php

namespace App\adms\Controllers;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar detalhes da empresa
 * @author Daniel Canedo - docan2006@gmail.com
 */
class ViewEmpresas
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Metodo visualizar detalhe da empresa
     * Recebe como parametro o ID que será usado para pesquisar as informações no banco de dados e instancia a MODELS AdmsViewEmpresas
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senão é redirecionado para o listar empresas
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        if (!empty($id)) {
            $this->id = (int) $id;

            $viewEmpresas = new \App\adms\Models\AdmsViewEmpresas();
            $viewEmpresas->viewEmpresas($this->id);
            if ($viewEmpresas->getResult()) {
                $this->data['viewEmpresas'] = $viewEmpresas->getResultBd();
                $this->viewEmpresas();
            } else {
                $urlRedirect = URLADM . "list-empresas/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Empresa não encontrada!</p>";
            $urlRedirect = URLADM . "list-empresas/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEmpresas(): void
    {
        $button = ['list_empresas' => ['menu_controller' => 'list-empresas', 'menu_metodo' => 'index'],
        //'view_empresas' => ['menu_controller' => 'view-empresas', 'menu_metodo' => 'index'],
        'edit_empresas' => ['menu_controller' => 'edit-empresas', 'menu_metodo' => 'index'],
        'delete_empresas' => ['menu_controller' => 'delete-empresas', 'menu_metodo' => 'index']];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu(); 
        
        $this->data['sidebarActive'] = "view-empresas";
        $loadView = new \Core\ConfigView("adms/Views/empresas/viewEmpresas", $this->data);
        $loadView->loadView();
    }
}
