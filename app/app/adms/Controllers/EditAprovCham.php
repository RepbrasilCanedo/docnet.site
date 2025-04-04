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
class EditAprovCham
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data = [];

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * Método editar Chamado.
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
        

        if ((!empty($id)) and (empty($this->dataForm['SendAprovCham']) and (empty($this->dataForm['SendReprCham'])))) {
            $this->id = (int) $id;
            $viewAprovCham = new \App\adms\Models\AdmsAprovCham();
            $viewAprovCham->viewAprovCham($this->id);
            
            if ($viewAprovCham->getResult()) {
                $this->data['form'] = $viewAprovCham->getResultBd();
                $this->viewAprovCham();
            } else {
                $urlRedirect = URLADM . "dashboard/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editAprovCham();
        }
    }

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewAprovCham(): void
    {
        $button = ['dashboard' => ['menu_controller' => 'dashboard', 'menu_metodo' => 'index']];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "edit-aprov-cham";
        $loadView = new \Core\ConfigView("adms/Views/chamados/editAprovCham", $this->data);
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
    private function editAprovCham(): void
    {
        if (!empty($this->dataForm['SendAprovCham']) and (empty($this->dataForm['SendReprCham']))) {
            unset($this->dataForm['SendAprovCham']);
            $editAprovCham = new \App\adms\Models\AdmsAprovCham();
            $editAprovCham->update($this->dataForm);
            if ($editAprovCham->getResult()) {
                $urlRedirect = URLADM . "dashboard/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAprovCham();
            }
        } elseif (empty($this->dataForm['SendAprovCham']) and (!empty($this->dataForm['SendReprCham']))){
            unset($this->dataForm['SendReprCham']);

            $SendReprCham = new \App\adms\Models\AdmsAprovCham();
            $SendReprCham->updateReprov($this->dataForm);

            if ($SendReprCham->getResult()) {
                $urlRedirect = URLADM . "dashboard/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewAprovCham();
            }
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado não encontrado!</p>";
            $urlRedirect = URLADM . "dashboard/index";
            header("Location: $urlRedirect");
        }
    }
}
