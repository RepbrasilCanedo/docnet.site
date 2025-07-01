<?php

namespace App\cpms\Models;

if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Listar marcas dos equipamentos do banco de dados
 *
 * @author Daniel Canedo - docan2006@gmail.com
 */
class CpmsRelatListEquip
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int $page Recebe o número página */
    private int $page;

    /** @var string|null $searchMarca Recebe o valor da marca*/
    private string|null $searchEmpresa;

    /** @var string|null $searchEmail Recebe o nome da cor em hexadecimal */
    private string|null $searchEmpresaValue;

    /** @var array|null $listRegistryAdd Recebe os registros do banco de dados */
    private array|null $listRegistryAdd;

 

    /**
     * @return bool Retorna os registros do BD
     */
    function getResultBd(): array|null
    {
        return $this->resultBd;
    }
        /**
     * Metodo pesquisar pela empresa do Ticket
     * @return void
     */
    public function listEquip(string|null $search_empresa): void
    {
        $contEquip = new \App\adms\Models\helper\AdmsRead();
        $contEquip->fullRead("SELECT COUNT(id) AS num_result FROM adms_produtos WHERE (empresa_id= :empresa_id)",
            "empresa_id={$_SESSION['emp_user']}"
        );
        $this->resultBd = $contEquip->getResult();
        if ($this->resultBd) {
            $_SESSION['resultado'] = '';
            $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
            $this->result = false;
        }

        $listEquip = new \App\adms\Models\helper\AdmsRead();
        $listEquip->fullRead("SELECT prod.id as id_prod, prod.name as name_prod, prod.serie as serie_prod, 
                            prod.modelo_id as modelo_id_prod, prod.marca_id as marca_id_prod, clie.nome_fantasia as nome_fantasia_clie, prod.empresa_id as empresa_id_prod, prod.sit_id, emp.logo as logo_emp   
                            FROM adms_produtos AS prod
                            INNER JOIN adms_clientes AS clie ON clie.id=prod.cliente_id 
                            INNER JOIN adms_emp_principal AS emp ON emp.id=prod.empresa_id
                            WHERE (empresa_id= :empresa_id)", "empresa_id={$_SESSION['emp_user']}");



        $this->resultBd = $listEquip->getResult();
        
        if ($this->resultBd) {
            //var_dump($this->resultBd);
            $this->generatePdf();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Equipamento encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo pesquisar pela empresa do Ticket
     * @return void
     */
    public function searchEmpresa(string|null $search_empresa): void
    {
        $this->searchEmpresa = $search_empresa;
        $this->searchEmpresaValue = $this->searchEmpresa;


        $contEquip = new \App\adms\Models\helper\AdmsRead();
        $contEquip->fullRead("SELECT COUNT(id) AS num_result FROM adms_produtos WHERE (empresa_id= :empresa_id) AND (cliente_id= :cliente_id)",
            "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresa}"
        );
        $this->resultBd = $contEquip->getResult();
        if ($this->resultBd) {
            $_SESSION['resultado'] = '';
            $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
            $this->result = false;
        }

        $listEquip = new \App\adms\Models\helper\AdmsRead();
        $listEquip->fullRead("SELECT prod.id as id_prod, prod.name as name_prod, prod.serie as serie_prod, 
                            prod.modelo_id as modelo_id_prod, prod.marca_id as marca_id_prod, clie.nome_fantasia as nome_fantasia_clie, prod.empresa_id as empresa_id_prod, prod.sit_id, emp.logo as logo_emp   
                            FROM adms_produtos AS prod
                            INNER JOIN adms_clientes AS clie ON clie.id=prod.cliente_id 
                            INNER JOIN adms_emp_principal AS emp ON emp.id=prod.empresa_id
                            WHERE (empresa_id= :empresa_id) AND (prod.cliente_id= :cliente_id)", 
                            "empresa_id={$_SESSION['emp_user']}&cliente_id={$this->searchEmpresa}");



        $this->resultBd = $listEquip->getResult();
        
        if ($this->resultBd) {
            //var_dump($this->resultBd);
            $this->generatePdf();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Equipamento encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo para pesquisar as informações que serão usadas no dropdown do formulário
     *
     * @return array
     */
    public function listSelect(): array
    {
        $list = new \App\adms\Models\helper\AdmsRead();

        if ($_SESSION['adms_access_level_id'] > 2) {

            if (($_SESSION['adms_access_level_id'] == 4) or ($_SESSION['adms_access_level_id'] == 12)) {

                $list->fullRead("SELECT id id_emp, nome_fantasia nome_fantasia_emp FROM adms_clientes as emp
                WHERE empresa= :empresa ORDER BY nome_fantasia", "empresa={$_SESSION['emp_user']}");
                $registry['nome_emp'] = $list->getResult();

                $this->listRegistryAdd = ['nome_emp' => $registry['nome_emp']];
                return $this->listRegistryAdd;
            }
        } else {
            $list->fullRead("SELECT id id_emp, nome_fantasia nome_fantasia_emp FROM adms_empresa as emp  
            ORDER BY nome_fantasia ASC");
            $registry['nome_emp'] = $list->getResult();

            $this->listRegistryAdd = ['nome_emp' => $registry['nome_emp']];
        }
        return $this->listRegistryAdd;
    }


    // Função para gerar os dados para o pdf em DOMPDF
    private function generatePdf()
    {      
        
        $total_tickets = $_SESSION['resultado'];
        unset( $_SESSION['resultado']);

        $image_clie=($this->resultBd[0]['empresa_id_prod']);
        $logo_clie=($this->resultBd[0]['logo_emp']);
      
        $html = "<style> table {border-collapse: collapse;width: 100%;}th, td {border: 1px solid black;padding: 2px;text-align: left;} caption{padding: 8px;text-align: center;}</style>";
        $html .= "<img src='" . URLADM . "app/adms/assets/image/logo/clientes/$image_clie/$logo_clie' width='70' alt='Logo do Cliente'";
        $html .= "<table>";
        $html .= "<caption><b> RELATORIO DE EQUIPAMENTOS </b>";
        $html .= "<caption>Total de : <b> {$total_tickets} </b> Ticket.";
        $html .= "<thead>";
        $html .= "<th>Id</th>";
        $html .= "<th>Nome Equipamento.</th>";
        $html .= "<th>Modelo/Marca</th>";
        $html .= "<th>N. de Serie</th>";
        $html .= "<th>Cliente</th>";
        $html .= "</thead>";

        foreach ($this->resultBd as $user) {
        extract($user);  
        
            $html .= "<tbody>";
            $html .= "<td>$id_prod</td>";
            $html .= "<td>$name_prod</td>";
            $html .= "<td>$modelo_id_prod - $marca_id_prod</td>";
            $html .= "<td>$serie_prod</td>";
            $html .= "<td>$nome_fantasia_clie</td>";
            $html .= "</tbody>";
        }
        
        $html .= "</table><br>";
        
        date_default_timezone_set('America/Bahia');
        $dataGeracao = date('d/m/Y H:i:s');
        $html .= "<caption><b> Data de emissão: $dataGeracao </b>";

        $generatePdf = new \App\cpms\Models\helper\CpmsGeneratePdf();
        $generatePdf->generatePdf($html);
    
        
    }
      
}
