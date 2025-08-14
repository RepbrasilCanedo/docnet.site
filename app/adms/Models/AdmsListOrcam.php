<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar marcas dos equipamentos do banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsListOrcam
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int $page Recebe o número página */
    private int $page;

    /** @var int $page Recebe o status */
    private int $status_id;

    /** @var string|null $searchEmail Recebe o metodo */
    private int|null $searchId;

    /** @var string|null $searchMarca Recebe o valor da marca*/
    private string|null $searchEmpresa;

    /** @var string|null $searchMarca Recebe o valor da marca*/
    private string|null $searchStatus;

    /** @var string|null $searchMarca Recebe o valor da marca*/
    private string|null $status_Cham;

    /** @var string|null $searchEmail Recebe o metodo */
    private string|null $searchIdValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchEmpresaValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchStatusValue;

    /** @var string|null $searchDateStart Recebe a data de inicio */
    private string|null $searchDateStart;

    /** @var string|null $searchDateEnd Recebe a data final */
    private string|null $searchDateEnd;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchDateStartValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchDateEndValue;

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
     * Metodo faz a pesquisa das Empresas na tabela "adms_cham" e lista as informações na view
     * Recebe como parametro "page" para fazer a paginação
     * @param integer|null $page
     * @return void
     */
    public function listOrcam(int $page): void
    {
        $this->page = (int) $page ? $page : 1;

            if (($_SESSION['adms_access_level_id'] > 2)) {

                //Se for 4 -> Cliente Administrativo ou 12 - Suporte cliente
                if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {
                    $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index');
                    $pagination->condition($this->page, $this->limitResult);
                    $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam 
                    WHERE empresa_id= :empresa_id", "empresa_id={$_SESSION['emp_user']}");
                    $this->resultPg = $pagination->getResult();

                    $listOrcam = new \App\adms\Models\helper\AdmsRead();
                    $listOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                            orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                            orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                            FROM adms_orcam as orcam
                            INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                            INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                            WHERE orcam.empresa_id= :empresa_id ORDER BY orcam.dt_orcam DESC LIMIT :limit OFFSET :offset", "empresa_id={$_SESSION['emp_user']}&limit={$this->limitResult}&offset={$pagination->getOffset()}");
                    
                            $this->resultBd = $listOrcam->getResult();

                    if ($this->resultBd) {
                       $this->result = true;
                    } else {
                        $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum orçamento encontrado para a empresa do usuario!</p>";
                        $this->result = false;
                    }

                //Se for 14 - Usuario final
                } elseif ($_SESSION['adms_access_level_id'] == 14) {
                    $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index');
                    $pagination->condition($this->page, $this->limitResult);
                    $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam  
                    WHERE empresa_id= :empresa_id and cliente_id= :id_cliente", "empresa_id={$_SESSION['emp_user']}&id_cliente={$_SESSION['set_clie']}");
                    $this->resultPg = $pagination->getResult();

                    $listOrcam = new \App\adms\Models\helper\AdmsRead();
                    $listOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                            orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                            orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                            FROM adms_orcam as orcam
                            INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                            INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                            WHERE orcam.empresa_id= :empresa_id AND orcam.cliente_id= :id_cliente 
                            ORDER BY orcam.dt_orcam DESC LIMIT :limit OFFSET :offset", "empresa_id={$_SESSION['emp_user']}&id_cliente={$_SESSION['set_clie']}&limit={$this->limitResult}&offset={$pagination->getOffset()}");
                    
                   $this->resultBd = $listOrcam->getResult();

                    if ($this->resultBd) {
                        $this->result = true;
                    } else {
                        $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado para a empresa do usuario!</p>";
                        $this->result = false;
                    }
                }
            } else {

                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index');
                    $pagination->condition($this->page, $this->limitResult);
                    $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam");
                    $this->resultPg = $pagination->getResult();

                    $listOrcam = new \App\adms\Models\helper\AdmsRead();
                    $listOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                            orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                            orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                            FROM adms_orcam as orcam
                            INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                            INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                            ORDER BY orcam.dt_orcam DESC LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");
                    
                            $this->resultBd = $listOrcam->getResult();

                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado para a empresa do usuario!</p>";
                    $this->result = false;
                }
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
    public function listSearchOrcam(int $page, string|null $search_id, string|null $search_empresa, string|null $search_status, string|null $search_Date_Start, string|null $search_Date_End): void
    {
        $this->page = (int) $page ? $page : 1;

        $this->searchId = (int) $search_id;
        $this->searchEmpresa = $search_empresa;
        $this->searchStatus = $search_status;
        $this->searchDateStart = $search_Date_Start;
        $this->searchDateEnd = $search_Date_End;

        $this->searchIdValue = $this->searchId;
        $this->searchEmpresaValue = $this->searchEmpresa;
        $this->searchStatusValue = $this->searchStatus;
        $this->searchDateStartValue = $this->searchDateStart;
        $this->searchDateEndValue = $this->searchDateEnd;


        if (!empty($this->searchId)) {
            $this->searchContrId();
        } else {
            if ((!empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd))) {
                $this->searchEmpresa(); //So empresa
            } elseif ((!empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd))) {
                $this->searchEmpresaStatus(); // empresa - Status -  Periodo
            } elseif ((empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd))) {
                $this->searchStatus(); //So status
            } elseif ((empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd))) {
                $this->searchStatusDate(); //So status e periodo do orcamento
            } elseif ((empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd))) {
                $this->searchChamDate(); // periodo
            } elseif ((!empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd))) {
                $this->searchChamEmpDate(); // empresa e periodo
            } elseif ((!empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd))) {
                $this->searchChamEmpStatusDate(); // empresa, status e periodo
            } else {
                $this->listOrcam($this->page);
            }
        }
    }

    /**
     * Metodo pesquisar pelo numero do orcamento
     * @return void
     */
    public function searchContrId(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {
                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?&search_empresa={$this->searchEmpresa}");
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam  WHERE (empresa_id= :empresa_id) AND id= :id", "empresa_id={$_SESSION['emp_user']}&id={$this->searchIdValue}");
                $this->resultPg = $pagination->getResult();

                $listOrcam = new \App\adms\Models\helper\AdmsRead();
                $listOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                            orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                            orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                            FROM adms_orcam as orcam
                            INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                            INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                                    WHERE (orcam.empresa_id= :empresa_id) and (orcam.id= :orcam_id) LIMIT :limit OFFSET :offset",
                                    "empresa_id={$_SESSION['emp_user']}&orcam_id={$this->searchIdValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}"
                );

                $this->resultBd = $listOrcam->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado com essa numeração!</p>";
                    $this->result = false;
                }
            }
        } else {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?&search_empresa={$this->searchEmpresa}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE id= :id", "id={$this->searchIdValue}");
            $this->resultPg = $pagination->getResult();

            $listOrcam = new \App\adms\Models\helper\AdmsRead();
            $listOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                            orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                            orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                            FROM adms_orcam as orcam
                            INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                            INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                                    WHERE orcam.id= :cham_id LIMIT :limit","cham_id={$this->searchIdValue}&limit=1");
            $this->resultBd = $listOrcam->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado com essa numeração!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pela empresa do orcamento
     * @return void
     */
    public function searchEmpresa(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {
                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_empresa={$this->searchEmpresa}");
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE (empresa_id= :empresa_id) AND (cliente_id= :cliente_id)",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}"
                );
                $this->resultPg = $pagination->getResult();

                $listOrcam = new \App\adms\Models\helper\AdmsRead();
                $listOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                            orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                            orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                            FROM adms_orcam as orcam
                            INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                            INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                                    WHERE (orcam.empresa_id= :empresa_id) AND (orcam.cliente_id= :cliente_id)  ORDER BY orcam.dt_orcam DESC
                                    LIMIT :limit OFFSET :offset", "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");
            }
        } else {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_empresa={$this->searchEmpresa}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE (cliente_id= :cliente_id)", "cliente_id={$this->searchEmpresaValue}");
            $this->resultPg = $pagination->getResult();

            $listOrcam = new \App\adms\Models\helper\AdmsRead();
            $listOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                            orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                            orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                            FROM adms_orcam as orcam
                            INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                            INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                                WHERE orcam.cliente_id= :cliente_id  ORDER BY orcam.dt_orcam DESC
                                LIMIT :limit OFFSET :offset", "cliente_id={$this->searchEmpresaValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");
        }

        $this->resultBd = $listOrcam->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
            $this->result = false;
        }
    }
    /**
     * Metodo pesquisar pelo status do orcamento
     * @return void
     */
    public function searchStatus(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {
                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_status={$this->searchStatus}");
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE (empresa_id= :empresa_id) and (status_id= :status_id)",
                    "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}"
                );
                $this->resultPg = $pagination->getResult();

                $listOrcam = new \App\adms\Models\helper\AdmsRead();
                $listOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                            orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                            orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                            FROM adms_orcam as orcam
                            INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                            INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                            WHERE (orcam.empresa_id= :empresa_id) and (orcam.status_id= :status_id) ORDER BY orcam.dt_orcam DESC
                            LIMIT :limit OFFSET :offset", "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

                $this->resultBd = $listOrcam->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
                    $this->result = false;
                }
            } elseif ($_SESSION['adms_access_level_id'] == 14) {
                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_status={$this->searchStatus}");
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE (cliente_id = :cliente_id ) and (status_id= :status_id)",
                    "cliente_id={$_SESSION['set_clie']}&status_id={$this->searchStatusValue}"
                );
                $this->resultPg = $pagination->getResult();

                $listOrcam = new \App\adms\Models\helper\AdmsRead();
                $listOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                            orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                            orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                            FROM adms_orcam as orcam
                            INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                            INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                            WHERE orcam.cliente_id= :cliente_id and orcam.status_id= :status_id  ORDER BY orcam.dt_orcam DESC
                            LIMIT :limit OFFSET :offset", "cliente_id={$_SESSION['set_clie']}&status_id={$this->searchStatusValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

                $this->resultBd = $listOrcam->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_status={$this->searchStatus}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE status_id= :status_id",
                "status_id={$this->searchStatusValue}"
            );
            $this->resultPg = $pagination->getResult();

            $listOrcam = new \App\adms\Models\helper\AdmsRead();
            $listOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                            orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                            orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                            FROM adms_orcam as orcam
                            INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                            INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                            WHERE(orcam.status_id= :status_id) ORDER BY orcam.dt_orcam DESC
                        LIMIT :limit OFFSET :offset", "status_id={$this->searchStatusValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listOrcam->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
                $this->result = false;
            }
        }
    }
    /**
     * Metodo pesquisar pela data inicio e fim
     * @return void
     */
    public function searchChamDate(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {
            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {
                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE (empresa_id = :empresa_id) AND (dt_orcam BETWEEN :search_date_start AND :search_date_end)",
                    "empresa_id={$_SESSION['emp_user']}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
                );
                $this->resultPg = $pagination->getResult();

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                                    orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                                    orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                                    FROM adms_orcam as orcam
                                    INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                                    INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                                    WHERE (orcam.empresa_id = :empresa_id) AND (orcam.dt_orcam BETWEEN :search_date_start AND :search_date_end)
                                    ORDER BY orcam.dt_orcam DESC
                                    LIMIT :limit OFFSET :offset", "empresa_id={$_SESSION['emp_user']}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
                    $this->result = false;
                }
                //Se for 12 - Suporte Cliente            

                //Se for 14 - Cliente Final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {

                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE (cliente_id= :cliente_id) AND (dt_orcam BETWEEN :search_date_start AND :search_date_end)",
                    "cliente_id={$_SESSION['set_clie']}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
                );
                $this->resultPg = $pagination->getResult();

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                                    orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                                    orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                                    FROM adms_orcam as orcam
                                    INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                                    INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id 
                                    WHERE (cliente_id= :cliente_id) AND (orcam.dt_orcam BETWEEN :search_date_start AND :search_date_end)
                                     ORDER BY orcam.dt_orcam DESC
                                    LIMIT :limit OFFSET :offset", "cliente_id={$_SESSION['set_clie']}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE (dt_orcam BETWEEN :search_date_start AND :search_date_end)",
                "search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );

            $this->resultPg = $pagination->getResult();

            $listUsers = new \App\adms\Models\helper\AdmsRead();
            $listUsers->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                                    orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                                    orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                                    FROM adms_orcam as orcam
                                    INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                                    INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id 
                                    WHERE orcam.dt_orcam BETWEEN :search_date_start AND :search_date_end  ORDER BY orcam.dt_orcam DESC
                                    LIMIT :limit OFFSET :offset", "search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listUsers->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pela empresa e status do orcamento
     * @return void
     */
    public function searchEmpresaStatus(): void
    {

        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_empresa={$this->searchEmpresa}&search_status={$this->searchStatus}");
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE (empresa_id= :empresa_id) AND (cliente_id= :cliente_id) AND (status_id= :status_id)",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}"
                );
                $this->resultPg = $pagination->getResult();

                $listOrcam = new \App\adms\Models\helper\AdmsRead();
                $listOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                                    orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                                    orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                                    FROM adms_orcam as orcam
                                    INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                                    INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                                    WHERE (orcam.empresa_id= :empresa_id) AND (orcam.cliente_id= :cliente_id) AND (orcam.status_id= :status_id) ORDER BY orcam.dt_orcam DESC
                                    LIMIT :limit OFFSET :offset", "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

                $this->resultBd = $listOrcam->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_empresa={$this->searchEmpresa}&search_status={$this->searchStatus}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination(
                "SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE (cliente_id= :cliente_id) AND (status_id= :status_id)",
                "cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}"
            );
            $this->resultPg = $pagination->getResult();

            $listOrcam = new \App\adms\Models\helper\AdmsRead();
            $listOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                                    orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                                    orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                                    FROM adms_orcam as orcam
                                    INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                                    INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                                    WHERE (orcam.cliente_id= :cliente_id) AND (orcam.status_id= :status_id)  ORDER BY orcam.dt_orcam DESC
                                    LIMIT :limit OFFSET :offset", "cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listOrcam->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
                $this->result = false;
            }
        }
    }
    /**
     * Metodo pesquisar pelo status do orcamento e periodo
     * @return void
     */
    public function searchStatusDate(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {
                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_status={$this->searchStatus}&search_empresa={$this->searchEmpresa}&search_date_start={$this->searchDateStart}");
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE (empresa_id= :empresa_id) AND (status_id= :status_id) AND (dt_orcam BETWEEN :search_date_start AND :search_date_end)",
                    "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
                );
                $this->resultPg = $pagination->getResult();

                $listOrcam = new \App\adms\Models\helper\AdmsRead();
                $listOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                                    orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                                    orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                                    FROM adms_orcam as orcam
                                    INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                                    INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                                    WHERE (orcam.empresa_id= :empresa_id) and (orcam.status_id= :status_id AND (orcam.dt_orcam BETWEEN :search_date_start AND :search_date_end))  ORDER BY orcam.dt_orcam DESC
                                    LIMIT :limit OFFSET :offset", "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

                $this->resultBd = $listOrcam->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
                    $this->result = false;
                }
                //Se for 12 - Cliente Suporte
            } elseif ($_SESSION['adms_access_level_id'] == 14) {
                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_status={$this->searchStatus}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE (cliente_id = :cliente_id) and (status_id= :status_id) AND (dt_orcam BETWEEN :search_date_start AND :search_date_end)",
                    "cliente_id={$_SESSION['set_clie']}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
                );
                $this->resultPg = $pagination->getResult();

                $listOrcam = new \App\adms\Models\helper\AdmsRead();
                $listOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                                    orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                                    orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                                    FROM adms_orcam as orcam
                                    INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                                    INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                                    WHERE (orcam.cliente_id = :cliente_id ) and (orcam.status_id= :status_id) AND (orcam.dt_orcam BETWEEN :search_date_start AND :search_date_end)  ORDER BY orcam.dt_orcam DESC
                                    LIMIT :limit OFFSET :offset", "cliente_id={$_SESSION['set_clie']}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

                $this->resultBd = $listOrcam->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {
            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_status={$this->searchStatus}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE (status_id= :status_id) AND (dt_orcam BETWEEN :search_date_start AND :search_date_end)",
                "status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );;
            $this->resultPg = $pagination->getResult();

            $listOrcam = new \App\adms\Models\helper\AdmsRead();
            $listOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                                    orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                                    orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                                    FROM adms_orcam as orcam
                                    INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                                    INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                                    WHERE (orcam.status_id= :status_id) AND (orcam.dt_orcam BETWEEN :search_date_start AND :search_date_end) ORDER BY orcam.dt_orcam DESC
                                    LIMIT :limit OFFSET :offset", "status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listOrcam->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pela empresa e periodo
     * @return void
     */
    public function searchChamEmpDate(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {
                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_empresa={$this->searchEmpresa}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination("SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE (empresa_id = :empresa_id) AND (cliente_id = :cliente_id) AND (dt_orcam BETWEEN :search_date_start AND :search_date_end)",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
                );
                $this->resultPg = $pagination->getResult();

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                                    orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                                    orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                                    FROM adms_orcam as orcam
                                    INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                                    INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                                    WHERE (orcam.empresa_id = :empresa_id) AND (orcam.cliente_id = :cliente_id) AND (orcam.dt_orcam BETWEEN :search_date_start AND :search_date_end)
                                    ORDER BY orcam.dt_orcam DESC
                                    LIMIT :limit OFFSET :offset", "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_empresa={$this->searchEmpresa}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination(
                "SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam  WHERE (cliente_id= :cliente_id) AND (dt_orcam BETWEEN :search_date_start AND :search_date_end)",
                "cliente_id={$this->searchEmpresaValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultPg = $pagination->getResult();

            $listUsers = new \App\adms\Models\helper\AdmsRead();
            $listUsers->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                                    orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                                    orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                                    FROM adms_orcam as orcam
                                    INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                                    INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id 
                                    WHERE (orcam.cliente_id= :cliente_id) AND (orcam.dt_orcam BETWEEN :search_date_start AND :search_date_end)
                                    ORDER BY orcam.dt_orcam DESC
                                    LIMIT :limit OFFSET :offset", "cliente_id={$this->searchEmpresaValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listUsers->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pela empresas, status e periodo
     * @return void
     */
    public function searchChamEmpStatusDate(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {
            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {
                $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_empresa={$this->searchEmpresa}&search_status={$this->searchStatus}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
                $pagination->condition($this->page, $this->limitResult);
                $pagination->pagination(
                    "SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam WHERE (empresa_id = :empresa_id) AND (cliente_id = :cliente_id) AND (status_id= :status_id) AND (dt_orcam BETWEEN :search_date_start AND :search_date_end)",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
                );
                $this->resultPg = $pagination->getResult();

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                                    orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                                    orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                                    FROM adms_orcam as orcam
                                    INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                                    INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id 
                                    WHERE (orcam.empresa_id = :empresa_id) AND (orcam.cliente_id = :cliente_id) AND (orcam.status_id= :status_id) AND (orcam.dt_orcam BETWEEN :search_date_start AND :search_date_end)
                                    ORDER BY orcam.dt_orcam DESC
                                    LIMIT :limit OFFSET :offset", "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
                    $this->result = false;
                }
                //Se for 12 - Suporte Cliente
            }
        } else {

            $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-orcam/index', "?search_empresa={$this->searchEmpresa}&search_status={$this->searchStatus}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");
            $pagination->condition($this->page, $this->limitResult);
            $pagination->pagination(
                "SELECT COUNT(id) AS num_result, empresa_id, cliente_id, status_id FROM adms_orcam  WHERE (cliente_id= :cliente_id) AND (status_id= :status_id) AND (dt_orcam BETWEEN :search_date_start AND :search_date_end)",
                "cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultPg = $pagination->getResult();

            $listUsers = new \App\adms\Models\helper\AdmsRead();
            $listUsers->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                                    orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                                    orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                                    FROM adms_orcam as orcam
                                    INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                                    INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id
                                    WHERE (orcam.cliente_id= :cliente_id) AND (orcam.status_id= :status_id) AND (orcam.dt_orcam BETWEEN :search_date_start AND :search_date_end)
                                    ORDER BY orcam.dt_orcam DESC
                                    LIMIT :limit OFFSET :offset", "cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listUsers->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Orçamento encontrado!</p>";
                $this->result = false;
            }
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
            // Cliente Adm ou Suporte Cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $list = new \App\adms\Models\helper\AdmsRead();
                $list->fullRead("SELECT id, nome_fantasia FROM adms_clientes
                WHERE empresa= :empresa  ORDER BY nome_fantasia", "empresa={$_SESSION['emp_user']}");
                $registry['nome_clie'] = $list->getResult();

                $listSta = new \App\adms\Models\helper\AdmsRead();
                $listSta->fullRead("SELECT id, name FROM adms_orcam_status  ORDER BY name ASC");
                $registry['nome_status'] = $listSta->getResult();

                $this->listRegistryAdd = ['nome_clie' => $registry['nome_clie'], 'nome_status' => $registry['nome_status']];
                return $this->listRegistryAdd;
                // Cliente Final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {

                $listSta = new \App\adms\Models\helper\AdmsRead();
                $listSta->fullRead("SELECT id, name FROM adms_orcam_status  ORDER BY name ASC");
                $registry['nome_status'] = $listSta->getResult();

                $this->listRegistryAdd = ['nome_status' => $registry['nome_status']];
                return $this->listRegistryAdd;
            }
        } else {

            $list = new \App\adms\Models\helper\AdmsRead();

            $list->fullRead("SELECT id, nome_fantasia FROM adms_clientes ORDER BY nome_fantasia");
            $registry['nome_clie'] = $list->getResult();

            $list->fullRead("SELECT id, name FROM adms_orcam_status  ORDER BY name ASC");
            $registry['nome_status'] = $list->getResult();

            $this->listRegistryAdd = ['nome_clie' => $registry['nome_clie'], 'nome_status' => $registry['nome_status']];
            return $this->listRegistryAdd;
        }
    }
}
