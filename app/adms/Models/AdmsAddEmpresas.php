<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar empresa no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsAddEmpresas
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array Recebe as informações que serão usadas no dropdown do formulário*/
    private array $listRegistryAdd;

    /** @var array $dataExitVal Recebe as informações que serão retiradas da validação*/
    private array $dataExitVal;

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

    public function create(array $data)
    {
        $this->data = $data;

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {
            $this->add();
        } else {
            $this->result = false;
        }
    }

    /** 
     * Cadastrar a empresa no banco de dados
     * Retorna TRUE quando cadastrar a empresa com sucesso
     * Retorna FALSE quando não cadastrar a empresa
     * 
     * @return void
     */
    private function add(): void
    {
        $this->data['created'] = date("Y-m-d H:i:s");
        $this->data['situacao'] = 1;

        if ($_SESSION['adms_access_level_id'] > 2) {
            $this->data['empresa'] = $_SESSION['emp_user'];
        };

        var_dump($this->data);
        $createEmpresas = new \App\adms\Models\helper\AdmsCreate();
        $createEmpresas->exeCreate("adms_clientes", $this->data);

        if ($createEmpresas->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Cliente Cadastrado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Cliente não cadastrado com sucesso!</p>";
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
            $list->fullRead("SELECT id, razao_social FROM adms_emp_principal ORDER BY razao_social ASC");
            $registry['empresa'] = $list->getResult();


            $this->listRegistryAdd = ['empresa' => $registry['empresa']];
            return $this->listRegistryAdd;

    }
}
