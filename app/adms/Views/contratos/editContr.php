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
/*
echo "<pre>";
var_dump($valorForm);
echo "</pre>";*/
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <span class="title-content">Editar Contrato</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_contr']) {
                    echo "<a href='" . URLADM . "list-contr/index' class='btn-info'>Listar</a> ";
                }
                if (isset($valorForm['id'])) {
                    if ($this->data['button']['view_contr']) {
                        echo "<a href='" . URLADM . "view-contr/index/" . $valorForm['id'] . "' class='btn-primary'>Visualizar</a><br><br>";
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
            <form method="POST" action="" id="form-edit-contr" class="form-adm">
                <?php
                $id = "";
                if (isset($valorForm['id'])) {
                    $id = $valorForm['id'];
                }
                ?>
                <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

                <div class="row-input">
                <div class="column">
                    <?php
                        $nome_fantasia_emp = "";
                        if (isset($valorForm['nome_fantasia_emp'])) {
                            $nome_fantasia_emp = $valorForm['nome_fantasia_emp'];
                        }
                        ?>
                        <label class="title-input">Empresa:</label>
                        <span class="input-group-text"><?php echo $nome_fantasia_emp; ?></span>
                        
                    </div>
                    <div class="column">
                        <?php
                        $servico = "";
                        if (isset($valorForm['servico'])) {
                            $servico = $valorForm['servico'];
                        }
                        ?>
                        <label class="title-input">Serviço:<span class="text-danger">*</span></label>
                        <select name="service_id" id="service_id" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['name_service'] as $nameServ) {
                                extract($nameServ);
                                if (isset($valorForm['servico']) and $valorForm['servico'] == $name_service) {
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
                        <label class="title-input">Número Contrato:<span class="text-danger">*</span></label>
                        <input type="text" name="num_cont" id="num_cont" class="input-adm" placeholder="Número Contrato" value="<?php echo $num_cont; ?>" required>

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
                        <?php
                        $situacao = "";
                        if (isset($valorForm['situacao'])) {
                            $situacao = $valorForm['situacao'];
                        }
                        ?>
                        <label class="title-input">Situação do Contrato:<span class="text-danger">*</span></label>
                        <select name="sit_cont" id="sit_cont" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['name_sit'] as $sitContr) {
                                extract($sitContr);
                                if (isset($valorForm['situacao']) and $valorForm['situacao'] == $name_sit) {
                                    echo "<option value='$id_sit' selected>$name_sit </option>";
                                } else {
                                    echo "<option value='$id_sit'>$name_sit </option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="column">
                        <?php
                        $tipo = "";
                        if (isset($valorForm['tipo'])) {
                            $tipo = $valorForm['tipo'];
                        }
                        ?>
                        <label class="title-input">Tipo Contrato:<span class="text-danger">*</span></label>
                        <select name="tipo_cont" id="tipo_cont" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['name_tipo'] as $tipoContr) {
                                extract($tipoContr);
                                if (isset($valorForm['tipo']) and $valorForm['tipo'] == $name_tipo) {
                                    echo "<option value='$id_tipo' selected>$name_tipo</option>";
                                } else {
                                    echo "<option value='$id_tipo'>$name_tipo</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="column mt-2">
                        <?php
                        $anexo = "";
                        if (isset($valorForm['anexo'])) {
                            $anexo = $valorForm['anexo'];
                        }

                        ?>
                        <label class="title-input">Contrato Anexado:</label><br>
                        <label class="title-input text-danger"><?= $anexo ?></label>
                    </div>
                </div>

                <div class="column">
                    <?php
                    $obs = "";
                    if (isset($valorForm['obs'])) {
                        $obs = $valorForm['obs'];
                    }
                    ?>
                    <label class="title-input">Informações Adicionais:<span class="text-danger">*</span></label>
                    <textarea type="text" name="obs" id="obs" class="input-adm" placeholder="Número Contrato" required rows="4"><?php echo $obs; ?> </textarea>
                </div>



                <p class="text-danger mb-2 fs-5">* Campo Obrigatório</p>
                <button type="submit" name="SendEditContr" class="btn-success" value="Cadastrar">Salvar</button>
            </form>
        </div>

        <!-- Início do formulário enviar arquivo PDF -->
        <form method="POST" action="" enctype="multipart/form-data">
            <label>Arquivo PDF: </label>
            <input type="file" name="arquivo" accept="application/pdf">

            <input type="submit" name="btn-enviar-pdf" value="Anexar" class="btn-warning mt-3">
        </form>
        <!-- Fim do formulário enviar arquivo PDF -->

        <?php
        $clie_cont_cont = "";
        if (isset($valorForm['id'])) {
            $clie_cont_cont = $valorForm['id'];
        }
        // Receber os dados do formulário
        $dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        //var_dump ($_FILES['arquivo']['name']);
        // Acessa o IF quando o usuário clicar no botão Enviar
        if (!empty($dados['btn-enviar-pdf'])) {
            // Receber o arquivo enviado através do formulário
            $arquivo = $_FILES['arquivo'];
            //var_dump($arquivo);
            // Validar o arquivo verificando se o mesmo é PDF
            if ($arquivo['type'] != 'application/pdf') {
                echo "<p style='color: #f00;'>Erro: Necessário enviar arquivo PDF!</p>";
            } else {
                // Caminho para o upload
                $caminho_upload = "./app/adms/assets/arquivos/contratos/$clie_cont_cont/";
                //var_dump($caminho_upload);


                if (file_exists($caminho_upload)) {
                    // Criar novo nome para o arquivo PDF
                    $renomear_arquivo = $arquivo['name'];
                    $_SESSION['anex_Contr'] = '';
                    $_SESSION['anex_Contr'] = $renomear_arquivo;
                    // Realizar upload do arquivo
                    move_uploaded_file($arquivo['tmp_name'], $caminho_upload . $renomear_arquivo);
                } else {
                    // Criar novo diretório
                    $novoDir = mkdir('./app/adms/assets/arquivos/contratos/' . $clie_cont_cont, 0777, true);
                    // Criar novo nome para o arquivo PDF
                    $renomear_arquivo = $arquivo['name'];
                    $_SESSION['anex_Contr'] = '';
                    $_SESSION['anex_Contr'] = $renomear_arquivo;
                    move_uploaded_file($arquivo['tmp_name'], $caminho_upload . $renomear_arquivo);
                }
            }
        }
        ?>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->