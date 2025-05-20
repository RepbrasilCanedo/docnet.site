<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
//echo('<pre>');var_dump($_SESSION['status_ticket']);echo('</pre>');



?>


<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Listar Tickets</span><br>
        </div>

        <div class="top-list">
            <form method="POST" action="">
                <div class="row-input-search">
                    <?php if ($_SESSION['adms_access_level_id'] > 2) { ?>

                        <!--14: Usuario Final -->
                        <?php if ($_SESSION['adms_access_level_id'] == 14) { ?>

                            <div class="column" hidden>
                                <?php
                                $search_id = "";
                                if (isset($valorForm['search_id'])) {
                                    $search_id = $valorForm['search_id'];
                                }
                                ?>
                                <label class="title-input">Número Chamado:</label>
                                <input type="number" name="search_id" id="search_id" class="input-adm" placeholder="Todos" value="<?= $search_id ?>">
                            </div>

                            <div class="column" hidden>
                                <label class="title-input">Empresa:</label>
                                <select name="search_empresa" id="search_empresa" class="input-adm">
                                    <option value="">Todas</option>
                                    <?php
                                    foreach ($this->data['select']['nome_emp'] as $nome_emp) {
                                        extract($nome_emp);
                                        if (isset($valorForm['search_empresa']) and $valorForm['search_empresa'] == $id_emp) {
                                            echo "<option value='$id_emp' selected>$nome_fantasia_emp</option>";
                                        } else {
                                            echo "<option value='$id_emp'>$nome_fantasia_emp</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="column">
                                <label class="title-input">Status do Chamado:</label>
                                <select name="search_status" id="search_status" class="input-adm">
                                    <option value="">Todos</option>
                                    <?php
                                    foreach ($this->data['select']['nome_status'] as $status) {
                                        extract($status);
                                        if (isset($valorForm['search_status']) and $valorForm['search_status'] == $id) {
                                            echo "<option value='$id' selected>$name</option>";
                                        } else {
                                            echo "<option value='$id'>$name</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="column">
                                <label class="title-input">Tipo do Chamado:</label>
                                <select name="search_tipo" id="search_tipo" class="input-adm">
                                    <option value="">Todos</option>
                                    <option value="Telefonico">Telefônico</option>
                                    <option value="Remoto">Remoto</option>
                                    <option value="Presencial">Presencial</option>
                                    <option value="Outros">Outros</option>
                                </select>
                            </div>

                            <div class="column">
                                <?php
                                $search_date_start = "";
                                if (isset($valorForm['search_date_start'])) {
                                    $search_date_start = $valorForm['search_date_start'];
                                }
                                ?>
                                <label class="title-input-search">Data Inicio: </label>
                                <input type="date" name="search_date_start" id="search_date_start" class="input-search" value="<?php echo $search_date_start; ?>">
                            </div>

                            <div class="column">
                                <?php
                                $search_date_end = "";
                                if (isset($valorForm['search_date_end'])) {
                                    $search_date_end = $valorForm['search_date_end'];
                                }
                                ?>
                                <label class="title-input-search">Data Final: </label>
                                <input type="date" name="search_date_end" id="search_date_end" class="input-search" value="<?php echo $search_date_end; ?>">
                            </div>
                            <!--4: Cliente Administrador ou tecnico do cliente-->
                        <?php } elseif (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) { ?>

                            <div class="column">
                                <?php
                                $search_id = "";
                                if (isset($valorForm['search_id'])) {
                                    $search_id = $valorForm['search_id'];
                                }
                                ?>
                                <label class="title-input">Número Ticket:</label>
                                <input type="number" name="search_id" id="search_id" class="input-adm" placeholder="Todos" value="<?= $search_id ?>">
                            </div>

                            <div class="column" hidden>
                                <label class="title-input">Empresa Principal:</label>
                                <select name="search_empresa_prin" id="search_empresa_prin" class="input-emp" style="width: 100%">
                                    <option value="">Todas</option>
                                    <?php
                                    foreach ($this->data['select']['nome_emp'] as $nome_emp) {
                                        extract($nome_emp);
                                        if (isset($valorForm['search_empresa_prin']) and $valorForm['search_empresa_prin'] == $id_emp) {
                                            echo "<option value='$id_emp' selected>$nome_fantasia_emp</option>";
                                        } else {
                                            echo "<option value='$id_emp'>$nome_fantasia_emp</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="column">
                                <label class="title-input">Cliente:</label>
                                <select name="search_empresa" id="search_empresa" class="input-adm">
                                    <option value="">Todas</option>
                                    <?php
                                    foreach ($this->data['select']['nome_clie'] as $nome_clie) {
                                        extract($nome_clie);
                                        if (isset($valorForm['search_empresa']) and $valorForm['search_empresa'] == $id) {
                                            echo "<option value='$id' selected>$nome_fantasia</option>";
                                        } else {
                                            echo "<option value='$id'>$nome_fantasia</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="column">
                                <label class="title-input">Status do Chamado:</label>
                                <select name="search_status" id="search_status" class="input-adm">
                                    <option value="">Todos</option>
                                    <?php
                                    foreach ($this->data['select']['nome_status'] as $status) {
                                        extract($status);
                                        if (isset($valorForm['search_status']) and $valorForm['search_status'] == $id) {
                                            echo "<option value='$id' selected>$name</option>";
                                        } else {
                                            echo "<option value='$id'>$name</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="column">
                                <label class="title-input">Tipo do Chamado:</label>
                                <select name="search_tipo" id="search_tipo" class="input-adm">
                                    <option value="">Todos</option>
                                    <option value="Telefonico">Telefônico</option>
                                    <option value="Remoto">Remoto</option>
                                    <option value="Presencial">Presencial</option>
                                    <option value="Outros">Outros</option>
                                </select>
                            </div>

                            <div class="column">
                                <?php
                                $search_date_start = "";
                                if (isset($valorForm['search_date_start'])) {
                                    $search_date_start = $valorForm['search_date_start'];
                                }
                                ?>
                                <label class="title-input-search">Data Inicio: </label>
                                <input type="date" name="search_date_start" id="search_date_start" class="input-search" value="<?php echo $search_date_start; ?>">
                            </div>

                            <div class="column">
                                <?php
                                $search_date_end = "";
                                if (isset($valorForm['search_date_end'])) {
                                    $search_date_end = $valorForm['search_date_end'];
                                }
                                ?>
                                <label class="title-input-search">Data Final: </label>
                                <input type="date" name="search_date_end" id="search_date_end" class="input-search" value="<?php echo $search_date_end; ?>">
                            </div>

                        <?php } ?>

                    <?php } else { ?>

                        <div class="column">
                            <?php
                            $search_id = "";
                            if (isset($valorForm['search_id'])) {
                                $search_id = $valorForm['search_id'];
                            }
                            ?>
                            <label class="title-input">Número Chamado:</label>
                            <input type="number" name="search_id" id="search_id" class="input-adm" placeholder="Todos" value="<?= $search_id ?>">
                        </div>

                        <div class="column">
                            <label class="title-input">Clientes das Empresas:</label>
                            <select name="search_empresa" id="search_empresa" class="input-adm">
                                <option value="">Todas</option>
                                <?php
                                foreach ($this->data['select']['nome_clie'] as $nome_emp) {
                                    extract($nome_emp);
                                    if (isset($valorForm['search_empresa']) and $valorForm['search_empresa'] == $id) {
                                        echo "<option value='$id' selected>$nome_fantasia</option>";
                                    } else {
                                        echo "<option value='$id'>$nome_fantasia</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="column">
                            <label class="title-input">Status do Chamado:</label>
                            <select name="search_status" id="search_status" class="input-adm">
                                <option value="">Todos</option>
                                <?php
                                foreach ($this->data['select']['nome_status'] as $status) {
                                    extract($status);
                                    if (isset($valorForm['search_status']) and $valorForm['search_status'] == $id) {
                                        echo "<option value='$id' selected>$name</option>";
                                    } else {
                                        echo "<option value='$id'>$name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>

                        <div class="column">
                            <label class="title-input">Tipo do Chamado:</label>
                            <select name="search_tipo" id="search_tipo" class="input-adm">
                                <option value="">Todos</option>
                                <option value="Telefonico">Telefônico</option>
                                <option value="Remoto">Remoto</option>
                                <option value="Presencial">Presencial</option>
                                <option value="Outros">Outros</option>
                            </select>
                        </div>

                        <div class="column">
                            <?php
                            $search_date_start = "";
                            if (isset($valorForm['search_date_start'])) {
                                $search_date_start = $valorForm['search_date_start'];
                            }
                            ?>
                            <label class="title-input-search">Data Inicio: </label>
                            <input type="date" name="search_date_start" id="search_date_start" class="input-search" value="<?php echo $search_date_start; ?>">
                        </div>

                        <div class="column">
                            <?php
                            $search_date_end = "";
                            if (isset($valorForm['search_date_end'])) {
                                $search_date_end = $valorForm['search_date_end'];
                            }
                            ?>
                            <label class="title-input-search">Data Final: </label>
                            <input type="date" name="search_date_end" id="search_date_end" class="input-search" value="<?php echo $search_date_end; ?>">
                        </div>

                    <?php } ?>

                    <div class="column margin-top-search">
                        <button type="submit" name="SendSearchCham" class="btn-info" value="Pesquisar">Pesquisar</button>
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

        <?php //echo "Total de chamados: " . $_SESSION['resultado'];
        if (isset($_SESSION['resultado'])) { ?>
            <h5>Total de chamados: <?php echo $_SESSION['resultado'] ?></h5>
        <?php
        }
        ?>

        <table class="table table-hover table-list mb-5">
            <thead class="list-head">
                <tr>
                    <th class="list-head-content table-sm-none">ID</th>
                    <th class="list-head-content">Cliente</th>
                    <th class="list-head-content table-sm-none">Contato</th>
                    <th class="list-head-content table-sm-none">Tel/Zap</th>
                    <th class="list-head-content table-sm-none">Data </th>
                    <th class="list-head-content">Status</th>
                    <th class="list-head-content table-sm-none">Data</th>
                    <th class="list-head-content table-sm-none">Tipo</th>
                    <th class="list-head-content">Ações</th>
                </tr>
            </thead>
            <tbody class="list-body">
                <?php
                foreach ($this->data['listCham'] as $cham) {
                    extract($cham);
                ?>
                    <tr>
                        <td class="list-body-content table-sm-none"><?php echo $id; ?></td>
                        <td class="list-body-content"><?php echo $nome_fantasia_clie; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $contato_cham; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $tel_contato_cham; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo date('d/m/Y H:i:s', strtotime($dt_cham)); ?>
                        </td>
                        <td class="list-body-content"><?php echo $name_sta; ?></td>
                        <td class="list-body-content table-sm-none">
                            <?php echo date('d/m/Y H:i:s', strtotime($dt_status)); ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $type_cham; ?></td>

                        <td class="list-body-content">
                            <div class="dropdown-action">
                                <button onclick="actionDropdown(<?php echo $id; ?>)" class="dropdown-btn-action">Ações</button>

                                <div id="actionDropdown<?php echo $id; ?>" class="dropdown-action-item">
                                    <?php


                                    if (($name_sta == 'Finalizado') or ($name_sta == 'Aprovado')) {
                                        if (($name_sta == 'Aprovado')) {
                                            if ($this->data['button']['view_cham']) {
                                                echo "<a href='" . URLADM . "view-cham/index/$id'>Visualizar</a>";
                                            }
                                        } else {
                                            if ($this->data['button']['view_cham']) {
                                                echo "<a href='" . URLADM . "view-cham/index/$id'>Visualizar</a>";

                                                if (($_SESSION['adms_access_level_id'] > 2)) {
                                                    echo "<a href='" . URLADM . "edit-aprov-cham/index/$id'>Avaliar</a>";
                                                }
                                            }
                                        }
                                    } else if ($name_sta == 'Reprovado') {
                                        if ($this->data['button']['view_cham']) {
                                            echo "<a href='" . URLADM . "view-cham/index/$id'>Visualizar</a>";
                                        }
                                        if ($this->data['button']['edit_cham']) {
                                            echo "<a href='" . URLADM . "edit-cham/index/$id'>Reabrir</a>";
                                        }
                                    } else {
                                        if ($this->data['button']['view_cham']) {
                                            echo "<a href='" . URLADM . "view-cham/index/$id'>Visualizar</a>";
                                            if ($_SESSION['adms_access_level_id'] == 14){
                                                if ($name_sta == 'Aberto') {
                                                    echo "<a href='" . URLADM . "view-profile-cham/index/$id'>Anexar Erro</a>";
                                                }

                                            }
                                        }
                                        if ($this->data['button']['edit_cham']) {
                                            echo "<a href='" . URLADM . "edit-cham/index/$id'>Atender</a>";
                                        }
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
            echo "Total de chamados: " . $_SESSION['resultado'];
            unset($_SESSION['resultado']);
        }
        //unset($_SESSION['resultado']);
        ?>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->