<?php
if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}
//echo '<pre>';var_dump($this->data['viewOrcam']);
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <?php
            if (!empty($this->data['viewOrcam'])) {
                extract($this->data['viewOrcam'][0]);
            ?>
                <span class="title-content">
                    <h3>Detalhes do Orçamento nº: <?php echo $id_orcam; ?></h3>
                </span>

            <?php
            }
            ?>
            
            <div class="top-list-right">                         
                <?php
                if ($this->data['button']['list_orcam']) {
                    echo "<a href='" . URLADM . "list-orcam/index' class='btn-info aButton'>Listar</a> ";
                }

                if (($this->data['button']['view_profile_orcam']) and ($status_id <> 1) and ($status_id <> 4)) {
                    echo "<a href='" . URLADM . "view-profile-orcam/index/$id_orcam' class='btn-warning aButton'>Anexar Orçamento</a> ";
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
            if (!empty($this->data['viewOrcam'])) {
                extract($this->data['viewOrcam'][0]);
            ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-body border-top border-info border-2 input-group-sm">
                            <div class="view-det-adm">
                                <span class="view-adm-title">Cliente: </span>
                                <span class="view-adm-info"><?php echo $nome_fantasia_id_clie; ?></span>
                            </div>

                            <div class="view-det-adm">
                                <span class="view-adm-title">Contato: </span>
                                <span class="view-adm-info"><?php echo $contato_id_orcam; ?></span>
                            </div>

                            <div class="view-det-adm">
                                <span class="view-adm-title">Tel/Zap: </span>
                                <span class="view-adm-info"><?php echo $tel_contato_orcam; ?></span>
                            </div>
                            <div class="view-det-adm">
                                <span class="view-adm-title">Orçamento Enviado em:</span>
                                <span class="view-adm-info"><?php echo date('d/m/Y H:i:s', strtotime($dt_orcam_orcam)); ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-body border-top border-info border-2 input-group-sm">
                            <div class="view-det-adm">
                                <span class="view-adm-title">Status Atual: </span>
                                <span class="view-adm-info"><?php echo $name_status_orcam; ?></span>
                            </div>

                            <div class="view-det-adm">
                                <span class="view-adm-title">Data: </span>
                                <span class="view-adm-info"><?php echo date('d/m/Y H:i:s', strtotime($dt_status_orcam)); ?></span>
                            </div> 

                            <div class="view-det-adm">
                                <span class="view-adm-title">Responsável:: </span>
                                <span class="view-adm-info"><?php echo $name_user_final; ?></span>
                            </div> 

                            <div class="view-det-adm">
                                <span class="view-adm-title">Obs: </span>
                                <span class="view-adm-info"><?php echo $inf_adic_orcam; ?></span>
                            </div> 
                        </div>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="card card-body border-top border-info border-2 input-group-sm">
                            <div class="view-det-adm">
                                <span class="view-adm-title">Produto ou Serviço : </span>
                                <span class="view-adm-info"><?php echo $prod_serv;?></span>
                            </div>
                            <div class="view-det-adm">
                                <span class="view-adm-title">Informações Adicionais : </span>
                                <span class="view-adm-info"><?php echo $info_prod_serv; ?></span>
                            </div>
                        </div>
                    </div>
                </div>                   
                
                <div class="view-det-adm">
                    <?php
                     if ((!empty($image)) and (file_exists("app/adms/assets/image/orcamentos" . "/$id_orcam"))) {?>
                        <a href="<?php echo URLADM; ?>app/adms/assets/image/orcamentos/<?php echo $id_orcam ?>/<?php echo $image ?>"  target="_blank">Clique aqui para Visualizar seu Orçamento em PDF.</a>
                    <?php } else { ?>
                        <h5 class="title-content m-3">Não há Proposta de Orçamento Recebida</h5>
                   <?php } ?>
                </div>

            <?php } ?>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->