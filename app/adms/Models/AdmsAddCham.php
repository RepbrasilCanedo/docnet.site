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
class AdmsAddCham
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
        $valContAtivo->fullRead("SELECT id,  situacao  FROM adms_clientes WHERE id= :id and situacao = :situacao","id={$this->data['cliente_id']}&situacao=1");  
        
        $this->resultBd = $valContAtivo->getResult();   

        if ($valContAtivo->getResult()) {
            $this->val_prod();
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Este chamado não pode ser ABERTO pois o cliente esncontra-se INATIVO<b>!</p>";
            $this->result = false;
        }
    }

        
        
     /**
     * Metodo para verifica se o produto esta com contrato ativo e dentro do periodo de validade
     *
     * @return array
     */
          private function val_prod(): void
     {
               $viewProd = new \App\adms\Models\helper\AdmsRead();
                $viewProd->fullRead("SELECT id, cliente_id, dias, inicio_contr FROM adms_produtos 
                WHERE id= :id AND cliente_id= :cliente_id", "id={$this->data['prod_id']}& cliente_id={$this->data['cliente_id']}");
                $this->resultBd = $viewProd->getResult();

                if ($this->resultBd) {
                    // Sua data inicial
                    $dataInicial = $this->resultBd[0]['inicio_contr'];

                    // Número de dias a adicionar
                    $diasParaAdicionar = $this->resultBd[0]['dias'];

                    // Adiciona os dias e formata a nova data em uma única linha
                    $novaData = date('d/m/Y', strtotime($dataInicial . " +{$diasParaAdicionar} days"));

                    // Exibe a nova data
                    if($novaData < date(date("Y-m-d H:i:s"))){
                    $this->result = true;
                     $this->add();
                    } else{
                        $_SESSION['msg'] = "<p class='alert-danger'>Não e possivel a abertura de Ticket para este produto pois o contrato de suporte tecnico ou garantia esta vencido. Entre em contato com o setor comercial da REPBRASIL 071 98137 6244</p>";
                        $this->result = false;
                    };
                    
                   
                } else {
                    $_SESSION['msg'] = "<p class='alert-danger'>Erro: Produto não encontrado!</p>";
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
        date_default_timezone_set('America/Bahia');

        $this->data['usuario_id'] = $_SESSION['user_id'];
        $this->data['empresa_id'] = $_SESSION['emp_user'];
        $this->data['dt_cham'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 2;
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['created'] = date("Y-m-d H:i:s");
            

        
        $createCham = new \App\adms\Models\helper\AdmsCreate();
        $createCham->exeCreate("adms_cham", $this->data);

        if ($createCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Ticket aberto com sucesso!</p>";
            $urlRedirect = URLADM . "list-cham/index";
            header("Location: $urlRedirect");
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Ticket não aberto com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para pesquisar as informações que serão usadas no dropdown do formulário
     *
     * @return array
     */
    public function listSelect()
    {
        $list = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['adms_access_level_id'] > 2) {

            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $list->fullRead("SELECT id, nome_fantasia FROM adms_clientes 
                WHERE empresa= :empresa", "empresa={$_SESSION['emp_user']}");
                $registry['cliente'] = $list->getResult();

                $list->fullRead("SELECT id, name, dias, inicio_contr, cliente_id, empresa_id FROM adms_produtos 
                WHERE empresa_id= :empresa", "empresa={$_SESSION['emp_user']}");
                $registry['produto'] = $list->getResult();

                $this->listRegistryAdd = ['cliente' => $registry['cliente'],'produto' => $registry['produto']];

                //Se for 14 - Usuario(a) final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {

                $list->fullRead("SELECT id, nome_fantasia FROM adms_clientes 
                WHERE (empresa= :empresa) AND (id = :cliente) ORDER BY nome_fantasia ASC", "empresa={$_SESSION['emp_user']}&cliente={$_SESSION['set_clie']}");
                $registry['cliente'] = $list->getResult();

                $list->fullRead("SELECT id, name, dias, inicio_contr, cliente_id, empresa_id FROM adms_produtos
                WHERE cliente_id= :cliente_id", "cliente_id={$_SESSION['set_clie']}");
                $registry['produto'] = $list->getResult();

                $this->listRegistryAdd = ['cliente' => $registry['cliente'],'produto' => $registry['produto']];
            }
        } else {

            $list->fullRead("SELECT id, nome_fantasia FROM adms_clientes ORDER BY nome_fantasia ASC");
            $registry['cliente'] = $list->getResult();

            $this->listRegistryAdd = ['cliente' => $registry['cliente']];
        }
        

        return $this->listRegistryAdd;
    }
}
