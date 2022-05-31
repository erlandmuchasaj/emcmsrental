<?php
/**
* Export all member records in .xls format
* with the help of the xlsHelper
*/
	//declare the xls helper
	// $xls = new XlsHelper();


	//input the export file name
	$this->Xls->setHeader('contatcs_'.date('Y_m_d'));

	$this->Xls->addXmlHeader();
	$this->Xls->setWorkSheetName('Contact');

	//1st row for columns name
	$this->Xls->openRow();
	$this->Xls->writeString('email');
	$this->Xls->writeString('subject');
	$this->Xls->writeString('message');
	$this->Xls->writeString('created');
	$this->Xls->closeRow();


	//rows for data
	foreach ($contacts as $contact):
		$this->Xls->openRow();
		$this->Xls->writeString($contact['Contact']['email']);
		$this->Xls->writeString($contact['Contact']['subject']);
		$this->Xls->writeString($contact['Contact']['message']);
		$this->Xls->writeString($contact['Contact']['created']);
		$this->Xls->closeRow();
	endforeach;

	$this->Xls->addXmlFooter();

	$this->Xls->renderData();
die();
