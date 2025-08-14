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
    //echo "<pre>";var_dump($this->data['form']);echo "</pre>";
}
?>
<!-- Inicio do conteudo do administrativo -->
<div class="wrapper">
    <div class="row">
        <div class="top-list">
            <?php
            $id_orcam = "";
            if (isset($valorForm['id_orcam'])) {
                $id_orcam = $valorForm['id_orcam'];
            }
            ?>
            <span class="title-content">Orçamento nº : <?php echo $id_orcam; ?></span>
            <div class="top-list-right">
                <?php
                if ($this->data['button']['list_orcam']) {
                    echo "<a href='" . URLADM . "list-orcam/index' class='btn-info'>Lista Orçamentos</a> ";
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
            <span id_orcam="msg"></span>
        </div>

        <form method="post" action="">
            <?php
            $id_orcam = "";
            if (isset($valorForm['id_orcam'])) {
                $id_orcam = $valorForm['id_orcam'];
            }
            ?>
            <input type="hidden" name="id" id_orcam="id" value="<?php echo $id_orcam; ?>">

            <div class="row">
                <div class="col-md-6">
                    <div class="card  mb-5">
                        <div class="card-header">
                            Avaliação da Proposta de Orçamento Recebida:
                        </div>
                        <div class="card-body">
                            <div>
                                <textarea name="inf_adic" id="inf_adic" rows="5" cols="50" class="input-adm" placeholder="Informações Adicionais" required></textarea>
                                <button type="submit" name="SendAprovOrcam" value="Aprovar" class="btn btn-success btn-sm m-3"><span class="fas far fa-play-circle me-2"></span>Aprovado</button>
                                <button type="submit" name="SendReprOrcam" value="Reprovar" class="btn btn-danger btn-sm"><span class="fa-solid fa-stop me-2"></span>Reprovado</button>
                            </div>
                        </div>
                    </div>

                </div>
        </form>

        <form method="post" action="">
            <?php
            $id_orcam = "";
            if (isset($valorForm['id_orcam'])) {
                $id_orcam = $valorForm['id_orcam'];
            }
            ?>
            <input type="hidden" name="id_orcam" id_orcam="id_orcam" value="<?php echo $id_orcam; ?>">
        </form>
    </div>

</div>
</div>
<!-- Fim do conteudo do administrativo -->