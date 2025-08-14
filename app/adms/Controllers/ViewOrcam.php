<?php

namespace App\adms\Controllers;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar o chamado selecionado
 * @author Daniel Canedo - docan2006@gmail.com
 */
class ViewOrcam
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

        /** @var array $dataForm Recebe os dados do formulario */
        private array|null $dataForm;

    /**
     * Metodo visualizar chamdo
     * Recebe como parametro o ID que será usado para pesquisar as informações no banco de dados e instancia a MODELS AdmsViewCham
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senão é redirecionado para o listar chamado.
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //$this->id = (int) $id;
        

                 if (!empty($id)) {
                        $this->id = (int) $id;
                        $viewOrcam = new \App\adms\Models\AdmsViewOrcam();
                        $viewOrcam->viewOrcam($this->id);

                        if ($viewOrcam->getResult()) {
                            $this->data['viewOrcam'] = $viewOrcam->getResultBd();
                            $this->viewOrcam();
                        } else {
                            $urlRedirect = URLADM . "list-orcam/index";
                            header("Location: $urlRedirect");
                        }
                    
                    } else {
                        $_SESSION['msg'] = "<p class='alert-danger'>Erro: Orçamento não encontrado!</p>";
                        $urlRedirect = URLADM . "list-orcam/index";
                        header("Location: $urlRedirect");
                    }
                    
    }

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewOrcam(): void
    {    

        if ($_SESSION['adms_access_level_id'] > 2) {
            $button = ['list_orcam' => ['menu_controller' => 'list-orcam', 'menu_metodo' => 'index'],
                'view_profile_orcam' => ['menu_controller' => 'view-profile-orcam', 'menu_metodo' => 'index']
            ];
            $listBotton = new \App\adms\Models\helper\AdmsButton();
            $this->data['button'] = $listBotton->buttonPermission($button);
        } else {
            $button = ['list_orcam' => ['menu_controller' => 'list-orcam', 'menu_metodo' => 'index'],
                'add_hist_orcam' => ['menu_controller' => 'add-hist-orcam', 'menu_metodo' => 'index'],
                'view_profile_orcam' => ['menu_controller' => 'view-profile-orcam', 'menu_metodo' => 'index']
            ];
            $listBotton = new \App\adms\Models\helper\AdmsButton();
            $this->data['button'] = $listBotton->buttonPermission($button);
        }
        /*
        $listTable = new \App\adms\Models\AdmsViewOrcam();
        $this->data['list_table'] = $listTable->listTable();
        */
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu(); 
        
        $this->data['sidebarActive'] = "list-orcam"; 
        $loadView = new \Core\ConfigView("adms/Views/orcamentos/viewOrcam", $this->data);
        $loadView->loadView();
    }
}