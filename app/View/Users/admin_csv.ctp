<?php
$line= $users[0]['User'];
$this->CSV->addRow(array_keys($line));

foreach ($users as $user) {
	$line = $user['User'];
	$this->CSV->addRow($line);
}

$filename='users_'.date('Y_m_d');
echo  $this->CSV->render($filename);