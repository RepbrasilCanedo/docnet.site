<?php

namespace App\adms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Validar os dados do login
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class AdmsLogin
{

    /** @var array|null $data Recebe as informações do formulário */
    private array|null $data;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /**
     * @return bool Retorna true quando executar o processo com sucesso e false quando houver erro
     */
    function getResult(): bool
    {
        return $this->result;
    }

    /** 
     * Recebe os valores do formulário.
     * Recupera as informações do usuário no banco de dados
     * Quando encontrar o usuário no banco de dados instanciar o método "valEmailPerm" para validar a situação do usuário
     * Retorna FALSE quando não encontrar usuário no banco de dados
     * 
     * @param array $data Recebe as informações do formulário
     * 
     * @return void
     */
    public function login(array $data = null): void
    {
        $this->data = $data;

        $viewUser = new \App\adms\Models\helper\AdmsRead();
        $viewUser->fullRead("SELECT usr.id, usr.name, usr.nickname, usr.email, usr.password, usr.image, usr.adms_sits_user_id, usr.adms_access_level_id,
                            lev.order_levels, usr.empresa_id, usr.cliente_id, usr.contr_id, usr.setor_id 
                            FROM adms_users AS usr
                            INNER JOIN adms_access_levels AS lev ON lev.id=usr.adms_access_level_id
                            WHERE usr.user =:user 
                            OR usr.email =:email 
                            LIMIT :limit", "user={$this->data['user']}&email={$this->data['user']}&limit=1");

        $this->resultBd = $viewUser->getResult();
        if ($this->resultBd) {
            $this->valEmailPerm();
        } else {
            //Verifica e valida na tabela usuario final
            $viewUser = new \App\adms\Models\helper\AdmsRead();
            $viewUser->fullRead("SELECT usr.id, usr.name, usr.nickname, usr.email, usr.password, usr.image, usr.adms_sits_user_id, usr.adms_access_level_id,
                            lev.order_levels, usr.empresa_id, usr.cliente_id
                            FROM adms_users_final AS usr
                            INNER JOIN adms_access_levels AS lev ON lev.id=usr.adms_access_level_id
                            WHERE usr.user=:user OR usr.email =:email 
                            LIMIT :limit", "user={$this->data['user']}&email={$this->data['user']}&limit=1");

            $this->resultBd = $viewUser->getResult();
            if ($this->resultBd) {
                $this->valEmailPerm();
            } else {
                $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário ou a senha incorreta!</p>";
                $this->result = false;
            }
        }
    }

    /**
     * Metodo valida a situação do usuário
     * Se a situação for 1, chama chama a função valPassword para validar a senha
     * Se a situação for 3, retorna falso, pois, o usuario precisar confirmar o e-mail.
     * Se a situação for 5, retorna falso, pois, o e-mail do usuário foi descadastrado.
     * Se a situação for 2, retorna falso, pois, o e-mail esta inativo
     * @return void
     */
    private function valEmailPerm(): void
    {
        if ($this->resultBd[0]['adms_sits_user_id'] == 1) {
            $this->valPassword();
        } elseif ($this->resultBd[0]['adms_sits_user_id'] == 3) {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Necessário confirmar o e-mail, solicite novo link <a href='" . URLADM . "new-conf-email/index'>Clique aqui</a>!</p>";
            $this->result = false;
        } elseif ($this->resultBd[0]['adms_sits_user_id'] == 5) {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: E-mail descadastrado, entre em contato com a empresa!</p>";
            $this->result = false;
        } elseif ($this->resultBd[0]['adms_sits_user_id'] == 2) {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: E-mail inativo, entre em contato com a empresa!</p>";
            $this->result = false;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: E-mail inativo, entre em contato com a empresa!</p>";
            $this->result = false;
        }
    }


    /** 
     * Compara a senha enviado pelo usuário com a senha que está salva no banco de dados
     * Retorna TRUE quando os dados estão corretos e salva as informações do usuário na sessão
     * Retorna FALSE quando a senha está incorreta
     * 
     * @return void
     */
    private function valPassword(): void
    {
        if (password_verify($this->data['password'], $this->resultBd[0]['password'])) {
            $_SESSION['user_id'] = $this->resultBd[0]['id'];
            $_SESSION['user_name'] = $this->resultBd[0]['name'];
            $_SESSION['user_nickname'] = $this->resultBd[0]['nickname'];
            $_SESSION['user_email'] = $this->resultBd[0]['email'];
            $_SESSION['user_image'] = $this->resultBd[0]['image'];
            $_SESSION['adms_access_level_id'] = $this->resultBd[0]['adms_access_level_id'];
            $_SESSION['order_levels'] = $this->resultBd[0]['order_levels'];
            $_SESSION['emp_user'] = $this->resultBd[0]['empresa_id'];
            $_SESSION['set_clie'] = $this->resultBd[0]['cliente_id'];
            $_SESSION['set_Contr'] = $this->resultBd[0]['contr_id'];
            $_SESSION['set_cham'] = '';
            $_SESSION['set_hist'] = '';
            $_SESSION['set_status'] = '';
            $_SESSION['set_Contr_emp'] = '';
            $this->result = true;
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Usuário ou a senha incorreta!</p>";
            $this->result = false;
        }
    }
}
