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
            <span class="title-content">Cadastrar Empresa</span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_emp_principal']) {
                    echo "<a href='" . URLADM . "list-emp-principal/index' class='btn-info'>Listar</a> ";
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
            <form method="POST" action="" id="form-add-empresas" class="form-adm">

                <div class="row-input">
                    <div class="column">
                        <?php
                        $razao_social = "";
                        if (isset($valorForm['razao_social'])) {
                            $razao_social = $valorForm['razao_social'];
                        }
                        ?>
                        <label class="title-input">Razão Social:<span class="text-danger">*</span></label>
                        <input type="text" name="razao_social" id="razao_social" class="input-adm" placeholder="Razão social" value="<?php echo $razao_social; ?>" required>
                    </div>
                    <div class="column">
                        <?php
                        $nome_fantasia = "";
                        if (isset($valorForm['nome_fantasia'])) {
                            $nome_fantasia = $valorForm['nome_fantasia'];
                        }
                        ?>
                        <label class="title-input">Nome Fantasia:<span class="text-danger">*</span></label>
                        <input type="text" name="nome_fantasia" id="nome_fantasia" class="input-adm" placeholder="Nome fantasia" value="<?php echo $nome_fantasia; ?>" required>

                    </div>


                    <div class="column">
                        <label class="title-input">Contrato:<span class="text-danger">*</span></label>
                        <select name="contrato" id="contrato" class="input-adm" required>
                            <option value="">Selecione</option>
                            <?php
                            foreach ($this->data['select']['num_cont'] as $num_cont) {
                                extract($num_cont);
                                if (isset($valorForm['num_cont']) and $valorForm['num_cont'] == $id) {
                                    echo "<option value='$id' selected>$num_cont</option>";
                                } else {
                                    echo "<option value='$id'>$num_cont</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    
                </div>

                    <div class="row-input">
                        <div class="column">
                            <?php
                            $cnpj = "";
                            if (isset($valorForm['cnpj'])) {
                                $cnpj = $valorForm['cnpj'];
                            }
                            ?>
                            <label class="title-input">Cnpj:<span class="text-danger">*</span></label>
                            <input type="text" name="cnpj" id="cnpj" class="input-adm" placeholder="Número do Cnpj" value="<?php echo $cnpj; ?>" required>
                        </div>
                        <div class="column">
                            <?php
                            $cep = "";
                            if (isset($valorForm['cep'])) {
                                $cep = $valorForm['cep'];
                            }
                            ?>
                            <label class="title-input">Cep:<span class="text-danger">*</span></label>
                            <input type="text" name="cep" id="cep" class="input-adm" placeholder="Número do Cep" value="<?php echo $cep; ?>" required>
                        </div>
                    </div>

                    <div class="row-input">
                        <div class="column">
                            <?php
                            $logradouro = "";
                            if (isset($valorForm['logradouro'])) {
                                $logradouro = $valorForm['logradouro'];
                            }
                            ?>
                            <label class="title-input">Logradouro:<span class="text-danger">*</span></label>
                            <input type="text" name="logradouro" id="logradouro" class="input-adm" placeholder="Rua e numero" value="<?php echo $logradouro; ?>" required>

                        </div>
                        <div class="column">
                            <?php
                            $bairro = "";
                            if (isset($valorForm['bairro'])) {
                                $bairro = $valorForm['bairro'];
                            }
                            ?>
                            <label class="title-input">Bairro:<span class="text-danger">*</span></label>
                            <input type="text" name="bairro" id="bairro" class="input-adm" placeholder="Bairro" value="<?php echo $bairro; ?>" required>
                        </div>
                    </div>

                    <div class="row-input">
                        <div class="column">
                            <?php
                            $cidade = "";
                            if (isset($valorForm['cidade'])) {
                                $cidade = $valorForm['cidade'];
                            }
                            ?>
                            <label class="title-input">Cidade:<span class="text-danger">*</span></label>
                            <input type="text" name="cidade" id="cidade" class="input-adm" placeholder="Observação" value="<?php echo $cidade; ?>" required>
                        </div>
                        <div class="column">
                            <?php
                            $uf = "";
                            if (isset($valorForm['uf'])) {
                                $uf = $valorForm['uf'];
                            }
                            ?>
                            <label class="title-input">UF:<span class="text-danger">*</span></label>
                            <input type="text" name="uf" id="uf" class="input-adm" placeholder="Estado" value="<?php echo $uf; ?>" required>
                        </div>

                        <div class="column">
                            <label class="title-input">Situação da Empresa:<span class="text-danger">*</span></label>
                            <select name="situacao" id="situacao" class="input-adm" required>
                                <option value="">Selecione</option>
                                <?php
                                foreach ($this->data['select']['situacao'] as $sitempresas) {
                                    extract($sitempresas);
                                    if (isset($valorForm['situacao']) and $valorForm['situacao'] == $id) {
                                        echo "<option value='$id' selected>$name</option>";
                                    } else {
                                        echo "<option value='$id'>$name</option>";
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <p class="text-danger mb-5 fs-4">* Campo Obrigatório</p>

                    <button type="submit" name="SendAddEmpPrincipal" class="btn-success" value="Cadastrar">Cadastrar</button>

            </form>
        </div>
    </div>
</div>
<!-- Fim do conteudo do administrativo -->