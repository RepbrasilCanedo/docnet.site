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
                <div class="top-list-center">
                    <?php
                    $status_id = "";
                    if (isset($valorForm['status_id'])) {
                        $status_id = $valorForm['status_id'];
                    }
                    ?>
                    <h4 class="mb-3"><?php echo $status_id; ?></h4>

                </div>
            </div>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_orcam']) {
                    echo "<a href='" . URLADM . "list-orcam/index' class='btn-info'>Listar</a> ";
                }
                if (isset($valorForm['id'])) {
                    if ($this->data['button']['view_orcam']) {
                        echo "<a href='" . URLADM . "view-orcam/index/" . $_SESSION['set_cham'] . "' class='btn-primary'>Visualizar</a><br><br>";
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
                    <button type="submit" name="SendInicCham" value="Iniciar" class="btn btn-success btn-sm"><span class="fa-solid fa-money-bill-trend-up me-2"></span>Orçamento em Análise</button>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <?php
                            $id_orcam = "";
                            if (isset($valorForm['id_orcam'])) {
                                $id_orcam = $valorForm['id_orcam'];
                            }
                            ?>
                            <input type="hidden" name="id" id="id" value="<?php echo $id_orcam; ?>">
                            <div class="card-body border-top border-info border-5 input-group-sm">

                                <div class="input-group">
                                    <?php
                                    $nome_fantasia_id_clie = "";
                                    if (isset($valorForm['nome_fantasia_id_clie'])) {
                                        $nome_fantasia_id_clie = $valorForm['nome_fantasia_id_clie'];
                                    }
                                    ?>
                                    <span class="input-group-text view-adm-title">Cliente:</span>
                                    <span class="form-control"><?php echo $nome_fantasia_id_clie; ?></span>
                                </div>

                                <div class="input-group">
                                    <?php
                                    $contato_id_orcam = "";
                                    if (isset($valorForm['contato_id_orcam'])) {
                                        $contato_id_orcam = $valorForm['contato_id_orcam'];
                                    }
                                    ?>
                                    <span class="input-group-text">Contato</span>
                                    <span class="form-control"><?php echo $contato_id_orcam; ?></span>
                                </div>
                                <div class="input-group">
                                    <?php
                                    $tel_contato_orcam = "";
                                    if (isset($valorForm['tel_contato_orcam'])) {
                                        $tel_contato_orcam = $valorForm['tel_contato_orcam'];
                                    }
                                    ?>
                                    <span class="input-group-text">Tel/WhatsApp:</span>
                                    <span class="form-control"><?php echo $tel_contato_orcam; ?></span>
                                </div>
                                <div class="input-group">
                                    <?php
                                    $id_orcam = "";
                                    if (isset($valorForm['id_orcam'])) {
                                        $id_orcam = $valorForm['id_orcam'];
                                    }
                                    ?>
                                    <span class="input-group-text">Proposta Nº:</span>
                                    <span class="form-control"><?php echo $id_orcam; ?></span>
                                </div>

                                <div class="input-group">
                                    <?php
                                    $dt_orcam_orcam = "";
                                    if (isset($valorForm['dt_orcam_orcam'])) {
                                        $dt_orcam_orcam = $valorForm['dt_orcam_orcam'];
                                    }
                                    ?>
                                    <span class="input-group-text">Data Orçamento:</span>
                                    <span class="form-control"><?php echo date('d/m/Y H:i:s', strtotime($dt_orcam_orcam)); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body border-top border-info border-5 input-group-sm">
                                <div class="input-group">
                                    <?php
                                    $name_status_orcam = "";
                                    if (isset($valorForm['name_status_orcam'])) {
                                        $name_status_orcam = $valorForm['name_status_orcam'];
                                    }
                                    ?>
                                    <span class="input-group-text">Status Atual:</span>
                                    <span class="form-control"><?php echo $name_status_orcam; ?></span>
                                </div>
                                <div class="input-group">
                                    <?php
                                    $dt_status_orcam = "";
                                    if (isset($valorForm['dt_status_orcam'])) {
                                        $dt_status_orcam = $valorForm['dt_status_orcam'];
                                    }
                                    ?>
                                    <span class="input-group-text">Data e Hora:</span>
                                    <span class="form-control"><?php echo date('d/m/Y H:i:s', strtotime($dt_status_orcam)); ?></span>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-text">Técnico Suporte</span>
                                    <span class="form-control"><?php echo $_SESSION['user_name']; ?></span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col">
                            <div class="card-body input-group-sm">
                                <?php
                                    $info_prod_serv = "";
                                    if (isset($valorForm['info_prod_serv'])) {
                                        $info_prod_serv = $valorForm['info_prod_serv'];
                                    }
                                    ?>
                                <h6><span class="fas fa-edit p-2"></span>Informações Adicionáis para o Orçamento:</h6>
                                <textarea id="info_prod_serv" name="info_prod_serv" class="form-control" style="height: 100px;" aria-label="With textarea"><?php echo $info_prod_serv; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>



</div>
<!-- Fim do conteudo do administrativo -->