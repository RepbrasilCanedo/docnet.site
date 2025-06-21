<?php

namespace App\cpms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar marcas dos equipamentos do banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class CpmsRelatListCham
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
    private string|null $searchTipo;

    /** @var string|null $searchMarca Recebe o valor da marca*/
    private string|null $searchStatus;

    /** @var string|null $searchMarca Recebe o valor da marca*/
    private string|null $status_Cham;

    /** @var string|null $searchEmail Recebe o metodo */
    private string|null $searchIdValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchTipoValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchEmpresaValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchStatusValue;

    /** @var string|null $searchDateStart Recebe a data de inicio */
    private string|null $searchDateStart;

    /** @var string|null $searchDateEnd Recebe a data final */
    private string|null $searchDateEnd;

    /** @var string|null $searchDateEnd Recebe a data final */
    private string|null $searchTecSuporte;

    /** @var string|null $searchDateEnd Recebe a data final */
    private string|null $searchTecSuporteValue;

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
     * Metodo faz a pesquisa das Empresas na tabela "adms_cham" e lista as informações na view
     * Recebe como parametro "page" para fazer a paginação
     * @param integer|null $page
     * @return void
     */
    public function listCham(int $page = null): void
    {

        $listCham = new \App\adms\Models\helper\AdmsRead();
        $listCham->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                            WHERE empresa_id= :empresa_id and cliente_id= :id_cliente", "empresa_id={$_SESSION['emp_user']}&id_cliente={$_SESSION['set_clie']}");

        $this->resultBd = $listCham->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
           $_SESSION['msg'] = "<p class='alert-primary'>Alerta: Selecione uma opção para impressão de seu relatório!</p>";
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
    public function listSearchCham(int $page, string|null $search_empresa, string|null $search_status, string|null $search_Tipo, string|null $search_Date_Start, string|null $search_Date_End, string|null $search_Tec_Suporte): void
    {
        $this->page = (int) $page ? $page : 1;
        $this->searchEmpresa = $search_empresa;
        $this->searchStatus = $search_status;
        $this->searchTipo = $search_Tipo;
        $this->searchDateStart = $search_Date_Start;
        $this->searchDateEnd = $search_Date_End;
        $this->searchTecSuporte = $search_Tec_Suporte;

        $this->searchEmpresaValue = $this->searchEmpresa;
        $this->searchStatusValue = $this->searchStatus;
        $this->searchTipoValue = $this->searchTipo;
        $this->searchDateStartValue = $this->searchDateStart;
        $this->searchDateEndValue = $this->searchDateEnd;
        $this->searchTecSuporteValue = $this->searchTecSuporte;



        if ((!empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (empty($this->searchTipo)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd)) and (empty($this->searchTecSuporte))) {
            $this->searchEmpresa(); //So empresa
        } elseif ((!empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (!empty($this->searchTipo)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd)) and (empty($this->searchTecSuporte))) {
            $this->searchEmpresaTipoStatus(); // empresa - Status - Tipo
        } elseif ((!empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (!empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (empty($this->searchTecSuporte))) {
            $this->searchEmpresaTipoStatusDate(); // empresa - Status - Tipo - Periodo
        } elseif ((!empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (empty($this->searchTipo)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd)) and (empty($this->searchTecSuporte))) {
            $this->searchEmpresaStatus(); // empresa - Status - Tipo - Periodo
        } elseif ((empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (empty($this->searchTipo)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd)) and (empty($this->searchTecSuporte))) {
            $this->searchStatus(); //So status
        } elseif ((empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (empty($this->searchTecSuporte))) {
            $this->searchStatusDate(); //So status e periodo do Ticket
        } elseif ((empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (!empty($this->searchTipo)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd)) and (empty($this->searchTecSuporte))) {
            $this->searchTipo(); //So tipo do Ticket
        } elseif ((empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (!empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (empty($this->searchTecSuporte))) {
            $this->searchTipoDate(); //So tipo e periodo do Ticket
        } elseif ((empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (!empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (empty($this->searchTecSuporte))) {
            $this->searchTipoStatusDate(); //So status, tipó e periodo do Ticket
        } elseif ((!empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (!empty($this->searchTipo)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd)) and (empty($this->searchTecSuporte))) {
            $this->searchEmpresaTipo(); // empresa e tipo
        } elseif ((empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (!empty($this->searchTipo)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd)) and (empty($this->searchTecSuporte))) {
            $this->searchTipoStatus(); // status e tipo
        } elseif ((empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (empty($this->searchTecSuporte))) {
            $this->searchChamDate(); // periodo
        } elseif ((!empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (empty($this->searchTecSuporte))) {
            $this->searchChamEmpDate(); // empresa e periodo
        } elseif ((!empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (empty($this->searchTecSuporte))) {
            $this->searchChamEmpStatusDate(); // empresa, status e periodo
        } elseif ((!empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (!empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (empty($this->searchTecSuporte))) {
            $this->searchChamEmpTipoDate(); // empresa, tipo e periodo
        } elseif ((empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (empty($this->searchTipo)) and (empty($this->searchDateStart)) and (empty($this->searchDateEnd)) and (!empty($this->searchTecSuporte))) {
            $this->searchChamTecSuporte(); // Tecnico do suporte
        }  elseif ((!empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (!empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (!empty($this->searchTecSuporte))) {
            $this->searchChamEmpTipoStatusDateTec(); // Tecnico do suporte
        } elseif ((empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (!empty($this->searchTecSuporte))) {
            $this->searchChamDateTec(); // Tecnico do suporte
        } elseif ((empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (!empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (!empty($this->searchTecSuporte))) {
            $this->searchChamTipoDateTec(); // Tecnico do suporte
        } elseif ((empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (!empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (!empty($this->searchTecSuporte))) {
            $this->searchChamTipoStatusDateTec(); // Tecnico do suporte
        } elseif ((!empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (!empty($this->searchTecSuporte))) {
            $this->searchChamEmpDateTec(); // Tecnico do suporte
        } elseif ((!empty($this->searchEmpresa)) and (!empty($this->searchStatus)) and (empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (!empty($this->searchTecSuporte))) {
            $this->searchChamEmpStatusDateTec(); // Tecnico do suporte
        } elseif ((!empty($this->searchEmpresa)) and (empty($this->searchStatus)) and (!empty($this->searchTipo)) and (!empty($this->searchDateStart)) and (!empty($this->searchDateEnd)) and (!empty($this->searchTecSuporte))) {
            $this->searchChamEmpTipoDateTec(); // Tecnico do suporte
        }else {
            $this->listCham($this->page);
        }
    }
    /**
     * Metodo pesquisar pela empresa do Ticket
     * @return void
     */
    public function searchEmpresa(): void
    {
        $contCham = new \App\adms\Models\helper\AdmsRead();
        $contCham->fullRead("SELECT COUNT(id) AS num_result FROM adms_cham WHERE (empresa_id= :empresa_id) AND (cliente_id= :cliente_id)",
            "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}"
        );
        $this->resultBd = $contCham->getResult();
        if ($this->resultBd) {
            $_SESSION['resultado'] = '';
            $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
            $this->result = false;
        }

        $listCham = new \App\adms\Models\helper\AdmsRead();
                $listCham->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id 
                                    WHERE (cham.empresa_id= :empresa_id) AND (cham.cliente_id= :cliente_id)",
                                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}");


        $this->resultBd = $listCham->getResult();
        
        if ($this->resultBd) {
            $this->generatePdf();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo pesquisar pela empresa, status e tipo do Ticket
     * @return void
     */
    public function searchEmpresaTipoStatus(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou Suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {
                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead(
                    "SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND cliente_id= :cliente_id AND status_id= :status_id AND type_cham = :type_cham",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listCham = new \App\adms\Models\helper\AdmsRead();
                $listCham->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                        WHERE (cham.empresa_id= :empresa_id) AND (cham.cliente_id= :cliente_id) AND (cham.status_id= :status_id) AND (cham.type_cham= :type_cham) ORDER BY dt_cham",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}"
                );

                $this->resultBd = $listCham->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {
            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND status_id= :status_id AND type_cham = :type_cham",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listCham = new \App\adms\Models\helper\AdmsRead();
            $listCham->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                        WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham= :type_cham 
                        ", "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}");

            $this->resultBd = $listCham->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pela empresas, status, tipo  e periodo do Ticket
     * @return void
     */
    public function searchEmpresaTipoStatusDate(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou 12 - suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead(
                    "SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND cliente_id= :cliente_id AND status_id= :status_id AND type_cham = :type_cham AND dt_cham BETWEEN :search_date_start AND :search_date_end",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                WHERE (cham.empresa_id= :empresa_id) AND (cham.cliente_id= :cliente_id) AND (status_id= :status_id) AND (type_cham = :type_cham) AND (dt_cham BETWEEN :search_date_start AND :search_date_end)
                ORDER BY cham.dt_cham ASC", "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(cham.id) AS num_result FROM adms_cham cham WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listUsers = new \App\adms\Models\helper\AdmsRead();
            $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
            WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end
            ORDER BY cham.dt_cham ASC",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );

            $this->resultBd = $listUsers->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }
    /**
     * Metodo pesquisar pela empresa e status do Ticket
     * @return void
     */
    public function searchEmpresaStatus(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou 12 - suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead(
                    "SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND cliente_id= :cliente_id AND status_id= :status_id",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}"
                );

                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listCham = new \App\adms\Models\helper\AdmsRead();
                $listCham->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                WHERE (cham.empresa_id= :empresa_id) AND (cham.cliente_id= :cliente_id) AND (cham.status_id= :status_id)
                ORDER BY cham.dt_cham ASC", "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}");



                $this->resultBd = $listCham->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND status_id= :status_id",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listCham = new \App\adms\Models\helper\AdmsRead();
            $listCham->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                        ", "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}");

            $this->resultBd = $listCham->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }
    /**
     * Metodo pesquisar pelo status do Ticket
     * @return void
     */
    public function searchStatus(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou 12 - suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead("SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND status_id= :status_id",
                    "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}"
                );
                $this->resultBd = $contCham->getResult();
                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                 $listCham = new \App\adms\Models\helper\AdmsRead();
                $listCham->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id    
                                    WHERE (cham.empresa_id= :empresa_id) AND (cham.status_id= :status_id)
                                    ORDER BY cham.dt_cham ASC", "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}");


                $this->resultBd = $listCham->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead("SELECT COUNT(id) AS num_result FROM adms_cham WHERE status_id= :status_id", "status_id={$this->searchStatusValue}");
            $this->resultBd = $contCham->getResult();
            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listCham = new \App\adms\Models\helper\AdmsRead();
            $listCham->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                        WHERE cham.status_id= :status_id", "status_id={$this->searchStatusValue}");

            $this->resultBd = $listCham->getResult();

            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pelo status do Ticket e periodo
     * @return void
     */
    public function searchStatusDate(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou 12 - Suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead(
                    "SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND status_id= :status_id AND dt_cham BETWEEN :search_date_start AND :search_date_end",
                    "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                WHERE (cham.empresa_id= :empresa_id) AND (cham.status_id= :status_id) AND (cham.dt_cham BETWEEN :search_date_start AND :search_date_end)
                ORDER BY cham.dt_cham ASC", "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {
            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(id) AS num_result FROM adms_cham WHERE status_id= :status_id AND dt_cham BETWEEN :search_date_start AND :search_date_end",
                "status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listCham = new \App\adms\Models\helper\AdmsRead();
            $listCham->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                        WHERE cham.status_id= :status_id AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end
                        ", "status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

            $this->resultBd = $listCham->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pelo status, tipo e periodo do Ticket
     * @return void
     */
    public function searchTipoStatusDate(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead(
                    "SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND status_id= :status_id AND type_cham = :type_cham AND dt_cham BETWEEN :search_date_start AND :search_date_end",
                    "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                WHERE (cham.empresa_id= :empresa_id) AND (status_id= :status_id) AND (type_cham = :type_cham) AND (cham.dt_cham BETWEEN :search_date_start AND :search_date_end)
                ORDER BY cham.dt_cham ASC", "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {
            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(id) AS num_result FROM adms_cham WHERE status_id= :status_id AND type_cham = :type_cham AND dt_cham BETWEEN :search_date_start AND :search_date_end",
                "status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listCham = new \App\adms\Models\helper\AdmsRead();
            $listCham->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                        WHERE cham.status_id= :status_id AND cham.type_cham= :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end
                        ", "status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

            $this->resultBd = $listCham->getResult();

            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pelo tipo do Ticket
     * @return void
     */
    public function searchTipo(): void
    {

        if (($_SESSION['adms_access_level_id'] > 1) and ($_SESSION['adms_access_level_id'] <> 7) and ($_SESSION['adms_access_level_id'] <> 2)) {

            //Se for 4 - Cliente Administrativo
            if ($_SESSION['adms_access_level_id'] == 4) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead(
                    "SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND type_cham = :type_cham",
                    "empresa_id={$_SESSION['emp_user']}&type_cham={$this->searchTipoValue}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id   
                                    WHERE (cham.empresa_id= :empresa_id) AND (type_cham = :type_cham)
                                    ORDER BY cham.dt_cham ASC", "empresa_id={$_SESSION['emp_user']}&type_cham={$this->searchTipoValue}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(id) AS num_result FROM adms_cham WHERE type_cham = :type_cham",
                "type_cham={$this->searchTipo}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listCham = new \App\adms\Models\helper\AdmsRead();
            $listCham->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                        WHERE cham.type_cham= :type_cham 
                        ", "type_cham={$this->searchTipo}");

            $this->resultBd = $listCham->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pelo tipo do Ticket e periodo
     * @return void
     */
    public function searchTipoDate(): void
    {

        if (($_SESSION['adms_access_level_id'] > 1) and ($_SESSION['adms_access_level_id'] <> 7) and ($_SESSION['adms_access_level_id'] <> 2)) {

            //Se for 4 - Cliente Administrativo ou suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead(
                    "SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND type_cham = :type_cham AND dt_cham BETWEEN :search_date_start AND :search_date_end",
                    "empresa_id={$_SESSION['emp_user']}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                WHERE (cham.empresa_id= :empresa_id) AND (type_cham = :type_cham) AND (cham.dt_cham BETWEEN :search_date_start AND :search_date_end)
                ORDER BY cham.dt_cham ASC", "empresa_id={$_SESSION['emp_user']}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(id) AS num_result FROM adms_cham WHERE type_cham = :type_cham AND dt_cham BETWEEN :search_date_start AND :search_date_end",
                "type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listCham = new \App\adms\Models\helper\AdmsRead();
            $listCham->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                        WHERE cham.type_cham= :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end ORDER BY cham.dt_cham 
                        ", "type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

            $this->resultBd = $listCham->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }


    /**
     * Metodo pesquisar pela empresa e pelo tipo do Ticket
     * @return void
     */
    public function searchEmpresaTipo(): void
    {

        if (($_SESSION['adms_access_level_id'] > 2) and ($_SESSION['adms_access_level_id'] <> 7)) {

            //Se for 4 - Cliente Administrativo ou suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead(
                    "SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND cliente_id= :cliente_id AND type_cham = :type_cham",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&type_cham={$this->searchTipoValue}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                WHERE (cham.empresa_id= :empresa_id) AND (cham.cliente_id= :cliente_id) AND (cham.type_cham = :type_cham)
                ORDER BY cham.dt_cham ASC", "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&type_cham={$this->searchTipoValue}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND type_cham = :type_cham",
                "empresa_id={$this->searchEmpresaValue}&type_cham={$this->searchTipoValue}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listCham = new \App\adms\Models\helper\AdmsRead();
            $listCham->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id    
                        WHERE cham.empresa_id= :empresa_id AND cham.type_cham= :type_cham
                        ", "empresa_id={$this->searchEmpresaValue}&type_cham={$this->searchTipoValue}");

            $this->resultBd = $listCham->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pelo status e tipo  do Ticket
     * @return void
     */
    public function searchTipoStatus(): void
    {

        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead(
                    "SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND status_id= :status_id AND type_cham = :type_cham",
                    "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                WHERE (cham.empresa_id= :empresa_id)  AND (cham.status_id= :status_id) AND (cham.type_cham = :type_cham)
                ORDER BY cham.dt_cham ASC", "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(id) AS num_result FROM adms_cham WHERE status_id= :status_id AND type_cham = :type_cham",
                "status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listCham = new \App\adms\Models\helper\AdmsRead();
            $listCham->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                        WHERE cham.status_id= :status_id AND cham.type_cham= :type_cham 
                        ", "status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}");

            $this->resultBd = $listCham->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
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
        if (($_SESSION['adms_access_level_id'] > 2) and ($_SESSION['adms_access_level_id'] <> 7)) {

            //Se for 4 - Cliente Administrativo ou suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 4)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead(
                    "SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND cliente_id= :cliente_id AND status_id= :status_id AND type_cham = :type_cham AND dt_cham BETWEEN :search_date_start AND :search_date_end",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                WHERE (cham.empresa_id= :empresa_id) AND (cham.cliente_id= :cliente_id) AND (cham.dt_cham BETWEEN :search_date_start AND :search_date_end)
                ORDER BY cham.dt_cham ASC", "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(cham.id) AS num_result FROM adms_cham cham WHERE cham.empresa_id= :empresa_id AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end",
                "empresa_id={$this->searchEmpresaValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listUsers = new \App\adms\Models\helper\AdmsRead();
            $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id   
            WHERE cham.empresa_id= :empresa_id AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end
            ORDER BY cham.dt_cham ASC
            ", "empresa_id={$this->searchEmpresaValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

            $this->resultBd = $listUsers->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
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
        if (($_SESSION['adms_access_level_id'] > 2) and ($_SESSION['adms_access_level_id'] <> 7)) {

            //Se for 4 - Cliente Administrativo ou suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 4)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead(
                    "SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND cliente_id= :cliente_id AND status_id= :status_id AND dt_cham BETWEEN :search_date_start AND :search_date_end",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                WHERE (cham.empresa_id= :empresa_id) AND (cham.cliente_id= :cliente_id) AND (cham.status_id= :status_id) AND (cham.dt_cham BETWEEN :search_date_start AND :search_date_end)
                ORDER BY cham.dt_cham ASC", "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(cham.id) AS num_result FROM adms_cham cham WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listUsers = new \App\adms\Models\helper\AdmsRead();
            $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id   
            WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end
            ORDER BY cham.dt_cham ASC
            ", "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

            $this->resultBd = $listUsers->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pela empresas, tipo  e periodo do Ticket
     * @return void
     */
    public function searchChamEmpTipoDate(): void
    {
        if (($_SESSION['adms_access_level_id'] > 2) and ($_SESSION['adms_access_level_id'] <> 7)) {

            //Se for 4 - Cliente Administrativo ou suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead(
                    "SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND cliente_id= :cliente_id AND type_cham = :type_cham AND dt_cham BETWEEN :search_date_start AND :search_date_end",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id    
                WHERE (cham.empresa_id= :empresa_id) AND (cham.cliente_id= :cliente_id) AND (cham.type_cham = :type_cham) AND (cham.dt_cham BETWEEN :search_date_start AND :search_date_end)
                ORDER BY cham.dt_cham ASC", "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresaValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(cham.id) AS num_result FROM adms_cham cham WHERE cham.empresa_id= :empresa_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end",
                "empresa_id={$this->searchEmpresaValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listUsers = new \App\adms\Models\helper\AdmsRead();
            $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id   
            WHERE cham.empresa_id= :empresa_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end
            ORDER BY cham.dt_cham ASC
            ", "empresa_id={$this->searchEmpresaValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

            $this->resultBd = $listUsers->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
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
        if (($_SESSION['adms_access_level_id'] > 2) and ($_SESSION['adms_access_level_id'] <> 7)) {

            //Se for 4 - Cliente Administrativo ou suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)){

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead("SELECT COUNT(id) AS num_result FROM adms_cham WHERE empresa_id= :empresa_id AND dt_cham BETWEEN :search_date_start AND :search_date_end",
                    "empresa_id={$_SESSION['emp_user']}&search_date_end={$this->searchDateEnd}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                WHERE (cham.empresa_id= :empresa_id) AND (cham.dt_cham BETWEEN :search_date_start AND :search_date_end)
                ORDER BY cham.dt_cham ASC", "empresa_id={$_SESSION['emp_user']}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(cham.id) AS num_result FROM adms_cham cham WHERE cham.dt_cham BETWEEN :search_date_start AND :search_date_end",
                "search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listUsers = new \App\adms\Models\helper\AdmsRead();
            $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id   
            WHERE cham.dt_cham BETWEEN :search_date_start AND :search_date_end
            ORDER BY cham.dt_cham ASC
            ", "search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}");

            $this->resultBd = $listUsers->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }
    /**
     * Metodo pesquisar pela tecnico de suporte do cliente
     * @return void
     */
    public function searchChamTecSuporte(): void
    {
        $contCham = new \App\adms\Models\helper\AdmsRead();
        $contCham->fullRead("SELECT COUNT(id) AS num_result FROM adms_cham WHERE (empresa_id= :empresa_id) AND (suporte_id= :suporte_id)",
            "empresa_id={$_SESSION['emp_user']}&suporte_id={$this->searchTecSuporte}"
        );
        $this->resultBd = $contCham->getResult();
        if ($this->resultBd) {
            $_SESSION['resultado'] = '';
            $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
            $this->result = false;
        }

        $listCham = new \App\adms\Models\helper\AdmsRead();
        $listCham->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id                                  
                                    WHERE (cham.empresa_id= :empresa_id) AND (cham.suporte_id= :suporte_id)",
                                    "empresa_id={$_SESSION['emp_user']}&suporte_id={$this->searchTecSuporte}");

        $this->resultBd = $listCham->getResult();
        if ($this->resultBd) {
            $this->generatePdf();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrados!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo pesquisar pela empresas, status, tipo  e periodo do Ticket e suporte do cliente.
     * @return void
     */
    public function searchChamEmpTipoStatusDateTec(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou 12 - suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead("SELECT COUNT(id) AS num_result FROM adms_cham WHERE (empresa_id= :empresa_id) AND (cliente_id= :cliente_id) AND (status_id= :status_id) AND (type_cham = :type_cham) AND (dt_cham BETWEEN :search_date_start AND :search_date_end) AND (suporte_id= :suporte_id)",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresa}&status_id={$this->searchStatus}&type_cham={$this->searchTipo}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&suporte_id={$this->searchTecSuporte}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id   
                                    WHERE (cham.empresa_id= :empresa_id) AND (cham.cliente_id= :cliente_id) AND (cham.status_id= :status_id) AND (cham.type_cham = :type_cham) AND (cham.dt_cham BETWEEN :search_date_start AND :search_date_end) AND (cham.suporte_id= :suporte_id)", 
                                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresa}&status_id={$this->searchStatus}&type_cham={$this->searchTipo}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&suporte_id={$this->searchTecSuporte}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(cham.id) AS num_result FROM adms_cham cham WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listUsers = new \App\adms\Models\helper\AdmsRead();
            $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
            WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end
            ORDER BY cham.dt_cham ASC",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );

            $this->resultBd = $listUsers->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pelo periodo do Ticket e suporte do cliente.
     * @return void
     */
    public function searchChamDateTec(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou 12 - suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead("SELECT COUNT(id) AS num_result FROM adms_cham WHERE (empresa_id= :empresa_id) AND (dt_cham BETWEEN :search_date_start AND :search_date_end) AND (suporte_id= :suporte_id)",
                    "empresa_id={$_SESSION['emp_user']}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&suporte_id={$this->searchTecSuporte}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id   
                                    WHERE (cham.empresa_id= :empresa_id) AND (cham.dt_cham BETWEEN :search_date_start AND :search_date_end) AND (cham.suporte_id= :suporte_id)", 
                                    "empresa_id={$_SESSION['emp_user']}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&suporte_id={$this->searchTecSuporte}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(cham.id) AS num_result FROM adms_cham cham WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listUsers = new \App\adms\Models\helper\AdmsRead();
            $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
            WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end
            ORDER BY cham.dt_cham ASC",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );

            $this->resultBd = $listUsers->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pelo tipo  e periodo do Ticket e suporte do cliente.
     * @return void
     */
    public function searchChamTipoDateTec(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou 12 - suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead("SELECT COUNT(id) AS num_result FROM adms_cham WHERE (empresa_id= :empresa_id) AND (type_cham = :type_cham) AND (dt_cham BETWEEN :search_date_start AND :search_date_end) AND (suporte_id= :suporte_id)",
                    "empresa_id={$_SESSION['emp_user']}&type_cham={$this->searchTipo}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&suporte_id={$this->searchTecSuporte}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id   
                                    WHERE (cham.empresa_id= :empresa_id) AND (cham.type_cham = :type_cham) AND (cham.dt_cham BETWEEN :search_date_start AND :search_date_end) AND (cham.suporte_id= :suporte_id)", 
                                    "empresa_id={$_SESSION['emp_user']}&type_cham={$this->searchTipo}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&suporte_id={$this->searchTecSuporte}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(cham.id) AS num_result FROM adms_cham cham WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listUsers = new \App\adms\Models\helper\AdmsRead();
            $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id    
            WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end
            ORDER BY cham.dt_cham ASC",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );

            $this->resultBd = $listUsers->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pelo status, tipo  e periodo do Ticket e suporte do cliente.
     * @return void
     */
    public function searchChamTipoStatusDateTec(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou 12 - suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead("SELECT COUNT(id) AS num_result FROM adms_cham WHERE (empresa_id= :empresa_id) AND (status_id= :status_id) AND (type_cham = :type_cham) AND (dt_cham BETWEEN :search_date_start AND :search_date_end) AND (suporte_id= :suporte_id)",
                    "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatus}&type_cham={$this->searchTipo}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&suporte_id={$this->searchTecSuporte}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id   
                                    WHERE (cham.empresa_id= :empresa_id) AND (cham.status_id= :status_id) AND (cham.type_cham = :type_cham) AND (cham.dt_cham BETWEEN :search_date_start AND :search_date_end) AND (cham.suporte_id= :suporte_id)", 
                                    "empresa_id={$_SESSION['emp_user']}&status_id={$this->searchStatus}&type_cham={$this->searchTipo}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&suporte_id={$this->searchTecSuporte}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(cham.id) AS num_result FROM adms_cham cham WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listUsers = new \App\adms\Models\helper\AdmsRead();
            $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
            WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end
            ORDER BY cham.dt_cham ASC",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );

            $this->resultBd = $listUsers->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pela empresas, periodo do Ticket e suporte do cliente.
     * @return void
     */
    public function searchChamEmpDateTec(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou 12 - suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead("SELECT COUNT(id) AS num_result FROM adms_cham WHERE (empresa_id= :empresa_id) AND (cliente_id= :cliente_id) AND (dt_cham BETWEEN :search_date_start AND :search_date_end) AND (suporte_id= :suporte_id)",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresa}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&suporte_id={$this->searchTecSuporte}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                                    WHERE (empresa_id= :empresa_id) AND (cliente_id= :cliente_id) AND (dt_cham BETWEEN :search_date_start AND :search_date_end) AND (suporte_id= :suporte_id)", 
                                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresa}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&suporte_id={$this->searchTecSuporte}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(cham.id) AS num_result FROM adms_cham cham WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listUsers = new \App\adms\Models\helper\AdmsRead();
            $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
            WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end
            ORDER BY cham.dt_cham ASC",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );

            $this->resultBd = $listUsers->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pela empresas, status, tipo  e periodo do Ticket e suporte do cliente.
     * @return void
     */
    public function searchChamEmpStatusDateTec(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou 12 - suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead("SELECT COUNT(id) AS num_result FROM adms_cham WHERE (empresa_id= :empresa_id) AND (cliente_id= :cliente_id) AND (status_id= :status_id) AND (dt_cham BETWEEN :search_date_start AND :search_date_end) AND (suporte_id= :suporte_id)",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresa}&status_id={$this->searchStatus}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&suporte_id={$this->searchTecSuporte}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id   
                                    WHERE (empresa_id= :empresa_id) AND (cliente_id= :cliente_id) AND (status_id= :status_id) AND (dt_cham BETWEEN :search_date_start AND :search_date_end) AND (suporte_id= :suporte_id)", 
                                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresa}&status_id={$this->searchStatus}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&suporte_id={$this->searchTecSuporte}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(cham.id) AS num_result FROM adms_cham cham WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listUsers = new \App\adms\Models\helper\AdmsRead();
            $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id   
            WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end
            ORDER BY cham.dt_cham ASC",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );

            $this->resultBd = $listUsers->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo pesquisar pela empresas, tipo  e periodo do Ticket e suporte do cliente.
     * @return void
     */
    public function searchChamEmpTipoDateTec(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo ou 12 - suporte do cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $contCham = new \App\adms\Models\helper\AdmsRead();
                $contCham->fullRead("SELECT COUNT(id) AS num_result FROM adms_cham WHERE (empresa_id= :empresa_id) AND (cliente_id= :cliente_id) AND (type_cham = :type_cham) AND (dt_cham BETWEEN :search_date_start AND :search_date_end) AND (suporte_id= :suporte_id)",
                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresa}&type_cham={$this->searchTipo}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&suporte_id={$this->searchTecSuporte}"
                );
                $this->resultBd = $contCham->getResult();

                if ($this->resultBd) {
                    $_SESSION['resultado'] = '';
                    $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                    $this->result = false;
                }

                $listUsers = new \App\adms\Models\helper\AdmsRead();
                $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                                    WHERE (empresa_id= :empresa_id) AND (cliente_id= :cliente_id) AND (type_cham = :type_cham) AND (dt_cham BETWEEN :search_date_start AND :search_date_end) AND (suporte_id= :suporte_id)", 
                                    "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresa}&type_cham={$this->searchTipo}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}&suporte_id={$this->searchTecSuporte}");

                $this->resultBd = $listUsers->getResult();
                if ($this->resultBd) {
                    $this->generatePdf();
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {

            $contCham = new \App\adms\Models\helper\AdmsRead();
            $contCham->fullRead(
                "SELECT COUNT(cham.id) AS num_result FROM adms_cham cham WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );
            $this->resultBd = $contCham->getResult();

            if ($this->resultBd) {
                $_SESSION['resultado'] = '';
                $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum contrato encontrado!</p>";
                $this->result = false;
            }

            $listUsers = new \App\adms\Models\helper\AdmsRead();
            $listUsers->fullRead("SELECT cham.id as id_cham, princ.logo as logo_princ, cham.empresa_id as empresa_id_cham, clie.nome_fantasia as nome_fantasia_emp, cham.contato as contato_cham, cham.tel_contato as tel_contato_cham, 
                                    cham.dt_cham as dt_cham_cham, sta.name AS name_sta_cham, cham.dt_status as dt_status_cham, cham.type_cham as type_cham_cham, user.name as name_user
                                    FROM adms_cham AS cham
                                    INNER JOIN adms_emp_principal AS princ ON princ.id=cham.empresa_id 
                                    INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                                    INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id
                                    INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
            WHERE cham.empresa_id= :empresa_id AND cham.status_id= :status_id AND cham.type_cham = :type_cham AND cham.dt_cham BETWEEN :search_date_start AND :search_date_end
            ORDER BY cham.dt_cham ASC",
                "empresa_id={$this->searchEmpresaValue}&status_id={$this->searchStatusValue}&type_cham={$this->searchTipoValue}&search_date_start={$this->searchDateStart}&search_date_end={$this->searchDateEnd}"
            );

            $this->resultBd = $listUsers->getResult();
            if ($this->resultBd) {
                $this->generatePdf();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
                $this->result = false;
            }
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

        if ($_SESSION['adms_access_level_id'] > 2) {

            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $list->fullRead("SELECT id id_emp, nome_fantasia nome_fantasia_emp FROM adms_clientes as emp
                WHERE empresa= :empresa ORDER BY nome_fantasia", "empresa={$_SESSION['emp_user']}");
                $registry['nome_emp'] = $list->getResult();

                $list = new \App\adms\Models\helper\AdmsRead();
                $list->fullRead("SELECT id, name FROM adms_cham_status  ORDER BY name ASC");
                $registry['nome_status'] = $list->getResult();

                $list = new \App\adms\Models\helper\AdmsRead();
                $list->fullRead("SELECT id, name FROM adms_users
                WHERE empresa_id= :empresa and adms_access_level_id > {$_SESSION['adms_access_level_id']} ORDER BY name", "empresa={$_SESSION['emp_user']}");
                $registry['nome_emp_user'] = $list->getResult();

                $this->listRegistryAdd = ['nome_emp' => $registry['nome_emp'], 'nome_status' => $registry['nome_status'], 'nome_emp_user' => $registry['nome_emp_user']];
                return $this->listRegistryAdd;
            }
        } else {
            $list->fullRead("SELECT id id_emp, nome_fantasia nome_fantasia_emp FROM adms_empresa as emp  
            ORDER BY nome_fantasia ASC");
            $registry['nome_emp'] = $list->getResult();

            $list->fullRead("SELECT id, name FROM adms_cham_status  ORDER BY name ASC");
            $registry['nome_status'] = $list->getResult();

            $list->fullRead("SELECT id, name FROM adms_cham_type  ORDER BY name ASC");
            $registry['nome_type'] = $list->getResult();

            $this->listRegistryAdd = ['nome_emp' => $registry['nome_emp'], 'nome_status' => $registry['nome_status'], 'nome_type' => $registry['nome_type']];
        }
        return $this->listRegistryAdd;
    }


    // Função para gerar os dados para o pdf em DOMPDF
    private function generatePdf()
    {      
        
        $total_tickets = $_SESSION['resultado'];
        unset( $_SESSION['resultado']);

        $image_clie=($this->resultBd[0]['empresa_id_cham']);
        $logo_clie=($this->resultBd[0]['logo_princ']);
      
        $html = "<style> table {border-collapse: collapse;width: 100%;}th, td {border: 1px solid black;padding: 2px;text-align: left;} caption{padding: 8px;text-align: center;}</style>";
        $html .= "<img src='" . URLADM . "app/adms/assets/image/logo/clientes/$image_clie/$logo_clie' width='70' alt='Logo do Cliente'";
        $html .= "<table>";
        $html .= "<caption><b> RELATORIO DE TICKETS DOCNET HELP DESK </b>";
        $html .= "<caption>Total de : <b> {$total_tickets} </b> Ticket.";
        $html .= "<thead>";
        $html .= "<th>Ticket</th>";
        $html .= "<th>Cliente</th>";
        $html .= "<th>Contato</th>";
        $html .= "<th>Telefone</th>";
        $html .= "<th>Colaborador</th>";
        $html .= "<th>Data Ticket</th>";
        $html .= "<th>Status Atual</th>";
        $html .= "<th>Tipo</th>";
        $html .= "</thead>";

        foreach ($this->resultBd as $user) {
        extract($user);  
        
            $html .= "<tbody>";
            $html .= "<td>$id_cham</td>";
            $html .= "<td>$nome_fantasia_emp</td>";
            $html .= "<td>$contato_cham</td>";
            $html .= "<td>$tel_contato_cham</td>";
            $html .= "<td>$name_user</td>";
            $dt_cham_formatada = date('d/m/Y', strtotime($dt_cham_cham));
            $html .= "<td>$dt_cham_formatada</td>";
            $html .= "<td>$name_sta_cham</td>";
            $html .= "<td>$type_cham_cham</td>";
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
