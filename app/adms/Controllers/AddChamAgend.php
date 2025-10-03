<?php

namespace App\adms\Controllers;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller cadastrar Cahamdos
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AddChamAgend
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**
     * Método cadastrar chamdos
     * Receber os dados do formulário.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página cadastrar chamados. Acessa o IF e instância a classe "AdmsAddCham" responsável em cadastrar a página no banco de dados.
     * Chamdos cadastrado com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);  


        if(!empty($this->dataForm['empresa_id'])){
            $_SESSION['empresa_contr']=$this->dataForm['empresa_id'];
        }
        
        if(!empty($this->dataForm['SendAddChamAgend'])){
            //var_dump($this->dataForm);
            unset($this->dataForm['SendAddChamAgend']);
            $createChamAgend = new \App\adms\Models\AdmsAddChamAgend();
            $createChamAgend->create($this->dataForm);
            
            if($createChamAgend->getResult()){
                $urlRedirect = URLADM . "list-cham/index";
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewAddChamAgend();
            }   
        }else{
            $this->viewAddChamAgend();
        }  
    }

    /**
     * Instanciar a MODELS e o método "listSelect" responsável em buscar os dados para preencher o campo SELECT 
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddChamAgend(): void
    {
        $button = ['list_cham' => ['menu_controller' => 'list-cham', 'menu_metodo' => 'index']];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listSelect = new \App\adms\Models\AdmsAddChamAgend();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu(); 

        $this->data['sidebarActive'] = "add-cham-agend"; 
        
        $loadView = new \Core\ConfigView("adms/Views/chamados/addChamAgend", $this->data);
        $loadView->loadView();
    }
}
