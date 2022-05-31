<?php
$line= $contacts[0]['Contact'];
$this->Csv->addRow(array_keys($line));

foreach ($contacts as $contact) {
	$line = $contact['Contact'];
	$this->Csv->addRow($line);
}

$filename='contacts_'.date('Y_m_d');
echo  $this->Csv->render($filename);