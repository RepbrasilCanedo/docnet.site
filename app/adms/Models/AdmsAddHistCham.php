<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar historico do chamado no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsAddHistCham
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array Recebe as informações que serão usadas no dropdown do formulário*/
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
    public function create(array $data)
    {
        $this->data = $data;
        echo "<pre>"; var_dump($this->data);

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            $this->add();
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
    private function add(): void
    {
        date_default_timezone_set('America/Bahia');
        
        $this->data['status'] =$_SESSION['set_status'];
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['cham_id'] = $_SESSION['set_cham'];
        $this->data['usr_id'] = $_SESSION['user_id'];
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
}
