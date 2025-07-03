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
            <h5>Lista de Mensagens de Solicitação de Alterações no Sistema</h5>
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
                    <th class="list-head-content">Assunto</th>
                    <th class="list-head-content">Cliente</th>
                    <th class="list-head-content">Nome</th>
                    <th class="list-head-content">Usuario</th>
                    <th class="list-head-content">Tel</th>
                    <th class="list-head-content">Mensagem</th>
                    <th class="list-head-content">Data</th>                    
                    <th class="list-head-content">Status</th>
                    <th class="list-head-content">Ações</th>
                </tr>
            </thead>
            <tbody class="list-body">
                <?php
                foreach ($this->data['listContato'] as $listContato) {
                    extract($listContato);
                ?>
                    <tr>
                        <td class="list-body-content"><?php echo $id_mens; ?></td>
                        <td class="list-body-content"><?php echo $assunto_mens; ?></td>
                        <td class="list-body-content"><?php echo $nome_fantasia_clie; ?></td>
                        <td class="list-body-content"><?php echo $nome_mens	; ?></td>
                        <td class="list-body-content"><?php echo $email_mens	; ?></td>
                        <td class="list-body-content"><?php echo $tel_mens; ?></td>
                        <td class="list-body-content"><?php echo $mensagem_mens; ?></td>
                        <td class="list-body-content"><?php echo date('d/m/Y H:i:s', strtotime($dia_mens));?></td>
                        <td class="list-body-content"><?php echo $status_mens; ?></td>

                        <td class="list-body-content">
                            <div class="dropdown-action">
                                <button onclick="actionDropdown(<?php echo $id_mens; ?>)" class="dropdown-btn-action">Ações</button>
                                <div id="actionDropdown<?php echo $id_mens; ?>" class="dropdown-action-item">
                                    <?php
                                    if ($this->data['button']['view_contato']) {
                                        echo "<a href='" . URLADM . "view-contato/index/$id_mens'>Visualizar</a>";
                                    }
                                    if ($this->data['button']['edit_contato']) {
                                        echo "<a href='" . URLADM . "edit-contato/index/$id_mens'>Editar</a>";
                                    }                                    
                                    if ($this->data['button']['delete_mensagem']) {
                                        echo "<a href='" . URLADM . "delete-mensagem/index/$id_mens' onclick='return confirm(\"Tem certeza que deseja excluir esta mensagem?\")'>Apagar</a>";
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