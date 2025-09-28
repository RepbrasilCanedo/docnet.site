<?php

namespace App\adms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller listar Sla(acordo de Nivel de Servico)
 * @author Daniel Canedo - docan2006@gmail.com
 */
class ListSla
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var string|null $searchName Recebe o nome da cor */
    private string|null $searchName;

    /** @var string|null $searchSla Recebe o nome da cor em hexadecimal */
    private string|null $searchSla;

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

        $listSla = new \App\adms\Models\AdmsListSla();
        $listSla->listSla($this->page); 
        
        if ($listSla->getResult()) {
            $this->data['listSla'] = $listSla->getResultBd();
            $this->data['pagination'] = $listSla->getResultPg();
        } else {
            $this->data['listSla'] = [];
            $this->data['pagination'] = "";
        }

        $button = ['add_sla' => ['menu_controller' => 'add-sla', 'menu_metodo' => 'index'],
        'view_sla' => ['menu_controller' => 'view-sla', 'menu_metodo' => 'index'],
        'edit_sla' => ['menu_controller' => 'edit-sla', 'menu_metodo' => 'index'],
        'delete_sla' => ['menu_controller' => 'delete-sla', 'menu_metodo' => 'index']];
        
        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu(); 

        $this->data['sidebarActive'] = "list-sla";         
        $loadView = new \Core\ConfigView("adms/Views/sla/listSla", $this->data);
        $loadView->loadView();
    }
}
