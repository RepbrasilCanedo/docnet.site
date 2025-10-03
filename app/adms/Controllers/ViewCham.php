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
class ViewCham
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
        $this->id = (int) $id;

                if (!empty($this->dataForm['SendReagCham'])) {
                    unset($this->dataForm['SendReagCham']);  
                    $editCham = new \App\adms\Models\AdmsViewCham();
                    $editCham->editReag($this->dataForm, $this->id);
                } else {
                    if (!empty($id)) {
                        $this->id = (int) $id;
                        $viewCham = new \App\adms\Models\AdmsViewCham();
                        $viewCham->viewCham($this->id);

                        if ($viewCham->getResult()) {
                            $this->data['viewCham'] = $viewCham->getResultBd();
                            $this->viewCham();
                        } else {
                            $urlRedirect = URLADM . "list-cham/index";
                            header("Location: $urlRedirect");
                        }
                    
                    } else {
                        $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado não encontrado!</p>";
                        $urlRedirect = URLADM . "list-cham/index";
                        header("Location: $urlRedirect");
                    }
                }
    }

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewCham(): void
    {    

        if ($_SESSION['adms_access_level_id'] > 2) {
            $button = [
                'list_cham' => ['menu_controller' => 'list-cham', 'menu_metodo' => 'index'],
                'view_profile_cham' => ['menu_controller' => 'view-profile-cham', 'menu_metodo' => 'index']
            ];
            $listBotton = new \App\adms\Models\helper\AdmsButton();
            $this->data['button'] = $listBotton->buttonPermission($button);
        } else {
            $button = [
                'list_cham' => ['menu_controller' => 'list-cham', 'menu_metodo' => 'index'],
                'add_hist_cham' => ['menu_controller' => 'add-hist-cham', 'menu_metodo' => 'index'],
                'view_profile_cham' => ['menu_controller' => 'view-profile-cham', 'menu_metodo' => 'index']
            ];
            $listBotton = new \App\adms\Models\helper\AdmsButton();
            $this->data['button'] = $listBotton->buttonPermission($button);
        }
        
        $listTable = new \App\adms\Models\AdmsViewCham();
        $this->data['list_table'] = $listTable->listTable();

        $listSelect = new \App\adms\Models\AdmsViewCham();
        $this->data['select'] = $listSelect->listSelect();
        
        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu(); 
        
        $this->data['sidebarActive'] = "list-cham"; 
        $loadView = new \Core\ConfigView("adms/Views/chamados/viewCham", $this->data);
        $loadView->loadView();
    }
}