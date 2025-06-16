<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar Contratos do banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsListContr
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int $page Recebe o número página */
    private int $page;

    /** @var string|null $searchEmail Recebe o metodo */
    private int|null $searchId;

    /** @var string|null $searchEmail Recebe o metodo */
    private int|null $searchType;

    /** @var string|null $searchEmail Recebe o metodo */
    private int|null $searchServ;

    /** @var string|null $searchEmail Recebe o metodo */
    private string|null $searchEmp;

    /** @var string|null $searchEmail Recebe o metodo */
    private string|null $searchIdValue;

    /** @var string|null $searchEmail Recebe o metodo */
    private string|null $searchTypeValue;

    /** @var string|null $searchEmail Recebe o metodo */
    private string|null $searchServValue;

    /** @var string|null $searchEmail Recebe o metodo */
    private string|null $searchEmpValue;

    /** @var int $page Recebe a quantidade de registros que deve retornar do banco de dados */
    private int $limitResult = 40;

    /** @var string|null $page Recebe a páginação */
    private string|null $resultPg;

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
     * Metodo faz a pesquisa dos contratos na tabela adms_contr e lista as informações na view
     * Recebe o paramentro "page" para que seja feita a paginação do resultado
     * @param integer|null $page
     * @return void
     */
    public function listContr(int $page = null): void
    {
        $this->page = (int) $page ? $page : 1;
        
        if (($_SESSION['adms_access_level_id'] > 2) and ($_SESSION['adms_access_level_id'] <> 7)) {
            
            //Se for 4 -> Cliente Administrativo e suporte cliente
            if ($_SESSION['adms_access_level_id'] == 4) {

                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-contr/index');
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(cont.id) AS num_result FROM adms_contr cont WHERE cont.id= :cont_id", "cont_id={$_SESSION['set_Contr']}");
                $this->resultPg = $pagination->getResult();

                $listContr = new \App\adms\Models\helper\AdmsRead();
                $listContr->fullRead("SELECT cont.id, emp.razao_social AS razao_social, serv.name AS servico, cont.num_cont, cont.anexo, cont.dt_term, 
                sit.name AS situacao, typ.name AS tipo
                FROM adms_contr AS cont 
                INNER JOIN adms_empresa AS emp ON emp.id=cont.clie_cont    
                INNER JOIN adms_contr_service AS serv ON serv.id=cont.service_id   
                INNER JOIN adms_contr_sit AS sit ON sit.id=cont.sit_cont   
                INNER JOIN adms_contr_type AS typ ON typ.id=cont.tipo_cont 
                WHERE cont.id= :cont_id  
                ORDER BY cont.dt_term ASC
                LIMIT :limit OFFSET :offset", "cont_id={$_SESSION['set_Contr']}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

                $this->resultBd = $listContr->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhuma contrato encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-contr/index');
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination("SELECT COUNT(cont.id) AS num_result FROM adms_contr AS cont");
            $this->resultPg = $pagination->getResult();

            $listContr = new \App\adms\Models\helper\AdmsRead();
            $listContr->fullRead("SELECT cont.id, emp.razao_social AS razao_social, serv.name AS servico, 
            cont.num_cont, cont.anexo, cont.dt_term, sit.name AS situacao, typ.name AS tipo 
            FROM adms_contr AS cont 
            INNER JOIN adms_empresa AS emp ON emp.id=cont.clie_cont   
            INNER JOIN adms_contr_service AS serv ON serv.id=cont.service_id   
            INNER JOIN adms_contr_sit AS sit ON sit.id=cont.sit_cont   
            INNER JOIN adms_contr_type AS typ ON typ.id=cont.tipo_cont ORDER BY razao_social ASC
            LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listContr->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Contrato encontrado!</p>";
                $this->result = false;
            }
        }
    }


    /**
     * Metodo faz a pesquisa dos contratos na tabela adms_contr e lista as informacoes na view
     * Recebe o paramentro "page" para que seja feita a paginacao do resultado
     * Recebe o paramentro "search_id para que seja feita a pesquisa pelo Id
     * Recebe o paramentro "search_type" para que seja feita a pesquisa pelo tipo do contrato
     * Recebe o paramentro "search_serv para que seja feita a pesquisa pelo serviço do contrato
     * Recebe o paramentro "search_emp" para que seja feita a pesquisa pela empresa do contrato
     
     * @param integer|null $page
     * @param string|null $search_id
     * @param string|null $search_type
     * @param string|null $search_serv
     * @param string|null $search_emp
     * @return void
     */
    public function listSearchContr(int $page = null, string|null $search_id, string|null $search_type, string|null $search_serv, string|null $search_emp): void
    {
        $this->page = (int) $page ? $page : 1;

        $this->searchId = (int) $search_id;
        $this->searchType = (int)$search_type;
        $this->searchServ = (int)$search_serv;
        $this->searchEmp = (int)$search_emp;

        $this->searchIdValue = $this->searchId;
        $this->searchTypeValue = $this->searchType;
        $this->searchServValue = $this->searchServ;
        $this->searchEmpValue = $this->searchEmp;
        //        var_dump($this->searchTypeValue);

        if (!empty($this->searchId)){
            $this->searchContrId();
        } elseif (empty($this->searchId) and (!empty($this->searchType)) and (empty($this->searchServ)) and (empty($this->searchEmp))) {
            $this->searchType();
        } elseif (empty($this->searchId) and (empty($this->searchType)) and (!empty($this->searchServ)) and (empty($this->searchEmp))) {
            $this->searchServ();
        } elseif (empty($this->searchId) and (empty($this->searchType)) and (empty($this->searchServ)) and (!empty($this->searchEmp))) {
            $this->searchEmp();
        } else {
            $this->listContr();
        }
    }

    /**
     * Metodo pesquisar pela empresa e pelo status do chamado
     * @return void
     */
    public function searchContrId(): void
    {
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-contr/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_contr  WHERE id= :search_id", "search_id={$this->searchIdValue}");

        $this->resultPg = $pagination->getResult();

        $listCham = new \App\adms\Models\helper\AdmsRead();
        $listCham->fullRead("SELECT cont.id, emp.razao_social AS razao_social, serv.name AS servico, cont.num_cont, cont.dt_term, 
            sit.name AS situacao, typ.name AS tipo, cont.anexo FROM adms_contr AS cont
            INNER JOIN adms_empresa AS emp ON emp.id=cont.clie_cont 
            INNER JOIN adms_contr_service AS serv ON serv.id=cont.service_id   
            INNER JOIN adms_contr_sit AS sit ON sit.id=cont.sit_cont   
            INNER JOIN adms_contr_type AS typ ON typ.id=cont.tipo_cont 
            WHERE cont.id = :search_id", "search_id={$this->searchIdValue}");

        $this->resultBd = $listCham->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum chamado encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo pesquisar pela empresa e pelo status do chamado
     * @return void
     */
    public function searchType(): void
    {
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-contr/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_contr where tipo_cont= :search_type", "search_type={$this->searchTypeValue}");
        $this->resultPg = $pagination->getResult();

        $listCham = new \App\adms\Models\helper\AdmsRead();
        $listCham->fullRead("SELECT cont.id, emp.razao_social AS razao_social, serv.name AS servico, cont.num_cont, cont.dt_term, 
        sit.name AS situacao, typ.name AS tipo, cont.anexo FROM adms_contr AS cont
        INNER JOIN adms_empresa AS emp ON emp.id=cont.clie_cont 
        INNER JOIN adms_contr_service AS serv ON serv.id=cont.service_id   
        INNER JOIN adms_contr_sit AS sit ON sit.id=cont.sit_cont   
        INNER JOIN adms_contr_type AS typ ON typ.id=cont.tipo_cont 
        WHERE tipo_cont= :tipo
        LIMIT :limit OFFSET :offset", "tipo={$this->searchTypeValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

        $this->resultBd = $listCham->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo pesquisar pela empresa e pelo status do chamado
     * @return void
     */
    public function searchServ(): void
    {
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-contr/index', "?search_serv={$this->searchServ}");
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_contr where service_id= :search_serv", "search_serv={$this->searchServValue}");
        $this->resultPg = $pagination->getResult();

        $listCham = new \App\adms\Models\helper\AdmsRead();

        $listCham->fullRead("SELECT cont.id, emp.razao_social AS razao_social, serv.name AS servico, cont.num_cont, cont.dt_term, 
        sit.name AS situacao, typ.name AS tipo, cont.anexo FROM adms_contr AS cont 
        INNER JOIN adms_empresa AS emp ON emp.id=cont.clie_cont 
        INNER JOIN adms_contr_service AS serv ON serv.id=cont.service_id   
        INNER JOIN adms_contr_sit AS sit ON sit.id=cont.sit_cont   
        INNER JOIN adms_contr_type AS typ ON typ.id=cont.tipo_cont 
        WHERE service_id= :search_serv
        LIMIT :limit OFFSET :offset", "search_serv={$this->searchServValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

        $this->resultBd = $listCham->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
            $this->result = false;
        }
    }


    /**
     * Metodo pesquisar pela empresa e pelo status do chamado
     * @return void
     */
    public function searchEmp(): void
    {
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-contr/index', "?search_emp={$this->searchEmp}");
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_contr WHERE clie_cont= :search_emp", "search_emp={$this->searchEmpValue}");
        $this->resultPg = $pagination->getResult();

        $listCham = new \App\adms\Models\helper\AdmsRead();

        $listCham->fullRead("SELECT cont.id, emp.razao_social AS razao_social, serv.name AS servico, cont.num_cont, cont.dt_term, 
            sit.name AS situacao, typ.name AS tipo, cont.anexo 
            FROM adms_contr AS cont 
            INNER JOIN adms_empresa AS emp ON emp.id=cont.clie_cont 
            INNER JOIN adms_contr_service AS serv ON serv.id=cont.service_id   
            INNER JOIN adms_contr_sit AS sit ON sit.id=cont.sit_cont   
            INNER JOIN adms_contr_type AS typ ON typ.id=cont.tipo_cont 
            WHERE clie_cont= :search_emp
            LIMIT :limit OFFSET :offset", "search_emp={$this->searchEmpValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

        $this->resultBd = $listCham->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
            $this->result = false;
        }
    }



    /**
     * Metodo para pesquisar as informações que serão usadas no dropdown do formulário
     *
     * @return array
     */
    public function listSelect(): array
    {
        $list = new \App\adms\Models\helper\AdmsRead();

        $list->fullRead("SELECT id, name FROM adms_contr_type  ORDER BY name");
        $registry['type_cont'] = $list->getResult();

        $list->fullRead("SELECT id id_serv, name serv_name FROM adms_contr_service as serv  ORDER BY serv_name ASC");
        $registry['name_serv'] = $list->getResult();

        $list->fullRead("SELECT id, razao_social, contrato FROM adms_empresa  ORDER BY razao_social ASC");
        $registry['nome_emp'] = $list->getResult();




        $this->listRegistryAdd = ['name_serv' => $registry['name_serv'], 'type_cont' => $registry['type_cont'], 'nome_emp' => $registry['nome_emp']];

        return $this->listRegistryAdd;
    }
}
