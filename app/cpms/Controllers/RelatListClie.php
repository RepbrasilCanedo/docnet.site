<?php

namespace App\cpms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Controller listar todas as chamadas
 * @author Daniel Canedo - docan2006@gmail.com
 */
class RelatListClie
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;

    /** @var string|null $searchCham Recebe a empresa do chamado*/
    private string|null $searchCidade;

    /**
     * Método listar Chamados
     * 
     * Instancia a MODELS responsável em buscar os registros no banco de dados.
     * Se encontrar registro no banco de dados envia para VIEW.
     * Senão enviar o array de dados vazio.
     *
     * @return void
     */
    public function index(): void
    {
        

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);  

        if($this->dataForm<>null){
            $this->searchCidade= $this->dataForm['search_cidade'];
            
        }
        
        
        //var_dump($this->searchCidade);

        $listClie = new \App\cpms\Models\CpmsRelatListClie();
        
        if ((!empty($this->dataForm['SendSearchClie']))) {

            if($this->dataForm['search_cidade']== null){
                $listClie->listClie();   
           }else{
              $listClie->searchCidade($this->searchCidade);     
            //$listClie->searchCidade($this->searchCidade);  
           }      
        }

        $listSelect = new \App\cpms\Models\CpmsRelatListClie();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "adms/relat-list-clie";
        $loadView = new \Core\ConfigView("cpms/Views/chamados/relatListClie", $this->data);
        $loadView->loadView();
    }


    
}
