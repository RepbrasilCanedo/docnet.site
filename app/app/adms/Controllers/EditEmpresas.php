<?php

namespace App\adms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller editar empresas
 * @author Daniel Canedo - docan2006@gmail.com
 */
class EditEmpresas
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Método editar empresas.
     * Receber os dados do formulário.
     * 
     * Se o parâmetro ID e diferente de vazio e o usuário não clicou no botão editar, instancia a MODELS para recuperar as informações da empresa no banco de dados, 
     * se encontrar instancia o método "viewEditEmpresas". Se não existir redireciona para o listar empresas.
     * 
     * Se não existir a empresa clicar no botão acessa o ELSE e instancia o método "editEmpresas".
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if ((!empty($id)) and (empty($this->dataForm['SendEditEmpresas']))) {
            $this->id = (int) $id;
            $viewEmpresas = new \App\adms\Models\AdmsEditEmpresas();
            $viewEmpresas->viewEmpresas($this->id);
            if ($viewEmpresas->getResult()) {
                $this->data['form'] = $viewEmpresas->getResultBd();
                $this->viewEditEmpresas();
            } else {
                $urlRedirect = URLADM . "list-empresas/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editEmpresas();
        }
    }

    /**
     * Instanciar a MODELS e o método "listSelect" responsável em buscar os dados para preencher o campo SELECT 
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditEmpresas(): void
    {
        $button = ['list_empresas' => ['menu_controller' => 'list-empresas', 'menu_metodo' => 'index'],
        'view_empresas' => ['menu_controller' => 'view-empresas', 'menu_metodo' => 'index']];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listSelect = new \App\adms\Models\AdmsEditEmpresas();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu(); 

        $this->data['sidebarActive'] = "list-empresas";
        $loadView = new \Core\ConfigView("adms/Views/empresas/editEmpresas", $this->data);
        $loadView->loadView();
    }

    /**
     * Editar página.
     * Se o usuário clicou no botão, instancia a MODELS responsável em receber os dados e editar no banco de dados.
     * Verifica se editou corretamente a página no banco de dados.
     * Se o usuário não clicou no botão redireciona para página listar página.
     *
     * @return void
     */
    private function editEmpresas(): void
    {
        if (!empty($this->dataForm['SendEditEmpresas'])) {
            unset($this->dataForm['SendEditEmpresas']);
            $editEmpresas = new \App\adms\Models\AdmsEditEmpresas();
            $editEmpresas->update($this->dataForm);
            if ($editEmpresas->getResult()) {
                $urlRedirect = URLADM . "view-empresas/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditEmpresas();
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Empresa não encontrada!</p>";
            $urlRedirect = URLADM . "list-empresas/index";
            header("Location: $urlRedirect");
        }
    }
}
