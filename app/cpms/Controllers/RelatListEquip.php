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
class RelatListEquip
{
    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;

    /** @var string|null $searchCham Recebe a empresa do chamado*/
    private string|null $searchEmpresa;

    /** @var string|null $searchDateStart Recebe a data de inicio */
    private string|null $searchDateStart;

    /** @var string|null $searchDateEnd Recebe a data final */
    private string|null $searchDateEnd;

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
            $this->searchEmpresa= $this->dataForm['search_empresa'];
            $this->searchDateStart = $this->dataForm['search_date_start'];
            $this->searchDateEnd = $this->dataForm['search_date_end'];
        }

        $listEquip = new \App\cpms\Models\CpmsRelatListEquip();
        
        if ((!empty($this->dataForm['SendSearchEquip']))) {
            if ((!empty($this->dataForm['search_empresa'])) and (empty($this->dataForm['search_date_start'])) and (empty($this->dataForm['search_date_end']))){  
                $listEquip->searchEmpresa($this->searchEmpresa);  
            } elseif ((empty($this->dataForm['search_empresa'])) and (!empty($this->dataForm['search_date_start'])) and (!empty($this->dataForm['search_date_end']))){            
                $listEquip->searchPeriodo($this->searchDateStart, $this->searchDateEnd); 
            } elseif ((empty($this->dataForm['search_empresa'])) and (empty($this->dataForm['search_date_start'])) and (empty($this->dataForm['search_date_end']))) {            
                $listEquip->listEquip($this->searchEmpresa); 
            }      
        }

        $listSelect = new \App\cpms\Models\CpmsRelatListEquip();
        $this->data['select'] = $listSelect->listSelect();

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "adms/relat-list-equip";
        $loadView = new \Core\ConfigView("cpms/Views/chamados/relatListEquip", $this->data);
        $loadView->loadView();
    }


    
}
