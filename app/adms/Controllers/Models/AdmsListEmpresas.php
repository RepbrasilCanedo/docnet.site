<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar Empresa do banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsListEmpresas
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

    /** @var string|null $searchCnpj Recebe o cnpj da empresa*/
    private string|null $searchCnpj;

    /** @var string|null $sesearchRazao Recebe a razao social da empresa*/
    private string|null $searchRazao;

    /** @var string|null $searchCnpj Recebe o valor do cnpj da empresa*/
    private string|null $searchCnpjValue;

    /** @var string|null $searchFantasia Recebe o nome de fantasia da empresa */
    private string|null $searchFantasia;

    /** @var string|null $sesearchRazao Recebe o valor da razao social da empresa*/
    private string|null $searchRazaoValue;

    /** @var string|null $searchFantasia Recebe o valor do nome de fantasia da empresa */
    private string|null $searchFantasiaValue;

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
     * Metodo faz a pesquisa das Empresas na tabela "adms_clientess" e lista as informações na view
     * Recebe como parametro "page" para fazer a paginação
     * @param integer|null $page
     * @return void
     */
    public function listEmpresas(int $page): void
    {
        $this->page = (int) $page ? $page : 1;

        if ($_SESSION['adms_access_level_id'] > 2) {

            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-empresas/index');
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination("SELECT COUNT(clie.id) AS num_result FROM adms_clientes AS clie WHERE empresa= :empresa", "empresa={$_SESSION['emp_user']}");
            $this->resultPg = $pagination->getResult();

            $listEmpresas = new \App\adms\Models\helper\AdmsRead();
            $listEmpresas->fullRead("SELECT clie.id, clie.razao_social, clie.nome_fantasia, clie.cnpjcpf, clie.bairro, clie.cidade, clie.empresa,
                            sit.name as name_sit                            
                            FROM adms_clientes as clie
                            INNER JOIN adms_sits_empr_unid AS sit ON sit.id=clie.situacao 
                            WHERE empresa= :empresa LIMIT :limit OFFSET :offset", "empresa={$_SESSION['emp_user']}&limit={$this->limitResult}&offset={$pagination->getOffset()}");
            $this->resultBd = $listEmpresas->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma Empresa encontrada!</p>";
                $this->result = false;
            }
        } else {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-empresas/index');
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_clientes");
            $this->resultPg = $pagination->getResult();

            $listEmpresas = new \App\adms\Models\helper\AdmsRead();
            $listEmpresas->fullRead("SELECT clie.id, clie.razao_social, clie.nome_fantasia, clie.cnpjcpf, clie.bairro, clie.cidade, 
                            sit.name as name_sit
                            FROM adms_clientes as clie
                            INNER JOIN adms_sits_empr_unid AS sit ON sit.id=clie.situacao 
                            LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listEmpresas->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma Empresa encontrada!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo faz a pesquisa das Empresas na tabela adms_colors e lista as informacoes na view
     * Recebe o paramentro "page" para que seja feita a paginacao do resultado
     * Recebe o paramentro "searchRazao" para que seja feita a pesquisa pelo nome da Empresa
     * Recebe o paramentro "search_fantasia" para que seja feita a pesquisa pelo nome em hexadecimal
     * @param integer|null $page
     * @param string|null $searchRazao
     * @param string|null $search_fantasia
     * @return void
     */
    public function listSearchEmpresas(int $page, string|null $searchCnpj, string|null $searchRazao, string|null $search_fantasia): void
    {
        $this->page = (int) $page ? $page : 1;

        $this->searchCnpj = trim($searchCnpj);
        $this->searchRazao = trim($searchRazao);
        $this->searchFantasia = trim($search_fantasia);


        $this->searchCnpjValue = $this->searchCnpj . "%";
        $this->searchRazaoValue = $this->searchRazao . "%";
        $this->searchFantasiaValue = $this->searchFantasia . "%";

        if ((!empty($this->searchCnpj))) {
            $this->searchCnpj();
        } elseif ((!empty($this->searchRazao)) and (!empty($this->searchFantasia))) {
            $this->searchEmpresaRazaoFantasia();
        } elseif ((!empty($this->searchRazao)) and (empty($this->searchFantasia))) {
            $this->searchEmpresaRazao();
        } elseif ((empty($this->searchRazao)) and (!empty($this->searchFantasia))) {
            $this->searchEmpresaFantasia();
        } else {
            $this->listEmpresas($this->page);
        }
    }

    /**
     * Metodo pesquisar pelo cnpj ou cpf do cliente
     * @return void
     */
    public function searchCnpj(): void
    {
        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-empresas/index', "?search_cnpj={$this->searchCnpj}");
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_clientes  WHERE (cnpjcpf LIKE :search_cnpj)", "search_cnpj={$this->searchCnpjValue}");
        $this->resultPg = $pagination->getResult();

        $listEmpresas = new \App\adms\Models\helper\AdmsRead();
        $listEmpresas->fullRead("SELECT clie.id, clie.razao_social, clie.nome_fantasia, clie.cnpjcpf, clie.bairro, clie.cidade, 
                            sit.name as name_sit
                            FROM adms_clientes as clie
                            INNER JOIN adms_sits_empr_unid AS sit ON sit.id=clie.situacao 
                            WHERE clie.cnpjcpf LIKE :search_cnpj
                            ORDER BY clie.razao_social
                            LIMIT :limit OFFSET :offset", "search_cnpj={$this->searchCnpjValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

        $this->resultBd = $listEmpresas->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma cliente encontrado com este CNPJ/CPF!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo pesquisar pelo nome da Empresa e nome de fantasia
     * @return void
     */
    public function searchEmpresaRazaoFantasia(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-empresas/index', "?search_razao={$this->searchRazao}&search_fantasia={$this->searchFantasia}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_clientes
                                    WHERE empresa= :empresa AND (razao_social LIKE :search_razao) AND (nome_fantasia LIKE :search_fantasia)", "empresa={$_SESSION['emp_user']}&search_razao={$this->searchRazaoValue}&search_fantasia={$this->searchFantasiaValue}");
            $this->resultPg = $pagination->getResult();

            $listEmpresas = new \App\adms\Models\helper\AdmsRead();
            $listEmpresas->fullRead("SELECT clie.id, clie.razao_social, clie.nome_fantasia, clie.cnpjcpf, clie.bairro, clie.cidade, 
                                sit.name as name_sit, cont.num_cont as contrato, emp.nome_fantasia as empresa
                                FROM adms_clientes as clie
                                INNER JOIN adms_sits_empr_unid AS sit ON sit.id=clie.situacao 
                                INNER JOIN adms_contr AS cont ON cont.id=clie.contrato
                                INNER JOIN adms_emp_principal AS emp ON emp.id=clie.empresa
                        WHERE (empresa= :empresa) AND (clie.razao_social LIKE :search_razao) AND (clie.nome_fantasia LIKE :search_fantasia)
                        ORDER BY emp.nome_fantasia
                        LIMIT :limit OFFSET :offset", "empresa={$_SESSION['emp_user']}&search_razao={$this->searchRazaoValue}&search_fantasia={$this->searchFantasiaValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listEmpresas->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma Empresa encontrada!</p>";
                $this->result = false;
            }
        } else {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-empresas/index', "?search_razao={$this->searchRazao}&search_fantasia={$this->searchFantasia}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_clientes
                                    WHERE (razao_social LIKE :search_razao) AND (nome_fantasia LIKE :search_fantasia)", "search_razao={$this->searchRazaoValue}&search_fantasia={$this->searchFantasiaValue}");
            $this->resultPg = $pagination->getResult();

            $listEmpresas = new \App\adms\Models\helper\AdmsRead();
            $listEmpresas->fullRead("SELECT clie.id, clie.razao_social, clie.nome_fantasia, clie.cnpjcpf, clie.bairro, clie.cidade, 
                                sit.name as name_sit, cont.num_cont as contrato, emp.nome_fantasia as empresa
                                FROM adms_clientes as clie
                                INNER JOIN adms_sits_empr_unid AS sit ON sit.id=clie.situacao 
                                INNER JOIN adms_contr AS cont ON cont.id=clie.contrato
                                INNER JOIN adms_emp_principal AS emp ON emp.id=clie.empresa
                        WHERE (clie.razao_social LIKE :search_razao) AND (clie.nome_fantasia LIKE :search_fantasia)
                        ORDER BY emp.nome_fantasia
                        LIMIT :limit OFFSET :offset", "search_razao={$this->searchRazaoValue}&search_fantasia={$this->searchFantasiaValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listEmpresas->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma Empresa encontrada!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pelo nome ou razão social
     * @return void
     */
    public function searchEmpresaRazao(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-empresas/index', "?search_razao={$this->searchRazao}&search_fantasia={$this->searchFantasia}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_clientes
                                    WHERE empresa= :empresa AND (razao_social LIKE :search_razao)", "empresa={$_SESSION['emp_user']}&search_razao={$this->searchRazaoValue}");
            $this->resultPg = $pagination->getResult();

            $listEmpresas = new \App\adms\Models\helper\AdmsRead();
            $listEmpresas->fullRead("SELECT clie.id, clie.razao_social, clie.nome_fantasia, clie.cnpjcpf, clie.bairro, clie.cidade, sit.name as name_sit
                                FROM adms_clientes as clie
                                INNER JOIN adms_sits_empr_unid AS sit ON sit.id=clie.situacao 
                        WHERE (empresa= :empresa) AND (clie.razao_social LIKE :search_razao)
                        ORDER BY clie.nome_fantasia
                        LIMIT :limit OFFSET :offset", "empresa={$_SESSION['emp_user']}&search_razao={$this->searchRazaoValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listEmpresas->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma Empresa encontrada!</p>";
                $this->result = false;
            }
        } else {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-empresas/index', "?search_razao={$this->searchRazao}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_clientes
                                WHERE razao_social LIKE :search_razao", "search_razao={$this->searchRazaoValue}");
            $this->resultPg = $pagination->getResult();

            $listEmpresas = new \App\adms\Models\helper\AdmsRead();
            $listEmpresas->fullRead("SELECT clie.id, clie.razao_social, clie.nome_fantasia, clie.cnpjcpf, clie.bairro, clie.cidade, 
                            sit.name as name_sit
                            FROM adms_clientes as clie
                            INNER JOIN adms_sits_empr_unid AS sit ON sit.id=clie.situacao 
                            WHERE clie.razao_social LIKE :search_razao
                            ORDER BY clie.razao_social
                            LIMIT :limit OFFSET :offset", "search_razao={$this->searchRazaoValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listEmpresas->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma Empresa encontrada!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pelo nome de fantasia ou apelido
     * @return void
     */
    public function searchEmpresaFantasia(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-empresas/index', "?search_razao={$this->searchRazao}&search_fantasia={$this->searchFantasia}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_clientes
                                    WHERE empresa= :empresa AND nome_fantasia LIKE :nome_fantasia", "empresa={$_SESSION['emp_user']}&nome_fantasia={$this->searchFantasiaValue}");
            $this->resultPg = $pagination->getResult();

            $listEmpresas = new \App\adms\Models\helper\AdmsRead();
            $listEmpresas->fullRead("SELECT clie.id, clie.razao_social, clie.nome_fantasia, clie.cnpjcpf, clie.bairro, clie.cidade, 
                                sit.name as name_sit
                                FROM adms_clientes as clie
                                INNER JOIN adms_sits_empr_unid AS sit ON sit.id=clie.situacao 
                                WHERE empresa= :empresa AND clie.nome_fantasia LIKE :search_fantasia
                                ORDER BY clie.nome_fantasia
                                LIMIT :limit OFFSET :offset", "empresa={$_SESSION['emp_user']}&search_fantasia={$this->searchFantasiaValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listEmpresas->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma Empresa encontrada!</p>";
                $this->result = false;
            }
        } else {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-empresas/index', "?search_razao={$this->searchRazao}&search_fantasia={$this->searchFantasia}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination("SELECT COUNT(id) AS num_result FROM adms_clientes WHERE nome_fantasia LIKE :nome_fantasia", "nome_fantasia={$this->searchFantasiaValue}");
            $this->resultPg = $pagination->getResult();

            $listEmpresas = new \App\adms\Models\helper\AdmsRead();
            $listEmpresas->fullRead("SELECT clie.id, clie.razao_social, clie.nome_fantasia, clie.cnpjcpf, clie.bairro, clie.cidade, 
                            sit.name as name_sit
                            FROM adms_clientes as clie
                            INNER JOIN adms_sits_empr_unid AS sit ON sit.id=clie.situacao 
                            WHERE clie.nome_fantasia LIKE :search_fantasia
                            ORDER BY clie.nome_fantasia
                            LIMIT :limit OFFSET :offset", "search_fantasia={$this->searchFantasiaValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listEmpresas->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma Empresa encontrada!</p>";
                $this->result = false;
            }
        }
    }
}
