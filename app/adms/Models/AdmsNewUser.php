<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar o usuário no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsNewUser
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var string $fromEmail Recebe o e-mail do remetente */
    private string $fromEmail;

    /** @var string $firstName Recebe o primeiro nome do usuário */
    private string $firstName;

    /** @var string $url Recebe a URL com endereço para o usuário confirmar o e-mail */
    private string $url;

    /** @var array $emailData Recebe dados do conteúdo do e-mail */
    private array $emailData;

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
    public function create(array $data)
    {
        
        $this->data = $data;
        

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->verifUser();
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
    private function verifUser(): void
    {
        
        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT user, name, empresa_id, cliente_id FROM adms_users_final WHERE user= :email" , "email={$_SESSION['solUser']}");

 
        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            
            $_SESSION['solUser']='';
            $_SESSION['solClie']='';            
            $_SESSION['solName']='';
            $_SESSION['solUser']=$this->resultBd[0]['empresa_id'];            
            $_SESSION['solClie']=$this->resultBd[0]['cliente_id'];                        
            $_SESSION['solName']=$this->resultBd[0]['name'];
            $this->add();  
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Este Usuario não esta cadastrado no sistema!</p>";
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
    private function add(): void
    {
      
            date_default_timezone_set('America/Bahia');

            $this->data['empresa_id'] = $_SESSION['solUser'];
            $this->data['cliente_id'] = $_SESSION['solClie'];            
            $this->data['nome'] = $_SESSION['solName'];
            $this->data['assunto'] = 'Cadastrar nova senha';
            $this->data['dia'] = date("Y-m-d H:i:s");
            $this->data['status'] = 'Enviado';
            $this->data['mensagem'] = 'Usuario não consegui logar no sistema';
            $this->data['created'] = date("Y-m-d H:i:s");

            $createUser = new \App\adms\Models\helper\AdmsCreate();
            $createUser->exeCreate("sts_contacts_msgs", $this->data);

            if ($createUser->getResult()) {
                $_SESSION['msg'] = "<p style='color: green;'>Solicitação enviada com sucesso!</p>";
                $this->result = true;

            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: A solicitação não foi enviada!</p>";
                $this->result = false;
            }
               
    }
    

}