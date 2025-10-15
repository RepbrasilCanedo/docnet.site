<?php
if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

//echo '<pre>';var_dump($this->data['viewCham']);
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <?php
            if (!empty($this->data['viewCham'])) {
                extract($this->data['viewCham'][0]);
            ?>
                <span class="title-content">
                    <h3>Detalhes do Chamado nº: <?php echo $id; ?></h3>
                </span>

            <?php
            }
            ?>
            
            <div class="top-list-right">                         
                <?php
                if ($this->data['button']['list_cham']) {
                    echo "<a href='" . URLADM . "list-cham/index' class='btn-info aButton'>Listar</a> ";
                }

                if ((empty($this->data['button']['add_hist_cham'])) and ($_SESSION['adms_access_level_id'] == 12)) {
                    $_SESSION['set_status']=$name_sta;
                    echo "<a href='" . URLADM . "add-hist-cham/index/$id' class='btn btn-success btn-sm mb-0'>Anexar Histórico</a> ";
                }

                if ((($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) and ($name_sta <> 'Finalizado')){ ?>
                        <!--Modal para inserir a data do reagendamento do ticket -->
                        <button type="button" class="btn btn-dark btn-sm mb-0" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-whatever="@mdo">Reagendar Ticket</button>
 
                        <form method="post" action="">
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Data do novo atendimento do Ticket</php></h1>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Dia:</label>
                                                <input type="date" class="form-control" name="dia_cham" id="dia_cham" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="recipient-name" class="col-form-label">Horario:</label>
                                                <input type="time" class="form-control" name="hr_cham" id="hr_cham" required>
                                            </div>
                                        <div class="mb-3">
                                                <label class="title-input">Técnico do Suporte:</label>
                                                <select name="suporte_id" id="suporte_id" class="input-adm">
                                                    <option value="1">Suporte Livre</option>
                                                    <?php
                                                    foreach ($this->data['select']['nomesup'] as $searchSuporte) {
                                                        extract($searchSuporte);
                                                        if (isset($valorForm['suporte_id']) and $valorForm['suporte_id'] == $id) {
                                                            echo "<option value='$id' selected>$name</option>";
                                                        } else {
                                                            echo "<option value='$id'>$name</option>";
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                        </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" name="SendReagCham" value="Reagendar_Ticket" class="btn btn-dark btn-sm"><span class="fa-solid fa-calendar-day me-2"></span>Reagendar Ticket</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                <?php } 

                if (($this->data['button']['view_profile_cham']) and ($name_sta <> 'Finalizado')) {
                    echo "<a href='" . URLADM . "view-profile-cham/index/$id' class='btn-warning aButton'>Anexar Imagem Erro</a> ";
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
        </div>

        <div class="content-adm">
            <?php
            if (!empty($this->data['viewCham'])) {
                extract($this->data['viewCham'][0]);
            ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-body border-top border-info border-2 input-group-sm">
                            <div class="view-det-adm">
                                <span class="view-adm-title">Cliente: </span>
                                <span class="view-adm-info"><?php echo $nome_fantasia_clie; ?></span>
                            </div>
                            <div class="view-det-adm">
                                <span class="view-adm-title">Tipo: </span>
                                <span class="view-adm-info"><?php echo $type_cham; ?></span>
                            </div>
                            <div class="view-det-adm">
                                <span class="view-adm-title">Prioridade(SLA):: </span>
                                <span class="view-adm-info"><?php echo $name_sla; ?></span>
                            </div>

                            <div class="view-det-adm">
                                <span class="view-adm-title">Contato: </span>
                                <span class="view-adm-info"><?php echo $contato; ?></span>
                            </div>
                            <div class="view-det-adm">
                                <span class="view-adm-title">Tel/Zap: </span>
                                <span class="view-adm-info"><?php echo $tel_contato; ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body border-top border-info border-2 input-group-sm">
                            <div class="view-det-adm">
                                <span class="view-adm-title">Abertura : </span>
                                <span class="view-adm-info"><?php echo date('d/m/Y H:i:s', strtotime($dt_cham)); ?></span>
                            </div>
                            <div class="view-det-adm">
                                <span class="view-adm-title">Conclusão : </span>
                                <span class="view-adm-info">
                                    <?php
                                    if (!empty($fech_cham)) {
                                        echo date('d/m/Y H:i:s', strtotime($fech_cham));
                                    } ?>
                                </span>
                            </div>


                            <div class="view-det-adm">
                                <span class="view-adm-title">Tempo SLA: </span>
                                    <span class="view-adm-info"><?php echo $sla_total ?></span>  
                                
                            </div>

                            <div class="view-det-adm">
                                <span class="view-adm-title">Aprovação Chamado: </span>
                                <span class="view-adm-info">
                                    <?php
                                    if (!empty($dt_term_cham)) {
                                        echo date('d/m/Y H:i:s', strtotime($dt_term_cham));
                                    } ?>
                                </span>
                            </div>
                        </div>
                        <div class="card card-body border-top border-info border-2 input-group-sm">
                            <div class="view-det-adm">
                                <span class="view-adm-title">Status Atual: </span>
                                <span class="view-adm-info"><?php echo $name_sta; ?></span>
                            </div>

                            <div class="view-det-adm">
                                <span class="view-adm-title">Data: </span>
                                <span class="view-adm-info"><?php echo date('d/m/Y H:i:s', strtotime($dt_status)); ?></span>
                            </div>                            

                            <div class="view-det-adm">
                                <span class="view-adm-title">Colaborador: </span>
                                <span class="view-adm-info">
                                    <?php 
                                    if($suporte_id === 1){
                                        echo "Suporte Livre" ;
                                    } else {
                                        echo $name_user;
                                    }; ?>
                                </span>
                            </div>

                            <?php if (!empty($motivo_repr)) { ?>
                                <div class="view-det-adm">
                                    <span class="view-adm-title">Justificativa Reprovação: </span>
                                    <span class="view-adm-info"><?php echo $motivo_repr ?></span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="row">
                    <div class="col-md-6 mt-3">
                        <div class="card card-body border-top border-info border-2 input-group-sm">
                            <div class="view-det-adm">
                                <span class="view-adm-title" >Equipamento :</span> 
                                <span class="view-adm-info"><?php echo $name_prod; echo ' - '; echo $marca_id_prod; echo ' - '; echo $modelo_id_prod; ?> <br> <?php echo 'TIPO DO CONTRATO : '; echo $type_cham; ?></span>
                            </div>
                        </div>
                    </div><div class="col-md-6 mt-3">
                        <div class="card card-body border-top border-info border-2 input-group-sm">
                            <div class="view-det-adm">
                                <span class="view-adm-title">Problema : </span>
                                <span class="view-adm-info"><?php echo $inf_cham; ?></span>
                            </div>
                        </div>
                    </div>
                    </div>

                    <?php if (!empty($image)) { ?>
                        <div class="col-md-12 mt-3">
                            <div class="card card-body border-top border-info border-2 input-group-sm">
                                <div class="view-det-adm">
                                    <div class="view-det-adm">
                                        <span class="view-adm-info">
                                            <?php
                                            if ((!empty($image)) and (file_exists("app/adms/assets/image/chamados" . "/$id"))) {
                                                echo "<img src='" . URLADM . "app/adms/assets/image/chamados/" . $id . "/" . "$image'><br><br>";
                                            }
                                            ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                <?php } ?>

                <div class="col-md-12">
                    <div class="card-body border-button border-info border-5 input-group-sm">
                        <div class="input-group-sm">
                            <span class="mb-3"> <b>Históricos do Chamado</span>
                            <table class="table table-sm table-hover table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th class="list-head-content table-sm-none">Id</th>
                                        <th class="list-head-content">Status</th>
                                        <th class="list-head-content table-sm-none">Data</th>
                                        <th class="list-head-content">Suporte</th>
                                        <th class="list-head-content">Históricos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach ($this->data['list_table']['list_table'] as $cham) {
                                        extract($cham);
                                    ?>
                                        <tr>
                                            <td class="list-body-content table-sm-none"><?php echo $id_hist ?></td>
                                            <td class="list-body-content"><?php echo $status ?></td>
                                            <td class="list-body-content table-sm-none"><?php echo date('d/m/Y H:i:s', strtotime($dt_status)) ?></td>
                                            <td class="list-body-content"><?php echo $name_usr_hist ?></td>
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
</div>
<!-- Fim do conteudo do administrativo -->