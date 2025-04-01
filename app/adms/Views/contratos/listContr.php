<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];

////echo "<pre>";
//var_dump($this->data['pagination']);
//var_dump($this->data['listContr']);
}

?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Listar Contratos</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['add_contr']) {
                    echo "<a href='" . URLADM . "add-contr/index' class='btn-success'>Cadastrar</a> ";
                }
                ?>
            </div>
        </div>
        <?php if (($_SESSION['adms_access_level_id'] > 2) and ($_SESSION['adms_access_level_id'] <> 7)) { ?>

        <?php } else { ?>
            <div class="top-list">
                <form method="POST" action="">
                    <div class="row-input">
                        <div class="column">
                            <?php
                            $id = "";
                            if (isset($valorForm['id'])) {
                                $id = $valorForm['id'];
                            }
                            ?>
                            <label class="title-input">Id Contrato:</label>
                            <input type="text" name="search_id" id="search_id" class="input-adm" placeholder="Id do Contrato" value="<?php $id ?>">
                        </div>

                        <div class="column">
                            <label class="title-input">Tipo de Contrato:</label>
                            <select name="search_type" id="search_type" class="input-adm">
                                <option value="">Todos</option>
                                <?php
                                foreach ($this->data['select']['type_cont'] as $type) {
                                    extract($type);
                                    if (isset($valorForm['search_type']) and $valorForm['search_type'] == $id) {
                                        echo "<option value='$id' selected>$name</option>";
                                    } else {
                                        echo "<option value='$id'>$name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="column">
                            <label class="title-input">Serviço Contratado:</label>
                            <select name="search_serv" id="search_serv" class="input-adm">
                                <option value="">Todos</option>
                                <?php
                                foreach ($this->data['select']['name_serv'] as $service) {
                                    extract($service);
                                    if (isset($valorForm['search_serv']) and $valorForm['search_serv'] == $id_serv) {
                                        echo "<option value='$id_serv' selected>$serv_name</option>";
                                    } else {
                                        echo "<option value='$id_serv'>$serv_name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="column">
                            <label class="title-input">Empresa:</label>
                            <select name="search_emp" id="search_emp" class="input-adm">
                                <option value="">Todos</option>
                                <?php
                                foreach ($this->data['select']['nome_emp'] as $nome_emp) {
                                    extract($nome_emp);
                                    if (isset($valorForm['search_emp']) and $valorForm['search_emp'] == $id) {
                                        echo "<option value='$id' selected>$razao_social</option>";
                                    } else {
                                        echo "<option value='$id'>$razao_social</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="column margin-top-search">
                            <button type="submit" name="SendSearchContrEmp" class="btn-info" value="Pesquisar">Pesquisar</button>
                        </div>
                    </div>
                    <div>
                </form>
            </div>
        <?php } ?>


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
            echo "Total de contratos Cadastrados:  " . $_SESSION['resultado'];
        }
        ?>
        <?php ?>
        <table class="table table-hover table-list">
            <thead class="list-head">
                <tr>
                    <th class="list-head-content table-sm-none">ID</th>
                    <th class="list-head-content">Empresa</th>
                    <th class="list-head-content">Serviço</th>
                    <th class="list-head-content table-sm-none">Descrição</th>
                    <th class="list-head-content table-sm-none">Contrato Anexado</th>
                    <th class="list-head-content table-sm-none">Vencimento</th>
                    <th class="list-head-content table-sm-none">Situação</th>
                    <th class="list-head-content table-sm-none">Tipo</th>
                    <th class="list-head-content">Ação</th>
                </tr>
            </thead>
            <tbody class="list-body">
                <?php
                foreach ($this->data['listContr'] as $contr) {
                    extract($contr);                   
                ?>
                    <tr>
                        <td class="list-body-content table-sm-none"><?php echo $id; ?></td>
                        <td class="list-body-content"><?php echo $razao_social; ?></td>
                        <td class="list-body-content"><?php echo $servico; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $num_cont; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $anexo; ?></td>
                        <td class="list-body-content table-sm-none"><?php if(isset($dt_term)){echo date('d/m/Y', strtotime($dt_term));} ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $situacao; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $tipo; ?></td>

                        <td class="list-body-content">
                            <div class="dropdown-action">
                                <button onclick="actionDropdown(<?php echo $id; ?>)" class="dropdown-btn-action">Ações</button>
                                <div id="actionDropdown<?php echo $id; ?>" class="dropdown-action-item">
                                    <?php
                                    if ($this->data['button']['view_contr']) {
                                        echo "<a href='" . URLADM . "view-contr/index/$id'>Visualizar</a>";
                                    }
                                    if ($this->data['button']['edit_contr']) {
                                        echo "<a href='" . URLADM . "edit-contr/index/$id'>Editar</a>";
                                    }
                                    if ($this->data['button']['delete_contr']) {
                                        echo "<a href='" . URLADM . "delete-contr/index/$id' onclick='return confirm(\"Tem certeza que deseja excluir este registro?\")'>Apagar</a>";
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
            echo "Total de contratos Cadastrados:  " . $_SESSION['resultado'];
            unset($_SESSION['resultado']);
        }
        ?>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->