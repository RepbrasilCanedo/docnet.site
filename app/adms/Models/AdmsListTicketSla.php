<?php

namespace App\adms\Models;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar Slas dos Tikets do banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsListTicketSla
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

    /** @var string|null $searchEmail Recebe o metodo */
    private string|null $searchTicketValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchTipoValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchEmpresaValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchStatusValue;

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
     * @return bool Retorna a paginação
     */
    function getResultPg(): string|null
    {
        return $this->resultPg;
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
                            LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");

        $this->resultBd = $listTicketSla->getResult();        
        if($this->resultBd){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma Ticket Sla encontrado!</p>";
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
    }

    
}
