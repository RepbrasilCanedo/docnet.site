<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Pagina inicial do sistema administrativo "dashboard"
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsDashboard
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int $page Recebe o número página */
    private int $page;

    /** @var int $page Recebe a quantidade de registros que deve retornar do banco de dados */
    private int $limitResult = 40;

    /** @var string|null $page Recebe a páginação */
    private string|null $resultPg;

        /** @var array $data Recebe os registros do banco de dados */
    private array|null $data;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os dados
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
     * Carrega as informações para o carroussel de marketing
     */
    public function carrMarketing(): void
    {
        $carrMarketing = new \App\adms\Models\helper\AdmsRead();
        $carrMarketing->fullRead("SELECT id, empresa_id, instagram, whatszap, image_1, titlte_1, link_url_1, image_2, titlte_2, link_url_2, image_3, titlte_3, link_url_3, 
        image_4, titlte_4, link_url_4, image_5, titlte_5, link_url_5, image_6, titlte_6, link_url_6 FROM sts_carr_mark WHERE empresa_id= :empresa_id LIMIT :limit", "limit=6&empresa_id={$_SESSION['emp_user']}");
        
        $this->resultBd = $carrMarketing->getResult();      

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $this->result = false;
        }
    }
    /**
     * Verifica se o cliente tem logo cadastrada o banco de dados
     */
    
    public function logoCliente(): void
    {
        $logoCliente = new \App\adms\Models\helper\AdmsRead();
        $logoCliente->fullRead("SELECT id, nome_fantasia, logo FROM  adms_emp_principal
                                WHERE id= :id", "id= {$_SESSION['emp_user']}");

        $this->resultBd = $logoCliente->getResult();
        if ($this->resultBd) {
            $_SESSION['logo_emp_prin']='';
            $_SESSION['logo_emp_prin']=$this->resultBd[0]['logo'];
            $this->result = true;
        } else {
            $this->result = false;
        }
    }
    
    /**
     * Metodo retornar dados para o dashboard
     * Retorna FALSE se houver algum erro
     * @param integer $id
     * @return void
     */
    // Verifica se existe tickets abertos com sla vencido -> 2
    public function verifSlaTicket(): void    
    {
        if ($_SESSION['adms_access_level_id'] > 2){

             if (($_SESSION['adms_access_level_id'] == 4) or  ($_SESSION['adms_access_level_id'] == 12)){
                $verifSlaTicket = new \App\adms\Models\helper\AdmsRead();
                $verifSlaTicket->fullRead("SELECT COUNT(cham.id) AS qnt_cham, cham.empresa_id, cham.status_id, cham.sla_id, cham.dt_cham FROM adms_cham as cham
                                    WHERE status_id= :status_id and empresa_id = :empresa and TIMESTAMPDIFF(SECOND, cham.dt_cham, NOW()) > 1800;", 
                                    "status_id=2&empresa={$_SESSION['emp_user']}");

                $this->resultBd = $verifSlaTicket->getResult();

                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $this->result = false;
                }
            }
        } else {

                $verifSlaTicket = new \App\adms\Models\helper\AdmsRead();
                $verifSlaTicket->fullRead("SELECT COUNT(cham.id) AS qnt_cham, cham.empresa_id, cham.status_id, cham.sla_id, cham.dt_cham FROM adms_cham as cham
                                    WHERE status_id= :status_id and TIMESTAMPDIFF(SECOND, cham.dt_cham, NOW()) > 1800;", 
                                    "status_id=2");

                $this->resultBd = $verifSlaTicket->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $this->result = false;
                }
        }
    }
    
    /**
     * Metodo retornar dados para o dashboard
     * Retorna FALSE se houver algum erro
     * @param integer $id
     * @return void
     */
    // verifica recebeu algum orçamento novo -> 
    public function verifOrcan(): void    
    {
        if ($_SESSION['adms_access_level_id'] > 2){

             if ($_SESSION['adms_access_level_id'] == 4){
                $verifOrcan = new \App\adms\Models\helper\AdmsRead();
                $verifOrcan->fullRead("SELECT COUNT(id) AS qnt_cham, empresa_id, status_id FROM adms_orcam
                                    WHERE status_id= :status_id and empresa_id = :empresa", 
                                    "status_id=1&empresa={$_SESSION['emp_user']}");

                $this->resultBd = $verifOrcan->getResult();

                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $this->result = false;
                }
             }
            } else {

                    if ($_SESSION['adms_access_level_id'] == 4){
                    $verifOrcan = new \App\adms\Models\helper\AdmsRead();
                    $verifOrcan->fullRead("SELECT COUNT(id) AS qnt_cham, FROM adms_orcam WHERE status_id= :status_id",  "status_id=1");

                    $this->resultBd = $verifOrcan->getResult();

                    if ($this->resultBd) {
                        $this->result = true;
                    } else {
                        $this->result = false;
                    }
            }
        }
    }
    /**
     * Metodo retornar dados para o dashboard
     * Retorna FALSE se houver algum erro
     * @param integer $id
     * @return void
     */
    // Verifica a quantidade de chamados Abertos -> 2
    public function countChamAber(): void
    {
        if (($_SESSION['adms_access_level_id'] > 2)) {
            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or  ($_SESSION['adms_access_level_id'] == 12)){
                $countCham = new \App\adms\Models\helper\AdmsRead();
                $countCham->fullRead("SELECT COUNT(id) AS qnt_cham, status_id, empresa_id FROM adms_cham WHERE status_id= :status_id and empresa_id = :empresa", 
                                    "status_id=2&empresa={$_SESSION['emp_user']}");

                $this->resultBd = $countCham->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $this->result = false;
                }
                //Se for 14 - Usuario final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {
                $countCham = new \App\adms\Models\helper\AdmsRead();
                $countCham->fullRead("SELECT COUNT(id) AS qnt_cham, status_id FROM adms_cham WHERE status_id= :status_id and cliente_id= :id_cliente", 
                "status_id=2&id_cliente={$_SESSION['set_clie']}");

                $this->resultBd = $countCham->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $this->result = false;
                }
            }
        } else {
            $countCham = new \App\adms\Models\helper\AdmsRead();
            $countCham->fullRead("SELECT COUNT(id) AS qnt_cham, status_id 
                                FROM adms_cham WHERE status_id= :status_id ", "status_id=2 ");

            $this->resultBd = $countCham->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $this->result = false;
            }
        }
    }
    
    /**
     * Metodo retornar dados para o dashboard
     * Retorna FALSE se houver algum erro
     * @param integer $id
     * @return void
     */
    // Verifica a quantidade de Equipamentos com contrato de suporte ou garantia vencidos -> 2
    public function countEquipVenc(): void
    {
        $dataAtual=date("Y-m-d");        

        if (($_SESSION['adms_access_level_id'] > 2)) {
            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or  ($_SESSION['adms_access_level_id'] == 12)){
                $countEquipVenc = new \App\adms\Models\helper\AdmsRead();
                $countEquipVenc->fullRead("SELECT COUNT(id) AS qnt_equip, sit_id, venc_contr, empresa_id FROM adms_produtos 
                                        WHERE sit_id= :sit_id and venc_contr <= :data_atual and empresa_id = :empresa", 
                                        "sit_id=1&data_atual={$dataAtual}&empresa={$_SESSION['emp_user']}");

                $this->resultBd = $countEquipVenc->getResult();

                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $this->result = false;
                }
                //Se for 14 - Usuario final
            }
        } else {
                $countEquipVenc = new \App\adms\Models\helper\AdmsRead();
                $countEquipVenc->fullRead("SELECT COUNT(id) AS qnt_equip, sit_id, venc_contr, empresa_id FROM adms_produtos 
                                        WHERE sit_id= :sit_id and venc_contr <= :data_atual", 
                                        "sit_id=1&data_atual={$dataAtual}");

                $this->resultBd = $countEquipVenc->getResult();

                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $this->result = false;
                }
        }
    }

    // Verifica a quantidade de chamados Agendados -> 9
    public function countChamAgend(): void
    {
        // Chamados Agendados
        if ($_SESSION['adms_access_level_id'] > 2) {
            //Se for 4 - Cliente Administrativo e Cliente Suporte
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)){
                $countCham = new \App\adms\Models\helper\AdmsRead();
                $countCham->fullRead("SELECT COUNT(id) AS qnt_cham, status_id, empresa_id FROM adms_cham WHERE status_id= :status_id and empresa_id = :empresa", 
                "status_id=9&empresa={$_SESSION['emp_user']}");
                $this->resultBd = $countCham->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $this->result = false;
                }
                //Se for 14 - Cliente final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {
                $countCham = new \App\adms\Models\helper\AdmsRead();
                $countCham->fullRead("SELECT COUNT(id) AS qnt_cham, status_id FROM adms_cham WHERE status_id= :status_id and cliente_id= :id_cliente", 
                "status_id=9&id_cliente={$_SESSION['set_clie']}");

                $this->resultBd = $countCham->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $this->result = false;
                }
            }
        } else {
            $countCham = new \App\adms\Models\helper\AdmsRead();
            $countCham->fullRead("SELECT COUNT(id) AS qnt_cham, status_id 
                                    FROM adms_cham WHERE status_id= :status_id ", "status_id=9");

            $this->resultBd = $countCham->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $this->result = false;
            }
        }
    }

    // Verifica a quantidade de chamados Reagendados -> 13
    public function countChamReagend(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {
            //Se for 4 - Cliente Administrativo ou Cliente Suporte
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)){
                $countCham = new \App\adms\Models\helper\AdmsRead();
                $countCham->fullRead("SELECT COUNT(id) AS qnt_cham, status_id, empresa_id FROM adms_cham WHERE status_id= :status_id and empresa_id = :empresa", 
                "status_id=13&empresa={$_SESSION['emp_user']}");
                
                $this->resultBd = $countCham->getResult();

                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $this->result = false;
                }
                //Se for 14 - Cliente final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {
                $countCham = new \App\adms\Models\helper\AdmsRead();
                $countCham->fullRead("SELECT COUNT(id) AS qnt_cham, status_id FROM adms_cham WHERE status_id= :status_id and cliente_id= :id_cliente", 
                "status_id=13&id_cliente={$_SESSION['set_clie']}");

                $this->resultBd = $countCham->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $this->result = false;
                }
            }
        } else {
            $countCham = new \App\adms\Models\helper\AdmsRead();
            $countCham->fullRead("SELECT COUNT(id) AS qnt_cham, status_id 
                                    FROM adms_cham WHERE status_id= :status_id ", "status_id=13");

            $this->resultBd = $countCham->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $this->result = false;
            }
        }
    }

    // Chamados em atendimentos ->3
    public function countChamAtend(): void
    {
        if (($_SESSION['adms_access_level_id'] > 1) and ($_SESSION['adms_access_level_id'] <> 7) and ($_SESSION['adms_access_level_id'] <> 2)) {
            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)){
                $countChamAtend = new \App\adms\Models\helper\AdmsRead();
                $countChamAtend->fullRead("SELECT COUNT(id) AS qnt_cham_atend, status_id, empresa_id FROM adms_cham WHERE status_id= :status_id and empresa_id = :empresa", 
                "status_id=3&empresa={$_SESSION['emp_user']}");
                $this->resultBd = $countChamAtend->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                } 

                //Se for 14 - Cliente final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {
                $countChamAtend = new \App\adms\Models\helper\AdmsRead();
                $countChamAtend->fullRead("SELECT COUNT(id) AS qnt_cham_atend, status_id
                            FROM adms_cham WHERE status_id= :status_id and cliente_id= :id_cliente", "status_id=3&id_cliente={$_SESSION['set_clie']}");

            $this->resultBd = $countChamAtend->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                $this->result = false;
            }
            }
        } else {
            $countChamAtend = new \App\adms\Models\helper\AdmsRead();
            $countChamAtend->fullRead("SELECT COUNT(id) AS qnt_cham_atend, status_id
                            FROM adms_cham WHERE status_id= :status_id", "status_id=3");

            $this->resultBd = $countChamAtend->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                $this->result = false;
            }
        }
    }
    // Chamados em Pausados-> 5
    public function countChamPausa(): void
    {
        if (($_SESSION['adms_access_level_id'] > 1) and ($_SESSION['adms_access_level_id'] <> 7) and ($_SESSION['adms_access_level_id'] <> 2)) {
            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)){
                $countChamPausa = new \App\adms\Models\helper\AdmsRead();
                $countChamPausa->fullRead("SELECT COUNT(id) AS qnt_cham_pausa, status_id, empresa_id FROM adms_cham WHERE status_id= :status_id and empresa_id = :empresa", 
                "status_id=5&empresa={$_SESSION['emp_user']}");
                $this->resultBd = $countChamPausa->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                }
                //Se for 14 - Cliente Final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {
                $countChamPausa = new \App\adms\Models\helper\AdmsRead();
                $countChamPausa->fullRead("SELECT COUNT(id) AS qnt_cham_pausa, status_id FROM adms_cham 
                WHERE status_id= :status_id and cliente_id= :id_cliente", "status_id=5&id_cliente={$_SESSION['set_clie']}");
                $this->resultBd = $countChamPausa->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {
            $countChamPausa = new \App\adms\Models\helper\AdmsRead();
            $countChamPausa->fullRead("SELECT COUNT(id) AS qnt_cham_pausa, status_id
                            FROM adms_cham WHERE status_id= :status_id", "status_id=5");

            $this->resultBd = $countChamPausa->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                $this->result = false;
            }
        }
    }
    
    // Chamados em aguardando outros -> 5
    public function countChamAgua(): void
    {
        if (($_SESSION['adms_access_level_id'] > 1) and ($_SESSION['adms_access_level_id'] <> 7) and ($_SESSION['adms_access_level_id'] <> 2)) {
            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)){
                $countChamPausa = new \App\adms\Models\helper\AdmsRead();
                $countChamPausa->fullRead("SELECT COUNT(id) AS qnt_cham_agua, status_id, empresa_id FROM adms_cham WHERE status_id= :status_id and empresa_id = :empresa", 
                "status_id=12&empresa={$_SESSION['emp_user']}");
                $this->resultBd = $countChamPausa->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                }
                //Se for 14 - Cliente Final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {
                $countChamPausa = new \App\adms\Models\helper\AdmsRead();
                $countChamPausa->fullRead("SELECT COUNT(id) AS qnt_cham_agua, status_id FROM adms_cham 
                WHERE status_id= :status_id and cliente_id= :id_cliente", "status_id=12&id_cliente={$_SESSION['set_clie']}");
                $this->resultBd = $countChamPausa->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {
            $countChamPausa = new \App\adms\Models\helper\AdmsRead();
            $countChamPausa->fullRead("SELECT COUNT(id) AS qnt_cham_agua, status_id
                            FROM adms_cham WHERE status_id= :status_id", "status_id=5");

            $this->resultBd = $countChamPausa->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                $this->result = false;
            }
        }
    }
    // Chamados Aguardando Setor Comercial -> 11
    public function countChamCom(): void
    {
        if (($_SESSION['adms_access_level_id'] > 1) and ($_SESSION['adms_access_level_id'] <> 7) and ($_SESSION['adms_access_level_id'] <> 2)) {
            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)){
                $countChamCom = new \App\adms\Models\helper\AdmsRead();
                $countChamCom->fullRead("SELECT COUNT(id) AS qnt_cham_com, status_id, empresa_id FROM adms_cham WHERE status_id= :status_id and empresa_id = :empresa", 
                "status_id=11&empresa={$_SESSION['emp_user']}");
                $this->resultBd = $countChamCom->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                }
                //Se for 14 - Cliente Final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {
                $countChamCom = new \App\adms\Models\helper\AdmsRead();
                $countChamCom->fullRead("SELECT COUNT(id) AS qnt_cham_com, status_id FROM adms_cham WHERE status_id= :status_id and cliente_id= :id_cliente", 
                "status_id=11&id_cliente={$_SESSION['set_clie']}");
                $this->resultBd = $countChamCom->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {
            $countChamCom = new \App\adms\Models\helper\AdmsRead();
            $countChamCom->fullRead("SELECT COUNT(id) AS qnt_cham_com, status_id
                            FROM adms_cham WHERE status_id= :status_id", "status_id=11");

            $this->resultBd = $countChamCom->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                $this->result = false;
            }
        }
    }
    // Chamados Aguardando Cliente -> 10
    public function countChamClie(): void
    {
        if (($_SESSION['adms_access_level_id'] > 1) and ($_SESSION['adms_access_level_id'] <> 7) and ($_SESSION['adms_access_level_id'] <> 2)) {
            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)){
                $countChamClie = new \App\adms\Models\helper\AdmsRead();
                $countChamClie->fullRead("SELECT COUNT(id) AS qnt_cham_clie, status_id, empresa_id FROM adms_cham WHERE status_id= :status_id and empresa_id = :empresa", 
                "status_id=10&empresa={$_SESSION['emp_user']}");
                $this->resultBd = $countChamClie->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                }
                //Se for 14 - Cliente Final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {
                $countChamClie = new \App\adms\Models\helper\AdmsRead();
                $countChamClie->fullRead("SELECT COUNT(id) AS qnt_cham_clie, status_id FROM adms_cham WHERE status_id= :status_id and cliente_id= :id_cliente", 
                "status_id=10&id_cliente={$_SESSION['set_clie']}");
                $this->resultBd = $countChamClie->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {
            $countChamClie = new \App\adms\Models\helper\AdmsRead();
            $countChamClie->fullRead("SELECT COUNT(id) AS qnt_cham_clie, status_id  FROM adms_cham WHERE status_id= :status_id", "status_id=10");

            $this->resultBd = $countChamClie->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                $this->result = false;
            }
        }
    }

    // Chamados Finalizados -> 6

    public function countChamFinal(): void
    {
        if (($_SESSION['adms_access_level_id'] > 2) and ($_SESSION['adms_access_level_id'] <> 7)) {
            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)){
                $countChamFinal = new \App\adms\Models\helper\AdmsRead();
                $countChamFinal->fullRead("SELECT COUNT(id) AS qnt_cham_final, status_id, empresa_id FROM adms_cham WHERE status_id= :status_id and empresa_id = :empresa", 
                "status_id=6&empresa={$_SESSION['emp_user']}");
                $this->resultBd = $countChamFinal->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                }
                //Se for 14 - Cliente Final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {
                $countChamFinal = new \App\adms\Models\helper\AdmsRead();
                $countChamFinal->fullRead("SELECT COUNT(id) AS qnt_cham_final, status_id FROM adms_cham WHERE status_id= :status_id and cliente_id= :id_cliente", 
                "status_id=6&id_cliente={$_SESSION['set_clie']}");
                $this->resultBd = $countChamFinal->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {
            $countChamFinal = new \App\adms\Models\helper\AdmsRead();
            $countChamFinal->fullRead("SELECT COUNT(id) AS qnt_cham_final, status_id
                            FROM adms_cham WHERE status_id= :status_id", "status_id=6");

            $this->resultBd = $countChamFinal->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                $this->result = false;
            }
        }
    }

    // Chamados Reprovados pelo Cliente -> 7
    public function countChamRepr(): void
    {
        if (($_SESSION['adms_access_level_id'] > 1) and ($_SESSION['adms_access_level_id'] <> 7) and ($_SESSION['adms_access_level_id'] <> 2)) {
            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)){
                $countChamRepr = new \App\adms\Models\helper\AdmsRead();
                $countChamRepr->fullRead("SELECT COUNT(id) AS qnt_cham_repr, status_id, empresa_id FROM adms_cham WHERE status_id= :status_id and empresa_id = :empresa", 
                "status_id=7&empresa={$_SESSION['emp_user']}");
                $this->resultBd = $countChamRepr->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                }
                //Se for 14 - Cliente Final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {
                $countChamRepr = new \App\adms\Models\helper\AdmsRead();
                $countChamRepr->fullRead("SELECT COUNT(id) AS qnt_cham_repr, status_id FROM adms_cham WHERE status_id= :status_id and cliente_id= :id_cliente", 
                "status_id=7&id_cliente={$_SESSION['set_clie']}");
                $this->resultBd = $countChamRepr->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {
            $countChamRepr = new \App\adms\Models\helper\AdmsRead();
            $countChamRepr->fullRead("SELECT COUNT(id) AS qnt_cham_repr, status_id
                            FROM adms_cham WHERE status_id= :status_id", "status_id=7");

            $this->resultBd = $countChamRepr->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                $this->result = false;
            }
        }
    }
    // Chamados Aprovados pelo Cliente -> 8
    public function countChamApro(): void
    {
        if (($_SESSION['adms_access_level_id'] > 2) and ($_SESSION['adms_access_level_id'] <> 7)) {
            //Se for 4 - Cliente Administrativo
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)){
                $countChamApro = new \App\adms\Models\helper\AdmsRead();
                $countChamApro->fullRead("SELECT COUNT(id) AS qnt_cham_apro, status_id, empresa_id FROM adms_cham WHERE status_id= :status_id and empresa_id = :empresa", 
                "status_id=8&empresa={$_SESSION['emp_user']}");
                $this->resultBd = $countChamApro->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                }
                //Se for 14 - Cliente Final
            } elseif ($_SESSION['adms_access_level_id'] == 14) {
                $countChamApro = new \App\adms\Models\helper\AdmsRead();
                $countChamApro->fullRead("SELECT COUNT(id) AS qnt_cham_apro, status_id FROM adms_cham WHERE status_id= :status_id and cliente_id= :id_cliente", 
                "status_id=8&id_cliente={$_SESSION['set_clie']}");
                $this->resultBd = $countChamApro->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                }
            }
        } else {
            $countChamApro = new \App\adms\Models\helper\AdmsRead();
            $countChamApro->fullRead("SELECT COUNT(id) AS qnt_cham_apro, status_id
                            FROM adms_cham WHERE status_id= :status_id", "status_id=8");

            $this->resultBd = $countChamApro->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                $this->result = false;
            }
        }
    }
    public function countChamAproAval(): void
    {
        $countChamApro = new \App\adms\Models\helper\AdmsRead();
        $countChamApro->fullRead("SELECT AVG(nota_atend) AS qnt_cham_apro_aval, status_id
                            FROM adms_cham WHERE status_id= :status_id", "status_id=8");

        $this->resultBd = $countChamApro->getResult();
        if ($this->resultBd) {
            $this->result = true;
        } else {
            //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
            $this->result = false;
        }
    }

    // Consulta o banco de dados para verificar se existe chamado finalizado para a empresa do usuario logado
    public function VerifChamFinal(): void
    {
        $verifChamFinal = new \App\adms\Models\helper\AdmsRead();
        $verifChamFinal->fullRead("SELECT status_id FROM adms_cham WHERE status_id= :status_id and empresa_id= :empresa_id", "status_id=6&empresa_id={$_SESSION['emp_user']}");
        $this->resultBd = $verifChamFinal->getResult();

        if ($this->resultBd) {
            $this->result = true;
        } else {
            $this->result = false;
        }
    }
    
    // Mensagen recebidas 
    public function countMensRec(): void
    {
        if ($_SESSION['adms_access_level_id'] > 2) {
            //Se for 4 - Cliente Administrativo ou suporte tecnico cliente
            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)){
                $countMensRec = new \App\adms\Models\helper\AdmsRead();
                $countMensRec->fullRead("SELECT COUNT(id) AS qnt_mens_rec, status, empresa_id FROM sts_contacts_msgs WHERE status='Enviado' and empresa_id = :empresa", 
                "empresa={$_SESSION['emp_user']}");
                $this->resultBd = $countMensRec->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                    $this->result = false;
                }
            }
            
        } else {
            $countMensRec = new \App\adms\Models\helper\AdmsRead();
            $countMensRec->fullRead("SELECT COUNT(id) AS qnt_mens_rec, status, empresa_id FROM sts_contacts_msgs WHERE status= :status_id", 
                "status_id='Enviado'");

            $this->resultBd = $countMensRec->getResult();
            if ($this->resultBd) {
                $this->result = true;
            } else {
                //$_SESSION['msg'] = "<p style='color: #f00'>Erro: Usuário não encontrado!</p>";
                $this->result = false;
            }
        }
    }
}
