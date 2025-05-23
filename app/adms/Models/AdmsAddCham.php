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

    /*
    verifica intervalo de dias entre datas
     WHERE (DATEDIFF(dt_term, dt_inicio) < 30) AND (empresa_id = :empresa_id) AND (sit_cont = :sit_cont)","empresa_id={$_SESSION['empresa_contr']}&sit_cont=1)"); */

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
        $this->data['dt_cham'] = date("Y-m-d H:i:s");
        $this->data['status_id'] = 2;
        $this->data['dt_status'] = date("Y-m-d H:i:s");
        $this->data['created'] = date("Y-m-d H:i:s");
        $createCham = new \App\adms\Models\helper\AdmsCreate();
        $createCham->exeCreate("adms_cham", $this->data);

        if ($createCham->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Chamado cadastrado com sucesso!</p>";
            $urlRedirect = URLADM . "list-cham/index";
            header("Location: $urlRedirect");
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado não cadastrado com sucesso!</p>";
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

                //Se for 14 - Usuario(a) final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {

                $list->fullRead("SELECT id, nome_fantasia FROM adms_clientes 
                WHERE (empresa= :empresa) AND (id = :cliente) ORDER BY nome_fantasia ASC", "empresa={$_SESSION['emp_user']}&cliente={$_SESSION['set_clie']}");
                $registry['cliente'] = $list->getResult();

                $list->fullRead("SELECT id, name FROM adms_produtos 
                WHERE cliente_id= :cliente_id", "cliente_id={$_SESSION['set_clie']}");
                $registry['produto'] = $list->getResult();
            }
        } else {

            $list->fullRead("SELECT id, nome_fantasia FROM adms_clientes ORDER BY nome_fantasia ASC");
            $registry['cliente'] = $list->getResult();
        }
        $this->listRegistryAdd = ['cliente' => $registry['cliente'],'produto' => $registry['produto']];

        return $this->listRegistryAdd;
    }
}
