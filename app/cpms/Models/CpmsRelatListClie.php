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
class CpmsRelatListClie
{

    /** @var bool $result Recebe true quando executar o processo com sucesso e false quando houver erro */
    private bool $result;

    /** @var array|null $resultBd Recebe os registros do banco de dados */
    private array|null $resultBd;

    /** @var int $page Recebe o número página */
    private int $page;

    /** @var string|null $searchMarca Recebe o valor da marca*/
    private string|null $searchCidade;

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
    public function listClie(): void
    {
        $contEquip = new \App\adms\Models\helper\AdmsRead();
        $contEquip->fullRead("SELECT COUNT(id) AS num_result FROM adms_clientes WHERE (empresa= :empresa)",
            "empresa={$_SESSION['emp_user']}"
        );
        $this->resultBd = $contEquip->getResult();
        if ($this->resultBd) {
            $_SESSION['resultado'] = '';
            $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum cliente encontrado!</p>";
            $this->result = false;
        }

        $listEquip = new \App\adms\Models\helper\AdmsRead();
        $listEquip->fullRead("SELECT clie.id as id_clie, clie.razao_social as razao_social_clie, clie.nome_fantasia as nome_fantasia_clie, 
                            clie.cnpjcpf as cnpjcpf_clie, clie.cep as cep_clie, clie.logradouro as logradouro_clie, clie.bairro as bairro_clie,
                            clie.cidade as cidade_clie, clie.uf as uf_clie, clie.empresa as empresa_clie, emp.logo as logo_emp   
                            FROM adms_clientes AS clie 
                            INNER JOIN adms_emp_principal AS emp ON emp.id=clie.empresa
                            WHERE (clie.empresa= :empresa)", "empresa={$_SESSION['emp_user']}");



        $this->resultBd = $listEquip->getResult();
        
        if ($this->resultBd) {
            $this->generateClie();
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Cliente encontrado!</p>";
            $this->result = false;
        }
    }

    /**
     * Metodo pesquisar pela empresa do Ticket
     * @return void
     */
    public function searchCidade(string|null $searchCidade): void
    {
        $this->searchCidade = $searchCidade . "%";

        $contClie = new \App\adms\Models\helper\AdmsRead();
        $contClie->fullRead("SELECT COUNT(id) AS num_result FROM adms_clientes WHERE (empresa= :empresa) AND (cidade LIKE :cidade)",
            "empresa={$_SESSION['emp_user']}&cidade={$this->searchCidade}");

        $this->resultBd = $contClie->getResult();
        if ($this->resultBd) {
            $_SESSION['resultado'] = '';
            $_SESSION['resultado'] = $this->resultBd[0]['num_result'];
        } else {
            $_SESSION['msg'] = "<p class='alert-danger'>Erro: Nenhum Ticket encontrado!</p>";
            $this->result = false;
        }

        $listClie = new \App\adms\Models\helper\AdmsRead();
        $listClie->fullRead("SELECT clie.id as id_clie, clie.razao_social as razao_social_clie, clie.nome_fantasia as nome_fantasia_clie, 
                            clie.cnpjcpf as cnpjcpf_clie, clie.cep as cep_clie, clie.logradouro as logradouro_clie, clie.bairro as bairro_clie,
                            clie.cidade as cidade_clie, clie.uf as uf_clie, clie.empresa as empresa_clie, emp.logo as logo_emp 
                            FROM adms_clientes AS clie 
                            INNER JOIN adms_emp_principal AS emp ON emp.id=clie.empresa
                            WHERE (clie.empresa= :empresa) AND (clie.cidade LIKE :cidade)", 
                            "empresa={$_SESSION['emp_user']}&cidade={$this->searchCidade}");


        $this->resultBd = $listClie->getResult();
        
        if ($this->resultBd) {
            $this->generateClie();
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
    private function generateClie()
    {      
        
        $total_tickets = $_SESSION['resultado'];
        unset( $_SESSION['resultado']);

        $image_clie=($this->resultBd[0]['empresa_clie']);
        $logo_clie=($this->resultBd[0]['logo_emp']);
        $html = "<style> table {border-collapse: collapse;width: 100%;}th, td {border: 1px solid black;padding: 2px;text-align: left;} caption{padding: 8px;text-align: center;}a{padding-left: 1000px}</style>";
        $html .= "<a href='" .URLADM. "relat-list-clie/index'><img src='" . URLADM . "app/adms/assets/image/logo/clientes/$image_clie/$logo_clie' width='70' alt='Logo do Cliente'></a>";
        $html .= "<table>";
        $html .= "<caption><b> RELATORIO DE CLIENTES </b>";
        $html .= "<caption>Total de : <b> {$total_tickets} </b> Clientes.";
        $html .= "<thead>";
        $html .= "<th>Id</th>";
        $html .= "<th>Nome</th>";
        $html .= "<th>Cnpj/Cpf</th>";
        $html .= "<th>Endereço</th>";
        $html .= "<th>Cidade/Estado</th>";
        $html .= "</thead>";

        foreach ($this->resultBd as $clie) {
        extract($clie);  
        
            $html .= "<tbody>";
            $html .= "<td>$id_clie</td>";
            $html .= "<td>$razao_social_clie - $nome_fantasia_clie</td>";
            $html .= "<td>$cnpjcpf_clie</td>";
            $html .= "<td>$cep_clie - $logradouro_clie - $bairro_clie </td>";
            $html .= "<td>$cidade_clie - $uf_clie</td>";
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
