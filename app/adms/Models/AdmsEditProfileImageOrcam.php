<?php

namespace app\adms\Models;

if(!defined('D0O8C0A3N1E9D6O1')){
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Editar a imagem do perfil do usuario
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsEditProfileImageOrcam
{
    private array|null $data;
    private array|null $dataImagem;
    private string|null $nameImg;
    private string|null $directory;
    private string|null $delImgOrcam;

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
    public function viewProfileOrcam(): bool
    {   
        $viewOrcam = new \App\adms\Models\helper\AdmsRead();
        $viewOrcam->fullRead("SELECT id, image, status_id, modified FROM  adms_orcam  WHERE id=:id", "id={$_SESSION['set_orcam']}"
        );

        $this->resultBd = $viewOrcam->getResult();
        if ($this->resultBd) {
            $_SESSION['status_prop']='';
            $_SESSION['status_prop']=$this->resultBd[0]['status_id'];
            $this->result = true;
            return true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Orçamento não encontrado!</p>";
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
        $this->dataImagem = $this->data['new_image_orcam'];
        unset($this->data['new_image_orcam']);  

        $valEmptyField = new \App\adms\Models\helper\AdmsValEmptyField();
        $valEmptyField->valField($this->data);

        if ($valEmptyField->getResult()) {
            if (!empty($this->dataImagem['name'])) {
                $this->valInput();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário selecionar um orçamento!</p>";
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
        
        $valExtImgOrcam = new \App\adms\Models\helper\AdmsValExtPdf();        
        $valExtImgOrcam->validateExtOrcam($this->dataImagem['type']);

        if (($this->viewProfileOrcam()) and ($valExtImgOrcam->getResult())) {
            $this->upload();
        } else {
            $this->result = false;
        }
    }

    /**
     * Metodo gera o slug da imagem com o helper AdmsSlug
     * Faz o upload da imagem usando o helper AdmsUploadImgPdf
     * Chama o metodo edit para atualizar as informações no banco de dados
     * @return void
     */
    private function upload(): void
    {       
        $slugImgCham = new \App\adms\Models\helper\AdmsSlug();
        $this->nameImg = $slugImgCham->slug($this->dataImagem['name']);
        $this->directory = "app/adms/assets/image/orcamentos/".$_SESSION['set_orcam']."/";

        
        $uploadImgRes = new \App\adms\Models\helper\AdmsUploadPdfOrcam();
        $uploadImgRes->upload($this->dataImagem, $this->directory, $this->nameImg);        

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
        date_default_timezone_set('America/Bahia');

        $this->data['image'] = $this->nameImg;

        if($_SESSION['status_prop'] == 5){//ptoposta reprovada
            $this->data['status_id'] = 6; //Proposta Reenviada
        }else{
            $this->data['status_id'] = 3; //Proposta Enviada
        }
        
        $this->data['modified'] = date("Y-m-d H:i:s");

        $upOrcam = new \App\adms\Models\helper\AdmsUpdate();
        $upOrcam->exeUpdate("adms_orcam", $this->data, "WHERE id=:id", "id={$_SESSION['set_orcam']}");

        if ($upOrcam->getResult()) {
            $_SESSION['user_image'] = $this->nameImg;
            $this->deleteImage();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Imagem do Orçamento não editado com sucesso!</p>";
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
            $this->delImgOrcam = "app/adms/assets/image/orcamentos/".$_SESSION['set_orcam']."/".$this->resultBd[0]['image'];
            if (file_exists($this->delImgOrcam)) {
                unlink($this->delImgOrcam);
            }
        }

        $_SESSION['msg'] = "<p class='alert-success'>Imagem da Proposta de Orçamento editada com sucesso!</p>";
        $this->result = true;
    }

}
