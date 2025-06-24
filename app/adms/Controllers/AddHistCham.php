<?php

namespace App\adms\Controllers;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller cadastrar históricos para o chamado
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AddHistCham
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**
     * Método cadastrar usuário
     * Receber os dados do formulário.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página novo usuário. Acessa o IF e instância a classe "AdmsAddUsers" responsável em cadastrar o usuário no banco de dados.
     * Usuário cadastrado com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);        
        
        if(!empty($this->dataForm['SendAddHistCham'])){            
            unset($this->dataForm['SendAddHistCham']);
            $createHistCham= new \App\adms\Models\AdmsAddHistCham();
            $createHistCham->create($this->dataForm);

            if($createHistCham->getResult()){
                $urlRedirect = URLADM . "edit-cham/index/" . $_SESSION['set_cham'];
                header("Location: $urlRedirect");
            }else{
                $this->data['form'] = $this->dataForm;
                $this->viewAddHistCham();
            }   
        }else{
            $this->viewAddHistCham();
        }  
    }

    /**
     * Instanciar a MODELS e o método "listSelect" responsável em buscar os dados para preencher o campo SELECT 
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddHistCham(): void
    {
        $button = ['edit_cham' => ['menu_controller' => 'edit-cham', 'menu_metodo' => 'index']];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu(); 

        $this->data['sidebarActive'] = "edit-cham"; 
        
        $loadView = new \Core\ConfigView("adms/Views/chamados/addHistCham", $this->data);
        $loadView->loadView();
    }
}
