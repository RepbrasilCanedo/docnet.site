<?php

namespace App\adms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller cadastrar Cahamdos
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AddCham
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**
     * Método cadastrar chamados
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
        if (!empty($this->dataForm['SendAddCham'])) {
            unset($this->dataForm['SendAddCham']);   
                    
                $createCham = new \App\adms\Models\AdmsAddCham();
                $createCham->create($this->dataForm);

                if ($createCham->getResult()) {                    
                    $urlRedirect = URLADM . "list-cham/index";
                    header("Location: $urlRedirect");
                } else {
                    $this->data['form'] = $this->dataForm;
                    $this->viewAddCham();
                }
        } else {
            $this->viewAddCham();
        }
    }

    /**
     * Instanciar a MODELS e o método "listSelect" responsável em buscar os dados para preencher o campo SELECT 
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddCham(): void
    {
        $button = ['list_cham' => ['menu_controller' => 'list-cham', 'menu_metodo' => 'index']];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listSelect = new \App\adms\Models\AdmsAddCham();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "add-cham";

        $loadView = new \Core\ConfigView("adms/Views/chamados/addCham", $this->data);
        $loadView->loadView();
    }
}