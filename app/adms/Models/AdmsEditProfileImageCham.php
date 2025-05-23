<?php

namespace App\adms\Models;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar a imagem do perfil do usuario
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsEditProfileImageCham
{
    private array|null $data;
    private array|null $dataImagem;
    private string|null $nameImg;
    private string|null $directory;
    private string|null $delImgCham;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result = false;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /**
     * @return bool Retorna os detalhes do registro
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }

    /**
     * Metodo para pesquisar a imagem do usuário que será editada
     * @return boolean
     */
    public function viewProfileCham(): bool
    {        
        
        $viewCham = new \App\adms\Models\helper\AdmsRead();
        $viewCham->fullRead("SELECT id, image, modified FROM  adms_cham  WHERE id=:id LIMIT :limit", "id=" . $_SESSION['set_cham'] . "&limit=1"
        );

        $this->resultBd = $viewCham->getResult();
        if ($this->resultBd) {
            $this->result = true;
            return true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Chamado não encontrado!</p>";
            $this->result = false;
            return false;
        }
    }

    /**
     * Metodo recebe a informação da imagem que será editada
     * Instancia o helper AdmsValEmptyField para validar os campos do formulário
     * Retira o campo "new_image" da validação
     * Chama o metodo valInput para validar a extensão da imagem     
     * @param array|null $data
     * @return void
     */
    public function update(array $data): void
    {
        
        $this->data = $data;

        $this->dataImagem = $this->data['new_image_cham'];
        unset($this->data['new_image_cham']);


        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);
        if ($valEmptyField->getResult()) {
            if (!empty($this->dataImagem['name'])) {
                $this->valInput();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar um chamado!</p>";
                $this->result = false;
            }
        } else {
            $this->result = false;
        }
    }

    /** 
     * Valida a extensão da imagem com o helper AdmsValExtImg
     * Retorna FALSE quando houve algum erro
     * 
     * @return void
     */
    private function valInput(): void
    {
        $valExtImgCham = new \App\adms\Models\helper\AdmsValExtImg();
        $valExtImgCham->validateExtImg($this->dataImagem['type']);
        if (($this->viewProfileCham()) and ($valExtImgCham->getResult())) {
            $this->upload();
        } else {
            $this->result = false;
        }
    }

    /**
     * Metodo gera o slug da imagem com o helper AdmsSlug
     * Faz o upload da imagem usando o helper AdmsUploadImgRes
     * Chama o metodo edit para atualizar as informações no banco de dados
     * @return void
     */
    private function upload(): void
    {
        
        
        $slugImgCham = new \App\adms\Models\helper\AdmsSlug();
        $this->nameImg = $slugImgCham->slug($this->dataImagem['name']);
        $this->directory = "app/adms/assets/image/chamados/" . $_SESSION['set_cham'] . "/";

        $uploadImgRes = new \App\adms\Models\helper\AdmsUploadImgRes();
        $uploadImgRes->upload($this->dataImagem, $this->directory, $this->nameImg, 300, 300);
        if($uploadImgRes->getResult()){
            $this->edit();
        }else{
            $this->result = false;
        }
    }

    /**
     * Metodo envia as informações editadas para o banco de dados
     * Chama o metodo deleteImage apagar a imagem antiga do usuário
     *
     * @return void
     */
    private function edit(): void
    {
        $this->data['image'] = $this->nameImg;
        $this->data['modified'] = date("Y-m-d H:i:s");

        $upCham = new \App\adms\Models\helper\AdmsUpdate();
        $upCham->exeUpdate("adms_cham", $this->data, "WHERE id=:id", "id=" . $_SESSION['set_cham']);

        if ($upCham->getResult()) {
            $_SESSION['user_image'] = $this->nameImg;
            $this->deleteImage();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Imagem do chamado não editado com sucesso!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo apaga a imagem antiga do usuário
     * @return void
     */
    private function deleteImage(): void
    {
        if (((!empty($this->resultBd[0]['image'])) or ($this->resultBd[0]['image'] != null)) and ($this->resultBd[0]['image'] != $this->nameImg)) {
            $this->delImgCham = "app/adms/assets/image/chamados/" . $_SESSION['set_cham'] . "/" . $this->resultBd[0]['image'];
            if (file_exists($this->delImgCham)) {
                unlink($this->delImgCham);
            }
        }

        $_SESSION['msg'] = "<p class='alert-success'>Imagem do Chamado editada com sucesso!</p>";
        $this->result = true;
    }

}
