<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar sla no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsAddSla
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    private array $listRegistryAdd;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /** 
     * Recebe os valores do formulário.
     * Instancia o helper "AdmsValEmptyField" para verificar se todos os campos estão preenchidos 
     * Verifica se todos os campos estão preenchidos e instancia o método "valInput" para validar os dados dos campos
     * Retorna FALSE quando algum campo está vazio
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function create(array $data): void
    {
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->add();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Cadastrar cor no banco de dados
     * Retorna TRUE quando cadastrar a cor com sucesso
     * Retorna FALSE quando não cadastrar a cor
     * 
     * @return void
     */
    private function add(): void
    {       
        date_default_timezone_set('America/Bahia');

        $this->data['empresa_id'] = $_SESSION['emp_user'];
        $this->data['created'] = date("Y-m-d H:i:s");
        
        
        $createSla = new \App\adms\Models\helper\AdmsCreate();
        $createSla->exeCreate("adms_sla", $this->data);

        if ($createSla->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Sla cadastrada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Sla não cadastrada com sucesso!</p>";
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

                $list->fullRead("SELECT id id_temp, name name_temp, empresa_id FROM adms_tempo_sla as temp WHERE empresa_id= :empresa_id", "empresa_id={$_SESSION['emp_user']}");
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
