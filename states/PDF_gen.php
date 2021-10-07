<?php
/**
 * HTML2PDF Library - example
 *
 * HTML => PDF convertor
 * distributed under the LGPL License
 *
 * @package   Html2pdf
 * @author    Laurent MINGUET <webmaster@html2pdf.fr>
 * @copyright 2016 Laurent MINGUET
 *
 * isset($_GET['vuehtml']) is not mandatory
 * it allow to display the result in the HTML format
 */

    // get the HTML
    ob_start();
    include('fiche.php');
    $content = ob_get_clean();
    // convert in PDF
    /*require_once __DIR__ .'/../vendor/autoload.php';
    //echo htmlspecialchars($content);
    $mpdf = new \Mpdf\Mpdf();
    $mpdf->WriteHTML($content);
    $mpdf->Output();*/
    require_once('/Applications/MAMP/htdocs/GPRD-proto/vendor/autoload.php');

    use Spipu\Html2Pdf\Html2Pdf;
    try
    {
        $html2pdf = new HTML2PDF('L', 'A4', 'fr');
//      $html2pdf->setModeDebug();
        $html2pdf->setDefaultFont('Arial');
        $html2pdf->setTestTdInOnePage(false);
        
        $html2pdf->writeHTML($content, false);
        $html2pdf->Output('exemple00.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
