<?php

namespace App\adms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller cadastrar sla
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AddSla
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**     
     * Método cadastrar cor
     * Receber os dados do formulário.
     * Quando o usuário clicar no botão "cadastrar" do formulário da página nova cor. Acessa o IF e instância a classe "AdmsAddColores" responsável em cadastrar a situação no banco de dados.
     * Situação cadastrada com sucesso, redireciona para a página listar registros.
     * Senão, instância a classe responsável em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($this->dataForm['SendAddSla'])) {
            unset($this->dataForm['SendAddSla']);

            $createSla = new \App\adms\Models\AdmsAddSla();
            $createSla->create($this->dataForm);
            
            if ($createSla->getResult()) {
                $urlRedirect = URLADM . "list-sla/index";
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAddSla();
            }
        } else {
            $this->viewAddSla();
        }
    }

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAddSla(): void
    {
        $button = ['list_sla' => ['menu_controller' => 'list-sla', 'menu_metodo' => 'index']];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listSelect = new \App\adms\Models\AdmsEditSla();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu(); 
        
        $this->data['sidebarActive'] = "add-sla"; 
        
        $loadView = new \Core\ConfigView("adms/Views/sla/addSla", $this->data);
        $loadView->loadView();
    }
}
