<?php
$file = dirname(__FILE__) . '/../vendor/phpoffice/phpword/src/PhpWord/Autoloader.php';
require_once $file;

use PhpOffice\PhpWord\Autoloader;
Autoloader::register();

$fileTemplate = dirname(__FILE__) . '/../txt/Chandler-Lucius_Java-Developer_Template.docx';
$fileOutputDOCX = dirname(__FILE__) . '/../txt/Chandler-Lucius_Java-Developer.docx';
$fileOutputPDF = dirname(__FILE__) . '/../txt/Chandler-Lucius_Java-Developer.pdf';

$templateProcessor = new \PhpOffice\PhpWord\TemplateProcessor($fileTemplate);
$templateProcessor->setValue('NAME', 'Somebody three');
$templateProcessor->setValue('hey', '4.5');
$templateProcessor->setValue('hey1', '4.5');
$templateProcessor->setValue('hey2', '4.5');

$templateProcessor->saveAs($fileOutputDOCX);

// $rendererName = PhpOffice\PhpWord\Settings::PDF_RENDERER_TCPDF;
// $rendererLibraryPath = dirname(__FILE__) . '/../tcpdf/';

// PhpOffice\PhpWord\Settings::setPdfRenderer($rendererName, $rendererLibraryPath);

// $temp = \PhpOffice\PhpWord\IOFactory::load($fileOutputDOCX); 
// $xmlWriter = \PhpOffice\PhpWord\IOFactory::createWriter($temp , 'PDF');
// $xmlWriter->save($fileOutputPDF, 'PDF');

?>