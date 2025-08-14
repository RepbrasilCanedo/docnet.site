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
class AdmsAprovOrcam
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
    public function viewAprovOrcam(int $id): void
    {
        $this->id = $id;

        $viewCham = new \App\adms\Models\helper\AdmsRead();
        $viewCham->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                            orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, 
                            orcam.info_prod_serv, status_orcam.name as name_status_orcam, orcam.inf_adic, orcam.usuario_id_aval,
                            orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                            FROM adms_orcam as orcam
                            INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                            INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id 
                            WHERE orcam.id= :orcam_id and orcam.status_id IN (3, 6) LIMIT :limit", "orcam_id={$this->id}&limit=1");

        $this->resultBd = $viewCham->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Proposta não enviada!</p>";
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
     * Metodo recebe como parametro a informação que será editada
     * Instancia o helper AdmsValEmptyField para validar os campos do formulário
     * Chama a função edit para enviar as informações para o banco de dados
     * @param array|null $data
     * @return void
     */
    public function updateReprov(array $data): void
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
        date_default_timezone_set('America/Bahia');

        $this->data['status_id'] = 4;//Proposta Aprovada
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['usuario_id_aval'] = $_SESSION['user_id'];
        $this->data['modified'] = date("Y-m-d H:i:s");        

        $upOrcam = new \App\adms\Models\helper\AdmsUpdate();
        $upOrcam->exeUpdate("adms_orcam", $this->data, "WHERE id= :id", "id={$this->data['id']}");

        if ($upOrcam->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Proposta Validada Com Sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Proposta Não Validada Com Sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function editReprov(): void
    { 
        date_default_timezone_set('America/Bahia');

        $this->data['status_id'] = 5;//Proposta reprovada
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['usuario_id_aval'] = $_SESSION['user_id'];
        $this->data['modified'] = date("Y-m-d H:i:s");        

        $upOrcam = new \App\adms\Models\helper\AdmsUpdate();
        $upOrcam->exeUpdate("adms_orcam", $this->data, "WHERE id= :id", "id={$this->data['id']}");

        if ($upOrcam->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Proposta Validada Com Sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Proposta Não Validada Com Sucesso!</p>";
            $this->result = false;
        }
    }
}
