<?php

namespace App\adms\Models;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar o chamado no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsViewCham
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;
    

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
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
     * Metodo para visualizar os detalhes do chamado
     * Recebe o ID do chamado que será usado como parametro na pesquisa
     * Retorna FALSE se houver algum erro.
     * @param integer $id
     * @return void
     */
    public function viewCham(int $id): void
    {
        
        $this->id = $id;
        $_SESSION['set_cham']='';
        $_SESSION['set_cham'] = $this->id;

        $viewCham = new \App\adms\Models\helper\AdmsRead();
        $viewCham->fullRead("SELECT cham.id, clie.nome_fantasia as nome_fantasia_clie, prod.name as name_prod, prod.marca_id as marca_id_prod, prod.modelo_id as modelo_id_prod, cham.contato, cham.tel_contato,
                            cham.dt_cham, user.name as name_user, sta.name as name_sta, cham.dt_status, cham.dt_term_cham, cham.inf_cham, cham.type_cham, cham.fech_cham, cham.image, cham.motivo_repr, cham.created
                            FROM adms_cham as cham 
                            INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                            INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id                             
                            INNER JOIN adms_produtos AS prod ON prod.id=cham.prod_id                             
                            INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                            WHERE cham.id= :cham_id LIMIT :limit","cham_id={$this->id}&limit=1");

        $this->resultBd = $viewCham->getResult();        
        if ($this->resultBd) {   
            $this->result = true;
        } else {            
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado não encontrado!</p>";
            $this->result = false;
            
        }
    }
        /**
     * Metodo para visualizar os detalhes do chamado
     * Recebe o ID do chamado que será usado como parametro na pesquisa
     * Retorna FALSE se houver algum erro.
     * @param integer $id
     * @return void
     */
    public function reagCham(array $data): void
    {      
        if ($this->resultBd) {   
            //$this->editReag();
            var_dump($this->resultBd);
        } else {            
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado não encontrado!</p>";
            $this->result = false;
            
        }
    }

    

    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    public function editReag(array $data, int $id): void
    {
        $this->id = $id;
        $this->data = $data;
        //var_dump( $this->data);
        date_default_timezone_set('America/Bahia');

        // concatena o dia junto com o horario do agendamento
        $diaAgendado=$this->data['dia_cham'];
        unset($this->data['dia_cham']);
        $horaAgendado=$this->data['hr_cham'];
        unset($this->data['hr_cham']);
        $agendamento=$diaAgendado . " ". $horaAgendado;

        $this->data['modified'] = date("Y-m-d H:i:s");        
        $this->data['status_id'] = 13; //Reagendado
        $this->data['dt_status'] =$agendamento;
        //$this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['suporte_id'] = $_SESSION['user_id'];

        $upCham = new \App\adms\Models\helper\AdmsUpdate();
        $upCham->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->id}");

        if ($upCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Ticket Reagendado com sucesso!</p>";
            $urlRedirect = URLADM . "list-cham/index";
            header("Location: $urlRedirect");
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Ticket não Reagendado com sucesso!</p>";
            $this->result = false;
        }
    }

    public function listTable() : array
    {       

        $listTable = new \App\adms\Models\helper\AdmsRead();
        $listTable->fullRead("SELECT hist.id as id_hist, hist.status, hist.dt_status, hist.cham_id, usr.name as name_usr_hist, hist.obs 
        FROM adms_cham_hist AS hist
        INNER JOIN adms_users AS usr ON usr.id=hist.usr_id  
        WHERE cham_id= :cham_id", "cham_id={$_SESSION['set_cham']}");

        $registry['list_table'] = $listTable->getResult();

        $this->listRegistryAdd = ['list_table' => $registry['list_table']];

        return $this->listRegistryAdd;

    }
}
