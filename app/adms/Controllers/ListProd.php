<?php

namespace App\adms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller listar Produtos
 * @author Daniel Canedo - docan2006@gmail.com
 */
class ListProd
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $dataForm;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;

    /** @var string|null $searchProd Recebe o nome do controller */
    private string|null $searchProd;

    /** @var string|null $searchEmail Recebe o nome do metodo */
    private string|null $searchEmp;

    /** @var string|null $searchEmail Recebe o nome do metodo */
    private string|null $searchTipo;

    /**
     * Método listar páginas.
     * 
     * Instancia a MODELS responsável em buscar os registros no banco de dados.
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senão enviar o array de dados vazio.
     *
     * @return void
     */
    public function index(string|int|null $page = null): void
    {
        if (isset($_GET['status_ticket'])) {
            $_SESSION['status_ticket'] = (int)$_GET['status_ticket'];
            header("Location: " . URLADM . "list-prod/index");
            exit();
        }
            $this->page = (int) $page ? $page : 1;

            $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
            $this->searchEmp = filter_input(INPUT_GET, 'search_emp', FILTER_DEFAULT);
            $this->searchProd = filter_input(INPUT_GET, 'search_prod', FILTER_DEFAULT);
            $this->searchTipo = filter_input(INPUT_GET, 'search_tipo', FILTER_DEFAULT);

            $listProd = new \App\adms\Models\AdmsListProd();

            if (!empty($this->dataForm['SendSearchProdEmp'])) {
                $this->page = 1;
                $listProd->listSearchProd($this->page, $this->dataForm['search_emp'], $this->dataForm['search_prod'], $this->dataForm['search_tipo']);
                $this->data['form'] = $this->dataForm;
            } else {
                $listProd->listProd($this->page);
            }

            if ($listProd->getResult()) {
                $this->data['listProd'] = $listProd->getResultBd();
                $this->data['pagination'] = $listProd->getResultPg();
            } else {
                $this->data['listProd'] = [];
                $this->data['pagination'] = "";
            }       


        $button = [
            'add_prod' => ['menu_controller' => 'add-prod', 'menu_metodo' => 'index'],
            'view_prod' => ['menu_controller' => 'view-prod', 'menu_metodo' => 'index'],
            'edit_prod' => ['menu_controller' => 'edit-prod', 'menu_metodo' => 'index'],
            'delete_prod' => ['menu_controller' => 'delete-prod', 'menu_metodo' => 'index']
        ];

        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $listSelect = new \App\adms\Models\AdmsListProd();
        $this->data['select'] = $listSelect->listSelect();

        $this->data['pag'] = $this->page;
        $this->data['sidebarActive'] = "list-prod";
        $loadView = new \Core\ConfigView("adms/Views/produtos/listProd", $this->data);
        $loadView->loadView();
    }
}
