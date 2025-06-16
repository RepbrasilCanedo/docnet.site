<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar Contrato no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsAddContr
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
    public function create(array $data = null)
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
     * Cadastrar a página no banco de dados
     * Retorna TRUE quando cadastrar a página com sucesso
     * Retorna FALSE quando não cadastrar a página
     * 
     * @return void
     */
    private function add(): void
    {
        $this->data['created'] = date("Y-m-d H:i:s");

        $createContr = new \App\adms\Models\helper\AdmsCreate();
        $createContr->exeCreate("adms_contr", $this->data);

        if ($createContr->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Contrato cadastrado com sucesso!</p>";
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Contrato não cadastrado com sucesso!</p>";
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

        $list->fullRead("SELECT id clie_id, nome_fantasia fantasia_name FROM adms_empresa ORDER BY nome_fantasia ASC");
        $registry['clie_cont'] = $list->getResult();

        $list->fullRead("SELECT id id_service, name name_service FROM adms_contr_service ORDER BY name ASC");
        $registry['name_service'] = $list->getResult();

        $list->fullRead("SELECT id id_sit, name name_sit FROM adms_contr_sit ORDER BY name ASC");
        $registry['name_sit'] = $list->getResult();

        $list->fullRead("SELECT id id_tipo, name name_tipo FROM adms_contr_type ORDER BY name ASC");
        $registry['name_tipo'] = $list->getResult();

        $this->listRegistryAdd = ['clie_cont' => $registry['clie_cont'], 'name_service' => $registry['name_service'],
        'name_sit' => $registry['name_sit'], 'name_tipo' => $registry['name_tipo']];

        return $this->listRegistryAdd;
    }
}
