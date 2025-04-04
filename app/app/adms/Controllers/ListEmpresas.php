<?php

namespace App\adms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller listar cores
 * @author Daniel Canedo - docan2006@gmail.com
 */
class ListEmpresas
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var string|null $sesearchCnpj Recebe o cnpj da empresa*/
    private string|null $searchCnpj;

    /** @var string|null $sesearchRazao Recebe a razao social da empresa*/
    private string|null $searchRazao;

    /** @var string|null $searchFantasia Recebe o nome de fantasia da empresaal */
    private string|null $searchFantasia;

    /**
     * Método listar cores.
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

        $this->searchCnpj = filter_input(INPUT_GET, 'searchCnpj', FILTER_DEFAULT);
        $this->searchRazao = filter_input(INPUT_GET, 'searchRazao', FILTER_DEFAULT);
        $this->searchFantasia= filter_input(INPUT_GET, 'searchFantasia', FILTER_DEFAULT);

        $listEmpresas= new \App\adms\Models\AdmsListEmpresas();
        
        if (!empty($this->dataForm['SendSearchEmpresa'])) {
            $this->page = 1;
            $listEmpresas->listSearchEmpresas($this->page, $this->dataForm['search_cnpj'], $this->dataForm['search_razao'], $this->dataForm['search_fantasia']);
            $this->data['form'] = $this->dataForm;
        } elseif ((!empty($this->searchCnpj)) or (!empty($this->searchRazao)) or (!empty($this->searchFantasia))) {
            $listEmpresas->listSearchEmpresas($this->page, $this->searchCnpj, $this->searchRazao, $this->searchFantasia);
            $this->data['form']['search_cnpj'] = $this->searchCnpj;
            $this->data['form']['search_razao'] = $this->searchRazao;
            $this->data['form']['search_fantasia'] = $this->searchFantasia;
        } else {            
            $listEmpresas->listEmpresas($this->page);            
        }
        
        if ($listEmpresas->getResult()) {
            $this->data['listEmpresas'] = $listEmpresas->getResultBd();
            $this->data['pagination'] = $listEmpresas->getResultPg();
        } else {
            $this->data['listEmpresas'] = [];
            $this->data['pagination'] = "";
        }

        $button = ['add_empresas' => ['menu_controller' => 'add-empresas', 'menu_metodo' => 'index'],
        'view_empresas' => ['menu_controller' => 'view-empresas', 'menu_metodo' => 'index'],
        'edit_empresas' => ['menu_controller' => 'edit-empresas', 'menu_metodo' => 'index'],
        'delete_empresas' => ['menu_controller' => 'delete-empresas', 'menu_metodo' => 'index']];
        
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu(); 

        $this->data['sidebarActive'] = "list-empresas";         
        $loadView = new \Core\ConfigView("adms/Views/empresas/listEmpresas", $this->data);
        $loadView->loadView();
    }
}
