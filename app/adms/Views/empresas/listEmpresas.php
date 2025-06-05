<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
//var_dump($this->data['listEmpresas']);
?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Listar Clientes</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['add_empresas']) {
                    echo "<a href='" . URLADM . "add-empresas/index' class='btn-success'>Cadastrar</a>";
                }
                ?>
            </div>
        </div>

        <div class="top-list">
            <form method="POST" action="">
                <div class="row-input-search">
                    <?php
                    $search_cnpj = "";
                    if (isset($valorForm['search_cnpj'])) {
                        $search_cnpj = $valorForm['search_cnpj'];
                    }
                    ?>
                    <div class="column">
                        <label class="title-input-search">Cnpj: </label>
                        <input type="text" name="search_cnpj" id="search_cnpj" class="input-search"
                            placeholder="Pesquisar pelo CNPJ" value="<?php echo $search_cnpj; ?>">
                    </div>

                    <?php
                    $search_razao = "";
                    if (isset($valorForm['search_razao'])) {
                        $search_razao = $valorForm['search_razao'];
                    }
                    ?>
                    <div class="column">
                        <label class="title-input-search">Razão Social: </label>
                        <input type="text" name="search_razao" id="search_razao" class="input-search"
                            placeholder="Pesquisar pela razao social" value="<?php echo $search_razao; ?>">
                    </div>

                    <?php
                    $search_fantasia = "";
                    if (isset($valorForm['search_fantasia'])) {
                        $search_fantasia = $valorForm['search_fantasia'];
                    }
                    ?>
                    <div class="column">
                        <label class="title-input-search">Nome Fantasia: </label>
                        <input type="text" name="search_fantasia" id="search_fantasia" class="input-search"
                            placeholder="Pesquisar pelo nome fantasia..." value="<?php echo $search_fantasia; ?>">
                    </div>

                    <div class="column margin-top-search">
                        <button type="submit" name="SendSearchEmpresa" class="btn-info"
                            value="Pesquisar">Pesquisar</button>
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
        <?php
        if (isset($_SESSION['resultado'])) {
            echo "Total de Clientes Cadastrados:  " . $_SESSION['resultado'];
        }
        ?>

        <table class="table table-hover table-list mb-5">
            <thead class="list-head">
                <tr>
                    <th class="list-head-content table-sm-none">ID</th>
                    <th class="list-head-content table-sm-none">Razão Social</th>
                    <th class="list-head-content">Nome Fantasia</th>
                    <th class="list-head-content table-md-none">CNPJ</th>
                    <th class="list-head-content table-lg-none">Bairro</th>
                    <th class="list-head-content">Cidade</th>
                    <th class="list-head-content table-lg-none">Situação</th>
                    <th class="list-head-content">Ações</th>
                </tr>
            </thead>
            </thead>
            <tbody class="list-body">
                <?php
                foreach ($this->data['listEmpresas'] as $empresas) {
                    extract($empresas);
                    ?>
                    <tr>
                        <td class="list-body-content table-sm-none"><?php echo $id; ?></td>
                        <td class="list-body-content  table-sm-none"><?php echo $razao_social; ?></td>
                        <td class="list-body-content"><?php echo $nome_fantasia; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $cnpjcpf; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $bairro; ?></td>
                        <td class="list-body-content"><?php echo $cidade; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $name_sit; ?></td>

                        <td class="list-body-content">
                            <div class="dropdown-action">
                                <button onclick="actionDropdown(<?php echo $id; ?>)"
                                    class="dropdown-btn-action">Ações</button>
                                <div id="actionDropdown<?php echo $id; ?>" class="dropdown-action-item">
                                    <?php
                                    if ($this->data['button']['view_empresas']) {
                                        echo "<a href='" . URLADM . "view-empresas/index/$id'>Visualizar</a>";
                                    }
                                    if ($this->data['button']['edit_empresas']) {
                                        echo "<a href='" . URLADM . "edit-empresas/index/$id'>Editar</a>";
                                    }
                                    if ($this->data['button']['delete_empresas']) {
                                        echo "<a href='" . URLADM . "delete-empresas/index/$id' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'>Apagar</a>";
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
            echo "Total de clientes Cadastrados:  " . $_SESSION['resultado'];
            unset($_SESSION['resultado']);
        }
        ?>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->