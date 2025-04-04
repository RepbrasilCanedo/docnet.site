<?php

namespace App\cpms\Models\helper;

use Dompdf\Dompdf;
use Dompdf\Options;


if (!defined('D0O8C0A3N1E9D6O1')) {
    header("Location: /");
    die("Erro: Página não encontrada<br>");
}

/**
 * Classe genérica para gerar PDF
 *
 * @author Daniel Canedo
 */

class CpmsGeneratePdf
{
    
    public function generatePdf(string $html): void
    {
        try {
        // Instanciando o DomPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $dompdf = new Dompdf($options);

        // Carregar o conteúdo HTML
        $dompdf->loadHtml($html);

        // Renderizar o PDF
        $dompdf->render();
        
       $dompdf->stream("exemplo.pdf", array("Attachment" => 0)); // Attachment 0 força a abertura no navegador

        } catch (\Exception $e) {
            echo 'Erro ao gerar o PDF: ' . $e->getMessage();
        }
    }
}

