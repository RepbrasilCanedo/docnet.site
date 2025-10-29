<?php

namespace App\adms\Models;

use DateTime;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar Ticket no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsEditCham
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $idStatus;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $dataSla;


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
    public function viewCham(int $id): void
    {
        $this->id = $id;
        $_SESSION['set_cham'] = $this->id;

        $viewCham = new \App\adms\Models\helper\AdmsRead();
        $viewCham->fullRead("SELECT cham.id, clie.nome_fantasia as nome_fantasia_clie, sla.name as name_sla, prod.name as name_prod, prod.marca_id as marca_id_prod, prod.modelo_id as modelo_id_prod, cham.contato, cham.tel_contato, 
                            cham.dt_cham, cham.suporte_id, user.name as name_user, cham.status_id, sta.name as name_sta, cham.dt_status, cham.dt_term_cham, cham.inf_cham, cham.type_cham, cham.fech_cham, cham.dur_cham as sla_total, cham.image, cham.motivo_repr, cham.created
                            FROM adms_cham as cham 
                            INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id                             
                            INNER JOIN adms_sla AS sla ON sla.id=cham.sla_id  
                            INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id                             
                            INNER JOIN adms_produtos AS prod ON prod.id=cham.prod_id                             
                            INNER JOIN adms_users AS user ON user.id=cham.suporte_id  
                            WHERE cham.id= :cham_id ORDER BY cham.id DESC LIMIT :limit","cham_id={$_SESSION['set_cham']}&limit=1");

        $this->resultBd = $viewCham->getResult();
        if ($this->resultBd) {
            $_SESSION['dt_status_ant']='';
            $_SESSION['status_id_ant']='';
            $_SESSION['dt_status_ant']=$this->resultBd[0]['dt_status'];
            $_SESSION['status_id_ant']=$this->resultBd[0]['status_id'];
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Ticket  não encontrado!</p>";
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
        // verifica se todos os campos obrigatorios estão preenchidos
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $_SESSION['status_cham']='';
            $_SESSION['status_cham']=3;
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
    public function updatePausa(array $data): void
    {
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $_SESSION['status_cham']='';
            $_SESSION['status_cham']=5;
            $this->editPausa();
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
    public function updateReag(array $data): void
    {
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $_SESSION['status_cham']='';
            $_SESSION['status_cham']=13;
            $this->editReag();
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
    public function updatePausaCom(array $data): void
    {
        $this->data = $data;
        // echo "<pre>"; print_r($this->data);echo "</pre>";

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {            
            $_SESSION['status_cham']='';
            $_SESSION['status_cham']=11;
            $this->editPausaCom();
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
    public function updatePend(array $data): void
    {
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {            
            $_SESSION['status_cham']='';
            $_SESSION['status_cham']=10;
            $this->editPend();
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
    public function updateAguar(array $data): void
    {
        $this->data = $data;
        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {            
            $_SESSION['status_cham']='';
            $_SESSION['status_cham']=12;
            $this->editAguar();
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
    public function updateFinal(array $data): void
    {
        $this->data = $data;
        $_SESSION['set_cham']=$this->data['id'];

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {            
            $_SESSION['status_cham']='';
            $_SESSION['status_cham']=6;// ticket finalizado
            $this->editFinal();
        } else {
            $this->result = false;
        }
    }
    /** 
     * Cadastrar usuário no banco de dados
     * Retorna TRUE quando cadastrar o usuário com sucesso
     * Retorna FALSE quando não cadastrar o usuário
     * 
     * @return void
     */
    public function addHistChamHist(): void
    {
        date_default_timezone_set('America/Bahia');
        
        $this->data['status'] = 'Em Atendimento';
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['cham_id'] = $_SESSION['set_cham'];
        $this->data['usr_id'] = $_SESSION['user_id'];
        $this->data['suporte_id'] = $_SESSION['user_id'];
        $this->data['obs'] = 'Via modal';
        $this->data['created'] = date("Y-m-d H:i:s");


        $createHistCham = new \App\adms\Models\helper\AdmsCreate();
        $createHistCham->exeCreate("adms_cham_hist", $this->data);

        if ($createHistCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Historico Cadastrado com sucesso cadastrado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Hitórico não cadastrado com sucesso!</p>";
            $this->result = false;
        }
    }

    /** 
     * Reagendar o data do ticket
     * Retorna TRUE quando Reagendar o data do ticket
     * Retorna FALSE quando não Reagendar o data do ticket
     * 
     * @return void
     */
    public function addHistChamReag(): void
    {

        date_default_timezone_set('America/Bahia');

        $this->data['status'] = 'Reagendado';
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['cham_id'] = $_SESSION['set_cham'];
        $this->data['usr_id'] = $_SESSION['user_id'];
        $this->data['obs'] = "Reagendado as " . date("H:i:s") . " hs." . " do dia " . date("d-m-Y");
        $this->data['created'] = date("Y-m-d H:i:s");


        $createHistCham = new \App\adms\Models\helper\AdmsCreate();
        $createHistCham->exeCreate("adms_cham_hist", $this->data);

        if ($createHistCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Historico Cadastrado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Hitórico não cadastrado com sucesso!</p>";
            $this->result = false;
        }
    }

    /** 
     * Cadastrar usuário no banco de dados
     * Retorna TRUE quando cadastrar o usuário com sucesso
     * Retorna FALSE quando não cadastrar o usuário
     * 
     * @return void
     */
    public function addHistChamInic(): void
    {

        date_default_timezone_set('America/Bahia');
        $this->data['status'] = 'Em Atendimento';
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['cham_id'] = $_SESSION['set_cham'];
        $this->data['usr_id'] = $_SESSION['user_id'];
        $this->data['obs'] = "Inicializado as " . date("H:i:s") . " hs." . " do dia " . date("d-m-Y");
        $this->data['created'] = date("Y-m-d H:i:s");


        $createHistCham = new \App\adms\Models\helper\AdmsCreate();
        $createHistCham->exeCreate("adms_cham_hist", $this->data);

        if ($createHistCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Historico Cadastrado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Hitórico não cadastrado com sucesso!</p>";
            $this->result = false;
        }
    }

    /** 
     * Cadastrar usuário no banco de dados
     * Retorna TRUE quando cadastrar o usuário com sucesso
     * Retorna FALSE quando não cadastrar o usuário
     * 
     * @return void
     */
    public function addHistChamPaus(): void
    {

        date_default_timezone_set('America/Bahia');
        $this->data['status'] = 'Pausado';
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['cham_id'] = $_SESSION['set_cham'];
        $this->data['usr_id'] = $_SESSION['user_id'];
        $this->data['obs'] = 'Ticket Pausado pelo Suporte Técnico';
        $this->data['created'] = date("Y-m-d H:i:s");


        $createHistCham = new \App\adms\Models\helper\AdmsCreate();
        $createHistCham->exeCreate("adms_cham_hist", $this->data);

        if ($createHistCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Historico Cadastrado com sucesso cadastrado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Hitórico não cadastrado com sucesso!</p>";
            $this->result = false;
        }
    }
    /** 
     * Cadastrar usuário no banco de dados
     * Retorna TRUE quando cadastrar o usuário com sucesso
     * Retorna FALSE quando não cadastrar o usuário
     * 
     * @return void
     */
    public function addHistChamClie(): void
    {
        date_default_timezone_set('America/Bahia');

        $this->data['status'] = 'Aguardando Cliente';
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['cham_id'] = $_SESSION['set_cham'];
        $this->data['usr_id'] = $_SESSION['user_id'];
        $this->data['obs'] = 'Ticket Pausado Aguardando Autorização do Cliente';
        $this->data['created'] = date("Y-m-d H:i:s");


        $createHistCham = new \App\adms\Models\helper\AdmsCreate();
        $createHistCham->exeCreate("adms_cham_hist", $this->data);

        if ($createHistCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Historico Cadastrado com sucesso cadastrado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Hitórico não cadastrado com sucesso!</p>";
            $this->result = false;
        }
    }
    /** 
     * Cadastrar usuário no banco de dados
     * Retorna TRUE quando cadastrar o usuário com sucesso
     * Retorna FALSE quando não cadastrar o usuário
     * 
     * @return void
     */
    public function addHistChamAguar(): void
    {
        date_default_timezone_set('America/Bahia');

        $this->data['status'] = 'Aguardando Outros';
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['cham_id'] = $_SESSION['set_cham'];
        $this->data['usr_id'] = $_SESSION['user_id'];
        $this->data['obs'] = 'Ticket Pausado Aguardando Outros(Terceirizados, Operadoras, etc... ';
        $this->data['created'] = date("Y-m-d H:i:s");


        $createHistCham = new \App\adms\Models\helper\AdmsCreate();
        $createHistCham->exeCreate("adms_cham_hist", $this->data);

        if ($createHistCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Historico Cadastrado com sucesso cadastrado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Hitórico não cadastrado com sucesso!</p>";
            $this->result = false;
        }
    }

    /** 
     * Cadastrar usuário no banco de dados
     * Retorna TRUE quando cadastrar o usuário com sucesso
     * Retorna FALSE quando não cadastrar o usuário
     * 
     * @return void
     */
    public function addHistChamFin(): void
    {
        date_default_timezone_set('America/Bahia');

        $this->data['status'] = 'Finalizado';
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['cham_id'] = $_SESSION['set_cham'];
        $this->data['usr_id'] = $_SESSION['user_id'];
        $this->data['obs'] = 'Ticket com Atendimento Finalizado pelo Suporte Técnico';
        $this->data['created'] = date("Y-m-d H:i:s");


        $createHistCham = new \App\adms\Models\helper\AdmsCreate();
        $createHistCham->exeCreate("adms_cham_hist", $this->data);

        if ($createHistCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Historico Cadastrado com sucesso cadastrado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Hitórico não cadastrado com sucesso!</p>";
            $this->result = false;
        }
    }

        /**
     * Metodo envia as informações criadas para o banco de dados
     * @return void
     */
    private function createdSlaHist(): void
    {
        date_default_timezone_set('America/Bahia'); 

        $viewTicket = new \App\adms\Models\helper\AdmsRead();
        $viewTicket->fullRead("SELECT cham.id as id_cham, cham.empresa_id as empresa_id_cham,  cham.cliente_id as cliente_id_cham, cham.sla_id, sla.prim_resp as prim_resp_sla, sla.final_resp as final_resp_sla, 
                            cham.suporte_id, cham.status_id, cham.dt_cham as dt_cham, cham.dt_status, cham.type_cham
                            FROM adms_cham  AS cham
                            INNER JOIN adms_sla AS sla ON sla.id = cham.sla_id 
                            INNER JOIN adms_sla AS sla ON sla.id = cham.sla_id 
                            WHERE cham.id= :cham_id","cham_id={$_SESSION['set_cham']}");

        $this->resultBd = $viewTicket->getResult();
               
        $this->dataSla['id'] ='';
        $this->dataSla['empresa_id'] = $this->resultBd[0]['empresa_id_cham'];
        $this->dataSla['cliente_id'] = $this->resultBd[0]['cliente_id_cham'];
        $this->dataSla['id_ticket'] = $this->resultBd[0]['id_cham'];
        $this->dataSla['id_sla'] = $this->resultBd[0]['sla_id'];
        $this->dataSla['tempo_sla_prim'] = $this->resultBd[0]['prim_resp_sla'];
        $this->dataSla['tempo_sla_fin'] = $this->resultBd[0]['final_resp_sla'];
        $this->dataSla['suporte_id'] = $_SESSION['user_id'];
        $this->dataSla['status_id'] = $_SESSION['status_cham'];
        $this->dataSla['dt_status'] = date("Y-m-d H:i:s");
        $this->dataSla['dt_abert_ticket'] = $this->resultBd[0]['dt_cham'];          
        $this->dataSla['typo_cham'] = $this->resultBd[0]['type_cham'];        
        $this->dataSla['status_id_ant'] = $_SESSION['status_id_ant'];//Status anterior do ticket
        $this->dataSla['dt_status_ant'] = $_SESSION['dt_status_ant'];//Status anterior do ticket 

        // Define as duas datas/horários
        $data_inicio = new DateTime($_SESSION['dt_status_ant']);
        $data_fim = new DateTime();
        // Use o método diff() para obter a diferença
        $intervalo = $data_inicio->diff($data_fim);

        $this->dataSla['tempo_sla'] =$intervalo->format('%H:%i');
        $this->dataSla['modified'] = date("Y-m-d H:i:s");

        
        $createSla = new \App\adms\Models\helper\AdmsCreate();
        $createSla->exeCreate("adms_sla_hist", $this->dataSla);
    }

    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function edit(): void
    {
        date_default_timezone_set('America/Bahia');
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 3; //Em Atendimento
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['suporte_id'] = $_SESSION['user_id'];

        $upCham = new \App\adms\Models\helper\AdmsUpdate();
        $upCham->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upCham->getResult()) {
            $this->createdSlaHist();
            $_SESSION['msg'] = "<p class='alert-success'>Ticket Iniciado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Ticket não editado com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function editPausa(): void
    {
        date_default_timezone_set('America/Bahia');
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 5; //Pausado
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['suporte_id'] = $_SESSION['user_id'];

        $upCham = new \App\adms\Models\helper\AdmsUpdate();
        $upCham->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upCham->getResult()) {
            $this->createdSlaHist();
            $_SESSION['msg'] = "<p class='alert-success'>Ticket Pausado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Ticket não Pausado com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function editReag(): void
    {
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
        $this->data['dt_status'] = date("Y-m-d H:i:s");

        $upCham = new \App\adms\Models\helper\AdmsUpdate();
        $upCham->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upCham->getResult()) {            
            $this->createdSlaHist();
            $_SESSION['msg'] = "<p class='alert-success'>Ticket Reagendado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Ticket não Reagendado com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function editPausaCom(): void
    {
        date_default_timezone_set('America/Bahia');
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 11; //Aguardando Comercial
        $this->data['suporte_id'] = $_SESSION['user_id'];
        $this->data['dt_status'] = date("Y-m-d H:i:s");

        $upCham = new \App\adms\Models\helper\AdmsUpdate();
        $upCham->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upCham->getResult()) {
            $this->createdSlaHist();
            $_SESSION['msg'] = "<p class='alert-success'>Ticket aguardando comercial pausado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Ticket aguardando comercial não Pausado com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function editPend(): void
    {
        date_default_timezone_set('America/Bahia');
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 10; //Aguardando Cliente
        $this->data['suporte_id'] = $_SESSION['user_id'];
        $this->data['dt_status'] = date("Y-m-d H:i:s");

        $updatePend = new \App\adms\Models\helper\AdmsUpdate();
        $updatePend->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($updatePend->getResult()) {            
            $this->createdSlaHist();
            $_SESSION['msg'] = "<p class='alert-success'>Ticket Pausado  com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Ticket não Pausado com sucesso!</p>";
            $this->result = false;
        }
    }
    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function editAguar(): void
    {
        date_default_timezone_set('America/Bahia');
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 12; //Aguardando Outros
        $this->data['suporte_id'] = $_SESSION['user_id'];
        $this->data['dt_status'] = date("Y-m-d H:i:s");

        $updateAguar = new \App\adms\Models\helper\AdmsUpdate();
        $updateAguar->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($updateAguar->getResult()) {            
            $this->createdSlaHist();
            $_SESSION['msg'] = "<p class='alert-success'>Ticket Pausado  com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Ticket não Pausado com sucesso!</p>";
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

        $viewChamGrav = new \App\adms\Models\helper\AdmsRead();
        $viewChamGrav->fullRead("SELECT cham.id, cham.dt_cham FROM adms_cham as cham WHERE cham.id= :cham_id","cham_id={$_SESSION['set_cham']}");
        $this->resultBd = $viewChamGrav->getResult();

        // Define as duas datas/horários
        $data_inicio = new DateTime($this->resultBd[0]['dt_cham']);
        $data_fim = new DateTime();
        // Use o método diff() para obter a diferença
        $intervalo = $data_inicio->diff($data_fim);

        
       
        $this->data['dur_cham'] =$intervalo->format('%H:%i');
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 6; //TicketFinalizado
        //$this->data['suporte_id'] = $_SESSION['user_id'];
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['dt_term_cham'] = date("Y-m-d H:i:s");

        

        $upCham = new \App\adms\Models\helper\AdmsUpdate();
        $upCham->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upCham->getResult()) {  
            $this->createdSlaHist();// Gera o sla
            $_SESSION['msg'] = "<p class='alert-success'>Ticket Finalizado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Ticket não Finalizado com sucesso!</p>";
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
    

       /**
     * Metodo para pesquisar as informações que serão usadas no dropdown do formulário
     *
     * @return array
     */
    public function listSelect(): array
    {
        $list = new \App\adms\Models\helper\AdmsRead();


        if ($_SESSION['adms_access_level_id'] > 2){
            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $list->fullRead("SELECT id, name FROM adms_users WHERE empresa_id= :empresa AND adms_access_level_id= :nivel_acesso", "empresa={$_SESSION['emp_user']}&nivel_acesso=12");
                $registry['nomesup'] = $list->getResult();

                $this->listRegistryAdd = ['nomesup' => $registry['nomesup']];
            }
        } 

        return $this->listRegistryAdd;
    }
}
