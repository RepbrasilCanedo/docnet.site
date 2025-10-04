<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
//var_dump($this->data['select']);
?>

<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Listar Slas dos Tikets</span>
        </div>

        <!-- Inicio da rotina de busca dos Tickets Slas -->
        <div class="top-list">
            <form method="POST" action="">
                <div class="row-input-search">

                    <!--4: Cliente Administrador -->   
                    <?php if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] <=2)) { ?>                           
                            
                        <div class="column">
                               <?php
                               $searchTicket = "";
                               if (isset($valorForm['search_ticket'])) {
                                   $searchTicket = $valorForm['search_ticket'];
                               }
                               ?>
                               <label class="title-input">Número Ticket:</label>
                               <input type="number" name="search_ticket" id="search_ticket" class="input-adm" placeholder="Todos" value="<?= $searchTicket ?>">
                        </div>

                            <div class="column">
                                <label class="title-input">Clientes:</label>
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
                                <label class="title-input">Suporte:</label>
                                <select name="search_suporte" id="search_suporte" class="input-adm">
                                    <option value="">Todos</option>
                                    <?php
                                    foreach ($this->data['select']['nome_sup'] as $searchSuporte) {
                                        extract($searchSuporte);
                                        if (isset($valorForm['search_suporte']) and $valorForm['search_suporte'] == $id) {
                                            echo "<option value='$id' selected>$name</option>";
                                        } else {
                                            echo "<option value='$id'>$name</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="column">
                                <label class="title-input">Tipo do Sla do Ticket:</label>
                                    <select name="search_tipo" id="search_tipo" class="input-adm">
                                    <option value="">Todas</option>
                                    <?php
                                    foreach ($this->data['select']['nome_tipo'] as $nome_tipo) {
                                        extract($nome_tipo);
                                        if (isset($valorForm['search_tipo']) and $valorForm['search_tipo'] == $id) {
                                            echo "<option value='$id' selected>$name</option>";
                                        } else {
                                            echo "<option value='$id'>$name</option>";
                                        }
                                    }
                                    ?>
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

                            <div class="column">
                                <label class="title-input">Status Anterior do Ticket:</label>
                                <select name="search_status_anterior" id="search_status_anterior" class="input-adm">
                                    <option value="">Todos</option>
                                    <?php
                                    foreach ($this->data['select']['nome_status'] as $status) {
                                        extract($status);
                                        if (isset($valorForm['search_status_anterior']) and $valorForm['search_status_anterior'] == $id) {
                                            echo "<option value='$id' selected>$name</option>";
                                        } else {
                                            echo "<option value='$id'>$name</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="column">
                                <label class="title-input">Status Atual do Ticket:</label>
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

                    <?php } ?>

                    <div class="column margin-top-search">
                        <button type="submit" name="SendSearchTicket" class="btn-info" value="Pesquisar">Pesquisar</button>
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
                    <th class="list-head-content">Ticket</th>
                    <th class="list-head-content table-sm-none">Tipo</th>
                    <th class="list-head-content table-sm-none">Cliente</th>
                    <th class="list-head-content table-sm-none">Abertura Ticket</th>
                    <th class="list-head-content table-sm-none">Status Anter.</th>
                    <th class="list-head-content">Status Atual</th>
                    <th class="list-head-content">Tempo SLA</th>
                    <th class="list-head-content table-sm-none">Tecnico</th>

                    <th class="list-head-content">Ações</th>
                </tr>
            </thead>
            <tbody class="list-body">
                <?php
                foreach ($this->data['listTicketSla'] as $sla) {
                    extract($sla);
                ?>
                    <tr>
                        <td class="list-body-content"><?php echo $id_ticket_sla_hist; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $name_sla; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo $nome_fantasia_clie; ?></td>
                        <td class="list-body-content table-sm-none"><?php echo date('d/m/Y H:i:s', strtotime($dt_abert_ticket))?>
                        <td class="list-body-content table-sm-none"><?php echo $name_status_id_ant; ?></td>
                        <td class="list-body-content"><?php echo $name_sta_atu; ?></td>
                        <td class="list-body-content"><?php echo date('H:i:s', strtotime($tempo_sla))?>
                        <td class="list-body-content table-sm-none"><?php echo $name_user; ?></td>
                        
                        <td class="list-body-content">
                            <div class="dropdown-action">
                                <button onclick="actionDropdown(<?php echo $id_sla_hist; ?>)" class="dropdown-btn-action">Ações</button>
                                <div id="actionDropdown<?php echo $id_sla_hist; ?>" class="dropdown-action-item">
                                    <?php
                                    if ($this->data['button']['view_ticket_sla']) {
                                        echo "<a href='" . URLADM . "view-ticket-sla/index/$id_sla_hist'>Visualizar</a>";
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