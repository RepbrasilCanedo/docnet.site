<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar Orcamento no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsEditOrcam
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
    public function viewOrcam(int $id): void
    {
        $this->id = $id;
        $_SESSION['set_cham'] = $this->id;

        $viewOrcam = new \App\adms\Models\helper\AdmsRead();
        $viewOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                            orcam.prod_serv as prod_serv_orcam, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, status_orcam.name as name_status_orcam, 
                            orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam
                            FROM adms_orcam as orcam
                            INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                            INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id 
                            WHERE orcam.id= :orcam_id LIMIT :limit","orcam_id={$this->id}&limit=1");

        $this->resultBd = $viewOrcam->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Orcamento  não encontrado!</p>";
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
        date_default_timezone_set('America/Bahia');


        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 2;
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['usuario_id'] = $_SESSION['user_id'];

        $upCham = new \App\adms\Models\helper\AdmsUpdate();
        $upCham->exeUpdate("adms_orcam", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Proposta Enviada com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Proposta não editada com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function editFinal(): void
    {
        date_default_timezone_set('America/Bahia');
        
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 6; //Finalizado
        $this->data['suporte_id'] = $_SESSION['user_id'];
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['dt_term_cham'] = date("Y-m-d H:i:s");

        $upCham = new \App\adms\Models\helper\AdmsUpdate();
        $upCham->exeUpdate("adms_orcam", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Orcamento Finalizado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Orcamento não Finalizado com sucesso!</p>";
            $this->result = false;
        }
    }

    public function listTable(): array
    {

        $listTable = new \App\adms\Models\helper\AdmsRead();
        $listTable->fullRead("SELECT hist.status, hist.dt_status, hist.cham_id, usr.name as name_usr_hist, hist.obs 
        FROM adms_cham_hist AS hist
        INNER JOIN adms_users AS usr ON usr.id=hist.usr_id  
        WHERE cham_id= :cham_id", "cham_id={$_SESSION['set_cham']}");

        $registry['list_table'] = $listTable->getResult();

        $this->listRegistryAdd = ['list_table' => $registry['list_table']];

        return $this->listRegistryAdd;
    }
}
