<?php
if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Detalhes do Contrato</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_contr']) {
                    echo "<a href='" . URLADM . "list-contr/index' class='btn-info'>Listar</a> ";
                }
                if (!empty($this->data['viewContr'])) {
                    if ($this->data['button']['edit_contr']) {
                        echo "<a href='" . URLADM . "edit-contr/index/" . $this->data['viewContr'][0]['id'] . "' class='btn-warning'>Editar</a> ";
                    }
                    if ($this->data['button']['edit_profile_logo']) {
                        unset($_SESSION['logo_contr']);
                        $_SESSION['logo_contr'] = $this->data['viewContr'][0]['id'];
                        unset($_SESSION['id_contrato']);
                        $_SESSION['id_contrato'] = $this->data['viewContr'][0]['id'];
                        echo "<a href='" . URLADM . "edit-profile-logo/index/" . $this->data['viewContr'][0]['id'] . "' class='btn-success'>Editar Logo Cliente</a> ";
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
        </div>

        <div class="content-adm">
            <?php
            if (!empty($this->data['viewContr'])) {
                extract($this->data['viewContr'][0]);
            ?>
                <div class="view-det-adm">
                    <span class="view-adm-title">Logo: </span>
                    <span class="view-adm-info">
                        <?php
                        if ((!empty($logo_clie)) and (file_exists("app/adms/assets/image/logo/contratos/" . $id . "/$logo_clie"))) {
                            echo "<img src='" . URLADM . "app/adms/assets/image/logo/contratos/" . $id . "/$logo_clie' width='100' height='100'><br><br>";
                        } else {
                            echo "<img src='" . URLADM . "app/adms/assets/image/logo/contratos/icon_user.png' width='100' height='100'><br><br>";
                        }
                        ?>
                    </span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">ID: </span>
                    <span class="view-adm-info"><?php echo $id; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Cliente: </span>
                    <span class="view-adm-info"><?php echo $razao_social_emp; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Serviço: </span>
                    <span class="view-adm-info"><?php echo $servico; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Num. Contrato: </span>
                    <span class="view-adm-info"><?php echo $num_cont; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Contrato Anexado: </span>
                    <span class="view-adm-info"><?php echo $anexo; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Início:: </span>
                    <span class="view-adm-info"><?php echo date('d/m/Y', strtotime($dt_inicio)); ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Vencimento: </span>
                    <span class="view-adm-info"><?php echo date('d/m/Y', strtotime($dt_term)); ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Situação: </span>
                    <span class="view-adm-info"><?php echo $situacao; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Tipo: </span>
                    <span class="view-adm-info"><?php echo $tipo; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Detalhes Adicionais: </span>
                    <span class="view-adm-info"><?php echo $obs; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Cadastrado: </span>
                    <span class="view-adm-info"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Modificado: </span>
                    <span class="view-adm-info"><?php if (!empty($modified)){echo date('d/m/Y H:i:s', strtotime($modified));}?></span>
                </div>
            <?php
            }
            ?>
            <?php if (isset($anexo)) { ?>
                <div class="column">
                    <h1 class="p-3" style="text-align: center;"> <?php if (isset($clie_cont)) {echo $clie_cont;} ?></h1>
                    <embed src="<?php echo URL; ?>adm/app/adms/assets/arquivos/contratos/<?= $id ?>\<?= $anexo ?>" width=100% height=900>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->