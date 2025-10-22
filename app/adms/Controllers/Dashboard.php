<?php

namespace App\adms\Controllers;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/*
var_dump($_SESSION['emp_user']);
var_dump($_SESSION['set_Contr']);
var_dump($_SESSION['adms_access_level_id']);
*/
/**
 * Controller Dashboard
 * @author Daniel Canedo - docan2006@gmail.com
 */
class Dashboard
{

    /** @var array|string|null $data Recebe os dados que devem ser enviados para VIEW */
    private array|string|null $data;

    /** @var string|int|null $page Recebe o número página */
    private string|int|null $page;

    /** @var array $dataForm Recebe os dados do formulario */
    private array|null $dataForm;

    /**
     * Método Dashboard.
     * Instanciar a classe responsavel em carregar a View e enviar os dados para View.
     * 
     * @return void
     */
    public function index(string|int|null $page = null): void
    {
        $this->page = (int) $page ? $page : 1;

        $this->dataForm = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        $logoCliente = new \App\adms\Models\AdmsDashboard();
        $logoCliente->logoCliente();

        if ($logoCliente->getResult()) {
            $this->data['logoCliente'] = $logoCliente->getResultBd();
        } else {
            $this->data['logoCliente'] = false;
        }

        $carrMarketing = new \App\adms\Models\AdmsDashboard();
        $carrMarketing->carrMarketing();

        if ($carrMarketing->getResult()) {
            $this->data['carrMarketing'] = $carrMarketing->getResultBd();
        } else {
            $this->data['carrMarketing'] = false;
        }

        $countEquipVenc = new \App\adms\Models\AdmsDashboard();
        $countEquipVenc->countEquipVenc();

        if ($countEquipVenc->getResult()) {
            $this->data['countEquipVenc'] = $countEquipVenc->getResultBd();
        } else {
            $this->data['countEquipVenc'] = false;
        }
        //verifica se sla esta vencido na primeira resposta
        $verifSlaTicket = new \App\adms\Models\AdmsDashboard();
        $verifSlaTicket->verifSlaTicket();

        if ($countEquipVenc->getResult()) {
            $this->data['verifSlaTicket'] = $verifSlaTicket->getResultBd();
        } else {
            $this->data['verifSlaTicket'] = false;
        }
        
        $countCham = new \App\adms\Models\AdmsDashboard();
        $countCham->countChamAber();

        if ($countCham->getResult()) {
            $this->data['countCham'] = $countCham->getResultBd();
        } else {
            $this->data['countCham'] = false;
        }

        $countAgend = new \App\adms\Models\AdmsDashboard();
        $countAgend->countChamAgend();

        if ($countAgend->getResult()) {
            $this->data['countAgend'] = $countAgend->getResultBd();
        } else {
            $this->data['countAgend'] = false;
        }

        $countReagend = new \App\adms\Models\AdmsDashboard();
        $countReagend->countChamReagend();

        if ($countReagend->getResult()) {
            $this->data['countReagend'] = $countReagend->getResultBd();
        } else {
            $this->data['countReagend'] = false;
        }

        $countChamAtend = new \App\adms\Models\AdmsDashboard();
        $countChamAtend->countChamAtend();
        if ($countChamAtend->getResult()) {
            $this->data['countChamAtend'] = $countChamAtend->getResultBd();
        } else {
            $this->data['countChamAtend'] = false;
        }

        $countChamPausa = new \App\adms\Models\AdmsDashboard();
        $countChamPausa->countChamPausa();
        if ($countChamPausa->getResult()) {
            $this->data['countChamPausa'] = $countChamPausa->getResultBd();
        } else {
            $this->data['countChamPausa'] = false;
        }

        $countChamAgua = new \App\adms\Models\AdmsDashboard();
        $countChamAgua->countChamAgua();
        if ($countChamAgua->getResult()) {
            $this->data['countChamAgua'] = $countChamAgua->getResultBd();
        } else {
            $this->data['countChamAgua'] = false;
        }

        $countChamCom = new \App\adms\Models\AdmsDashboard();
        $countChamCom->countChamCom();
        if ($countChamCom->getResult()) {
            $this->data['qnt_cham_com'] = $countChamCom->getResultBd();
        } else {
            $this->data['qnt_cham_com'] = false;
        }


        $countChamClie = new \App\adms\Models\AdmsDashboard();
        $countChamClie->countChamClie();
        if ($countChamClie->getResult()) {
            $this->data['countChamClie'] = $countChamClie->getResultBd();
        } else {
            $this->data['countChamClie'] = false;
        }

        $countChamFinal = new \App\adms\Models\AdmsDashboard();
        $countChamFinal->countChamFinal();

        if ($countChamFinal->getResult()) {
            $this->data['countChamFinal'] = $countChamFinal->getResultBd();
        } else {
            $this->data['countChamFinal'] = false;
        }

        $countChamRepr = new \App\adms\Models\AdmsDashboard();
        $countChamRepr->countChamRepr();

        if ($countChamRepr->getResult()) {
            $this->data['countChamRepr'] = $countChamRepr->getResultBd();
        } else {
            $this->data['countChamRepr'] = false;
        }

        $countChamApro = new \App\adms\Models\AdmsDashboard();
        $countChamApro->countChamApro();

        if ($countChamApro->getResult()) {
            $this->data['countChamApro'] = $countChamApro->getResultBd();
        } else {
            $this->data['countChamApro'] = false;
        }

        $countChamAproAval = new \App\adms\Models\AdmsDashboard();
        $countChamAproAval->countChamAproAval();
        if ($countChamAproAval->getResult()) {
            $this->data['countChamAproAval'] = $countChamAproAval->getResultBd();
        } else {
            $this->data['countChamAproAval'] = false;
        }
        

        $countMensRec = new \App\adms\Models\AdmsDashboard();
        $countMensRec->countMensRec();

        if ($countMensRec->getResult()) {
            $this->data['countMensRec'] = $countMensRec->getResultBd();
        } else {
            $this->data['countMensRec'] = false;
        }



        $button = [
            'edit_aprov_cham' => ['menu_controller' => 'edit-aprov-cham', 'menu_metodo' => 'index'],
            'list_cham' => ['menu_controller' => 'list-cham', 'menu_metodo' => 'index']
        ];

        $listBotton = new \App\adms\Models\helper\AdmsButton();
        $this->data['button'] = $listBotton->buttonPermission($button);

        $listMenu = new \App\adms\Models\helper\AdmsMenu();
        $this->data['menu'] = $listMenu->itemMenu();

        $this->data['sidebarActive'] = "dashboard";

        $loadView = new \Core\ConfigView("adms/Views/dashboard/dashboard", $this->data);
        $loadView->loadView();
    }
}
