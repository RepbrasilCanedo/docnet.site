<?php

namespace App\adms\Controllers;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar cor
 * @author Daniel Canedo - docan2006@gmail.com
 */
class ViewContato
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Metodo visualizar cor
     * Recebe como parametro o ID que será usado para pesquisar as informações no banco de dados e instancia a MODELS AdmsviewContato
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senão é redirecionado para o listar mensagens.
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        if (!empty($id)) {
            $this->id = (int) $id;

            $viewContato = new \App\adms\Models\AdmsViewContato();
            $viewContato->viewContato($this->id);
            if ($viewContato->getResult()) {
                $this->data['viewContato'] = $viewContato->getResultBd();
                $this->viewContato();
            } else {
                $urlRedirect = URLADM . "list-contato/index";
                header("Location: $urlRedirect");
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Mensagem não encontrada!</p>";
            $urlRedirect = URLADM . "list-contato/index";
            header("Location: $urlRedirect");
        }
    }

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewContato(): void
    {
        $button = ['list_contato' => ['menu_controller' => 'list-contato', 'menu_metodo' => 'index'],
        'edit_contato' => ['menu_controller' => 'edit-contato', 'menu_metodo' => 'index'],
        'delete_contato' => ['menu_controller' => 'delete-contato', 'menu_metodo' => 'index']];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);
        
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu(); 
        
        $this->data['sidebarActive'] = "list-contato"; 
        $loadView = new \Core\ConfigView("adms/Views/contato/viewContato", $this->data);
        $loadView->loadView();
    }
}
