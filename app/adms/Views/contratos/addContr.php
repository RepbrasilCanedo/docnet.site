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
            <span class="title-content">Cadastrar Contratos</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_contr']) {
                    echo "<a href='" . URLADM . "list-contr/index' class='btn-info'>Listar</a> ";
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
            <span id="msg"></span>
        </div>

        <div class="content-adm">
            <form method="POST" action="" id="form-add-contr" class="form-adm">

                <div class="row-input">
                    <div class="column">
                    <?php
                        $clie_cont = "";
                        if (isset($valorForm['clie_cont'])) {
                            $clie_cont = $valorForm['clie_cont'];
                        }
                        ?>
                        <label class="title-input">Empresa:<span class="text-danger">*</span></label>
                        <select name="clie_cont" id="clie_cont" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['clie_cont'] as $clie_cont) {
                                extract($clie_cont);
                                if (isset($valorForm['clie_cont']) and $valorForm['clie_cont'] == $id) {
                                    echo "<option value='$clie_id' selected>$fantasia_name</option>";
                                } else {
                                    echo "<option value='$clie_id'>$fantasia_name</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="column">
                        <label class="title-input">Serviço:<span class="text-danger">*</span></label>
                        <select name="service_id" id="service_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['name_service'] as $nameServ) {
                                extract($nameServ);
                                if (isset($valorForm['name_service']) and $valorForm['name_service'] == $id_service) {
                                    echo "<option value='$id_service' selected>$name_service</option>";
                                } else {
                                    echo "<option value='$id_service'>$name_service</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>

                    <div class="column">
                        <?php
                        $num_cont = "";
                        if (isset($valorForm['num_cont'])) {
                            $num_cont = $valorForm['num_cont'];
                        }
                        ?>
                        <label class="title-input">Descrição Contrato:<span class="text-danger">*</span></label>
                        <input type="text" name="num_cont" id="num_cont" class="input-adm" placeholder="Descrição Contrato" value="<?php echo $num_cont; ?>" required>

                    </div>
                </div>
                <div class="row-input">
                    <div class="column">
                        <?php
                        $dt_inicio = "";
                        if (isset($valorForm['dt_inicio'])) {
                            $dt_inicio = $valorForm['dt_inicio'];
                        }
                        ?>
                        <label class="title-input">Início Contrato:<span class="text-danger">*</span></label>
                        <input type="date" name="dt_inicio" id="dt_inicio" class="input-adm" placeholder="Início Contrato" value="<?php echo $dt_inicio; ?>" required>

                    </div>

                    <div class="column">
                        <?php
                        $dt_term = "";
                        if (isset($valorForm['dt_term'])) {
                            $dt_term = $valorForm['dt_term'];
                        }
                        ?>
                        <label class="title-input">Término Contrato:<span class="text-danger">*</span></label>
                        <input type="date" name="dt_term" id="dt_term" class="input-adm" placeholder="Término Contrato" value="<?php echo $dt_term; ?>" required>

                    </div>

                    <div class="column">
                        <label class="title-input">Situação do Contrato:<span class="text-danger">*</span></label>
                        <select name="sit_cont" id="sit_cont" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['name_sit'] as $sitContr) {
                                extract($sitContr);
                                if (isset($valorForm['name_sit']) and $valorForm['name_sit'] == $id_sit) {
                                    echo "<option value='$id_sit' selected>$name_sit </option>";
                                } else {
                                    echo "<option value='$id_sit'>$name_sit </option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <label class="title-input">Tipo Contrato:<span class="text-danger">*</span></label>
                        <select name="tipo_cont" id="tipo_cont" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['name_tipo'] as $tipoContr) {
                                extract($tipoContr);
                                if (isset($valorForm['name_tipo']) and $valorForm['name_tipo'] == $id_tipo) {
                                    echo "<option value='$id_tipo' selected>$name_tipo</option>";
                                } else {
                                    echo "<option value='$id_tipo'>$name_tipo</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="column">
                        <?php
                        $obs = "";
                        if (isset($valorForm['obs'])) {
                            $obs = $valorForm['obs'];
                        }
                        ?>
                        <label class="title-input">Obs:</label>
                        <textarea type="text" name="obs" id="obs" class="input-adm" placeholder="Observações" value="<?php echo $obs; ?>" required></textarea>

                    </div>
                </div>

                    

                <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>

                <button type="submit" name="SendAddContr" class="btn-success" value="Cadastrar">Cadastrar</button>

            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->