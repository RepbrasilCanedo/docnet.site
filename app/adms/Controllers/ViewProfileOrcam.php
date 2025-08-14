<?php

namespace App\adms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller da página visualizar perfil
 * @author Daniel Canedo - docan2006@gmail.com
 */
class ViewProfileOrcam
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var int|string|null $id Recebe o id do registro */
    private int|string|null $id;

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**
     * Metodo visualizar perfil
     * Instancia a MODELS AdmsViewProfile para pesquisar as informações do usuário
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senão é redirecionado para a página de login.
     * 
     * @return void
     */
    public function index(int|string|null $id = null): void
    {
        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($id)) {
            $this->id = (int) $id;
            $viewProfileOrcam = new \App\adms\Models\AdmsViewProfileOrcam();
            $viewProfileOrcam->viewProfileOrcam($this->id);

            if ($viewProfileOrcam->getResult()) {
                $this->data['viewProfileOrcam'] = $viewProfileOrcam->getResultBd();
                $this->loadViewProfileOrcam();
            } else {
                $urlRedirect = URLADM . "login/index";
                header("Location: $urlRedirect");
            }
        }
    }

    /**
     * Instanciar a classe responsável em carregar a View e enviar os dados para View.
     * 
     */
    private function loadViewProfileOrcam(): void
    {
        $button = ['list_orcam' => ['menu_controller' => 'list-orcam', 'menu_metodo' => 'index'],
        'edit_profile_image_orcam' => ['menu_controller' => 'edit-profile-image-orcam', 'menu_metodo' => 'index'],
        ];
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $loadView = new \Core\ConfigView("adms/Views/orcamentos/viewProfileOrcam", $this->data);
        $loadView->loadView();
    }
}
