<?php

namespace App\cpms\Models;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar Slas dos Tikets do banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class CpmsRelatListSla
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int $page Recebe o número página */
    private int $page;

    /** @var int $page Recebe a quantidade de registros que deve retornar do banco de dados */
    private int $limitResult = 40;

    /** @var string|null $page Recebe a páginação */
    private string|null $resultPg;

    /** @var string|null $searchEmail Recebe o metodo */
    private int|null $searchTicket;

    /** @var string|null $searchMarca Recebe o valor da marca*/
    private string|null $searchTipo;

    /** @var string|null $searchMarca Recebe o valor da marca*/
    private string|null $searchEmpresa;

    /** @var string|null $searchDateStart Recebe a data de inicio */
    private string|null $searchDateStart;

    /** @var string|null $searchDateEnd Recebe a data final */
    private string|null $searchDateEnd;

    /** @var string|null $searchColor Recebe o nome da cor em hexadecimal */
    private string|null $searchSuporte;

    /** @var string|null $searchMarca Recebe o valor da marca*/
    private string|null $searchStatus;

    /** @var string|null $searchMarca Recebe o valor da marca*/
    private string|null $searchStatusAnterior;

    /** @var string|null $searchEmail Recebe o metodo */
    private string|null $searchTicketValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchTipoValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchEmpresaValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchSuporteValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchStatusValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchStatusAnteriorValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchDateStartValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchDateEndValue;    

    /** @var array|null $listRegistryAdd Recebe os registros do banco de dados */
    private array|null $listRegistryAdd;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os registros do BD
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

   

    /**
     * Metodo faz a pesquisa dos Slas dos Tikets na tabela "adms_sla_hist" e lista as informações na view
     * Recebe como parametro "page" para fazer a paginação
     * @param integer|null $page
     * @return void
     */
    public function listTicketSla(int $page):void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-ticket-sla/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(sla_ticket.id) AS num_result FROM adms_sla_hist AS sla_ticket");
        $this->resultPg = $pagination->getResult();

        $listTicketSla = new \App\adms\Models\helper\AdmsRead();
        $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id 
                            ORDER BY sla_hist.dt_abert_ticket DESC", "limit={$this->limitResult}&offset={$pagination->getOffset()}");

        $this->resultBd = $listTicketSla->getResult();        
        if($this->resultBd){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma Ticket Sla encontrado!</p>";
            $this->result = false;
        }
    }


