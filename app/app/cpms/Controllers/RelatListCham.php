<?php

namespace App\cpms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller listar todas as chamadas
 * @author Daniel Canedo - docan2006@gmail.com
 */
class RelatListCham
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
    private string|null $searchTipo;

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

    /** @var string|null $searchDateEnd Recebe a data final */
    private string|null $searchTecSuporte;

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
        
        $this->page = (int) $page ? $page : 1;

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);  
        $this->searchEmpresa = filter_input(INPUT_GET, 'search_empresa', FILTER_DEFAULT);
        $this->searchStatus = filter_input(INPUT_GET, 'search_status', FILTER_DEFAULT);
        $this->searchTipo = filter_input(INPUT_GET, 'search_tipo', FILTER_DEFAULT);
        $this->searchDateStart = filter_input(INPUT_GET, 'search_date_start', FILTER_DEFAULT);
        $this->searchDateEnd = filter_input(INPUT_GET, 'search_date_end', FILTER_DEFAULT);
        $this->searchTecSuporte = filter_input(INPUT_GET, 'search_tec_suporte', FILTER_DEFAULT);
        

        $listCham = new \App\cpms\Models\CpmsRelatListCham();
        
        if ((!empty($this->dataForm['SendSearchCham']))) {
            $this->page = 1;
            $listCham->listSearchCham($this->page, $this->dataForm['search_empresa'], $this->dataForm['search_status'], $this->dataForm['search_tipo'], $this->dataForm['search_date_start'], $this->dataForm['search_date_end'], $this->dataForm['search_tec_suporte']);
            $this->data['form'] = $this->dataForm;
        } elseif ((!empty($this->searchEmpresa)) or (!empty($this->searchStatus)) or (!empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd)) or (empty($this->searchTecSuporte))) {
            $listCham->listSearchCham($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
            $this->data['form']['search_status'] = $this->searchStatus;
            $this->data['form']['search_tipo'] = $this->searchTipo;
        } elseif ((!empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd)) or (empty($this->searchTecSuporte))) {
            $listCham->listSearchCham($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
        } elseif ((empty($this->searchEmpresa)) or (!empty($this->searchStatus)) or (empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd)) or (empty($this->searchTecSuporte))) {
            $listCham->listSearchCham($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_status'] = $this->searchStatus;
        } elseif ((empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (!empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd)) or (empty($this->searchTecSuporte))) {
            $listCham->listSearchCham($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_tipo'] = $this->searchTipo;
        } elseif ((empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (!empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (empty($this->searchTecSuporte))) {
            $listCham->listSearchCham($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_tipo'] = $this->searchTipo;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
        } elseif ((!empty($this->searchEmpresa)) or (!empty($this->searchStatus)) or (empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd)) or (empty($this->searchTecSuporte))) {
            $listCham->listSearchCham($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
            $this->data['form']['search_status'] = $this->searchStatus;
        } elseif ((!empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (!empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd)) or (empty($this->searchTecSuporte))) {
            $listCham->listSearchCham($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
            $this->data['form']['search_tipo'] = $this->searchTipo;
        } elseif ((empty($this->searchEmpresa)) or (!empty($this->searchStatus)) or (!empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd)) or (empty($this->searchTecSuporte))) {
            $listCham->listSearchCham($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_status'] = $this->searchStatus;
            $this->data['form']['search_tipo'] = $this->searchTipo;
        } elseif ((empty($this->searchEmpresa)) or (!empty($this->searchStatus)) or (!empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (empty($this->searchTecSuporte))) {
            $listCham->listSearchCham($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_status'] = $this->searchStatus;
            $this->data['form']['search_tipo'] = $this->searchTipo;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
        } elseif ((!empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (empty($this->searchTecSuporte))) {
            $listCham->listSearchCham($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
        } elseif ((!empty($this->searchEmpresa)) or (!empty($this->searchStatus)) or (empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (empty($this->searchTecSuporte))) {
            $listCham->listSearchCham($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
            $this->data['form']['search_status'] = $this->searchStatus;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
        } elseif ((!empty($this->searchEmpresa)) or (!empty($this->searchStatus)) or (!empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (empty($this->searchTecSuporte))) {
            $listCham->listSearchCham($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
            $this->data['form']['search_status'] = $this->searchStatus;
            $this->data['form']['search_tipo'] = $this->searchTipo;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
        } elseif ((empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (empty($this->searchTecSuporte))) {
            $listCham->listSearchCham($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_date_start'] = $this->searchDateStart;
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
        }elseif ((empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd)) or (!empty($this->searchTecSuporte))) {
            $listCham->listSearchCham($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_tec_suporte'] = $this->searchTecSuporte;
        } elseif ((!empty($this->searchEmpresa)) or (!empty($this->searchStatus)) or (!empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (!empty($this->searchTecSuporte))) {
            $listCham->searchChamEmpTipoStatusDateTec($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
            $this->data['form']['search_status'] = $this->searchStatus;
            $this->data['form']['search_tipo'] = $this->searchTipo;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
            $this->data['form']['search_tec_suporte'] = $this->searchTecSuporte;
        } elseif ((empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (!empty($this->searchTecSuporte))) {
            $listCham->searchChamDateTec($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
            $this->data['form']['search_tec_suporte'] = $this->searchTecSuporte;
        } elseif ((empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (!empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (!empty($this->searchTecSuporte))) {
            $listCham->searchChamTipoDateTec($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_tipo'] = $this->searchTipo;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
            $this->data['form']['search_tec_suporte'] = $this->searchTecSuporte;
        } elseif ((empty($this->searchEmpresa)) or (!empty($this->searchStatus)) or (!empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (!empty($this->searchTecSuporte))) {
            $listCham->searchChamTipoStatusDateTec($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_status'] = $this->searchStatus;
            $this->data['form']['search_tipo'] = $this->searchTipo;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
            $this->data['form']['search_tec_suporte'] = $this->searchTecSuporte;
        } elseif ((!empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (!empty($this->searchTecSuporte))) {
            $listCham->searchChamEmpDateTec($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
            $this->data['form']['search_tec_suporte'] = $this->searchTecSuporte;
        } elseif ((!empty($this->searchEmpresa)) or (!empty($this->searchStatus)) or (empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (!empty($this->searchTecSuporte))) {
            $listCham->searchChamEmpStatusDateTec($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
            $this->data['form']['search_status'] = $this->searchStatus;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
            $this->data['form']['search_tec_suporte'] = $this->searchTecSuporte;
        } elseif ((!empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (!empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (!empty($this->searchTecSuporte))) {
            $listCham->searchChamEmpTipoDateTec($this->page, $this->searchEmpresa, $this->searchStatus, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchTecSuporte);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
            $this->data['form']['search_tipo'] = $this->searchTipo;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
            $this->data['form']['search_tec_suporte'] = $this->searchTecSuporte;
        }  
        if ($listCham->getResult()) {
            $this->data['relatListCham'] = $listCham->getResultBd();
        } else {
            $this->data['relatListCham'] = [];
        }

        $listSelect = new \App\cpms\Models\CpmsRelatListCham();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "adms/relat-list-cham";
        $loadView = new \Core\ConfigView("cpms/Views/chamados/relatListCham", $this->data);
        $loadView->loadView();
    }


    
}
