<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar Contrato no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */

class AdmsEditContr
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;
    
    
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $listRegistryAdd;

    /** @var array Recebe as informações que serão usadas no dropdown do formulário*/
    private array $listRegistryEdit;

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
    public function viewContr(int $id): void
    {
        $this->id = $id;

        $viewContr = new \App\adms\Models\helper\AdmsRead();
        $viewContr->fullRead("SELECT cont.id, emp.nome_fantasia as nome_fantasia_emp, cont.clie_cont, 
        serv.name AS servico, cont.num_cont, cont.dt_inicio, cont.dt_term, sit.name AS situacao, typ.name AS tipo, cont.anexo, cont.obs, cont.modified
        FROM adms_contr AS cont 
        INNER JOIN adms_empresa AS emp ON emp.id=cont.clie_cont  
        INNER JOIN adms_contr_service AS serv ON serv.id=cont.service_id   
        INNER JOIN adms_contr_sit AS sit ON sit.id=cont.sit_cont   
        INNER JOIN adms_contr_type AS typ ON typ.id=cont.tipo_cont
        WHERE cont.id=:id
        LIMIT :limit", "id={$this->id}&limit=1");

        $this->resultBd = $viewContr->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Contrato  não encontrado!</p>";
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
    public function update(array $data = null): void
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
        $this->data['anexo'] = $_SESSION['anex_Contr'];
        $this->data['modified'] = date("Y-m-d H:i:s");

        $upContr = new \App\adms\Models\helper\AdmsUpdate();
        $upContr->exeUpdate("adms_contr", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upContr->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Contrato editado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Contrato não editado com sucesso!</p>";
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

        $list->fullRead("SELECT id id_service, name name_service FROM adms_contr_service ORDER BY name ASC");
        $registry['name_service'] = $list->getResult();

        $list->fullRead("SELECT id id_sit, name name_sit FROM adms_contr_sit ORDER BY name ASC");
        $registry['name_sit'] = $list->getResult();

        $list->fullRead("SELECT id id_tipo, name name_tipo FROM adms_contr_type ORDER BY name ASC");
        $registry['name_tipo'] = $list->getResult();

        $this->listRegistryEdit = ['name_service' => $registry['name_service'],
        'name_sit' => $registry['name_sit'], 'name_tipo' => $registry['name_tipo']];

        return $this->listRegistryEdit;
    }
}
