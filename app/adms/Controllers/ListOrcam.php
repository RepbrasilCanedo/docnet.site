<?php

namespace App\adms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller listar todas as chamadas
 * @author Daniel Canedo - docan2006@gmail.com
 */
class ListOrcam
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;

    /** @var string|null $searchCham Recebe a empresa do chamado*/
    private string|null $searchId;

    /** @var string|null $searchCham Recebe a empresa do chamado*/
    private string|null $searchEmpresa;

    /** @var string|null $searchCham Recebe o status do chamado*/
    private string|null $searchStatus;

    /** @var array|string|null $searchCham Recebe o status do chamado*/
    private string|null $statusCham;

    /** @var string|null $searchDateStart Recebe a data de inicio */
    private string|null $searchDateStart;

    /** @var string|null $searchDateEnd Recebe a data final */
    private string|null $searchDateEnd;

    /** @var string|null $searchStatusChamado Recebe o status do chamado */
    private string|null $searchStatusChamado;

    /**
     * Método listar Chamados
     * 
     * Instancia a MODELS responsável em buscar os registros no banco de dados.
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senão enviar o array de dados vazio.
     *
     * @return void
     */
    public function index(string|int|null $page = null): void
    {
        if (isset($_GET['status_ticket'])) {
            $_SESSION['status_ticket'] = (int) $_GET['status_ticket'];
            header("Location: " . URLADM . "list-orcam/index");
            exit();
        }

        $this->page = (int) $page ? $page : 1;

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);  
        $this->searchId = filter_input(INPUT_GET, 'search_id', FILTER_DEFAULT);
        $this->searchEmpresa = filter_input(INPUT_GET, 'search_empresa', FILTER_DEFAULT);
        $this->searchStatus = filter_input(INPUT_GET, 'search_status', FILTER_DEFAULT);
        $this->searchDateStart = filter_input(INPUT_GET, 'search_date_start', FILTER_DEFAULT);
        $this->searchDateEnd = filter_input(INPUT_GET, 'search_date_end', FILTER_DEFAULT);

        $listOrcam = new \App\adms\Models\AdmsListOrcam();
        
        if ((!empty($this->dataForm['SendSearchCham']))) {
            $this->page = 1;
            $listOrcam->listSearchOrcam($this->page, $this->dataForm['search_id'], $this->dataForm['search_empresa'], $this->dataForm['search_status'], $this->dataForm['search_date_start'], $this->dataForm['search_date_end']);
            $this->data['form'] = $this->dataForm;
        } elseif ((!empty($this->searchId))) {
            $listOrcam->listSearchOrcam($this->page, $this->searchId, $this->searchEmpresa,$this->searchStatus, $this->searchDateStart, $this->searchDateEnd);
            $this->data['form']['search_id'] = $this->searchId;
        } elseif ((!empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd))) {
            $listOrcam->listSearchOrcam($this->page, $this->searchId, $this->searchEmpresa, $this->searchStatus, $this->searchDateStart, $this->searchDateEnd);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
        } elseif ((empty($this->searchEmpresa)) or (!empty($this->searchStatus)) or (empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd))) {
            $listOrcam->listSearchOrcam($this->page, $this->searchId, $this->searchEmpresa, $this->searchStatus, $this->searchDateStart, $this->searchDateEnd);
            $this->data['form']['search_status'] = $this->searchStatus;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
        } elseif ((!empty($this->searchEmpresa)) or (!empty($this->searchStatus)) or (empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd))) {
            $listOrcam->listSearchOrcam($this->page, $this->searchId, $this->searchEmpresa, $this->searchStatus, $this->searchDateStart, $this->searchDateEnd);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
            $this->data['form']['search_status'] = $this->searchStatus;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
        } elseif ((!empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd))) {
            $listOrcam->listSearchOrcam($this->page, $this->searchId, $this->searchEmpresa, $this->searchStatus,$this->searchDateStart, $this->searchDateEnd);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
        } elseif ((!empty($this->searchEmpresa)) or (!empty($this->searchStatus)) or (empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd))) {
            $listOrcam->listSearchOrcam($this->page, $this->searchId, $this->searchEmpresa, $this->searchStatus,$this->searchDateStart, $this->searchDateEnd);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
            $this->data['form']['search_status'] = $this->searchStatus;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
        } elseif ((empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd))) {
            $listOrcam->listSearchOrcam($this->page, $this->searchId, $this->searchEmpresa, $this->searchStatus,$this->searchDateStart, $this->searchDateEnd);
            $this->data['form']['search_date_start'] = $this->searchDateStart;
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
        } else {
            $listOrcam->listOrcam($this->page);
        }

        if ($listOrcam->getResult()) {
            $this->data['listOrcam'] = $listOrcam->getResultBd();
            $this->data['pagination'] = $listOrcam->getResultPg();
        } else {
            $this->data['listOrcam'] = [];
            $this->data['pagination'] = "";
        }

        $button = [
            'view_orcam' => ['menu_controller' => 'view-orcam', 'menu_metodo' => 'index'],
            'edit_orcam' => ['menu_controller' => 'edit-orcam', 'menu_metodo' => 'index'],
            'aval_orcam' => ['menu_controller' => 'aval-orcam', 'menu_metodo' => 'index']
        ];

        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listSelect = new \App\adms\Models\AdmsListOrcam();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "list-orcam";
        $loadView = new \Core\ConfigView("adms/Views/orcamentos/listOrcam", $this->data);
        $loadView->loadView();
    }


    
}
