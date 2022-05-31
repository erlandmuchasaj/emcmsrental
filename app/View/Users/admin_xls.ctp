<?php
/**
* Export all member records in .xls format
* with the help of the xlsHelper
*/

	//declare the xls helper
	$xls= new xlsHelper();

	//input the export file name
	$xls->setHeader('users_'.date('Y_m_d'));

	$xls->addXmlHeader();
	$xls->setWorkSheetName('User');

	//1st row for columns name
	$xls->openRow();
	$xls->writeString('name');
	$xls->writeString('surname');
	$xls->writeString('email');
	$xls->writeString('created');
	$xls->closeRow();

	//rows for data
	foreach ($users as $user):
		$xls->openRow();
		$xls->writeString($user['User']['name']);
		$xls->writeString($user['User']['surname']);
		$xls->writeString($user['User']['email']);
		$xls->writeString($user['User']['created']);
		$xls->closeRow();
	endforeach;

	$xls->addXmlFooter();
exit();