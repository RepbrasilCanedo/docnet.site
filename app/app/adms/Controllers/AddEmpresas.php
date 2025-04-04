<?php

namespace App\adms\Controllers;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller cadastrar Empresas
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AddEmpresas
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**
     * Método cadastrar empresas
     * Receber os dados do formulário.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página cadastrar empresa. Acessa o IF e instância a classe 
     * "AdmsAddEmpresas" responsável em cadastrar a empresa no banco de dados.
     * Empresa cadastrada com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);   

        if(!empty($this->dataForm['SendAddEmpresas'])){
            unset($this->dataForm['SendAddEmpresas']);
            $createEmpresas = new \App\adms\Models\AdmsAddEmpresas();
            $createEmpresas->create($this->dataForm);
            if($createEmpresas->getResult()){
                $urlRedirect = URLADM . "list-empresas/index";
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewAddEmpresas();
            }   
        }else{
            $this->viewAddEmpresas();
        }  
    }

    /**
     * Instanciar a MODELS e o método "listSelect" responsável em buscar os dados para preencher o campo SELECT 
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddEmpresas(): void
    {
        $button = ['list_empresas' => ['menu_controller' => 'list-empresas', 'menu_metodo' => 'index']];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listSelect = new \App\adms\Models\AdmsAddEmpresas();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu(); 

        $this->data['sidebarActive'] = "list-empresas"; 
        
        $loadView = new \Core\ConfigView("adms/Views/empresas/addEmpresas", $this->data);
        $loadView->loadView();
    }
}
