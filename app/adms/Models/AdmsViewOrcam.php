<?php

namespace App\adms\Models;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar o chamado no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsViewOrcam
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;
    

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $listRegistryAdd;

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
     * Metodo para visualizar os detalhes do chamado
     * Recebe o ID do chamado que será usado como parametro na pesquisa
     * Retorna FALSE se houver algum erro.
     * @param integer $id
     * @return void
     */
    public function viewOrcam(int $id): void
    {
        
        $this->id = $id;
        $_SESSION['set_cham']='';
        $_SESSION['set_cham'] = $this->id;

        $viewOrcam = new \App\adms\Models\helper\AdmsRead();
        $viewOrcam->fullRead("SELECT orcam.id as id_orcam, orcam.empresa_id, clie.nome_fantasia as nome_fantasia_id_clie, orcam.contato as contato_id_orcam,
                            orcam.prod_serv as prod_serv_orcam, orcam.image, orcam.tel_contato as tel_contato_orcam, orcam.usuario_id as usuario_id_orcam, orcam.prod_serv, orcam.info_prod_serv, orcam.status_id, status_orcam.name as name_status_orcam, 
                            orcam.dt_orcam as dt_orcam_orcam, orcam.dt_status as dt_status_orcam, user_final.name as name_user_final, orcam.inf_adic as inf_adic_orcam
                            FROM adms_orcam as orcam
                            INNER JOIN adms_clientes AS clie ON clie.id=orcam.cliente_id 
                            INNER JOIN adms_orcam_status AS status_orcam ON status_orcam.id=orcam.status_id 
                            LEFT JOIN adms_users_final AS user_final ON user_final.id=orcam.usuario_id_aval 
                            WHERE orcam.id= :orcam_id LIMIT :limit","orcam_id={$this->id}&limit=1");

        $this->resultBd = $viewOrcam->getResult();        
        if ($this->resultBd) {   
            $this->result = true;
        } else {            
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Orçamento não encontrado!</p>";
            $this->result = false;
            
        }
    }
}
