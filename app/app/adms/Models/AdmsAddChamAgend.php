<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar Chamdo no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsAddChamAgend
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var array Recebe as informações que serão usadas no dropdown do formulário*/
    private array $listRegistryAdd;

    /** @var array $dataExitVal Recebe as informações que serão retiradas da validação*/
    private array $dataExitVal;

    private array|string|null $agendamento;

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
     * Verifica se todos os campos estão preenchidos e retira campos especificos da validação
     * Retorna FALSE quando algum campo está vazio
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function create(array $data = null)
    {
        $this->data = $data;
        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->add();
            //$this->listHist(); 
        } else {
            $this->result = false;
        }
    }

    /**
     * Metodo para pesquisar se existe alguma chamado Finalizado para o cliente
     *
     * @return array
     */
    private function listHist(): void
    {
        $listHist = new \App\adms\Models\helper\AdmsRead();
        $listHist->fullRead("SELECT empresa_id, status_id FROM adms_cham  WHERE status_id=6 and empresa_id = :empresa_id", "empresa_id={$_SESSION['emp_user']}");
        $this->resultBd = $listHist->getResult();

        if ($listHist->getResult()) {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Este chamado não pode ser ABERTO pois existe chamado FINALIZADO para a empresa deste USUÁRIO que precisa ser AVALIADO!</p>";
            $this->result = true;
        } else {
            $this->add();
            $this->result = false;
        }
    }



    
/**
     * Metodo para pesquisar se a empresa esta vinculada a outra empresa com contrato ativo possui contrato ativo ou vencido
     *
     * @return array
     */
    private function valEmpContr(): void
    {
        $valContAtivo = new \App\adms\Models\helper\AdmsRead();
        $valContAtivo->fullRead("SELECT id, contrato, situacao FROM adms_empresa 
        WHERE id= :empresa_contr","empresa_contr={$_SESSION['empresa_contr']})");  
        
        $this->resultBd = $valContAtivo->getResult();   

        if ($valContAtivo->getResult()) {
            $_SESSION['contrato_matriz']='';
            $_SESSION['contrato_matriz']=$this->resultBd['0']['contrato'];
            $this->valContAtivo();
            $this->result = false;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Este chamado não pode ser ABERTO entre em cotato com o setor comercial da REP BRASIL. --> <b>(WhatsApp 71 98137 6244)<b>!</p>";
            $this->result = true;
        }
    }
    /**
     * Metodo para pesquisar se o cliente possui contrato ativo ou vencido
     *
     * @return array
     */
    private function valContAtivo(): void
    {        
        $valContAtivo = new \App\adms\Models\helper\AdmsRead();
        $valContAtivo->fullRead("SELECT id, clie_cont, service_id, num_cont, dt_inicio, dt_term, sit_cont, tipo_cont FROM adms_contr 
        WHERE (dt_term > CURDATE()) AND (id= :num_cont) AND (sit_cont = :sit_cont)","num_cont={$_SESSION['contrato_matriz']}&sit_cont=1)");  
        
        $this->resultBd = $valContAtivo->getResult();       

        if ($valContAtivo->getResult()) {
            $this->add();
            $this->result = false;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Este chamado não pode ser ABERTO entre em cotato com o setor comercial da REP BRASIL. --> <b>(WhatsApp 71 98137 6244)<b>!</p>";
            $this->result = true;
        }
    }
    /** 
     * Cadastrar a página no banco de dados
     * Retorna TRUE quando cadastrar a página com sucesso
     * Retorna FALSE quando não cadastrar a página
     * 
     * @return void
     */
    private function add(): void
    {
        $this->data['usuario_id'] = $_SESSION['user_id'];
        $this->data['empresa_id'] = $_SESSION['emp_user'];
        $diaAgendado=$this->data['dia_cham'];
        unset($this->data['dia_cham']);
        $horaAgendado=$this->data['hr_cham'];
        unset($this->data['hr_cham']);
        $agendamento=$diaAgendado . " ". $horaAgendado;
        $this->data['dt_cham'] = date("Y-m-d H:i:s");;
        $this->data['status_id'] = 9;
        $this->data['dt_status'] = $agendamento;
        $this->data['created'] = date("Y-m-d H:i:s");

        $createChamAgend = new \App\adms\Models\helper\AdmsCreate();
        $createChamAgend->exeCreate("adms_cham", $this->data);

        if ($createChamAgend->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Chamado Agendado com sucesso!</p>";
            $urlRedirect = URLADM . "list-cham/index";
            header("Location: $urlRedirect");
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado não agendado com sucesso!</p>";
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


        if ($_SESSION['adms_access_level_id'] > 2){
            //Se for 4 - Cliente Administrativo
            if ($_SESSION['adms_access_level_id'] == 4) {

                $list->fullRead("SELECT id, nome_fantasia FROM adms_clientes 
                WHERE empresa= :clie_id ORDER BY nome_fantasia ASC", "clie_id={$_SESSION['emp_user']}");
                $registry['cliente'] = $list->getResult();

                //Se for 14 - Usuário final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {

                $list->fullRead("SELECT id, nome_fantasia FROM adms_clientes 
                WHERE id= :clie_id ORDER BY nome_fantasia ASC", "clie_id={$_SESSION['set_clie']}");
                $registry['cliente'] = $list->getResult();
            }
        } else {
            $list->fullRead("SELECT id id_emp, nome_fantasia nome_fantasia_emp FROM adms_empresa as emp ORDER BY nome_fantasia ASC");
            $registry['cliente'] = $list->getResult();
            
        }



        $this->listRegistryAdd = ['cliente' => $registry['cliente']];

        return $this->listRegistryAdd;
    }
}