/**
     * Metodo faz a pesquisa das cores na tabela adms_colors e lista as informacoes na view
     * Recebe o paramentro "page" para que seja feita a paginacao do resultado
     * Recebe o paramentro "search_name" para que seja feita a pesquisa pelo nome da cor
     * Recebe o paramentro "search_color" para que seja feita a pesquisa pelo nome em hexadecimal
     * @param integer|null $page
     * @param string|null $search_name
     * @param string|null $search_color
     * @return void
     */
    public function listSearchSla(int $page, string|null $search_ticket, string|null $search_empresa, string|null $search_status, string|null $search_status_anterior, string|null $search_Tipo, string|null $search_Date_Start, string|null $search_Date_End, string|null $search_suporte): void
    {
        $this->page = (int) $page ? $page : 1;

        $this->searchTicket = (int) $search_ticket;
        $this->searchEmpresa = $search_empresa;
        $this->searchSuporte = $search_suporte;
        $this->searchStatus = $search_status;
        $this->searchStatusAnterior = $search_status_anterior;
        $this->searchTipo = $search_Tipo;
        $this->searchDateStart = $search_Date_Start;
        $this->searchDateEnd = $search_Date_End;

        $this->searchTicketValue = $this->searchTicket;
        $this->searchEmpresaValue = $this->searchEmpresa;
        $this->searchSuporteValue = $this->searchSuporte;
        $this->searchStatusValue = $this->searchStatus;
        $this->searchStatusAnteriorValue = $this->searchStatusAnterior;
        $this->searchTipoValue = $this->searchTipo;
        $this->searchDateStartValue = $this->searchDateStart;
        $this->searchDateEndValue = $this->searchDateEnd;


        if (!empty($this->searchTicket)) {
            $this->searchTicket();
        } else {
            if ((!empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (empty($this->searchTipo)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd)) and (empty($this->searchSuporte))) {
                $this->searchEmpresa(); //Pesquisa pelo cliente do atendimento
            } else if ((empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (empty($this->searchTipo)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd)) and (!empty($this->searchSuporte))) {
                $this->searchSuporte(); //Pesquisa pelo Suporte do atendimento
            } else if ((empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (empty($this->searchStatusAnterior)) and (!empty($this->searchTipo)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd)) and (empty($this->searchSuporte))) {
                $this->searchTipo(); //Pesquisa pelo Suporte do atendimento
            } else if ((empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (empty($this->searchStatusAnterior)) and (empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (empty($this->searchSuporte))) {
                $this->searchDiaAtendimento(); //Pesquisa pelo periodo do atendimento
            } else if ((empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (!empty($this->searchStatusAnterior)) and (empty($this->searchTipo)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd)) and (empty($this->searchSuporte))) {
                $this->searchStatusAnterior(); //Pesquisa pelo status anterior
            } else if ((empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (empty($this->searchStatusAnterior)) and (empty($this->searchTipo)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd)) and (empty($this->searchSuporte))) {
                $this->searchStatusAtual(); //Pesquisa pelo status atual
            } else if ((empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (!empty($this->searchStatusAnterior)) and (empty($this->searchTipo)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd)) and (empty($this->searchSuporte))) {
                $this->searchStatusAmbos(); //Pesquisa pelos dois status
            } else if ((!empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (empty($this->searchStatusAnterior)) and (empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (empty($this->searchSuporte))) {
                $this->searchEmpresaPeriodo(); //Pesquisa pelo cliente no periodo do atendimento
            } else if ((empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (empty($this->searchStatusAnterior)) and (empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (!empty($this->searchSuporte))) {
                $this->searchSuportePeriodo(); //Pesquisa pelo Suporte no periodo do atendimento
            } else if ((empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (!empty($this->searchStatusAnterior)) and (empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (empty($this->searchSuporte))) {
                $this->searchStatusAntPeriodo(); //Pesquisa pelo periodo do atendimento e status anterior
            } else if ((empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (empty($this->searchStatusAnterior)) and (empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (empty($this->searchSuporte))) {
                $this->searchStatusAtualPeriodo(); //Pesquisa pelo periodo do atendimento e status atual
            } else if ((empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (!empty($this->searchStatusAnterior)) and (empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (empty($this->searchSuporte))) {
                $this->searchStatusAmbosPeriodo(); //Pesquisa pelo periodo do atendimento ambos os status
            } else if ((empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (empty($this->searchStatusAnterior)) and (!empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (empty($this->searchSuporte))) {
                $this->searchTipoPeriodo(); //Pesquisa pelo periodo do atendimento e o tipo do sla






            } else {
               $this->listTicketSla($this->page);
            }
        }
    }

    /**
     * Metodo pesquisar pelo numero do Ticket
     * @return void
     */
    public function searchTicket(): void
    {

        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo 
            if ($_SESSION['adms_access_level_id'] == 4) {

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (id_ticket= :id_ticket)", "empresa_id={$_SESSION['emp_user']}&id_ticket={$this->searchTicketValue}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.empresa_id= :empresa_id) and (sla_hist.id_ticket= :cham_id)",
                            "empresa_id={$_SESSION['emp_user']}&cham_id={$this->searchTicketValue}");


                $this->resultBd = $listTicketSla->getResult();

               if ($this->resultBd) {  
                  $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado com essa numeração!</p>";
                    $this->result = false;
                }
            }
        } else {

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (id_ticket= :id_ticket)", "empresa_id={$_SESSION['emp_user']}&id_ticket={$this->searchTicketValue}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.id_ticket= :cham_id)",
                            "cham_id={$this->searchTicketValue}");


                $this->resultBd = $listTicketSla->getResult();

               if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado com essa numeração!</p>";
                    $this->result = false;
                }
        }
    }

    /**
     * Metodo pesquisar pela empresa do Ticket
     * @return void
     */
    public function searchEmpresa(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo 
            if ($_SESSION['adms_access_level_id'] == 4)  {

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (sla_hist.cliente_id = :cliente_id)", "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.empresa_id= :empresa_id) and (sla_hist.cliente_id = :cliente_id)",
                            "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }

        } else {

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (sla_hist.cliente_id = :cliente_id)", "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.cliente_id = :cliente_id)",
                            "cliente_id={$this->searchEmpresaValue}");
            }
    }

    /**
     * Metodo pesquisar pelo suporte do ticket
     * @return void
     */
    public function searchSuporte(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo 
            if ($_SESSION['adms_access_level_id'] == 4)  {

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (suporte_id = :suporte_id)", "empresa_id={$_SESSION['emp_user']}&suporte_id={$this->searchSuporteValue}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.empresa_id= :empresa_id) and (sla_hist.suporte_id = :suporte_id) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&suporte_id={$this->searchSuporteValue}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }

        } else {
                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (suporte_id  = :suporte_id)", "empresa_id={$_SESSION['emp_user']}&suporte_id={$this->searchSuporteValue}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.suporte_id = :suporte_id) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&suporte_id={$this->searchSuporteValue}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
    }

    /**
     * Metodo pesquisar pelo tipo do Ticket
     * @return void
     */
    public function searchTipo(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo 
            if ($_SESSION['adms_access_level_id'] == 4)  {

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (id_sla = :id_sla)", "empresa_id={$_SESSION['emp_user']}&id_sla={$this->searchTipoValue}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.empresa_id= :empresa_id) and (sla_hist.id_sla= :id_sla) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&id_sla={$this->searchTipoValue}");


                $this->resultBd = $listTicketSla->getResult();}

                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }

        } else {

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (sla_hist.id_sla= :id_sla)", "id_sla={$this->searchTipoValue}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.id_sla= :id_sla) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "id_sla={$this->searchTipoValue}");


                $this->resultBd = $listTicketSla->getResult();}

                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
    }

    /**
     * Metodo pesquisar pelo periodo do atendimento do Ticket
     * @return void
     */
    public function searchDiaAtendimento(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo 
            if ($_SESSION['adms_access_level_id'] == 4)  {                

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end)", 
                "empresa_id={$_SESSION['emp_user']}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.empresa_id= :empresa_id) AND (sla_hist.dt_abert_ticket BETWEEN :search_date_start AND :search_date_end) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }

        } else {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-ticket-sla/index');
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (cliente_id = :cliente_id)", "cliente_id={$this->searchEmpresaValue}");
                $this->resultPg = $pagination->getResult();
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id 
                            WHERE (sla_hist.cliente_id = :cliente_id) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
    }

    /**
     * Metodo pesquisar pelo status anterior do atendimento do ticket
     * @return void
     */
    public function searchStatusAnterior(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo 
            if ($_SESSION['adms_access_level_id'] == 4)  {

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (status_id_ant= :status_id_ant)", 
                "empresa_id={$_SESSION['emp_user']}&status_id_ant={$this->searchStatusAnteriorValue}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.empresa_id= :empresa_id) AND (sla_hist.status_id_ant = :status_id_ant) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&status_id_ant={$this->searchStatusAnteriorValue}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }

        } else {

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (status_id_ant= :status_id_ant)", 
                "status_id_ant={$this->searchStatusAnteriorValue}");
                
                $this->resultBd=$contEquip->getResult();
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.empresa_id= :empresa_id) AND (sla_hist.status_id_ant = :status_id_ant) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "status_id_ant={$this->searchStatusAnteriorValue}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
    }

    /**
     * Metodo pesquisar pelo status atual do atendimento do ticket
     * @return void
     */
    public function searchStatusAtual(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo 
            if ($_SESSION['adms_access_level_id'] == 4)  {

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (status_id= :status_id)", 
                "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}");
                
                $this->resultBd=$contEquip->getResult();
                
                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id  
                            WHERE (sla_hist.empresa_id= :empresa_id) AND (sla_hist.status_id = :status_id) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }

        } else {
            

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (status_id= :status_id)", 
                "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}");
                
                $this->resultBd=$contEquip->getResult();
                
                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.empresa_id= :empresa_id) AND (sla_hist.status_id = :status_id) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "status_id={$this->searchStatusValue}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
    }

    /**
     * Metodo pesquisar pelo status atnterior e atual do atendimento do ticket
     * @return void
     */
    public function searchStatusAmbos(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo 
            if ($_SESSION['adms_access_level_id'] == 4)  {


                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (status_id_ant= :status_id_ant) AND (status_id= :status_id)",  
                "empresa_id={$_SESSION['emp_user']}&status_id_ant={$this->searchStatusAnteriorValue}&status_id={$this->searchStatusValue}");
                
                $this->resultBd=$contEquip->getResult();
                
                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.empresa_id= :empresa_id) AND (sla_hist.status_id_ant = :status_id_ant) AND (status_id= :status_id) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&status_id_ant={$this->searchStatusAnteriorValue}&status_id={$this->searchStatusValue}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }

        } else {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-ticket-sla/index');
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (cliente_id = :cliente_id)", "cliente_id={$this->searchEmpresaValue}");
                $this->resultPg = $pagination->getResult();
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id 
                            WHERE (sla_hist.cliente_id = :cliente_id) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
    }

    /**
     * Metodo pesquisar pela empresa e periodo do Ticket
     * @return void
     */
    public function searchEmpresaPeriodo(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo 
            if ($_SESSION['adms_access_level_id'] == 4)  {                

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (cliente_id = :cliente_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end)", 
                "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id  
                            WHERE (sla_hist.empresa_id= :empresa_id) AND (sla_hist.cliente_id = :cliente_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }

        } else {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-ticket-sla/index');
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (cliente_id = :cliente_id)", "cliente_id={$this->searchEmpresaValue}");
                $this->resultPg = $pagination->getResult();
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.cliente_id = :cliente_id) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
    }

    /**
     * Metodo pesquisar pelo suporte e periodo do Ticket
     * @return void
     */
    public function searchSuportePeriodo(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo 
            if ($_SESSION['adms_access_level_id'] == 4)  {                

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (suporte_id = :suporte_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end)", 
                "empresa_id={$_SESSION['emp_user']}&suporte_id={$this->searchSuporteValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id  
                            WHERE (sla_hist.empresa_id= :empresa_id) AND (sla_hist.suporte_id = :suporte_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&suporte_id={$this->searchSuporteValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {                    
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }

        } else {
                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (suporte_id = :suporte_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end)", 
                "suporte_id={$this->searchSuporteValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id  
                            WHERE (sla_hist.suporte_id = :suporte_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&suporte_id={$this->searchSuporteValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {                    
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
    }

    /**
     * Metodo pesquisar pelo status anterior e periodo do Ticket
     * @return void
     */
    public function searchStatusAntPeriodo(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo 
            if ($_SESSION['adms_access_level_id'] == 4)  {                

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (status_id_ant= :status_id_ant) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end)", 
                "empresa_id={$_SESSION['emp_user']}&status_id_ant={$this->searchStatusAnteriorValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id  
                            WHERE (sla_hist.empresa_id= :empresa_id) AND (sla_hist.status_id_ant = :status_id_ant) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&status_id_ant={$this->searchStatusAnteriorValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {                    
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }

        } else {                

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (status_id_ant= :status_id_ant) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end)", 
                "status_id_ant={$this->searchStatusAnteriorValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id  
                            (sla_hist.status_id_ant = :status_id_ant) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&status_id_ant={$this->searchStatusAnteriorValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {                    
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
    }

    /**
     * Metodo pesquisar pelo status anterior e periodo do Ticket
     * @return void
     */
    public function searchStatusAtualPeriodo(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo 
            if ($_SESSION['adms_access_level_id'] == 4)  {                

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (status_id= :status_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end)", 
                "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.empresa_id= :empresa_id) AND (sla_hist.status_id = :status_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {                    
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }

        } else {                

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE  (status_id= :status_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end)", 
                "status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.status_id = :status_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {                    
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
    }

    /**
     * Metodo pesquisar pelo status anterior e periodo do Ticket
     * @return void
     */
    public function searchStatusAmbosPeriodo(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo 
            if ($_SESSION['adms_access_level_id'] == 4)  {                

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id) AND (status_id_ant= :status_id_ant) AND (status_id= :status_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end)", 
                "empresa_id={$_SESSION['emp_user']}&status_id_ant={$this->searchStatusAnteriorValue}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.empresa_id= :empresa_id) AND (sla_hist.status_id_ant = :status_id_ant) AND (sla_hist.status_id= :status_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&status_id_ant={$this->searchStatusAnteriorValue}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {                    
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }

        } else {                

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (status_id_ant= :status_id_ant) AND (status_id= :status_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end)", 
                "status_id_ant={$this->searchStatusAnteriorValue}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.status_id_ant = :status_id_ant) AND (sla_hist.status_id= :status_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "status_id_ant={$this->searchStatusAnteriorValue}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {                    
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
    }

    /**
     * Metodo pesquisar pelo status anterior e periodo do Ticket
     * @return void
     */
    public function searchTipoPeriodo(): void
  {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo 
            if ($_SESSION['adms_access_level_id'] == 4)  {                

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (empresa_id= :empresa_id)  AND (id_sla = :id_sla) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end)", 
                "empresa_id={$_SESSION['emp_user']}&id_sla={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.empresa_id= :empresa_id) AND (id_sla = :id_sla) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "empresa_id={$_SESSION['emp_user']}&id_sla={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }

        } else {                

                $contEquip = new \App\adms\Models\helper\AdmsRead();
                $contEquip->fullRead("SELECT COUNT(id_ticket) AS num_result FROM adms_sla_hist WHERE (status_id_ant= :status_id_ant) AND (status_id= :status_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end)", 
                "status_id_ant={$this->searchStatusAnteriorValue}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                
                $this->resultBd=$contEquip->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }
                
                $listTicketSla = new \App\adms\Models\helper\AdmsRead();
                $listTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla, emp.logo as logo_emp 
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla_hist.empresa_id 
                            WHERE (sla_hist.status_id_ant = :status_id_ant) AND (sla_hist.status_id= :status_id) AND (dt_abert_ticket BETWEEN :search_date_start AND :search_date_end) ORDER BY sla_hist.dt_abert_ticket DESC",
                            "status_id_ant={$this->searchStatusAnteriorValue}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");


                $this->resultBd = $listTicketSla->getResult();}

                $this->resultBd = $listTicketSla->getResult();
                if ($this->resultBd) {                    
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
    }

    /**
     * Metodo para pesquisar as informações que serão usadas no dropdown do formulário
     *
     * @return array
     */
    public function listSelect()
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            if ($_SESSION['adms_access_level_id'] == 4) {

                    $listTipo = new \App\adms\Models\helper\AdmsRead();                
                    $listTipo->fullRead("SELECT id, name FROM adms_sla
                    WHERE empresa_id= :empresa", "empresa={$_SESSION['emp_user']}");
                    $registry['nome_tipo'] = $listTipo->getResult();

                    $listClie = new \App\adms\Models\helper\AdmsRead();                
                    $listClie->fullRead("SELECT id, nome_fantasia FROM adms_clientes
                    WHERE empresa= :empresa", "empresa={$_SESSION['emp_user']}");
                    $registry['nome_clie'] = $listClie->getResult();

                    $listSup = new \App\adms\Models\helper\AdmsRead();                
                    $listSup->fullRead("SELECT id, name FROM adms_users
                    WHERE empresa_id= :empresa AND adms_access_level_id= :nivel_acesso ORDER BY name", "empresa={$_SESSION['emp_user']}&nivel_acesso=12");
                    $registry['nome_sup'] = $listSup->getResult();

                    $listSta = new \App\adms\Models\helper\AdmsRead();
                    $listSta->fullRead("SELECT id, name FROM adms_cham_status  ORDER BY name ASC");
                    $registry['nome_status'] = $listSta->getResult();

                    $this->listRegistryAdd = ['nome_tipo' => $registry['nome_tipo'], 'nome_clie' => $registry['nome_clie'], 'nome_sup' => $registry['nome_sup'], 'nome_status' => $registry['nome_status']];
                    return $this->listRegistryAdd;
            }
        } else{
                    $listTipo = new \App\adms\Models\helper\AdmsRead();                
                    $listTipo->fullRead("SELECT id, name FROM adms_sla");
                    $registry['nome_tipo'] = $listTipo->getResult();

                    $listClie = new \App\adms\Models\helper\AdmsRead();                
                    $listClie->fullRead("SELECT id, nome_fantasia FROM adms_clientes}");
                    $registry['nome_clie'] = $listClie->getResult();

                    $listSup = new \App\adms\Models\helper\AdmsRead();                
                    $listSup->fullRead("SELECT id, name FROM adms_users
                    WHERE  adms_access_level_id= :nivel_acesso ORDER BY name", "nivel_acesso=12");
                    $registry['nome_sup'] = $listSup->getResult();

                    $listSta = new \App\adms\Models\helper\AdmsRead();
                    $listSta->fullRead("SELECT id, name FROM adms_cham_status  ORDER BY name ASC");
                    $registry['nome_status'] = $listSta->getResult();

                    $this->listRegistryAdd = ['nome_tipo' => $registry['nome_tipo'], 'nome_clie' => $registry['nome_clie'], 'nome_sup' => $registry['nome_sup'], 'nome_status' => $registry['nome_status']];
                    return $this->listRegistryAdd;
        }
    }



    


    // Função para gerar os dados para o pdf em DOMPDF
    private function generatePdf()
    {      
        
        $total_tickets = $_SESSION['resultado'];
        unset( $_SESSION['resultado']);

        $image_clie=($this->resultBd[0]['empresa_id']);
        $logo_clie=($this->resultBd[0]['logo_emp']);
      
        $html = "<style> table {border-collapse: collapse;width: 100%;}th, td {border: 1px solid black;padding: 2px;text-align: left;} caption{padding: 8px;text-align: center;}center;} a{padding-left: 1000px}</style>";
        $html .= "<a href='" .URLADM. "relat-list-sla/index'><img src='" . URLADM . "app/adms/assets/image/logo/clientes/$image_clie/$logo_clie' width='70' alt='Logo do Cliente' title='Retorna a Página Anterior'></a>";
        $html .= "<table>";
        $html .= "<caption><b> RELATORIO DE SLAS DOS TICKETS - DOCNET HELP DESK </b>";
        $html .= "<caption>Total de : <b> {$total_tickets} </b> Ticket.";
        $html .= "<thead>";
        $html .= "<th>Ticket</th>";
        $html .= "<th>Cliente</th>";
        $html .= "<th>Colaborador</th>";
        $html .= "<th>Prioridade</th>";
        $html .= "<th>Data Abertura Ticket</th>";
        $html .= "<th>Status Anterior</th>";
        $html .= "<th>Status Atual</th>";
        $html .= "<th>Sla</th>";
        $html .= "</thead>";

        foreach ($this->resultBd as $user) {
        extract($user);  

            $html .= "<tbody>";
            $html .= "<td>$id_sla_hist</td>";
            $html .= "<td>$nome_fantasia_clie</td>";
            $html .= "<td>$name_user</td>";
            $html .= "<td>$name_sla</td>";
            $dt_cham_formatada = date('d/m/Y', strtotime($dt_abert_ticket));
            $html .= "<td>$dt_cham_formatada</td>";
            $html .= "<td>$name_status_id_ant</td>";
            $html .= "<td>$name_sta_atu</td>";
            $html .= "<td>$tempo_sla</td>";
            $html .= "</tbody>";
        }
        
        $html .= "</table><br>";
        
        date_default_timezone_set('America/Bahia');
        $dataGeracao = date('d/m/Y H:i:s');
        $html .= "<caption><b> Data de emissão: $dataGeracao </b>";

        $generatePdf = new \App\cpms\Models\helper\CpmsGeneratePdf();
        $generatePdf->generatePdf($html);

        
    }

    
}
