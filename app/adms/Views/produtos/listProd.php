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
            <span class="title-content">Listar Produtos</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['add_prod']) {
                    echo "<a href='" . URLADM . "add-prod/index' class='btn-success'>Cadastrar</a> ";
                }
                ?>
            </div>
        </div>

        <div class="top-list">
            <form method="POST" action="">
                <div class="row-input">
                    <?php if (($_SESSION['adms_access_level_id'] > 2) and ($_SESSION['adms_access_level_id'] <> 7)) { ?>
                       
                        
                    <?php } else { ?>
                        <?php $search_prod = "";
                        if (isset($valorForm['search_prod'])) {
                            $search_prod = $valorForm['search_prod'];
                        }
                        ?>
                        
                        <div class="column">
                            <label class="title-input-search">Produto: </label>
                            <input type="text" name="search_prod" id="search_prod" class="input-search" placeholder="Pesquisar pelo produto..." value="<?php echo $search_prod; ?>">
                        </div>
                        <?php
                        $search_emp = "";
                        if (isset($valorForm['search_emp'])) {
                            $search_emp = $valorForm['search_emp'];
                        }
                        ?>
                        <div class="column">
                            <label class="title-input-search">Empresa: </label>
                            <input type="text" name="search_emp" id="search_emp" class="input-search" placeholder="Pesquisar pela empresa..." value="<?php echo $search_emp; ?>">
                        </div>
                        
                    <div class="column margin-top-search">
                        <button type="submit" name="SendSearchProdEmp" class="btn-info" value="Pesquisar">Pesquisar</button>
                    </div>
                    <?php } ?>
                </div>
                <div>
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
        <?php 
        if (isset($_SESSION['resultado'])) {
            echo "Total de produtos Cadastrados:  " . $_SESSION['resultado'];
        }
        ?>
        <table class="table table-hover table-list">
            <thead class="list-head">
                <tr>
                    <th class="list-head-content table-sm-none">ID</th>
                    <th class="list-head-content">Nome</th>
                    <th class="list-head-content table-sm-none">Tipo</th>
                    <th class="list-head-content table-sm-none">Empresa</th>
                    <th class="list-head-content">Situação</th>
                    <th class="list-head-content">Ações</th>
                </tr>
            </thead>
            <tbody class="list-body">
                <?php
                foreach ($this->data['listProd'] as $prod) {
                    extract($prod);
                ?>
                    <tr>
                        <td class="list-body-content table-sm-none"><?php echo $id; ?></td>
                        <td class="list-body-content"><?php echo $name; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $name_type; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $nome_fantasia_clie; ?></td>
                        <td class="list-body-content"><?php echo $name_sit; ?></td>

                        <td class="list-body-content">
                            <div class="dropdown-action">
                                <button onclick="actionDropdown(<?php echo $id; ?>)" class="dropdown-btn-action">Ações</button>
                                <div id="actionDropdown<?php echo $id; ?>" class="dropdown-action-item">
                                    <?php
                                    if ($this->data['button']['view_prod']) {
                                        echo "<a href='" . URLADM . "view-prod/index/$id'>Visualizar</a>";
                                    }
                                    if ($this->data['button']['edit_prod']) {
                                        echo "<a href='" . URLADM . "edit-prod/index/$id'>Editar</a>";
                                    }
                                    if ($this->data['button']['delete_prod']) {
                                        echo "<a href='" . URLADM . "delete-prod/index/$id' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'>Apagar</a>";
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
        <?php 
        if (isset($_SESSION['resultado'])) {
            echo "Total de produtos Cadastrados:  " . $_SESSION['resultado'];
            unset($_SESSION['resultado']);
        }
        ?>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->