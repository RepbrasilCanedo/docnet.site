<?php

namespace App\adms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller aprovação dos chamados pelo usuario
 * @author Daniel Canedo - docan2006@gmail.com
 */
class EditAprovOrcam
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Método editar orcamento.
     * Receber os dados do formulário.
     * 
     * Se o parâmetro ID e diferente de vazio e o usuário não clicou no botão editar, instancia a MODELS para recuperar as informações da cor no banco de dados, se encontrar instancia o método "viewEditColor". Se não existir redireciona para o listar cor.
     * 
     * Se não existir o usuário clicar no botão acessa o ELSE e instancia o método "editColor".
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        

        if ((!empty($id)) and (empty($this->dataForm['SendAprovOrcam'])) and (empty($this->dataForm['SendReprOrcam']))) {
            $this->id = (int) $id;
            $viewAprovOrcam = new \App\adms\Models\AdmsAprovOrcam();
            $viewAprovOrcam->viewAprovOrcam($this->id);
            
            if ($viewAprovOrcam->getResult()) {
                $this->data['form'] = $viewAprovOrcam->getResultBd();
                $this->viewAprovOrcam();
            } else {
                $urlRedirect = URLADM . "list-orcam/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editAprovOrcam();
        }
    }

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAprovOrcam(): void
    {
        $button = ['list_orcam' => ['menu_controller' => 'list-orcam', 'menu_metodo' => 'index']];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "edit-aprov-orcam";
        $loadView = new \Core\ConfigView("adms/Views/orcamentos/editAprovOrcam", $this->data);
        $loadView->loadView();
    }

    /**
     * Editar cor.
     * Se o usuário clicou no botão, instancia a MODELS responsável em receber os dados e editar no banco de dados.
     * Verifica se editou corretamente a cor no banco de dados.
     * Se o usuário não clicou no botão redireciona para página listar cor.
     *
     * @return void
     */
    private function editAprovOrcam(): void
    {
        if (!empty($this->dataForm['SendAprovOrcam']) and (empty($this->dataForm['SendReprOrcam']))) {
            unset($this->dataForm['SendAprovOrcam']);

            $editAprovOrcam = new \App\adms\Models\AdmsAprovOrcam();
            $editAprovOrcam->update($this->dataForm);

            if ($editAprovOrcam->getResult()) {
                $urlRedirect = URLADM . "list-orcam/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAprovOrcam();
            }
        } elseif (empty($this->dataForm['SendAprovOrcam']) and (!empty($this->dataForm['SendReprOrcam']))) {
            unset($this->dataForm['SendReprOrcam']);
            
            $SendReprOrcam = new \App\adms\Models\AdmsAprovOrcam();
            $SendReprOrcam->updateReprov($this->dataForm);

            if ($SendReprOrcam->getResult()) {
                $urlRedirect = URLADM . "list-orcam/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAprovOrcam();
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Orçamento não avaliado!</p>";
            $urlRedirect = URLADM . "list-orcam/index";
            header("Location: $urlRedirect");
        }
    }
}
