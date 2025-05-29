<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar Chamado no banco de dados
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
    public function viewCham(int $id): void
    {
        $this->id = $id;
        $_SESSION['set_cham'] = $this->id;

        $viewCham = new \App\adms\Models\helper\AdmsRead();
        $viewCham->fullRead("SELECT cham.id, clie.nome_fantasia as nome_fantasia_clie, prod.name as name_prod, prod.marca_id as marca_id_prod, prod.modelo_id as modelo_id_prod, cham.contato, cham.tel_contato, usr.name AS name_usr, 
                            cham.dt_cham, cham.suporte_id, sta.name as name_sta, cham.dt_status, cham.dt_term_cham, cham.inf_cham, cham.type_cham, cham.fech_cham, cham.image, cham.motivo_repr, cham.created
                            FROM adms_cham as cham 
                            INNER JOIN adms_clientes AS clie ON clie.id=cham.cliente_id 
                            INNER JOIN adms_users_final AS usr ON usr.id=cham.usuario_id
                            INNER JOIN adms_cham_status AS sta ON sta.id=cham.status_id                             
                            INNER JOIN adms_produtos AS prod ON prod.id=cham.prod_id 
                            WHERE cham.id= :cham_id ORDER BY cham.id DESC LIMIT :limit","cham_id={$_SESSION['set_cham']}&limit=1");

        $this->resultBd = $viewCham->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado  não encontrado!</p>";
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
    public function updatePausa(array $data): void
    {
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
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
    public function updatePausaCom(array $data): void
    {
        $this->data = $data;
        // echo "<pre>"; print_r($this->data);echo "</pre>";

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
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

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->tempoGasto();
        } else {
            $this->result = false;
        }
    }
    /**
     * Metodo recebe como parametro a informação que será editada
     * Faz o calculo entre o inicio do atendimento e a finalização do atendimento
     * Chama a função edit para enviar as informações para o banco de dados
     * @param array|null $data
     * @return void
     */
    public function tempoGasto(array $data = null): void
    {
        /*// Executando a consulta SQL
        $viewCham = new \App\adms\Models\helper\AdmsRead();
        $viewCham->fullRead("SELECT TIMESTAMPDIFF(HOUR, dt_cham, fech_cham) AS dur_cham FROM adms_cham");

        // Obtendo o resultado
        $row = mysqli_fetch_assoc($viewCham);
        $horas = $row['horas_transcorridas'];

        // Formatando a saída
        echo "O tempo transcorrido foi de " . $horas . " horas.";
*/

        $this->editFinal();
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
     * Cadastrar usuário no banco de dados
     * Retorna TRUE quando cadastrar o usuário com sucesso
     * Retorna FALSE quando não cadastrar o usuário
     * 
     * @return void
     */
    public function addHistChamInic(): void
    {

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

        $this->data['status'] = 'Pausado';
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['cham_id'] = $_SESSION['set_cham'];
        $this->data['usr_id'] = $_SESSION['user_id'];
        $this->data['obs'] = 'Chamado Pausado pelo Suporte Técnico';
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

        $this->data['status'] = 'Aguardando Cliente';
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['cham_id'] = $_SESSION['set_cham'];
        $this->data['usr_id'] = $_SESSION['user_id'];
        $this->data['obs'] = 'Chamado Pausado Aguardando Autorização do Cliente';
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

        $this->data['status'] = 'Aguardando Outros';
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['cham_id'] = $_SESSION['set_cham'];
        $this->data['usr_id'] = $_SESSION['user_id'];
        $this->data['obs'] = 'Chamado Pausado Aguardando Outros(Terceirizados, Operadoras, etc... ';
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

        $this->data['status'] = 'Finalizado';
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['cham_id'] = $_SESSION['set_cham'];
        $this->data['usr_id'] = $_SESSION['user_id'];
        $this->data['obs'] = 'Chamado com Atendimento Finalizado pelo Suporte Técnico';
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
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function edit(): void
    {


        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 3; //Em Atendimento
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['suporte_id'] = $_SESSION['user_id'];

        $upCham = new \App\adms\Models\helper\AdmsUpdate();
        $upCham->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Chamado Iniciado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado não editado com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function editPausa(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 5; //Pausado
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['suporte_id'] = $_SESSION['user_id'];

        $upCham = new \App\adms\Models\helper\AdmsUpdate();
        $upCham->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Chamado Pausado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado não Pausado com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function editPausaCom(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 11; //Aguardando Comercial
        $this->data['suporte_id'] = $_SESSION['user_id'];
        $this->data['dt_status'] = date("Y-m-d H:i:s");

        $upCham = new \App\adms\Models\helper\AdmsUpdate();
        $upCham->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Chamado aguardando comercial pausado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado aguardando comercial não Pausado com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function editPend(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 10; //Aguardando Cliente
        $this->data['suporte_id'] = $_SESSION['user_id'];
        $this->data['dt_status'] = date("Y-m-d H:i:s");

        $updatePend = new \App\adms\Models\helper\AdmsUpdate();
        $updatePend->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($updatePend->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Chamado Pausado  com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado não Pausado com sucesso!</p>";
            $this->result = false;
        }
    }
    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function editAguar(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 12; //Aguardando Outros
        $this->data['suporte_id'] = $_SESSION['user_id'];
        $this->data['dt_status'] = date("Y-m-d H:i:s");

        $updateAguar = new \App\adms\Models\helper\AdmsUpdate();
        $updateAguar->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($updateAguar->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Chamado Pausado  com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado não Pausado com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo envia as informações editadas para o banco de dados
     * @return void
     */
    private function editFinal(): void
    {
        $this->data['modified'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 6; //Finalizado
        $this->data['suporte_id'] = $_SESSION['user_id'];
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['dt_term_cham'] = date("Y-m-d H:i:s");

        $upCham = new \App\adms\Models\helper\AdmsUpdate();
        $upCham->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id={$this->data['id']}");

        if ($upCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Chamado Finalizado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado não Finalizado com sucesso!</p>";
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
