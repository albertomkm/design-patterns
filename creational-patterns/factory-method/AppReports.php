<?php

abstract class FileGenerator{

	abstract protected function createReport(): Report;

	public function export(array $data):void{
		$report = $this->createReport();
		$cleanData = $this->prepareData($data);
		echo $report->render($cleanData);
	}
	public function prepareData(array $data):array{
        $filteredData = array_filter($data);
		return array_map(function($item){
            return strtoupper(trim($item));
        }, $filteredData);
	}
}

class CSVGenerator extends FileGenerator{
	protected function createReport():Report{
		return new CSVReport();
	}
}
class PDFGenerator extends FileGenerator{

	protected function createReport():Report{
		return new PDFReport();
	}
}
interface Report{
	function render(array $data): string;
}
class CSVReport implements Report{

	public function render(array $data): string{
		return implode(',', $data);
	}
}

class PDFReport implements Report{
	public function render(array $data): string{
		return "[--- PDF HEADER ---]<br>" . implode("<br>", $data) . "<br>[--- PDF FOOTER ---]";
	}
}

$datosVentas = ["Venta 1: $100", "Venta 2: $250", ""];
$csvFile = new CSVGenerator();
$csvFile->export($datosVentas);
echo "<br><br><br>";
$pdfFile = new PDFGenerator();
$pdfFile->export($datosVentas);