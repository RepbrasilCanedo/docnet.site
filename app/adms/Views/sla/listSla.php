<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Listar Slas</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['add_sla']) {
                    echo "<a href='" . URLADM . "add-sla/index' class='btn-success'>Cadastrar</a>";
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
        <table class="table table-hover table-list">
            <thead class="list-head">
                <tr>
                    <th class="list-head-content">ID</th>
                    <th class="list-head-content">Tipo</th>
                    <th class="list-head-content table-sm-none">Empresa</th>
                    <th class="list-head-content">Primeira Resposta</th>
                    <th class="list-head-content table-sm-none">Tempo do SLA</th>
                    <th class="list-head-content table-sm-none">Tipo de Urgencia</th>
                    <th class="list-head-content table-sm-none">Dados Adicionais</th>
                    <th class="list-head-content">Ações</th>
                </tr>
            </thead>
            <tbody class="list-body">
                <?php
                foreach ($this->data['listSla'] as $sla) {
                    extract($sla);
                ?>
                    <tr>
                        <td class="list-body-content"><?php echo $id_sla; ?></td>
                        <td class="list-body-content"><?php echo $name; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $nome_fantasia_emp; ?></td>
                        <td class="list-body-content"><?php echo $prim_resp_sla; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $final_resp_sla; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $name_ativ; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $obs_sla; ?></td>
                        
                        <td class="list-body-content">
                            <div class="dropdown-action">
                                <button onclick="actionDropdown(<?php echo $id_sla; ?>)" class="dropdown-btn-action">Ações</button>
                                <div id="actionDropdown<?php echo $id_sla; ?>" class="dropdown-action-item">
                                    <?php
                                    if ($this->data['button']['view_sla']) {
                                        echo "<a href='" . URLADM . "view-sla/index/$id_sla'>Visualizar</a>";
                                    }
                                    if ($this->data['button']['edit_sla']) {
                                        echo "<a href='" . URLADM . "edit-sla/index/$id_sla'>Editar</a>";
                                    }
                                    if ($this->data['button']['delete_sla']) {
                                        echo "<a href='" . URLADM . "delete-sla/index/$id_sla' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'>Apagar</a>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <?php echo $this->data['pagination']; ?>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->