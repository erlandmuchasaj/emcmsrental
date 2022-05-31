<?php
/**
* This xls helper is based on the one at 
* http://bakery.cakephp.org/articles/view/excel-xls-helper
* 
* The difference compared with the original one is this helper
* actually creates an xml which is openable in Microsoft Excel.
* 
* Written by Yuen Ying Kit @ ykyuen.wordpress.com
*
 *
 * @name       	  CSV Helper
 * @copyright     Copyright (c) Erland Muchasaj
 * @author     	  Erland Muchasaj (erland.muchasaj@gmail.com)
 * @link          http://erlandmuchasaj.com - Web Developer
 */  
App::uses('AppHelper', 'View/Helper');
class XlsHelper extends AppHelper {

	public $buffer = '';

	/**
	 * set the header of the http response.
	 *
	 * @param unknown_type $filename
	 */
	function setHeader($filename) {
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
		header("Content-Type: application/force-download");
		header("Content-Type: application/download");;
		// Name the file to .xlsx to solve the excel/openoffice file opening problem
		header("Content-Disposition: inline; filename=\"".$filename.".xls\"");
	}

	/**
	 * add the xml header for the .xls file.
	 *
	 */
	function addXmlHeader() {
		$this->buffer ."<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$this->buffer ."<?mso-application progid=\"Excel.Sheet\"?>\n";
		$this->buffer ."<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"\n";
		$this->buffer ."			xmlns:x=\"urn:schemas-microsoft-com:office:excel\"\n";
		$this->buffer ."			xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"\n";
		$this->buffer ."			xmlns:html=\"http://www.w3.org/TR/REC-html40\">\n";
		$this->buffer ."	<DocumentProperties xmlns=\"urn:schemas-microsoft-com:office:office\">\n";
		$this->buffer ."		<Author>Erland Muchasaj</Author>\n";
		$this->buffer ."		<LastAuthor>Self</LastAuthor>\n";
		$this->buffer ."		<Created>".date('d-m-Y')."</Created>\n";
		$this->buffer ."		<Company>EMCMS</Company>\n";
		$this->buffer ."		<Version>1.0.0</Version>\n";
		$this->buffer ."	</DocumentProperties>\n";
		$this->buffer ."	<ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">\n";
		$this->buffer ."		<WindowHeight>6795</WindowHeight>\n";
		$this->buffer ."		<WindowWidth>8460</WindowWidth>\n";
		$this->buffer ."		<WindowTopX>120</WindowTopX>\n";
		$this->buffer ."		<WindowTopY>15</WindowTopY>\n";
		$this->buffer ."		<ProtectStructure>False</ProtectStructure>\n";
		$this->buffer ."		<ProtectWindows>False</ProtectWindows>\n";
		$this->buffer ."	</ExcelWorkbook>\n";
	}

	/**
	 * add the worksheet name for the .xls.
	 * it has to be added otherwise the xml format is incomplete.
	 *
	 * @param unknown_type $workSheetName
	 */
	function setWorkSheetName($workSheetName) {
		$this->buffer .= "\t<Worksheet ss:Name=\"".$workSheetName."\">\n";
		$this->buffer .= "\t\t<Table>\n";
	}
	   
	/**
	 * add the footer to the end of xml.
	 * it has to be added otherwise the xml format is incomplete.
	 *
	 */
	function addXmlFooter() {
		$this->buffer .= "\t\t</Table>\n";
		$this->buffer .= "\t</Worksheet>\n";
		$this->buffer .= "</Workbook>\n";
	}
	   
	/**
	 * move to the next row in the .xls.
	 * must be used with closeRow() in pair.
	 *
	 */
	function openRow() {
		$this->buffer .= "\t\t\t<Row>\n";
	}
	   
	/**
	 * end the row in the .xls.
	 * must be used with openRow() in pair.
	 *
	 */
	function closeRow() {
		$this->buffer .= "\t\t\t</Row>\n";
	}
	 
	/**
	 * Write the content of a cell in number format
	 *
	 * @param unknown_type $Value
	 */
	function writeNumber($Value) {
		if (is_null($Value)) {
			$this->buffer .= "\t\t\t\t<Cell><Data ss:Type=\"String\"></Data></Cell>\n";
		} else {
			$this->buffer .= "\t\t\t\t<Cell><Data ss:Type=\"Number\">".$Value."</Data></Cell>\n";
		}
	}
	   
	/**
	 * Write the content of a cell in string format
	 *
	 * @param unknown_type $Value
	 */
	function writeString($Value) {
		$this->buffer .= "\t\t\t\t<Cell><Data ss:Type=\"String\">".$Value."</Data></Cell>\n";
	}

	/**
	 * Write the content of a cell in string format
	 *
	 * @param unknown_type $Value
	 */
	function writeDateTime($Value) {
		$this->buffer .= "\t\t\t\t<Cell><Data ss:Type=\"DateTime\">".$Value."</Data></Cell>\n";
	}

	/**
	 * Write the content of a cell in string format
	 *
	 * @param unknown_type $Value
	 */
	function renderData() {
		echo $this->buffer;
	}

}