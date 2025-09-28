<?php

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

if (isset($this->data['form'])) {
    $valorForm = $this->data['form'];
}

if (isset($this->data['form'][0])) {
    $valorForm = $this->data['form'][0];
}
//var_dump($this->data);
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Editar Sla</span>

            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_sla']) {
                    echo "<a href='" . URLADM . "list-sla/index' class='btn-info'>Listar</a> ";
                }                
                if (isset($valorForm['id_sla'])) {
                    if ($this->data['button']['view_sla']) {
                        echo "<a href='" . URLADM . "view-sla/index/" . $valorForm['id_sla'] . "' class='btn-primary'>Visualizar</a>";
                    }
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
                <?php
                $id_sla = "";
                if (isset($valorForm['id_sla'])) {
                    $id_sla = $valorForm['id_sla'];
                }
                ?>
                <input type="hidden" name="id" id="id" value="<?php echo $id_sla; ?>">

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
                        $name_temp = "";
                        if (isset($valorForm['name_temp'])) {
                            $name_temp = $valorForm['name_temp'];
                        }
                        ?>
                        <label class="title-input">Primeira Resposta do SLA:<span class="text-danger">*</span></label>                        
                        <select name="prim_resp" id="tempo_nome_sla_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['temp_sla'] as $temp_sla) {
                                extract($temp_sla);
                                if (isset($valorForm['tempo']) and $valorForm['tempo'] == $name_temp) {
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
                        <label class="title-input">Tempo Total SLA:<span class="text-danger">*</span></label>
                        <input type="text" name="final_resp" id="final_resp" class="input-adm" placeholder="Tempo total do sla" value="<?php echo $tempo_horas_sla_id; ?>" required>
                    </div>
                </div>

                <div class="row-input">
                    <div class="column">
                        <?php
                        $name_ativ = "";
                        if (isset($valorForm['name_ativ'])) {
                            $name_ativ = $valorForm['name_ativ'];
                        }
                        ?>
                        <label class="title-input">Tipo de Urgencia:<span class="text-danger">*</span></label>                        
                        <select name="atividade_id" id="atividade_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['ativ_sla'] as $ativ_sla) {
                                extract($ativ_sla);
                                if (isset($valorForm['name_ativ']) and $valorForm['name_ativ'] == $name_ativ) {
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
                        $obs_sla = "";
                        if (isset($valorForm['obs_sla'])) {
                            $obs_sla = $valorForm['obs_sla'];
                        }
                        ?>
                        <label class="title-input">Dados Adicionais:<span class="text-danger">*</span></label>
                        <textarea type="text" name="obs" id="obs" class="input-adm"  rows="4" cols="50" placeholder="Digite a sla " required><?php echo $obs_sla; ?></textarea>

                    </div>
                </div>

                <p class="text-danger mb-5 fs-6">* Campo Obrigatório</p>

                <button type="submit" name="SendEditSla" class="btn-warning" value="Salvar">Salvar</button>

            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->