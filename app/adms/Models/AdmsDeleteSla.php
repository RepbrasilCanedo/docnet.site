<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Apagar cor no banco de dados
 *
* @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsDeleteSla
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Metodo recebe como parametro o ID do registro que será excluido
     * Chama as funções viewSit e checkColorUsed para fazer a confirmação do registro antes de excluir
     * @param integer $id
     * @return void
     */
    public function deleteSla(int $id): void
    {
        $this->id = (int) $id;

        if (($this->viewSla()) and ($this->checkSlaUsed())) {
            $deleteSla = new \App\adms\Models\helper\AdmsDelete();
            $deleteSla->exeDelete("adms_sla", "WHERE id =:id", "id={$this->id}");

            if ($deleteSla->getResult()) {
                $_SESSION['msg'] = "<p class='alert-success'>Sla apagada com sucesso!</p>";
                $this->result = true;
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Sla não apagada com sucesso!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /**
     * Metodo verifica se a sla esta cadastrada na tabela e envia o resultado para a função deleteSla
     * @return boolean
     */
    private function viewSla(): bool
    {

        $viewColor = new \App\adms\Models\helper\AdmsRead();
        $viewColor->fullRead("SELECT sla.id as id_sla, sla.name, emp.nome_fantasia as nome_fantasia_emp, typ.name as name_typ, prio.name as name_prio, temp.name as name_temp, sla.tempo_horas_sla_id, 
                            ativ.name as name_ativ, sla.obs as obs_sla FROM adms_sla as sla
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla.empresa_id
                            INNER JOIN adms_tipo_ocorr AS typ ON typ.id=sla.tipo_ocorr_id
                            INNER JOIN adms_prioridade AS prio ON prio.id=sla.prioridade_id
                            INNER JOIN adms_tempo_sla AS temp ON temp.id=sla.tempo_nome_sla_id
                            INNER JOIN adms_atividade AS ativ ON ativ.id=sla.atividade_id 
                            WHERE sla.id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewColor->getResult();
        if ($this->resultBd) {
            return true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Cor não encontrada!</p>";
            return false;
        }
    }

    /**
     * Metodo verifica se tem chamado cadastrados usando a sla a ser excluida, caso tenha a exclusão não é permitida
     * O resultado da pesquisa é enviada para a função deleteSla
     * @return boolean
     */
    private function checkSlaUsed(): bool
    {
        $viewColorUsed = new \App\adms\Models\helper\AdmsRead();
        $viewColorUsed->fullRead("SELECT id, sla_id FROM adms_cham WHERE sla_id =:sla_id  LIMIT :limit", "sla_id={$this->id}&limit=1");
        if ($viewColorUsed->getResult()) {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: SLA não pode ser apagada, há chamado cadastrado com essa SLA!</p>";
            return false;
        } else {
            return true;
        }
    }
}
