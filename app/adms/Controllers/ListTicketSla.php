<?php

namespace App\adms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller listar Slas dos Tickets
 * @author Daniel Canedo - docan2006@gmail.com
 */
class ListTicketSla
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

        /** @var string|null $searchCham Recebe a empresa do chamado*/
    private string|null $searchTicket;    

    /** @var string|null $searchCham Recebe a empresa do chamado*/
    private string|null $searchTipo;

    /** @var string|null $searchCham Recebe a empresa do chamado*/
    private string|null $searchEmpresa;

     /** @var string|null $searchDateStart Recebe a data de inicio */
    private string|null $searchDateStart;

    /** @var string|null $searchDateEnd Recebe a data final */
    private string|null $searchDateEnd;

    /** @var string|null $searchColor Recebe o nome da cor em hexadecimal */
    private string|null $searchSuporte;

    /** @var string|null $searchName Recebe o nome da cor */
    private string|null $searchStatus;

    /** @var string|null $searchName Recebe o nome da cor */
    private string|null $searchStatusAnterior;

    /**
     * Método listar Slas dos Tickets.
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
        $this->searchTicket = filter_input(INPUT_GET, 'search_ticket', FILTER_DEFAULT);
        $this->searchTipo = filter_input(INPUT_GET, 'search_tipo', FILTER_DEFAULT);
        $this->searchEmpresa = filter_input(INPUT_GET, 'search_empresa', FILTER_DEFAULT);
        $this->searchDateStart = filter_input(INPUT_GET, 'search_date_start', FILTER_DEFAULT);
        $this->searchDateEnd = filter_input(INPUT_GET, 'search_date_end', FILTER_DEFAULT);
        $this->searchStatus = filter_input(INPUT_GET, 'search_status_anterior', FILTER_DEFAULT);
        $this->searchStatusAnterior = filter_input(INPUT_GET, 'search_status', FILTER_DEFAULT);
        $this->searchSuporte = filter_input(INPUT_GET, 'search_suporte', FILTER_DEFAULT);

        $listTicketSla = new \App\adms\Models\AdmsListTicketSla();
        
        if ((!empty($this->dataForm['SendSearchTicket']))) {
            $this->page = 1;
            $listTicketSla->listSearchCham($this->page, $this->dataForm['search_ticket'], $this->dataForm['search_empresa'], $this->dataForm['search_status'], $this->dataForm['search_status_anterior'], $this->dataForm['search_tipo'], $this->dataForm['search_date_start'], $this->dataForm['search_date_end'], $this->dataForm['search_suporte']);
            $this->data['form'] = $this->dataForm;

        // Busca pelo numero do Ticket    
        } elseif ((!empty($this->searchTicket))) {
            $listTicketSla->listSearchCham($this->page, $this->searchTicket, $this->searchEmpresa, $this->searchTipo, $this->searchStatus, $this->searchStatusAnterior, $this->searchDateStart, $this->searchDateEnd, $this->searchSuporte);
            $this->data['form']['search_id'] = $this->searchTicket;

        // Busca pelo tipo do Sla do Ticket
        } elseif ((empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (empty($this->searchStatusAnterior)) or (!empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd)) or (empty($this->searchSuporte))) {
            $listTicketSla->listSearchCham($this->page, $this->searchTicket, $this->searchEmpresa, $this->searchStatus, $this->searchStatusAnterior, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchSuporte);
            $this->data['form']['search_tipo'] = $this->searchTipo;

        // Busca pelo cliente do Ticket
        } elseif ((!empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (empty($this->searchStatusAnterior)) or (empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd)) or (empty($this->searchSuporte))) {
            $listTicketSla->listSearchCham($this->page, $this->searchTicket, $this->searchEmpresa, $this->searchStatus, $this->searchStatusAnterior, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchSuporte);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;

        // Busca pela data ou periodo do Ticket
        } elseif ((empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (empty($this->searchStatusAnterior)) or (empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (empty($this->searchSuporte))) {
            $listTicketSla->listSearchCham($this->page, $this->searchTicket, $this->searchEmpresa, $this->searchStatus, $this->searchStatusAnterior, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchSuporte);
            $this->data['form']['search_date_start'] = $this->searchDateStart;
            $this->data['form']['search_date_end'] = $this->searchDateEnd;

        // Busca pelo suporte do atendimento do Ticket
        } elseif ((!empty($this->searchSuporte)) or (empty($this->searchEmpresa)) or (empty($this->searchStatus))or (empty($this->searchStatusAnterior))  or (empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd))) {
            $listTicketSla->listSearchCham($this->page, $this->searchTicket, $this->searchEmpresa, $this->searchStatus, $this->searchStatusAnterior, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchSuporte);
            $this->data['form']['search_suporte'] = $this->searchSuporte;

        // Busca pelo status anterior do Ticket
        } elseif ((empty($this->searchEmpresa)) or (!empty($this->searchStatus)) or (!empty($this->searchStatusAnterior)) or(empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd)) or (empty($this->searchSuporte))) {
            $listTicketSla->listSearchCham($this->page, $this->searchTicket, $this->searchEmpresa, $this->searchStatus, $this->searchStatusAnterior, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchSuporte);
            $this->data['form']['search_status_anterior'] = $this->searchStatusAnterior;

        // Busca pelo status do Ticket
        } elseif ((empty($this->searchEmpresa)) or (!empty($this->searchStatus))or (empty($this->searchStatusAnterior))  or (empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd)) or (empty($this->searchSuporte))) {
            $listTicketSla->listSearchCham($this->page, $this->searchTicket, $this->searchEmpresa, $this->searchStatus, $this->searchStatusAnterior, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchSuporte);
            $this->data['form']['search_status'] = $this->searchStatus;

        // Busca pelo status do Ticket
        } elseif ((empty($this->searchEmpresa)) or (!empty($this->searchStatus))or (!empty($this->searchStatusAnterior))  or (empty($this->searchTipo)) or (empty($this->searchDateStart)) or (empty($this->searchDateEnd)) or (empty($this->searchSuporte))) {
            $listTicketSla->listSearchCham($this->page, $this->searchTicket, $this->searchEmpresa, $this->searchStatus, $this->searchStatusAnterior, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchSuporte);
            $this->data['form']['search_status_anterior'] = $this->searchStatusAnterior;
            $this->data['form']['search_status'] = $this->searchStatus;

        // Busca pelo cliente e periodo do atendimento
        } elseif ((!empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (empty($this->searchStatusAnterior)) or (empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (empty($this->searchSuporte))) {
            $listTicketSla->listSearchCham($this->page, $this->searchTicket, $this->searchEmpresa, $this->searchStatus, $this->searchStatusAnterior, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchSuporte);
            $this->data['form']['search_empresa'] = $this->searchEmpresa;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;

        // Busca pelo cliente e periodo do atendimento
        } elseif ((empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (empty($this->searchStatusAnterior)) or (empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (!empty($this->searchSuporte))) {
            $listTicketSla->listSearchCham($this->page, $this->searchTicket, $this->searchEmpresa, $this->searchStatus, $this->searchStatusAnterior, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchSuporte);
            $this->data['form']['search_suporte'] = $this->searchEmpresa;
            $this->data['form']['search_date_start'] = $this->searchDateStart;            
            $this->data['form']['search_date_end'] = $this->searchDateEnd;

        // Busca pela data ou periodo e status anterior do Ticket
        } elseif ((empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (!empty($this->searchStatusAnterior)) or (empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (empty($this->searchSuporte))) {
            $listTicketSla->listSearchCham($this->page, $this->searchTicket, $this->searchEmpresa, $this->searchStatus, $this->searchStatusAnterior, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchSuporte);
            $this->data['form']['search_date_start'] = $this->searchDateStart;
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
            $this->data['form']['search_status_anterior'] = $this->searchStatusAnterior;

        // Busca pela data ou periodo e status anterior do Ticket
        } elseif ((empty($this->searchEmpresa)) or (!empty($this->searchStatus)) or (empty($this->searchStatusAnterior)) or (empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (empty($this->searchSuporte))) {
            $listTicketSla->listSearchCham($this->page, $this->searchTicket, $this->searchEmpresa, $this->searchStatus, $this->searchStatusAnterior, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchSuporte);
            $this->data['form']['search_date_start'] = $this->searchDateStart;
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
            $this->data['form']['search_status'] = $this->searchStatus;

        // Busca pela data ou periodo e tipo de sla do Ticket
        } elseif ((empty($this->searchEmpresa)) or (empty($this->searchStatus)) or (empty($this->searchStatusAnterior)) or (!empty($this->searchTipo)) or (!empty($this->searchDateStart)) or (!empty($this->searchDateEnd)) or (empty($this->searchSuporte))) {
            $listTicketSla->listSearchCham($this->page, $this->searchTicket, $this->searchEmpresa, $this->searchStatus, $this->searchStatusAnterior, $this->searchTipo, $this->searchDateStart, $this->searchDateEnd, $this->searchSuporte);
            $this->data['form']['search_date_start'] = $this->searchDateStart;
            $this->data['form']['search_date_end'] = $this->searchDateEnd;
            $this->data['form']['search_tipo'] = $this->searchTipo;

        } else {
            $listTicketSla->listTicketSla($this->page); 
        }

         
        
        if ($listTicketSla->getResult()) {
            $this->data['listTicketSla'] = $listTicketSla->getResultBd();
            $this->data['pagination'] = $listTicketSla->getResultPg();
        } else {
            $this->data['listTicketSla'] = [];
            $this->data['pagination'] = "";
        }

        $button = ['view_ticket_sla' => ['menu_controller' => 'view-ticket-sla', 'menu_metodo' => 'index']];

        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);
        
        $listSelect = new \App\adms\Models\AdmsListTicketSla();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu(); 

        $this->data['sidebarActive'] = "list-ticket-sla";         
        $loadView = new \Core\ConfigView("adms/Views/sla/listTicketSla", $this->data);
        $loadView->loadView();
    }
}
