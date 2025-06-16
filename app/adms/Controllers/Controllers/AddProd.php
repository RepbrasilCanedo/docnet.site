<?php

namespace App\adms\Controllers;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller cadastrar Produtos
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AddProd
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**
     * Método cadastrar produtos
     * Receber os dados do formulário.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página cadastrar produtos. Acessa o IF e instância a classe "AdmsAddEquip" responsável em cadastrar a página no banco de dados.
     * Produtos cadastrado com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);        

        if(!empty($this->dataForm['SendAddProd'])){
            //var_dump($this->dataForm);
            unset($this->dataForm['SendAddProd']);
            $createProd = new \App\adms\Models\AdmsAddProd();
            $createProd->create($this->dataForm);
            
            if($createProd->getResult()){
                $urlRedirect = URLADM . "list-prod/index";
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewAddProd();
            }   
        }else{
            $this->viewAddProd();
        }  
    }

    /**
     * Instanciar a MODELS e o método "listSelect" responsável em buscar os dados para preencher o campo SELECT 
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddProd(): void
    {
        $button = ['list_prod' => ['menu_controller' => 'list-prod', 'menu_metodo' => 'index']];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listSelect = new \App\adms\Models\AdmsAddProd();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu(); 

        $this->data['sidebarActive'] = "list-prod"; 
        
        $loadView = new \Core\ConfigView("adms/Views/produtos/addProd", $this->data);
        $loadView->loadView();
    }
}
