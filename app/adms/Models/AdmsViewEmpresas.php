<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar detalhes da Empresa no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsViewEmpresas
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
     * Metodo para visualizar os detalhes da página
     * Recebe o ID da página que será usado como parametro na pesquisa
     * Retorna FALSE se houver algum erro
     * @param integer $id
     * @return void
     */
    public function viewEmpresas(int $id): void
    {
        $this->id = $id;

        $viewEmpresas = new \App\adms\Models\helper\AdmsRead();
        $viewEmpresas->fullRead("SELECT emp.id, emp.razao_social, emp.nome_fantasia, emp.cnpjcpf, emp.cep, emp.logradouro, emp.bairro, emp.cidade, 
                emp.uf, sit.name AS name_sit, emp.created, emp.modified
                FROM adms_clientes AS emp
                INNER JOIN adms_sits_empr_unid AS sit ON sit.id=emp.situacao 
                WHERE emp.id=:id LIMIT :limit", "id={$this->id}&limit=1");


        $this->resultBd = $viewEmpresas->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Empresa não encontrada!</p>";
            $this->result = false;
        }
    }
}
