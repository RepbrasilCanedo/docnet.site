<?php

namespace App\adms\Models;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar o perfil do usuario
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsViewProfileOrcam
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

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
     * Metodo para visualizar o perfil do orcamento
     * Recebe o ID do orcamento que será usado como parametro na pesquisa
     * Retorna FALSE se houver algum erro
     * @return void
     */
    public function viewProfileOrcam(int $id): void
    {
        $this->id = $id;
        $viewProfileOrcam = new \App\adms\Models\helper\AdmsRead();
        $viewProfileOrcam->fullRead("SELECT id, empresa_id, status_id, prod_serv, info_prod_serv, image FROM  adms_orcam WHERE id= :id_orcam", "id_orcam={$this->id}");

        $this->resultBd = $viewProfileOrcam->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Orçamento não encontrado.</p>";
            //$this->result = false;
        }
    }
}