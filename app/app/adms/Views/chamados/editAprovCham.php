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
    //echo "<pre>";var_dump($valorForm);
}
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <?php
            $id = "";
            if (isset($valorForm['id'])) {
                $id = $valorForm['id'];
            }
            ?>
            <span class="title-content">Chamado nº : <?php echo $id; ?></span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['dashboard']) {
                    echo "<a href='" . URLADM . "list-cham/index' class='btn-info'>Lista Chamados</a> ";
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

        <form method="post" action="">
            <?php
            $id = "";
            if (isset($valorForm['id'])) {
                $id = $valorForm['id'];
            }
            ?>
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

            <div class="row">
                <div class="col-md-6">
                    <div class="card  mb-5">
                        <div class="card-header">
                            Aprovação e Avaliação do Chamado Finalizado
                        </div>
                        <div class="card-body">
                            <div>
                                <div class="form-check mb-3">
                                    <h6> Como você classifica nosso atendimento:</h6>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="nota_atend" name="nota_atend" value="5" required>Muito Bom
                                        <label class="form-check-label"></label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="nota_atend" name="nota_atend" value="4" required>Bom
                                        <label class="form-check-label" for="radio2"></label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="nota_atend" name="nota_atend" value="3" required>Regular
                                        <label class="form-check-label"></label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="nota_atend" name="nota_atend" value="2" required>Ruim
                                        <label class="form-check-label" for="radio2"></label>
                                    </div>
                                    <div class="form-check">
                                        <input type="radio" class="form-check-input" id="nota_atend" name="nota_atend" value="1" required>Muito Ruim
                                        <label class="form-check-label" for="radio1"></label>
                                    </div>
                                    
                                </div>
                                <button type="submit" name="SendAprovCham" value="Aprovar" class="btn btn-success btn-sm"><span class="fas far fa-play-circle me-2"></span>Aprovado</button>
                            </div>

                        </div>
                    </div>

                </div>
        </form>

        <form method="post" action="">
            <?php
            $id = "";
            if (isset($valorForm['id'])) {
                $id = $valorForm['id'];
            }
            ?>
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Reprovação e Justificativa da Reprovação
                        </div>
                        <div class="card-body">
                            <textarea name="motivo_repr" id="motivo_repr" rows="5" cols="50" class="input-adm" placeholder="Justificativa" required></textarea>
                            <button type="submit" name="SendReprCham" value="Reprovar" class="btn btn-danger btn-sm"><span class="fas far fa-play-circle me-2"></span>Reprovado</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</div>
</div>
<!-- Fim do conteudo do administrativo -->