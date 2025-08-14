<?php

namespace App\adms\Models;

use DateTime;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}
/**
 * Cadastrar Chamdo no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsAddOrcam
{
    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $resultHist;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var array Recebe as informações que serão usadas no dropdown do formulário*/
    private array|null $listRegistryAdd;

    /** @var array $dataExitVal Recebe as informações que serão retiradas da validação*/
    private array $dataExitVal;

    /** @var bool|null $data Recebe as informações do formulário */
    private bool|null $validado;

    private string $dataatual;
    private  string $datainicial;
    private int $dias;

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
            $this->valClieAtivo();
         
        } else {
            $this->result = false;
        }
    }
    /**
     * Metodo para pesquisar se a empresa esta ativa 
     *
     * @return array
     */
    private function valClieAtivo(): void
    {
        $valContAtivo = new \App\adms\Models\helper\AdmsRead();
        $valContAtivo->fullRead("SELECT id,  situacao  FROM adms_clientes WHERE id= :id and situacao = :situacao","id={$_SESSION['set_clie']}&situacao=1");  
        
        $this->resultBd = $valContAtivo->getResult();   

        if ($this->resultBd) {
            $this->add();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Este orçamento não pode ser CRIADO pois o cliente esncontra-se INATIVO<b>!</p>";
            $this->result = false;
        }
    }

    /** 
    * Cadastrar a orcamento no banco de dados
     * Retorna TRUE quando cadastrar a página com sucesso
     * Retorna FALSE quando não cadastrar a página
     * 
     * @return void
     */
    private function add(): void
    {      
        
        date_default_timezone_set('America/Bahia');

        $this->data['usuario_id'] = $_SESSION['user_id'];
        $this->data['empresa_id'] = $_SESSION['emp_user'];
        $this->data['cliente_id'] = $_SESSION['set_clie'];
        $this->data['dt_orcam'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 1;
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['created'] = date("Y-m-d H:i:s");
  
        $createOrcam = new \App\adms\Models\helper\AdmsCreate();
        $createOrcam->exeCreate("adms_orcam", $this->data);

        if ($createOrcam->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Orçamento cadastrado com sucesso!</p>";
            $urlRedirect = URLADM . "list-orcam/index";
            header("Location: $urlRedirect");
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Orçamento não cadastrado com sucesso!</p>";
            $this->result = false;
        }
    }
}
