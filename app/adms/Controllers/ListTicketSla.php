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
        $this->searchStatus = filter_input(INPUT_GET, 'search_status', FILTER_DEFAULT);
        $this->searchSuporte = filter_input(INPUT_GET, 'search_suporte', FILTER_DEFAULT);

        $listTicketSla = new \App\adms\Models\AdmsListTicketSla();
        $listTicketSla->listTicketSla($this->page);  
        
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
