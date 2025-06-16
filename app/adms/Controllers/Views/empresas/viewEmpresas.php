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
            <span class="title-content">Detalhes do Cliente</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_empresas']) {
                    echo "<a href='" . URLADM . "list-empresas/index' class='btn-info'>Listar</a> ";
                }
                if (!empty($this->data['viewEmpresas'])) {
                    if ($this->data['button']['edit_empresas']) {
                        echo "<a href='" . URLADM . "edit-empresas/index/" . $this->data['viewEmpresas'][0]['id'] . "' class='btn-warning'>Editar</a> ";
                    }
                    if ($this->data['button']['delete_empresas']) {
                        echo "<a href='" . URLADM . "delete-empresas/index/" . $this->data['viewEmpresas'][0]['id'] . "' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")' class='btn-danger'>Apagar</a> ";
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
            if (!empty($this->data['viewEmpresas'])) {
                extract($this->data['viewEmpresas'][0]);
            ?>

                <div class="view-det-adm">
                    <span class="view-adm-title">ID: </span>
                    <span class="view-adm-info"><?php echo $id; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Razão Social: </span>
                    <span class="view-adm-info"><?php echo $razao_social; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Nome de Fantasia: </span>
                    <span class="view-adm-info"><?php echo $nome_fantasia; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Cnpj: </span>
                    <span class="view-adm-info"><?php echo $cnpjcpf; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Cep: </span>
                    <span class="view-adm-info"><?php echo $cep; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Logradouro: </span>
                    <span class="view-adm-info"><?php echo $logradouro; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Bairro: </span>
                    <span class="view-adm-info"><?php echo $bairro; ?></span>
                    
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">cidade: </span>
                    <span class="view-adm-info"><?php echo $cidade; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Uf: </span>
                    <span class="view-adm-info"><?php echo $uf; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Situação: </span>
                    <span class="view-adm-info"><?php echo $name_sit; ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Cadastrado: </span>
                    <span class="view-adm-info"><?php echo date('d/m/Y H:i:s', strtotime($created)); ?></span>
                </div>

                <div class="view-det-adm">
                    <span class="view-adm-title">Editado: </span>
                    <span class="view-adm-info">
                        <?php
                        if (!empty($modified)) {
                            echo date('d/m/Y H:i:s', strtotime($modified));
                        } ?>
                    </span>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->