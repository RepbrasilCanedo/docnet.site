<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}
//var_dump($this->data);
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Cadastrar Sla</span>

            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_sla']) {
                    echo "<a href='" . URLADM . "list-sla/index' class='btn-info'>Listar</a> ";
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
            <form method="POST" action="" id="form-add-sla" class="form-adm">

                <div class="row-input">
                    <div class="column">
                        <?php
                        $name = "";
                        if (isset($valorForm['name'])) {
                            $name = $valorForm['name'];
                        }
                        ?>
                        <label class="title-input">Nome:<span class="text-danger">*</span></label>
                        <input type="text" name="name" id="name" class="input-adm" placeholder="Digite o nome da sla" value="<?php echo $name; ?>" required>
                    </div>

                    <div class="column">
                        <?php
                        $tipo_ocorr_id  = "";
                        if (isset($valorForm['tipo_ocorr_id'])) {
                            $tipo_ocorr_id  = $valorForm['tipo_ocorr_id'];
                        }
                        ?>
                        <label class="title-input">Tipo:<span class="text-danger">*</span></label>
                        <select name="tipo_ocorr_id" id="tipo_ocorr_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['type_sla'] as $type_sla) {
                                extract($type_sla);
                                if (isset($valorForm['tipo_ocorr_id']) and $valorForm['tipo_ocorr_id'] == $tipo_ocorr_id) {
                                    echo "<option value='$id_typ' selected>$name_typ</option>";
                                } else {
                                    echo "<option value='$id_typ'>$name_typ</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="column">
                        <?php
                        $prioridade_id = "";
                        if (isset($valorForm['prioridade_id'])) {
                            $prioridade_id = $valorForm['prioridade_id'];
                        }
                        ?>
                        <label class="title-input">Prioridade:<span class="text-danger">*</span></label>                        
                        <select name="prioridade_id" id="prioridade_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['prior_sla'] as $prior_sla) {
                                extract($prior_sla);
                                if (isset($valorForm['prioridade_id']) and $valorForm['prioridade_id'] == $prioridade_id) {
                                    echo "<option value='$id_prior' selected>$name_prior</option>";
                                } else {
                                    echo "<option value='$id_prior'>$name_prior</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <?php
                        $tempo_nome_sla_id = "";
                        if (isset($valorForm['tempo_nome_sla_id'])) {
                            $tempo_nome_sla_id = $valorForm['tempo_nome_sla_id'];
                        }
                        ?>
                        <label class="title-input">Tempo de Sla:<span class="text-danger">*</span></label>                        
                        <select name="tempo_nome_sla_id" id="tempo_nome_sla_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['temp_sla'] as $temp_sla) {
                                extract($temp_sla);
                                if (isset($valorForm['tempo_nome_sla_id']) and $valorForm['tempo_nome_sla_id'] == $tempo_nome_sla_id) {
                                    echo "<option value='$id_temp' selected>$name_temp</option>";
                                } else {
                                    echo "<option value='$id_temp'>$name_temp</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="column">
                        <?php
                        $tempo_horas_sla_id = "";
                        if (isset($valorForm['tempo_horas_sla_id'])) {
                            $tempo_horas_sla_id = $valorForm['tempo_horas_sla_id'];
                        }
                        ?>
                        <label class="title-input">Tempo(horas):<span class="text-danger">*</span></label>
                        <input type="text" name="tempo_horas_sla_id" id="tempo_horas_sla_id" class="input-adm" placeholder="Quantidade de horas para a SLA" value="<?php echo $tempo_horas_sla_id; ?>" required>
                    </div>

                    <div class="column">
                        <?php
                        $atividade_id = "";
                        if (isset($valorForm['atividade_id'])) {
                            $atividade_id = $valorForm['atividade_id'];
                        }
                        ?>
                        <label class="title-input">Atividade:<span class="text-danger">*</span></label>                        
                        <select name="atividade_id" id="atividade_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['ativ_sla'] as $ativ_sla) {
                                extract($ativ_sla);
                                if (isset($valorForm['atividade_id']) and $valorForm['atividade_id'] == $atividade_id) {
                                    echo "<option value='$id_ativ' selected>$name_ativ</option>";
                                } else {
                                    echo "<option value='$id_ativ'>$name_ativ</option>";
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
                        <label class="title-input">Dados Adicionais:<span class="text-danger">*</span></label>
                        <textarea type="text" name="obs" id="obs" class="input-adm" placeholder="Digite dados adicionais para a SLA " required><?php echo $obs; ?></textarea>

                    </div>
                </div>

                <p class="text-danger mb-5 fs-6">* Campo Obrigatório</p>

                <button type="submit" name="SendAddSla" class="btn-warning" value="Salvar">Salvar</button>

            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->