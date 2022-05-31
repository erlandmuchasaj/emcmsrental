<?php
App::uses('Component', 'Controller');
class BackUpComponent extends Component {
/**
 * Contains arguments parsed from the command line.
 *
 * @args array
 * @access public
 */
	public $args;


/**
 * Override backup() for help message hook
 *
 * @access public
 */
	function backup() {
		App::uses('Folder', 'Utility');
		App::import('Model', 'CakeSchema');

		$dataSourceName = 'default';
		$path = APP . 'webroot/backups/';

		$Folder = new Folder($path, true);
		$fileSufix = date('Ymd\_His') . '.sql';
		$file = $path . $fileSufix;

		if (!is_writable($path)) {
			throw new CakeException('The path "' . $path . '" isn\'t writable!');
		}
		$File = new File($file);
		$File->write("\n|--------------------------------------------------------------------------/\n");
		$File->write("\n| AUTO BACKUP DB \n");
		$File->write("\n| Erland Muchasaj \n");
		$File->write("\n|--------------------------------------------------------------------------/\n");

		$db = ConnectionManager::getDataSource($dataSourceName);
		$config = $db->config;
		$tables = $db->listSources();
		foreach ($tables as $table) {

			$table 		= str_replace($config['prefix'], '', $table);
			$ModelName 	= Inflector::classify($table);
			$Model 		= ClassRegistry::init($ModelName);
			$DataSource = $Model->getDataSource();
			$CakeSchema = new CakeSchema();

			$CakeSchema->tables = array($table => $Model->schema());


			$File->write("\n/* Backuping table schema {$table} */\n");
			$File->write($DataSource->createSchema($CakeSchema, $table) . "\n");
			$File->write("\n/* Backuping table data {$table} */\n");

			unset($valueInsert, $fieldInsert);

			$rows = $Model->find('all', array('recursive' => -1));
			$quantity = 0;

			if (sizeOf($rows) > 0) {
				$fields = array_keys($rows[0][$ModelName]);
				$values = array_values($rows);
				$count = count($fields);

				for ($i = 0; $i < $count; $i++) {
					$fieldInsert[] = $DataSource->name($fields[$i]);
				}
				$fieldsInsertComma = implode(', ', $fieldInsert);

				foreach ($rows as $k => $row) {
					unset($valueInsert);
					for ($i = 0; $i < $count; $i++) {
						$valueInsert[] = $DataSource->value($row[$ModelName][$fields[$i]], $Model->getColumnType($fields[$i]), false);
					}
					$query = array(
						'table' => $DataSource->fullTableName($table),
						'fields' => $fieldsInsertComma,
						'values' => implode(', ', $valueInsert)
					);
					$File->write($DataSource->renderStatement('create', $query) . ";\n");
					$quantity++;
				}
			}
		}
		$File->close();

		if (class_exists('ZipArchive') && filesize($file) > 100) {
			$zip = new ZipArchive();
			$zip->open($file . '.zip', ZIPARCHIVE::CREATE);
			$zip->addFile($file, $fileSufix);
			$zip->close();
			if (file_exists($file . '.zip') && filesize($file) > 10) {
				unlink($file);
			}
		}
		return true;
	}
}