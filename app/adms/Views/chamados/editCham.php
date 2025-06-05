<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}
//echo "<pre>"; print_r($valorForm);echo "</pre>";
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <div class="d-flex flex-wrap align-items-center mb-3">
            <span class="me-2">Atendimento : </span>
            <div class="top-list-center">
                <?php
                $name_sta = "";
                if (isset($valorForm['name_sta'])) {
                    $name_sta = $valorForm['name_sta'];
                }
                ?>
                <h1 class="mb-3"><?php echo $name_sta; ?></h1>

            </div>
            </div>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_cham']) {
                    echo "<a href='" . URLADM . "list-cham/index' class='btn-info'>Listar</a> ";
                }
                if (isset($valorForm['id'])) {
                    if ($this->data['button']['view_cham']) {
                        echo "<a href='" . URLADM . "view-cham/index/" . $_SESSION['set_cham'] . "' class='btn-primary'>Visualizar</a><br><br>";
                    }
                }
                ?>

            </div>
        </div>



        <div class="content-adm-alert">
            <?php
            if (isset($_SESSION['msg'])) {
                echo $_SESSION['msg'];
                unset($_SESSION['msg']);
            }
            ?>
            <span id="msg"></span>
        </div>

        <form method="post" action="">
            <div class="row">
                <div class="col-md-12">
                    <?php if ($name_sta == 'Aberto') { ?>
                        <button type="submit" name="SendInicCham" value="Iniciar" class="btn btn-success btn-sm"><span class="fas far fa-play-circle me-2"></span>Iniciar o Atendimento</button>

                    <?php } elseif ($name_sta == 'Pausado') { ?>
                        <button type="submit" name="SendInicCham" value="Pausar" class="btn btn-info btn-sm"><span class="fas fa-bed me-2"></span>Reiniciar Atendimento</button>
                        <?php
                        if ($this->data['button']['list_cham']) {
                            $_SESSION['set_status'] = 'Pausado';
                            echo "<a href='" . URLADM . "add-hist-cham/index/" . $_SESSION['set_cham'] . "' class='btn btn-success btn-sm'>Cadastrar Histórico</a><br><br>";
                        }
                        ?>

                    <?php } elseif ($name_sta == 'Aguardando Comercial') { ?>
                        <button type="submit" name="SendInicCham" value="Aguardar_Comercial" class="btn btn-info btn-sm"><span class="fa-solid fa-money-bill-transfer me-2"></span>Reiniciar Atendimento</button>
                        <?php
                        if ($this->data['button']['list_cham']) {
                            $_SESSION['set_status'] = 'Aguardando Comercial';
                            echo "<a href='" . URLADM . "add-hist-cham/index/" . $_SESSION['set_cham'] . "' class='btn btn-success btn-sm'>Cadastrar Histórico</a><br><br>";
                        }
                        ?>

                    <?php } elseif ($name_sta == 'Aguardando Cliente') { ?>
                        <button type="submit" name="SendInicCham" value="Aguardar" class="btn btn-info btn-sm"><span class="fa-solid fa-truck-fast me-2"></span>Reiniciar Atendimento</button>
                        <?php
                        if ($this->data['button']['list_cham']) {
                            $_SESSION['set_status'] = 'Aguardando Cliente';
                            echo "<a href='" . URLADM . "add-hist-cham/index/" . $_SESSION['set_cham'] . "' class='btn btn-success btn-sm'>Cadastrar Histórico</a><br><br>";
                        }
                        ?>

                    <?php } elseif ($name_sta == 'Aguardando Outros') { ?>
                        <button type="submit" name="SendInicCham" value="Aguardando_Outros" class="btn btn-info btn-sm"><span class="fa-solid fa-hourglass me-2"></span>Reiniciar Atendimento</button>
                        <?php
                        if ($this->data['button']['list_cham']) {
                            $_SESSION['set_status'] = 'Aguardando Outros';
                            echo "<a href='" . URLADM . "add-hist-cham/index/" . $_SESSION['set_cham'] . "' class='btn btn-success btn-sm'>Cadastrar Histórico</a><br><br>";
                        }
                        ?>

                    <?php } elseif ($name_sta == 'Finalizado') { ?>
                        <?php
                        if ($this->data['button']['list_cham']) {
                            $_SESSION['set_status'] = 'Finalizado';
                            echo "<a href='" . URLADM . "add-hist-cham/index/" . $_SESSION['set_cham'] . "' class='btn btn-success btn-sm'>Cadastrar Histórico</a><br><br>";
                        }
                        ?>
                    <?php } elseif ($name_sta == 'Agendado') { ?>
                        <button type="submit" name="SendInicCham" value="Iniciar" class="btn btn-success btn-sm"><span class="fas far fa-play-circle me-2"></span>Iniciar o Atendimento</button>

                    <?php } elseif ($name_sta == 'Aprovado') { ?>

                    <?php } elseif ($name_sta == 'Reprovado') { ?>
                        <button type="submit" name="SendInicCham" value="Iniciar" class="btn btn-danger btn-sm"><span class="fas far fa-play-circle me-2"></span>Reabrir Atendimento</button>
                        <?php
                        if ($this->data['button']['list_cham']) {
                            $_SESSION['set_status'] = 'Reprovado';
                            echo "<a href='" . URLADM . "add-hist-cham/index/" . $_SESSION['set_cham'] . "' class='btn btn-success btn-sm'>Cadastrar Histórico</a><br><br>";
                        }
                        ?>
                    <?php } else { ?>
                        <button type="submit" name="SendPausCham" value="Pausar" class="btn btn-warning btn-sm"><span class="fas fa-bed me-2"></span>Pausar Atendimento</button>
                        <button type="submit" name="SendPausCom" value="Aguardar_Comercial" class="btn btn-dark btn-sm"><span class="fa-solid fa-money-bill-transfer me-2"></span>Aguardar Comercial</button>
                        <button type="submit" name="SendPendCham" value="Aguardar" class="btn btn-danger btn-sm"><span class="fa-solid fa-truck-fast me-2"></span>Aguardar Cliente</button>
                        <button type="submit" name="SendAguarCham" value="Aguardando_Outros" class="btn btn-success btn-sm"><span class="fa-solid fa-hourglass me-2"></span>Aguardando Outros</button>
                        <button type="submit" name="SendFinaCham" value="Finalizar" class="btn btn-primary btn-sm"><span class="fas fa-check me-2"></span>Finalizar Atendimento</button>

                    <?php } ?>


                </div>


                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <?php
                            $id = "";
                            if (isset($valorForm['id'])) {
                                $id = $valorForm['id'];
                            }
                            ?>
                            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                            <div class="card-body border-top border-info border-5 input-group-sm">

                                <div class="input-group">
                                    <?php
                                    $nome_fantasia_clie = "";
                                    if (isset($valorForm['nome_fantasia_clie'])) {
                                        $nome_fantasia_clie = $valorForm['nome_fantasia_clie'];
                                    }
                                    ?>
                                    <span class="input-group-text view-adm-title">Empresa:</span>
                                    <span class="form-control"><?php echo $nome_fantasia_clie; ?></span>
                                </div>

                                <div class="input-group">
                                    <?php
                                    $contato = "";
                                    if (isset($valorForm['contato'])) {
                                        $contato = $valorForm['contato'];
                                    }
                                    ?>
                                    <span class="input-group-text">Contato</span>
                                    <span class="form-control"><?php echo $contato; ?></span>
                                </div>
                                <div class="input-group">
                                    <?php
                                    $tel_contato = "";
                                    if (isset($valorForm['tel_contato'])) {
                                        $tel_contato = $valorForm['tel_contato'];
                                    }
                                    ?>
                                    <span class="input-group-text">Tel/Zap:</span>
                                    <span class="form-control"><?php echo $tel_contato; ?></span>
                                </div>
                                <div class="input-group">
                                    <?php
                                    $id = "";
                                    if (isset($valorForm['id'])) {
                                        $id = $valorForm['id'];
                                    }
                                    ?>
                                    <span class="input-group-text">Número Chamado</span>
                                    <span class="form-control"><?php echo $id; ?></span>
                                </div>

                                <div class="input-group">
                                    <?php
                                    $dt_cham = "";
                                    if (isset($valorForm['dt_cham'])) {
                                        $dt_cham = $valorForm['dt_cham'];
                                    }
                                    ?>
                                    <span class="input-group-text">Data Chamado</span>
                                    <span class="form-control"><?php echo date('d/m/Y H:i:s', strtotime($dt_cham)); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body border-top border-info border-5 input-group-sm">
                                <div class="input-group">
                                    <?php
                                    $name_sta = "";
                                    if (isset($valorForm['name_sta'])) {
                                        $name_sta = $valorForm['name_sta'];
                                    }
                                    ?>
                                    <span class="input-group-text">Status Atual</span>
                                    <span class="form-control"><?php echo $name_sta; ?></span>
                                </div>
                                <div class="input-group">
                                    <?php
                                    $dt_status = "";
                                    if (isset($valorForm['dt_status'])) {
                                        $dt_status = $valorForm['dt_status'];
                                    }
                                    ?>
                                    <span class="input-group-text">Data e Hora Status</span>
                                    <span class="form-control"><?php echo date('d/m/Y H:i:s', strtotime($dt_status)); ?></span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">Técnico Suporte</span>
                                    <span class="form-control"><?php echo $_SESSION['user_name']; ?></span>
                                </div>
                                <div class="input-group">
                                    <?php
                                    $type_cham = "";
                                    if (isset($valorForm['type_cham'])) {
                                        $type_cham = $valorForm['type_cham'];
                                    }
                                    ?>
                                    <span class="input-group-text">Tipo Atendimento</span>
                                    <span class="form-control"><?php echo $type_cham; ?></span>
                                </div>
                                <div class="input-group">
                                    <?php
                                    $fech_cham = "";
                                    if (isset($valorForm['fech_cham'])) {
                                        $obs = $valorForm['fech_cham'];
                                    }
                                    ?>
                                    <span class="input-group-text">Fechamento Chamado</span>

                                    <span class="form-control">
                                        <?php
                                        if (!empty($dt_term_cham)) {
                                            echo date('d/m/Y H:i:s', strtotime($dt_term_cham));
                                        }
                                        ?>
                                    </span>
                                </div>
                                <div class="input-group">
                                    <?php
                                    $dt_term_cham = "";
                                    if (isset($valorForm['dt_term_cham'])) {
                                        $dt_term_cham = $valorForm['dt_term_cham'];
                                    }
                                    ?>
                                    <span class="input-group-text">Conclusão Atendimento</span>
                                    <span class="form-control">
                                        <?php
                                        if (!empty($fech_cham)) {
                                            echo date('d/m/Y H:i:s', strtotime($fech_cham));
                                        }
                                        ?>
                                    </span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card-body input-group-sm">

                                <?php
                                $name_prod = "";
                                if (isset($valorForm['name_prod'])) {
                                    $name_prod = $valorForm['name_prod'];
                                }
                                 $marca_id_prod = "";
                                if (isset($valorForm['marca_id_prod'])) {
                                    $marca_id_prod = $valorForm['marca_id_prod'];
                                } 
                                $modelo_id_prod = "";
                                if (isset($valorForm['modelo_id_prod'])) {
                                    $modelo_id_prod = $valorForm['modelo_id_prod'];
                                }
                                $inf_cham = "";
                                if (isset($valorForm['inf_cham'])) {
                                    $inf_cham = $valorForm['inf_cham'];
                                }
                                ?>
                                <h6><span class="fas fa-edit p-2"></span>Descrição do Problema Apontado pelo Cliente do produto: <?php echo $name_prod; echo ' - '; echo $marca_id_prod; echo ' - '; echo $modelo_id_prod;?></h6>
                                <p id="descricao" class="form-control" style="height: 100px;" aria-label="With textarea"><?php echo $inf_cham; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
        </form>

        <div class="col-md-12">

            <div class="col-md-12">
                <div class="card-body border-button border-info border-5 input-group-sm">
                    <div class="input-group-sm">
                        <span class="mb-3"> <b>Históricos do Chamado</span>
                        <table class="table table-sm table-hover table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="list-head-content">Status</th>
                                    <th class="list-head-content">Data</th>
                                    <th class="list-head-content table-sm-none">Suporte</th>
                                    <th class="list-head-content">Históricos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                //echo "<pre>"; print_r($this->data['list_table']);echo "<pre>";
                                foreach ($this->data['list_table']['list_table'] as $cham) {
                                    extract($cham);
                                ?>
                                    <tr>
                                        <td class="list-body-content"><?php echo $status ?></td>
                                        <td class="list-body-content"><?php echo date('d/m/Y H:i:s', strtotime($dt_status)) ?></td>
                                        <td class="list-body-content table-sm-none"><?php echo $name_usr_hist ?></td>
                                        <td class="list-body-content"><?php echo $obs ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



</div>
<!-- Fim do conteudo do administrativo -->