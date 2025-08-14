<?php

namespace App\adms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller cadastrar Orçamentos
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AddOrcam
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**
     * Método cadastrar orçamentos
     * Receber os dados do formulário.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página cadastrar orcamentos. Acessa o IF e instância a classe "AdmsAddCham" responsável em cadastrar a página no banco de dados.
     * Chamdos cadastrado com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($this->dataForm['SendAddOrcam'])) {
            unset($this->dataForm['SendAddOrcam']);   
                $createOrcam = new \App\adms\Models\AdmsAddOrcam();
                $createOrcam->create($this->dataForm);

                if ($createOrcam->getResult()) {                    
                    $urlRedirect = URLADM . "list-orcam/index";
                    header("Location: $urlRedirect");
                } else {
                    $this->data['form'] = $this->dataForm;
                    $this->viewAddOrcam();
                }
        } else {
            $this->viewAddOrcam();
        }
    }

    /**
     * Instanciar a MODELS e o método "listSelect" responsável em buscar os dados para preencher o campo SELECT 
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddOrcam(): void
    {
        $button = ['list_orcam' => ['menu_controller' => 'list-orcam', 'menu_metodo' => 'index']];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listSelect = new \App\adms\Models\AdmsAddCham();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "add-orcam";

        $loadView = new \Core\ConfigView("adms/Views/orcamentos/addOrcam", $this->data);
        $loadView->loadView();
    }
}