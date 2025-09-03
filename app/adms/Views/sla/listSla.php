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

        <div class="top-list">
            <form method="POST" action="">
                <div class="row-input-search">
                    <?php
                    $search_name = "";
                    if (isset($valorForm['search_name'])) {
                        $search_name = $valorForm['search_name'];
                    }
                    ?>
                    <div class="column">
                        <label class="title-input-search">Nome: </label>
                        <input type="text" name="search_name" id="search_name" class="input-search" placeholder="Pesquisar pelo nome..." value="<?php echo $search_name; ?>">
                    </div>

                    <?php
                    $search_color = "";
                    if (isset($valorForm['search_color'])) {
                        $search_color = $valorForm['search_color'];
                    }
                    ?>
                    <div class="column">
                        <label class="title-input-search">Sla: </label>
                        <input type="text" name="search_color" id="search_color" class="input-search" placeholder="Pesquisar pela cor..." value="<?php echo $search_color; ?>">
                    </div>

                    <div class="column margin-top-search">
                        <button type="submit" name="SendSearchColor" class="btn-info" value="Pesquisar">Pesquisar</button>
                    </div>
                </div>
            </form>
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
                    <th class="list-head-content">Prioridade</th>
                    <th class="list-head-content">Sla</th>
                    <th class="list-head-content table-sm-none">Atividade</th>
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
                        <td class="list-body-content"><?php echo $nome_fantasia_emp; ?></td>
                        <td class="list-body-content"><?php echo $name_prio; ?></td>
                        <td class="list-body-content"><?php echo $name_temp; ?></td>
                        <td class="list-body-content"><?php echo $name_ativ; ?></td>
                        
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