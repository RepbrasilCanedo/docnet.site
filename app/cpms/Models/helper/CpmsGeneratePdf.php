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
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        // Carregar o conteúdo HTML
        $dompdf->loadHtml($html);

        // (Opcional) Definir tamanho do papel e orientação
        $dompdf->setPaper('A4', 'landscape');

        // Renderizar o PDF
        $dompdf->render();

        $dompdf->stream("relatorio_chamados.pdf", array("Attachment" => 0));

        } catch (\Exception $e) {
            echo 'Erro ao gerar o PDF: ' . $e->getMessage();
        }
    }
}

