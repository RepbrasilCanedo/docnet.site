<?php

namespace App\adms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller listar Contratos
 * @author Daniel Canedo - docan2006@gmail.com
 */
class ListContr
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $dataForm;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;

    /** @var string|null $searchEmail Recebe o nome do metodo */
    private string|null $searchId;

    /** @var string|null $searchEmail Recebe o nome do metodo */
    private string|null $searchType;

    /** @var string|null $searchEmail Recebe o nome do metodo */
    private string|null $searchServ;

    /** @var string|null $searchEmail Recebe o nome do metodo */
    private string|null $searchEmp;

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
            $this->page = (int) $page ? $page : 1;

            $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);

            $this->searchId = filter_input(INPUT_GET, 'search_id', FILTER_DEFAULT);
            $this->searchType = filter_input(INPUT_GET, 'search_type', FILTER_DEFAULT);
            $this->searchServ = filter_input(INPUT_GET, 'search_serv', FILTER_DEFAULT);
            $this->searchEmp = filter_input(INPUT_GET, 'search_emp', FILTER_DEFAULT);
            //var_dump($this->dataForm);

            $listContr = new \App\adms\Models\AdmsListContr();

            if (!empty($this->dataForm['SendSearchContrEmp'])) {
                $this->page = 1;
                $listContr->listSearchContr($this->page, $this->dataForm['search_id'], $this->dataForm['search_type'], $this->dataForm['search_serv'], $this->dataForm['search_emp']);
                $this->data['form'] = $this->dataForm;
            } elseif ((!empty($this->searchId)) or (!empty($this->searchType)) or (!empty($this->searchServ)) or (!empty($this->searchEmp))) {
                $listContr->listSearchContr($this->page, $this->searchId, $this->searchType, $this->searchServ, $this->searchEmp);
                $this->data['form']['search_id'] = $this->searchId;
                $this->data['form']['search_type'] = $this->searchType;
                $this->data['form']['search_serv'] = $this->searchServ;
                $this->data['form']['search_emp'] = $this->searchEmp;
            } else {
                $listContr->listContr($this->page);
            }

            if ($listContr->getResult()) {
                $this->data['listContr'] = $listContr->getResultBd();
                $this->data['pagination'] = $listContr->getResultPg();
            } else {
                $this->data['listContr'] = [];
                $this->data['pagination'] = "";
            }


        $button = [
            'add_contr' => ['menu_controller' => 'add-contr', 'menu_metodo' => 'index'],
            'view_contr' => ['menu_controller' => 'view-contr', 'menu_metodo' => 'index'],
            'edit_contr' => ['menu_controller' => 'edit-contr', 'menu_metodo' => 'index'],
            'delete_contr' => ['menu_controller' => 'delete-contr', 'menu_metodo' => 'index']
        ];

        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listSelect = new \App\adms\Models\AdmsListContr();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['pag'] = $this->page;
        
        $this->data['sidebarActive'] = "list-contr";
        $loadView = new \Core\ConfigView("adms/Views/contratos/listContr", $this->data);
        $loadView->loadView();
    }
}
