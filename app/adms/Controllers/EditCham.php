<?php

namespace App\adms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller editar Chamado
 * @author Daniel Canedo - docan2006@gmail.com
 */
class EditCham
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
     * Método editar Chamado.
     * Receber os dados do formulário.
     * 
     * Se o parâmetro ID e diferente de vazio e o usuário não clicou no botão editar, instancia a MODELS para recuperar as informações da cor no banco de dados, se encontrar instancia o método "viewEditCham". Se não existir redireciona para o listar cor.
     * 
     * Se não existir o usuário clicar no botão acessa o ELSE e instancia o método "editCham".
     * 
     * @return void
     */

    public function index(int|string|null $id = null): void

    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        // carregar pagina inicial do atendimento do chamado "Iniciar Atendimento"
        if ((!empty($id)) and (empty($this->dataForm['SendInicCham'])) and (empty($this->dataForm['SendReagCham'])) and (empty($this->dataForm['SendPausCham'])) and (empty($this->dataForm['SendPausCom'])) and (empty($this->dataForm['SendFinaCham'])) and (empty($this->dataForm['SendPendCham'])) and (empty($this->dataForm['SendAguarCham']))) {
            $this->id = (int) $id;
            $viewCham = new \App\adms\Models\AdmsEditCham();
            $viewCham->viewCham($this->id);

            if ($viewCham->getResult()) {
                $this->data['form'] = $viewCham->getResultBd();
                $this->viewEditCham();
            } else {
                $urlRedirect = URLADM . "list-cham/index";
                header("Location: $urlRedirect");
            }
        } else {
            $this->editCham();
        }
    }

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function viewEditCham(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {
            $button = [
                'list_cham' => ['menu_controller' => 'list-cham', 'menu_metodo' => 'index'],
                'view_cham' => ['menu_controller' => 'view-cham', 'menu_metodo' => 'index']
            ];
            $listBotton = new \App\adms\Models\helper\AdmsButton();
            $this->data['button'] = $listBotton->buttonPermission($button);
        } else {
            $button = [
                'list_cham' => ['menu_controller' => 'list-cham', 'menu_metodo' => 'index'],
                'view_cham' => ['menu_controller' => 'view-cham', 'menu_metodo' => 'index'],
                'edit_cham' => ['menu_controller' => 'edit-cham', 'menu_metodo' => 'index']
            ];
            $listBotton = new \App\adms\Models\helper\AdmsButton();
            $this->data['button'] = $listBotton->buttonPermission($button);
        }

        $listTable = new \App\adms\Models\AdmsEditCham();
        $this->data['list_table'] = $listTable->listTable();

        $listSelect = new \App\adms\Models\AdmsEditCham();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "list-cham";
        $loadView = new \Core\ConfigView("adms/Views/chamados/editCham", $this->data);
        $loadView->loadView();
    }

    /**
     * Editar Chamado.
     * Se o usuário clicou no botão, instancia a MODELS responsável em receber os dados e editar no banco de dados.
     * Verifica se editou corretamente a cor no banco de dados.
     * Se o usuário não clicou no botão redireciona para página listar Chamado.
     *
     * @return void
     */
    private function editCham(): void
    {


        if (!empty($this->dataForm['SendEditHist']) and (empty($this->dataForm['SendReagCham'])) and (empty($this->dataForm['SendInicCham'])) and (empty($this->dataForm['SendPausCham'])) and (empty($this->dataForm['SendPausCom'])) and (empty($this->dataForm['SendPendCham'])) and (empty($this->dataForm['SendAguarCham'])) and (empty($this->dataForm['SendFinaCham']))) {
            unset($this->dataForm['SendEditHist']);

            //Cadastra o Histórico Pausado
            $editHistCham = new \App\adms\Models\AdmsEditCham();
            $editHistCham->addHistChamHist();

            if ($editHistCham->getResult()) {

                $editCham = new \App\adms\Models\AdmsEditCham();
                $editCham->update($this->dataForm);

                if ($editCham->getResult()) {
                    $urlRedirect = URLADM . "edit-cham/index/" . $this->dataForm['id'];
                    header("Location: $urlRedirect");
                } else {
                    $this->data['form'] = $this->dataForm;
                    $this->viewEditCham();
                }
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Histórico não cadastrado!</p>";
                $this->data['form'] = $this->dataForm;
                $this->viewEditCham();
            }

        //xxxxxxxxxxxxxxxxx Reagendar o Ticket
        } elseif (empty($this->dataForm['SendEditHist']) and (!empty($this->dataForm['SendReagCham'])) and (empty($this->dataForm['SendInicCham'])) and (empty($this->dataForm['SendPausCham'])) and (empty($this->dataForm['SendPausCom'])) and (empty($this->dataForm['SendPendCham'])) and (empty($this->dataForm['SendAguarCham'])) and (empty($this->dataForm['SendFinaCham']))) {
            unset($this->dataForm['SendReagCham']);

            //Cadastra o Histórico do chamado Inicializado
            $editHistCham = new \App\adms\Models\AdmsEditCham();
            $editHistCham->addHistChamReag();

            if ($editHistCham->getResult()) {

                $editCham = new \App\adms\Models\AdmsEditCham();
                $editCham->updateReag($this->dataForm);

                if ($editCham->getResult()) {
                    $urlRedirect = URLADM . "edit-cham/index/" . $this->dataForm['id'];
                    header("Location: $urlRedirect");
                } else {
                    $this->data['form'] = $this->dataForm;
                    $this->viewEditCham();
                }
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Histórico não cadastrado!</p>";
                $this->data['form'] = $this->dataForm;
                $this->viewEditCham();
            }

        //xxxxxxxxxxxxxxxxx Inicializa o chamado
        } elseif (!empty($this->dataForm['SendInicCham']) and (empty($this->dataForm['SendReagCham'])) and  (empty($this->dataForm['SendPausCham'])) and (empty($this->dataForm['SendPausCom'])) and (empty($this->dataForm['SendPendCham'])) and (empty($this->dataForm['SendAguarCham'])) and (empty($this->dataForm['SendFinaCham']))) {
            unset($this->dataForm['SendInicCham']);

            //Cadastra o Histórico do chamado Inicializado
            $editHistCham = new \App\adms\Models\AdmsEditCham();
            $editHistCham->addHistChamInic();

            if ($editHistCham->getResult()) {
                $editCham = new \App\adms\Models\AdmsEditCham();
                $editCham->update($this->dataForm);

                if ($editCham->getResult()) {
                    $urlRedirect = URLADM . "edit-cham/index/" . $this->dataForm['id'];
                    header("Location: $urlRedirect");
                } else {
                    $this->data['form'] = $this->dataForm;
                    $this->viewEditCham();
                }
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Histórico não cadastrado!</p>";
                $this->data['form'] = $this->dataForm;
                $this->viewEditCham();
            }

        //xxxxxxxxxxxxxxxxxPausar o chamado
        } elseif (empty($this->dataForm['SendInicCham']) and (empty($this->dataForm['SendReagCham'])) and  (!empty($this->dataForm['SendPausCham'])) and (empty($this->dataForm['SendPausCom'])) and (empty($this->dataForm['SendPendCham'])) and (empty($this->dataForm['SendAguarCham'])) and (empty($this->dataForm['SendFinaCham']))) {
            unset($this->dataForm['SendPausCham']);

            $editCham = new \App\adms\Models\AdmsEditCham();
            $editCham->updatePausa($this->dataForm);

            if ($editCham->getResult()) {
                $urlRedirect = URLADM . "edit-cham/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditCham();
            }

        //xxxxxxxxxxxxxxxxxPausar para aguardar comercial
        } elseif (empty($this->dataForm['SendInicCham']) and (empty($this->dataForm['SendReagCham'])) and  (empty($this->dataForm['SendPausCham'])) and (!empty($this->dataForm['SendPausCom'])) and (empty($this->dataForm['SendPendCham'])) and (empty($this->dataForm['SendAguarCham'])) and (empty($this->dataForm['SendFinaCham']))) {
            unset($this->dataForm['SendPausCom']);

            $editCham = new \App\adms\Models\AdmsEditCham();
            $editCham->updatePausaCom($this->dataForm);

            if ($editCham->getResult()) {
                $urlRedirect = URLADM . "edit-cham/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditCham();
            }

        //xxxxxxxxxxxxxxxxx Pausar para aguarda cliente
        } elseif (empty($this->dataForm['SendInicCham']) and (empty($this->dataForm['SendReagCham'])) and  (empty($this->dataForm['SendPausCham'])) and (empty($this->dataForm['SendPausCom'])) and (!empty($this->dataForm['SendPendCham'])) and (empty($this->dataForm['SendAguarCham'])) and (empty($this->dataForm['SendFinaCham']))) {
            unset($this->dataForm['SendPendCham']);

            $updatePend = new \App\adms\Models\AdmsEditCham();
            $updatePend->updatePend($this->dataForm);

            if ($updatePend->getResult()) {
                $urlRedirect = URLADM . "edit-cham/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditCham();
            }

            //xxxxxxxxxxxxxxxxx Pausar para aguarda outros
           } elseif (empty($this->dataForm['SendInicCham']) and (empty($this->dataForm['SendReagCham'])) and  (empty($this->dataForm['SendPausCham'])) and (empty($this->dataForm['SendPausCom'])) and (empty($this->dataForm['SendPendCham'])) and (!empty($this->dataForm['SendAguarCham'])) and (empty($this->dataForm['SendFinaCham']))) {
                unset($this->dataForm['SendAguarCham']);
               
               $updateAguar = new \App\adms\Models\AdmsEditCham();
               $updateAguar->updateAguar($this->dataForm);
   
               if ($updateAguar->getResult()) {
                   $urlRedirect = URLADM . "edit-cham/index/" . $this->dataForm['id'];
                   header("Location: $urlRedirect");
               } else {
                   $this->data['form'] = $this->dataForm;
                   $this->viewEditCham();
               }

        //xxxxxxxxxxxxxxxxx Finalizar o chamado
        } elseif (empty($this->dataForm['SendInicCham']) and (empty($this->dataForm['SendReagCham'])) and  (empty($this->dataForm['SendPausCham'])) and (empty($this->dataForm['SendPausCom'])) and (empty($this->dataForm['SendPendCham'])) and (empty($this->dataForm['SendAguarCham'])) and (!empty($this->dataForm['SendFinaCham']))) {
           
              unset($this->dataForm['SendFinaCham']);            

            $editCham = new \App\adms\Models\AdmsEditCham();
            $editCham->updateFinal($this->dataForm);

            if ($editCham->getResult()) {
                $_SESSION['set_status'] = 'Finalizado';
                $urlRedirect = URLADM . "add-hist-cham/index/" . $this->dataForm['id'];
                header("Location: $urlRedirect");
            } else {
                $this->data['form'] = $this->dataForm;
                $this->viewEditCham();
            }

        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado não encontrado!</p>";
            $urlRedirect = URLADM . "list-cham/index";
            header("Location: $urlRedirect");
        }
    }
}
