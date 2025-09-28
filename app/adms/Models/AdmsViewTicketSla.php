<?php

namespace App\adms\Models;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Visualizar Sla dos Tickets no banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsViewTicketSla
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
     * Metodo para visualizar os detalhes da cor
     * Recebe o ID da cor que será usado como parametro na pesquisa
     * Retorna FALSE se houver algum erro.
     * @param integer $id
     * @return void
     */
    public function viewTicketSla(int $id): void
    {
        $this->id = $id;

        $viewTicketSla = new \App\adms\Models\helper\AdmsRead();
        $viewTicketSla->fullRead("SELECT sla_hist.id AS id_sla_hist, sla_hist.empresa_id, clie.nome_fantasia AS nome_fantasia_clie, sla_hist.id_ticket AS id_ticket_sla_hist, sla_hist.dt_abert_ticket as dt_abert_ticket, 
                            sla.name as name_sla, sla_hist.tempo_sla_prim AS tempo_sla_prim, sla_hist.tempo_sla_fin AS tempo_sla_fin, sta_ant.name AS name_status_id_ant, 
                            sla_hist.dt_status_ant AS dt_status_ant, sta_atu.name AS name_sta_atu, sla_hist.dt_status AS dt_status, user.name  AS name_user, sla_hist.tempo_sla AS tempo_sla
                            FROM adms_sla_hist AS sla_hist
                            INNER JOIN adms_clientes AS clie ON clie.id = sla_hist.cliente_id 
                            INNER JOIN adms_sla AS sla ON sla.id = sla_hist.id_sla 
                            INNER JOIN adms_cham_status AS sta_ant ON sta_ant.id = sla_hist.status_id_ant
                            INNER JOIN adms_cham_status AS sta_atu ON sta_atu.id = sla_hist.status_id
                            INNER JOIN adms_users AS user ON user.id = sla_hist.suporte_id 
                            WHERE sla_hist.id= :id_sla", "id_sla={$this->id}");

        $this->resultBd = $viewTicketSla->getResult();        
        if ($this->resultBd) {
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Sla dos Tickets não encontrado!</p>";
            $this->result = false;
        }
    }
}
