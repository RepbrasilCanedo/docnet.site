<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar sla no banco de dados
 *
* @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsEditSla
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array Recebe as informações que serão usadas no dropdown do formulário*/
    private array $listRegistryAdd;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

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
     * Metodo recebe como parametro o ID que será usado para verificar se tem o registro cadastrado no banco de dados
     * @param integer $id
     * @return void
     */
    public function editSla(int $id): void
    {
        $this->id = $id;

        $editSla = new \App\adms\Models\helper\AdmsRead();
        $editSla->fullRead("SELECT sla.id as id_sla, sla.name, emp.nome_fantasia as nome_fantasia_emp, sla.prim_resp as prim_resp_sla, sla.final_resp as final_resp_sla, typ.name as name_typ, prio.name as name_prio, temp.name as name_temp, sla.tempo_horas_sla_id, 
                            ativ.name as name_ativ, sla.obs as obs_sla FROM adms_sla as sla
                            INNER JOIN adms_emp_principal AS emp ON emp.id=sla.empresa_id
                            INNER JOIN adms_tipo_ocorr AS typ ON typ.id=sla.tipo_ocorr_id
                            INNER JOIN adms_prioridade AS prio ON prio.id=sla.prioridade_id
                            INNER JOIN adms_tempo_sla AS temp ON temp.id=sla.tempo_nome_sla_id
                            INNER JOIN adms_atividade AS ativ ON ativ.id=sla.atividade_id 
                            WHERE sla.id=:id LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $editSla->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: sla não encontrada!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo recebe como parametro a informação que será editada
     * Instancia o helper AdmsValEmptyField para validar os campos do formulário
     * Chama a função edit para enviar as informações para o banco de dados
     * @param array|null $data
     * @return void
     */
    public function update(array $data): void
    {
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->edit();
        } else {
            $this->result = false;
        }
    }

    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function edit(): void
    {
        $this->data['empresa_id'] = $_SESSION['emp_user'];
        $this->data['modified'] = date("Y-m-d H:i:s");
        var_dump($this->data);

        $upColor = new \App\adms\Models\helper\AdmsUpdate();
        $upColor->exeUpdate("adms_sla", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upColor->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>sla editada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: sla não editada com sucesso!</p>";
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

                $list->fullRead("SELECT id as id_typ, name as name_typ, empresa_id FROM adms_tipo_ocorr as typ WHERE empresa_id= :empresa_id", "empresa_id={$_SESSION['emp_user']}");
                $registry['type_sla'] = $list->getResult();

                $list->fullRead("SELECT id id_prior, name name_prior, empresa_id FROM adms_prioridade as prior WHERE empresa_id= :empresa_id", "empresa_id={$_SESSION['emp_user']}");
                $registry['prior_sla'] = $list->getResult();

                $list->fullRead("SELECT id id_temp, name name_temp, tempo, empresa_id FROM adms_tempo_sla as temp WHERE empresa_id= :empresa_id", "empresa_id={$_SESSION['emp_user']}");
                $registry['temp_sla'] = $list->getResult();

                $list->fullRead("SELECT id id_ativ, name name_ativ, empresa_id FROM adms_atividade as ativ WHERE empresa_id= :empresa_id", "empresa_id={$_SESSION['emp_user']}");
                $registry['ativ_sla'] = $list->getResult();


                $this->listRegistryAdd = [
                    'type_sla' => $registry['type_sla'],
                    'prior_sla' => $registry['prior_sla'],
                    'temp_sla' => $registry['temp_sla'],
                    'ativ_sla' => $registry['ativ_sla']
                ];
                
        return $this->listRegistryAdd;
    } 

    

}
