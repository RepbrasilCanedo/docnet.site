<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar detalhes da página no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsViewProd
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
    public function viewProd(int $id): void
    {
        $this->id = $id;

        $viewProd = new \App\adms\Models\helper\AdmsRead();
        $viewProd->fullRead("SELECT prod.id as id_prod, prod.name as name_prod, typ.name as name_type, prod.serie as serie_prod, 
                prod.modelo_id as name_modelo, prod.marca_id as name_mar, clie.nome_fantasia as nome_fantasia_clie, 
                prod.inf_adicionais as inf_adicionais, sit.name as name_sit, prod.created, prod.modified
                FROM adms_produtos AS prod  
                INNER JOIN adms_type_equip AS typ ON typ.id=prod.type_id 
                INNER JOIN adms_clientes AS clie ON clie.id=prod.cliente_id 
                INNER JOIN adms_sit_equip AS sit ON sit.id=prod.sit_id
                WHERE prod.id= :prod_id and prod.cliente_id= :cliente_id", "prod_id={$this->id}&cliente_id={$_SESSION['emp_user']}");


        $this->resultBd = $viewProd->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Produto não encontrado!</p>";
            $this->result = false;
        }
    }
}
