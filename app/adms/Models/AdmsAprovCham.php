<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar cor no banco de dados
 *
* @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsAprovCham
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

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
    public function viewAprovCham(int $id): void
    {
        $this->id = $id;

        $viewCham = new \App\adms\Models\helper\AdmsRead();
        $viewCham->fullRead("SELECT id, status_id, dt_status, fech_cham, nota_atend, motivo_repr, modified FROM adms_cham  
        WHERE id= :cham_id and status_id <>9 LIMIT :limit", "cham_id={$this->id}&limit=1");

        $this->resultBd = $viewCham->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado  não se encontra FINALIZADO!</p>";
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
     * Metodo recebe como parametro a informação que será editada
     * Instancia o helper AdmsValEmptyField para validar os campos do formulário
     * Chama a função edit para enviar as informações para o banco de dados
     * @param array|null $data
     * @return void
     */
    public function updateReprov(array $data = null): void
    {
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->editReprov();
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
        $this->data['status_id'] = 8;
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['fech_cham']=date("Y-m-d H:i:s");
        $this->data['modified'] = date("Y-m-d H:i:s");

        $upCham = new \App\adms\Models\helper\AdmsUpdate();
        $upCham->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Chamado Validado sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado Não Avaliado com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function editReprov(): void
    { 
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 7;
        $this->data['dt_status'] = date("Y-m-d H:i:s");

        $upCham = new \App\adms\Models\helper\AdmsUpdate();
        $upCham->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Chamado Avaliado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado Não Avaliado com sucesso!</p>";
            $this->result = false;
        }
    }
}
