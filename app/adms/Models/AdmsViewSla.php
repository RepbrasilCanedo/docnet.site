<?php

namespace App\adms\Models;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar cor no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsViewSla
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    /**
     * Metodo para visualizar os detalhes da cor
     * Recebe o ID da cor que será usado como parametro na pesquisa
     * Retorna FALSE se houver algum erro.
     * @param integer $id
     * @return void
     */
    public function viewSla(int $id): void
    {
        $this->id = $id;

        $viewSla = new \App\adms\Models\helper\AdmsRead();
        $viewSla->fullRead("SELECT sla.id as id_sla, sla.name, emp.nome_fantasia as nome_fantasia_emp, sla.prim_resp as prim_resp_sla, sla.final_resp as final_resp_sla, typ.name as name_typ, prio.name as name_prio, temp.name as name_temp, sla.tempo_horas_sla_id, 
                            ativ.name as name_ativ, sla.obs as obs_sla FROM adms_sla as sla
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla.empresa_id
                            INNER JOIN adms_tipo_ocorr AS typ ON typ.id=sla.tipo_ocorr_id
                            INNER JOIN adms_prioridade AS prio ON prio.id=sla.prioridade_id
                            INNER JOIN adms_tempo_sla AS temp ON temp.id=sla.tempo_nome_sla_id
                            INNER JOIN adms_atividade AS ativ ON ativ.id=sla.atividade_id 
                            WHERE sla.id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewSla->getResult();        
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Sla não encontrada!</p>";
            $this->result = false;
        }
    }
}
