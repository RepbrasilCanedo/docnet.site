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
     * Verifica se o cliente tem logo cadastrada o banco de dados
     */
    
    public function logoContrato(): void
    {
        $logoContrato = new \App\adms\Models\helper\AdmsRead();
        $logoContrato->fullRead("SELECT id, clie_cont, logo_clie FROM adms_contr
                                WHERE id= :contr_id", "contr_id= {$_SESSION['set_Contr']}");

        $this->resultBd = $logoContrato->getResult();
        if ($this->resultBd) {
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
    // Verifica a quantidade de chamados Abertos -> 2
    public function countChamAber(): void
    {
        if (($_SESSION['adms_access_level_id'] > 2)) {
            //Se for 4 - Cliente Administrativo
            if ($_SESSION['adms_access_level_id'] == 4) {
                $countCham = new \App\adms\Models\helper\AdmsRead();
                $countCham->fullRead("SELECT COUNT(id) AS qnt_cham, status_id, empresa_id FROM adms_cham WHERE status_id= :status_id and empresa_id = :empresa", 
                                    "status_id=2&empresa={$_SESSION['emp_user']}");

                $this->resultBd = $countCham->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $this->result = false;
                }
                //Se for 13 - Suporte Cliente
            } elseif ($_SESSION['adms_access_level_id'] == 12) {
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
                $countCham->fullRead("SELECT COUNT(id) AS qnt_cham FROM adms_cham WHERE status_id= :status_id and cliente_id= :id_cliente", 
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

    // Verifica a quantidade de chamados Abertos -> 9
    public function countChamAgend(): void
    {
        // Chamados Agendados
        if ($_SESSION['adms_access_level_id'] > 2) {
            //Se for 4 - Cliente Administrativo
            if ($_SESSION['adms_access_level_id'] == 4) {
                $countCham = new \App\adms\Models\helper\AdmsRead();
                $countCham->fullRead("SELECT COUNT(id) AS qnt_cham, status_id, empresa_id FROM adms_cham WHERE status_id= :status_id and empresa_id = :empresa", 
                "status_id=9&empresa={$_SESSION['emp_user']}");
                $this->resultBd = $countCham->getResult();
                if ($this->resultBd) {
                    $this->result = true;
                } else {
                    $this->result = false;
                }
                //Se for 13 - Cliente Suporte
            } elseif ($_SESSION['adms_access_level_id'] == 12) {
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
                $countCham->fullRead("SELECT COUNT(id) AS qnt_cham FROM adms_cham WHERE status_id= :status_id and cliente_id= :id_cliente", 
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

    // Chamados em atendimentos ->3
    public function countChamAtend(): void
    {
        if (($_SESSION['adms_access_level_id'] > 1) and ($_SESSION['adms_access_level_id'] <> 7) and ($_SESSION['adms_access_level_id'] <> 2)) {
            //Se for 4 - Cliente Administrativo
            if ($_SESSION['adms_access_level_id'] == 4) {
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

                //Se for 12 - Cliente Suporte
            } elseif ($_SESSION['adms_access_level_id'] == 12) {
                $countChamPausa = new \App\adms\Models\helper\AdmsRead();
                $countChamPausa->fullRead("SELECT COUNT(id) AS qnt_cham_atend FROM adms_cham WHERE status_id= :status_id and empresa_id= :empresa_id", 
                "status_id=3&empresa_id={$_SESSION['emp_user']}");

                $this->resultBd = $countChamPausa->getResult();
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
            if ($_SESSION['adms_access_level_id'] == 4) {
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
                //Se for 12 - Cliente Suporte
            } elseif ($_SESSION['adms_access_level_id'] == 12) {
                $countChamPausa = new \App\adms\Models\helper\AdmsRead();
                $countChamPausa->fullRead("SELECT COUNT(id) AS qnt_cham_pausa FROM adms_cham WHERE status_id= :status_id and empresa_id= :empresa_id", 
                "status_id=5&empresa_id={$_SESSION['emp_user']}");

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
            $countChamPausa->fullRead("SELECT COUNT(id) AS qnt_cham_pausa
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
            if ($_SESSION['adms_access_level_id'] == 4) {
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
                //Se for 12 - Cliente Suporte
            } elseif ($_SESSION['adms_access_level_id'] == 12) {
                $countChamCom = new \App\adms\Models\helper\AdmsRead();
                $countChamCom->fullRead("SELECT COUNT(id) AS qnt_cham_com FROM adms_cham WHERE status_id= :status_id and empresa_id= :empresa_id", "status_id=11&empresa_id={$_SESSION['emp_user']}");
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
            $countChamCom->fullRead("SELECT COUNT(id) AS qnt_cham_com
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
            if ($_SESSION['adms_access_level_id'] == 4) {
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
                //Se for 12 - Cliente Suporte
            } elseif ($_SESSION['adms_access_level_id'] == 12) {
                $countChamClie = new \App\adms\Models\helper\AdmsRead();
                $countChamClie->fullRead("SELECT COUNT(id) AS qnt_cham_clie FROM adms_cham WHERE status_id= :status_id and empresa_id= :empresa_id", "status_id=10&empresa_id={$_SESSION['emp_user']}");

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
        if (($_SESSION['adms_access_level_id'] > 1) and ($_SESSION['adms_access_level_id'] <> 7) and ($_SESSION['adms_access_level_id'] <> 2)) {
            //Se for 4 - Cliente Administrativo
            if ($_SESSION['adms_access_level_id'] == 4) {
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
                //Se for 13 - Cliente Suporte
            } elseif ($_SESSION['adms_access_level_id'] == 12) {
                $countChamFinal = new \App\adms\Models\helper\AdmsRead();
                $countChamFinal->fullRead("SELECT COUNT(id) AS qnt_cham_final FROM adms_cham WHERE status_id= :status_id and contrato_id= :contrato_id", "status_id=6&contrato_id={$_SESSION['set_Contr']}");

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
            $countChamFinal->fullRead("SELECT COUNT(id) AS qnt_cham_final
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
            if ($_SESSION['adms_access_level_id'] == 4) {
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
                //Se for 13 - Cliente Suporte
            } elseif ($_SESSION['adms_access_level_id'] == 12) {
                $countChamRepr = new \App\adms\Models\helper\AdmsRead();
                $countChamRepr->fullRead("SELECT COUNT(id) AS qnt_cham_repr FROM adms_cham WHERE status_id= :status_id and contrato_id= :contrato_id", "status_id=7&contrato_id={$_SESSION['set_Contr']}");

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
            $countChamRepr->fullRead("SELECT COUNT(id) AS qnt_cham_repr
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
        if (($_SESSION['adms_access_level_id'] > 1) and ($_SESSION['adms_access_level_id'] <> 7) and ($_SESSION['adms_access_level_id'] <> 2)) {
            //Se for 4 - Cliente Administrativo
            if ($_SESSION['adms_access_level_id'] == 4) {
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
                //Se for 13 - Cliente Suporte
            } elseif ($_SESSION['adms_access_level_id'] == 12) {
                $countChamApro = new \App\adms\Models\helper\AdmsRead();
                $countChamApro->fullRead("SELECT COUNT(id) AS qnt_cham_apro FROM adms_cham WHERE status_id= :status_id and contrato_id= :contrato_id", "status_id=8&contrato_id={$_SESSION['set_Contr']}");

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
            $countChamApro->fullRead("SELECT COUNT(id) AS qnt_cham_apro
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
        $countChamApro->fullRead("SELECT AVG(nota_atend) AS qnt_cham_apro_aval
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
}
