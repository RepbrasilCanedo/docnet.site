<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Cadastrar Produtos no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsAddProd
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
     * Cadastrar a página no banco de dados
     * Retorna TRUE quando cadastrar a página com sucesso
     * Retorna FALSE quando não cadastrar a página
     * 
     * @return void
     */
    private function add(): void
    {
        $this->data['created'] = date("Y-m-d H:i:s");

        $createEquip = new \App\adms\Models\helper\AdmsCreate();
        $createEquip->exeCreate("adms_produtos", $this->data);

        if ($createEquip->getResult()) {
            $_SESSION['msg'] = "<p class='alert-success'>Produto cadastrado com sucesso!</p>";
            $urlRedirect = URLADM . "list-prod/index";
            header("Location: $urlRedirect");
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Produto não cadastrado com sucesso!</p>";
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

        if (($_SESSION['adms_access_level_id'] > 2) and ($_SESSION['adms_access_level_id'] <> 7)) {

            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12) ){

                $list->fullRead("SELECT id id_typ, name name_typ FROM adms_type_equip ORDER BY name ASC");
                $registry['type_equip'] = $list->getResult();

                $list->fullRead("SELECT id id_sit, name name_sit FROM adms_sits_empr_unid ORDER BY name ASC");
                $registry['sit_equip'] = $list->getResult();

                $list->fullRead("SELECT id id_emp, nome_fantasia nome_fantasia_emp FROM adms_clientes WHERE id= :id ORDER BY nome_fantasia ASC", "id={$_SESSION['emp_user']}");
                $registry['emp_equip'] = $list->getResult();

                $this->listRegistryAdd = [
                    'type_equip' => $registry['type_equip'], 'emp_equip' => $registry['emp_equip'], 'sit_equip' => $registry['sit_equip']
                ];
            } else if ($_SESSION['adms_access_level_id'] == 13) {

                $list->fullRead("SELECT id id_typ, name name_typ FROM adms_type_equip ORDER BY name ASC");
                $registry['type_equip'] = $list->getResult();



                $list->fullRead("SELECT id id_sit, name name_sit FROM adms_sits_empr_unid ORDER BY name ASC");
                $registry['sit_equip'] = $list->getResult();

                $list->fullRead("SELECT id id_emp, nome_fantasia nome_fantasia_emp FROM adms_clientes WHERE contrato = :contrato  ORDER BY nome_fantasia ASC", "contrato={$_SESSION['set_Contr']}");
                $registry['emp_equip'] = $list->getResult();

                $this->listRegistryAdd = [
                    'type_equip' => $registry['type_equip'],'emp_equip' => $registry['emp_equip'], 'sit_equip' => $registry['sit_equip']
                ];
            } else if ($_SESSION['adms_access_level_id'] == 4) {

                $list->fullRead("SELECT id id_typ, name name_typ FROM adms_type_equip ORDER BY name ASC");
                $registry['type_equip'] = $list->getResult();



                $list->fullRead("SELECT id id_sit, name name_sit FROM adms_sits_empr_unid ORDER BY name ASC");
                $registry['sit_equip'] = $list->getResult();

                $list->fullRead("SELECT id id_emp, nome_fantasia nome_fantasia_emp FROM adms_clientes WHERE contrato = :contrato  ORDER BY nome_fantasia ASC", "contrato={$_SESSION['set_Contr']}");
                $registry['emp_equip'] = $list->getResult();

                $this->listRegistryAdd = [
                    'type_equip' => $registry['type_equip'],'emp_equip' => $registry['emp_equip'], 'sit_equip' => $registry['sit_equip']
                ];
            }
        } else {

            $list->fullRead("SELECT id id_typ, name name_typ FROM adms_type_equip ORDER BY name ASC");
            $registry['type_equip'] = $list->getResult();

            $list->fullRead("SELECT id id_emp, nome_fantasia nome_fantasia_emp FROM adms_clientes ORDER BY nome_fantasia ASC");
            $registry['emp_equip'] = $list->getResult();

            $list->fullRead("SELECT id id_sit, name name_sit FROM adms_sits_empr_unid ORDER BY name ASC");
            $registry['sit_equip'] = $list->getResult();

            $list->fullRead("SELECT id id_cont, num_cont FROM  adms_contr AS cont ORDER BY num_cont ASC");
            $registry['emp_cont'] = $list->getResult();

            $this->listRegistryAdd = [
                'type_equip' => $registry['type_equip'],'emp_equip' => $registry['emp_equip'], 'sit_equip' => $registry['sit_equip']];
        }

        return $this->listRegistryAdd;
    }
}
