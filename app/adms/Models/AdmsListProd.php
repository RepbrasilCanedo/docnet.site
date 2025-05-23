<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar produtos do banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsListProd
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

    /** @var string|null $searchName Recebe o controller */
    private string|null $searchProd;

    /** @var string|null $searchEmail Recebe o metodo */
    private string|null $searchEmp;

    /** @var string|null $searchName Recebe o controller */
    private string|null $searchProdValue;

    /** @var string|null $searchEmail Recebe o metodo */
    private string|null $searchEmpValue;

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
     * Metodo faz a pesquisa dos produtos na tabela adms_produtos e lista as informações na view
     * Recebe o paramentro "prod" para que seja feita a paginação do resultado
     * @param integer|null $prod
     * @return void
     */
    public function listProd(int $page): void
    {
        $this->page = (int) $page ? $page : 1;


        if (($_SESSION['adms_access_level_id'] > 2) and ($_SESSION['adms_access_level_id'] <> 7)) {
            //Acessa se for Cliente Adm ou Suporte do Cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)){
                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-prod/index');
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_produtos WHERE cliente_id = :cliente_id ","cliente_id={$_SESSION['emp_user']}");
                $this->resultPg = $pagination->getResult();

                $listProd = new \App\adms\Models\helper\AdmsRead();
                $listProd->fullRead("SELECT prod.id, prod.name,  typ.name as name_type, prod.serie, prod.modelo_id, prod.marca_id, clie.nome_fantasia as nome_fantasia_clie, prod.inf_adicionais, sit.name as name_sit
                FROM adms_produtos AS prod  
                INNER JOIN adms_type_equip AS typ ON typ.id=prod.type_id 
                INNER JOIN adms_clientes AS clie ON clie.id=prod.cliente_id 
                INNER JOIN adms_sit_equip AS sit ON sit.id=prod.sit_id
                WHERE prod.cliente_id= :cliente_id ORDER BY prod.name ASC
                LIMIT :limit OFFSET :offset", "cliente_id={$_SESSION['emp_user']}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

                $this->resultBd = $listProd->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhuma Produto encontrado!</p>";
                    $this->result = false;
                } 
            //Acessa se for Usuario final do Cliente
            } else if ($_SESSION['adms_access_level_id'] == 14) {
                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-prod/index');
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_produtos WHERE cont_id = :cont_id","cont_id={$_SESSION['set_Contr']}");
                $this->resultPg = $pagination->getResult();

                $listProd = new \App\adms\Models\helper\AdmsRead();
                $listProd->fullRead("SELECT prod.id, prod.name, typ.name name_typ, emp.nome_fantasia nome_fantasia_emp, sit.name name_sit
                FROM adms_produtos AS prod 
                LEFT JOIN adms_type_prod AS typ ON typ.id=prod.type_id  
                LEFT JOIN adms_empresa AS emp ON emp.id=prod.empresa_id 
                LEFT JOIN adms_sits_empr_unid AS sit ON sit.id=prod.sit_id  
                WHERE prod.cont_id = :cont_id  
                ORDER BY prod.name ASC
                LIMIT :limit OFFSET :offset", "cont_id={$_SESSION['set_Contr']}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

                $this->resultBd = $listProd->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhuma Produto encontrado!</p>";
                    $this->result = false;
                }
            }
            //Acessa se for Super Usuario ou Adm repbrasil
            } else {

                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-prod/index');
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_produtos");
                $this->resultPg = $pagination->getResult();

                $listProd = new \App\adms\Models\helper\AdmsRead();
                $listProd->fullRead("SELECT prod.id, prod.name, typ.name name_typ,
                emp.nome_fantasia nome_fantasia_emp, sit.name name_sit
                FROM adms_produtos AS prod 
                LEFT JOIN adms_type_prod AS typ ON typ.id=prod.type_id  
                LEFT JOIN adms_empresa AS emp ON emp.id=prod.empresa_id 
                LEFT JOIN adms_sits_empr_unid AS sit ON sit.id=prod.sit_id   
                ORDER BY prod.name ASC
                LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");

                $this->resultBd = $listProd->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhuma Produto encontrado!</p>";
                    $this->result = false;
                }
            }
        
    }

    /**
     * Metodo faz a pesquisa das páginas na tabela adms_produtos e lista as informacoes na view
     * Recebe o paramentro "produto" para que seja feita a paginacao do resultado
     * Recebe o paramentro "search_prod" para que seja feita a pesquisa pelo produto
     * Recebe o paramentro "search_emp" para que seja feita a pesquisa pela empresa
     * @param integer|null $page
     * @param string|null $search_prod
     * @param string|null $search_emp
     * @return void
     */


    public function listSearchProd(int $page, string|null $search_prod, string|null $search_emp): void
    {
        $this->page = (int) $page ? $page : 1;

        $this->searchProd = trim($search_prod);
        $this->searchEmp = trim($search_emp);


        $this->searchProdValue = "%" . $this->searchProd . "%";
        $this->searchEmpValue = "%" . $this->searchEmp . "%";

        if ((!empty($this->searchProdValue)) and (!empty($this->searchProdValue))) {
            $this->searchProdEmp();
        } elseif ((!empty($this->searchProd)) and (empty($this->searchEmp))) {
            $this->searchProd();
        } elseif ((empty($this->searchProd)) and (!empty($this->searchEmp))) {
            $this->searchEmp();
        } else {
            $this->searchProdEmp();
        }
    }

    /**
     * Metodo pesquisar pelo produto e empresa
     * @return void
     */

    public function searchProdEmp(): void
    {
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-prod/index', "?search_prod={$this->searchProd}&search_emp={$this->searchEmp}");
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(prod.id) AS num_result
        FROM adms_produtos AS prod  
        WHERE (prod.name LIKE :search_prod) AND (emp.nome_fantasia LIKE :search_nome_fantasia_emp )
        ORDER BY prod.name ASC", "search_prod={$this->searchProdValue}&search_nome_fantasia_emp={$this->searchEmpValue}");
        $this->resultPg = $pagination->getResult();

        $listprod = new \App\adms\Models\helper\AdmsRead();
        $listprod->fullRead("SELECT prod.id, prod.name, typ.name name_typ,
        emp.nome_fantasia nome_fantasia_emp, sit.name name_sit
        FROM adms_produtos AS prod 
        LEFT JOIN adms_type_prod AS typ ON typ.id=prod.type_id  
        LEFT JOIN adms_empresa AS emp ON emp.id=prod.empresa_id 
        LEFT JOIN adms_sits_empr_unid AS sit ON sit.id=prod.sit_id   
        WHERE (prod.name LIKE :search_prod) AND (emp.nome_fantasia LIKE :search_nome_fantasia_emp )
        ORDER BY prod.name ASC
        LIMIT :limit OFFSET :offset", "search_prod={$this->searchProdValue}&search_nome_fantasia_emp={$this->searchEmpValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

        $this->resultBd = $listprod->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhum produto encontradoss!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo pesquisar pelo controller
     * @return void
     */
    public function searchProd(): void
    {
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-prod/index', "?search_prod={$this->searchProd}&search_emp={$this->searchEmp}");
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_produtos WHERE name LIKE :search_prod", "search_prod={$this->searchProdValue}");
        $this->resultPg = $pagination->getResult();

        $listprod = new \App\adms\Models\helper\AdmsRead();
        $listprod->fullRead("SELECT prod.id, prod.empresa_id, prod.name, typ.name name_typ, prod.serie, modelo.name name_modelo, mar.name name_mar, 
        prod.cor, emp.nome_fantasia nome_fantasia_emp, prod.inf_adicionais, sit.name name_sit
        FROM adms_produtos AS prod 
        LEFT JOIN adms_type_prod AS typ ON typ.id=prod.type_id 
        LEFT JOIN adms_model AS modelo ON modelo.id=prod.modelo_id 
        LEFT JOIN adms_marca AS mar ON mar.id=prod.marca_id 
        LEFT JOIN adms_empresa AS emp ON emp.id=prod.empresa_id 
        LEFT JOIN adms_sits_empr_unid AS sit ON sit.id=prod.sit_id  
        WHERE (prod.empresa_id= :empresa_id) and (prod.name LIKE :search_prod LIKE :search_prod) ORDER BY prod.id DESC
         LIMIT :limit OFFSET :offset", "empresa_id={$_SESSION['emp_user']}&search_prod={$this->searchProdValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");


        $this->resultBd = $listprod->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhum produto encontrado2!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo pesquisar pelo metodo
     * @return void
     */
    public function searchEmp(): void
    {
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-prod/index', "?search_prod={$this->searchProd}&search_emp={$this->searchEmp}");
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_produtos WHERE name LIKE :search_prod", "search_prod={$this->searchProdValue}");
        $this->resultPg = $pagination->getResult();

        $listprod = new \App\adms\Models\helper\AdmsRead();
        $listprod->fullRead("SELECT prod.id, prod.name, typ.name name_typ, prod.serie, modelo.name name_modelo, mar.name name_mar, 
        prod.cor, emp.nome_fantasia nome_fantasia_emp, prod.inf_adicionais, sit.name name_sit
        FROM adms_produtos AS prod 
        LEFT JOIN adms_type_prod AS typ ON typ.id=prod.type_id 
        LEFT JOIN adms_model AS modelo ON modelo.id=prod.modelo_id 
        LEFT JOIN adms_marca AS mar ON mar.id=prod.marca_id 
        LEFT JOIN adms_empresa AS emp ON emp.id=prod.empresa_id 
        LEFT JOIN adms_sits_empr_unid AS sit ON sit.id=prod.sit_id 
        WHERE empresa_id LIKE :search_nome_fantasia_emp ORDER BY id_prod DESC
         LIMIT :limit OFFSET :offset", "search_nome_fantasia_emp={$this->searchEmpValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

        $this->resultBd = $listprod->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p style='color: #f00'>Erro: Nenhum produto encontrada!</p>";
            $this->result = false;
        }
    }
}
