<?php

namespace App\adms\Models;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar mensagens do banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsListcontato
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int $page Recebe o número página */
    private int $page;

    /** @var int $page Recebe a quantidade de registros que deve retornar do banco de dados */
    private int $limitResult = 40;

    /** @var string|null $page Recebe a páginação */
    private string|null $resultPg;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os registros do BD
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    /**
     * @return bool Retorna a paginação
     */
    function getResultPg(): string|null
    {
        return $this->resultPg;
    }

    /**
     * Metodo faz a pesquisa das mensagens na tabela "adms_contato" e lista as informações na view
     * Recebe como parametro "page" para fazer a paginação
     * @param integer|null $page
     * @return void
     */
    public function listContato(int $page):void
    {
        $this->page = (int) $page ? $page : 1;

        $pagination = new \App\adms\Models\helper\AdmsPagination(URLADM . 'list-contato/index');
        $pagination->condition($this->page, $this->limitResult);
        $pagination->pagination("SELECT COUNT(id) AS num_result FROM sts_contacts_msgs");
        $this->resultPg = $pagination->getResult();
        if ($_SESSION['adms_access_level_id'] > 2) {
            $listContato = new \App\adms\Models\helper\AdmsRead();
            $listContato->fullRead("SELECT mens.id as id_mens, mens.empresa_id, clie.nome_fantasia as nome_fantasia_clie, mens.assunto as assunto_mens, 
            mens.nome as nome_mens, mens.email as email_mens, mens.tel as tel_mens, mens.mensagem as mensagem_mens, mens.dia as dia_mens, mens.status as status_mens
            FROM sts_contacts_msgs AS mens
            INNER JOIN adms_clientes AS clie ON clie.id=mens.cliente_id 
            WHERE mens.empresa_id = :empresa_id
            LIMIT :limit OFFSET :offset","empresa_id={$_SESSION['emp_user']}&limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listContato->getResult();        
            if($this->resultBd){
                $this->result = true;
            }else{
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma Mensagem encontrada!</p>";
                $this->result = false;
            }
        } else {
            $listContato = new \App\adms\Models\helper\AdmsRead();
            $listContato->fullRead("SELECT mens.id as id_mens, mens.empresa_id, clie.nome_fantasia as nome_fantasia_clie, mens.assunto as assunto_mens, 
            mens.nome as nome_mens, mens.email as email_mens, mens.tel as tel_mens, mens.mensagem as mensagem_mens, mens.dia as dia_mens, mens.status as status_mens
            FROM sts_contacts_msgs AS mens
            INNER JOIN adms_clientes AS clie ON clie.id=mens.cliente_id 
            LIMIT :limit OFFSET :offset","limit={$this->limitResult}&offset={$pagination->getOffset()}");

            $this->resultBd = $listContato->getResult();        
            if($this->resultBd){
                $this->result = true;
            }else{
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhuma Mensagem encontrada!</p>";
                $this->result = false;
            }
        }
    }

    
}
