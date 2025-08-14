<?php

namespace App\adms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller editar Orcamento
 * @author Daniel Canedo - docan2006@gmail.com
 */
class EditOrcam
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $estagio;

    /**
     * Método editar Orcamento.
     * Receber os dados do formulário.
     * 
     * Se o parâmetro ID e diferente de vazio e o usuário não clicou no botão editar, instancia a MODELS para recuperar as informações da cor no banco de dados, se encontrar instancia o método "viewEditOrcam". Se não existir redireciona para o listar cor.
     * 
     * Se não existir o usuário clicar no botão acessa o ELSE e instancia o método "editCham".
     * 
     * @return void
     */

    public function index(int|string|null $id = null): void

    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        

        // carregar pagina inicial do atendimento do orcamento "Iniciar Atendimento"
       if ((!empty($id)) and (empty($this->dataForm['SendInicCham']))) {
            $this->id = (int) $id;
            $viewOrcam = new \App\adms\Models\AdmsEditOrcam();
            $viewOrcam->viewOrcam($this->id);

            if ($viewOrcam->getResult()) {
              $this->data['form'] = $viewOrcam->getResultBd();
                $this->viewEditOrcam();
            } else {
                $urlRedirect = URLADM . "list-orcam/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editOrcam();
        }
        
    }

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditOrcam(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {
            $button = [
                'list_orcam' => ['menu_controller' => 'list-orcam', 'menu_metodo' => 'index'],
                'view_orcam' => ['menu_controller' => 'view-orcam', 'menu_metodo' => 'index']
            ];
            $listBotton = new \App\adms\Models\helper\AdmsButton();
            $this->data['button'] = $listBotton->buttonPermission($button);
        } else {
            $button = [
                'list_orcam' => ['menu_controller' => 'list-orcam', 'menu_metodo' => 'index'],
                'view_orcam' => ['menu_controller' => 'view-orcam', 'menu_metodo' => 'index'],
                'edit_orcam' => ['menu_controller' => 'edit-orcam', 'menu_metodo' => 'index']
            ];
            $listBotton = new \App\adms\Models\helper\AdmsButton();
            $this->data['button'] = $listBotton->buttonPermission($button);
        }

        $listTable = new \App\adms\Models\AdmsEditOrcam();
        $this->data['list_table'] = $listTable->listTable();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "list-orcam";
        $loadView = new \Core\ConfigView("adms/Views/orcamentos/editOrcam", $this->data);
        $loadView->loadView();
    }

    /**
     * Editar Orcamento.
     * Se o usuário clicou no botão, instancia a MODELS responsável em receber os dados e editar no banco de dados.
     * Verifica se editou corretamente a cor no banco de dados.
     * Se o usuário não clicou no botão redireciona para página listar Orcamento.
     *
     * @return void
     */
    private function editOrcam(): void
    {
        //xxxxxxxxxxxxxxxxx Inicializa o orcamento
        if (!empty($this->dataForm['SendInicCham'])) {
            unset($this->dataForm['SendInicCham']);

                $editCham = new \App\adms\Models\AdmsEditOrcam();
                $editCham->update($this->dataForm);

                if ($editCham->getResult()) {
                    $urlRedirect = URLADM . "list-orcam/index/" . $this->dataForm['id'];
                    header("Location: $urlRedirect");
                } else {
                    $this->data['form'] = $this->dataForm;
                    $this->viewEditOrcam();
                }

        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Orcamento não encontrado!</p>";
            $urlRedirect = URLADM . "list-orcam/index";
            header("Location: $urlRedirect");
        }
    }
}
