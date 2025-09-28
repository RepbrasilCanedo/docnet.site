<?php

namespace App\adms\Models;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar sla do banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsListSla
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

    /** @var string|null $searchName Recebe o nome da cor */
    private string|null $searchName;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchSla;

    /** @var string|null $searchName Recebe o nome da cor */
    private string|null $searchNameValue;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchSlaValue;

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
     * Metodo faz a pesquisa das cores na tabela "adms_colors" e lista as informações na view
     * Recebe como parametro "page" para fazer a paginação
     * @param integer|null $page
     * @return void
     */
    public function listSla(int $page):void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-sla/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(col.id) AS num_result FROM adms_sla AS col");
        $this->resultPg = $pagination->getResult();

        $listSla = new \App\adms\Models\helper\AdmsRead();
        $listSla->fullRead("SELECT sla.id as id_sla, sla.name, emp.nome_fantasia as nome_fantasia_emp, sla.prim_resp as prim_resp_sla, 
        sla.final_resp as final_resp_sla, typ.name as name_typ, prio.name as name_prio, temp.name as name_temp, sla.tempo_horas_sla_id, 
                            ativ.name as name_ativ, sla.obs as obs_sla FROM adms_sla as sla
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla.empresa_id
                            INNER JOIN adms_tipo_ocorr AS typ ON typ.id=sla.tipo_ocorr_id
                            INNER JOIN adms_prioridade AS prio ON prio.id=sla.prioridade_id
                            INNER JOIN adms_tempo_sla AS temp ON temp.id=sla.tempo_nome_sla_id
                            INNER JOIN adms_atividade AS ativ ON ativ.id=sla.atividade_id
                            LIMIT :limit OFFSET :offset", "limit={$this->limitResult}&offset={$pagination->getOffset()}");

        $this->resultBd = $listSla->getResult();        
        if($this->resultBd){
            $this->result = true;
        }else{
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma Sla encontrado!</p>";
            $this->result = false;
        }
    }

    
}
