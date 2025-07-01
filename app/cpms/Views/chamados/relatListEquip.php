<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

//echo('<pre>');var_dump($this->data);echo('</pre>');
?>


<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Relatório de Equipamentos</span><br>
        </div>

        <div class="top-list">
            <form method="POST" action="">
                <div class="row-input-search">
                        <!--4 ou 12: Usuario adm e suporte -->
                        <?php if (($_SESSION['adms_access_level_id'] == 4) or($_SESSION['adms_access_level_id'] == 12)){ ?>    
                            <div class="column">
                                <label class="title-input">Cliente:</label>
                                <select name="search_empresa" id="search_empresa" class="input-adm">
                                    <option value="">Todos</option>
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
                        <?php } ?>

                    <div class="column margin-top-search">
                        <button type="submit" name="SendSearchEquip" class="btn-warning" value="Pesquisar" target="_blank">Gerar Pdf</button>
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
    </div>
</div>
<!-- Fim do conteudo do administrativo -->