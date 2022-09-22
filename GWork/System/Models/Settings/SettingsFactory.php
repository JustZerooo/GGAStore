<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Models\Settings {
	    use GWork\System\Patterns\MVC\Models\AbstractFactory;
	    use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

	    use GWork\System\Common;
		use GWork\System\Configurations\Database;

		use \PDO;

	    final class SettingsFactory extends AbstractFactory {
			/**
			 * @see GWork\System\Patterns\MVC\Models\AbstractFactory::__construct()
			 */
			public function __construct(ModelsManager $modelsManager, PDO $connection) {
				$database = new Database(Common::getConfiguration()->getDatabaseSettings());
				$prefix = $database->getPrefix();
				
				parent::__construct($modelsManager, $connection, $prefix . 'settings');

				$stmt = $this->getConnection()->prepare('SELECT * FROM `' . $this->getTable() . '`');
				$stmt->execute();

				while($obj = $stmt->fetch(PDO::FETCH_OBJ)) {
					$this->{$obj->row} = $obj->value;
				}
		    }

			/**
			 * @see GWork\System\Patterns\MVC\Models\AbstractFactory::create()
			 */
	        public function create($row) {
				return null;
			}
			
			/**
			 * Changes the value by row.
			 * @param string $row
			 * @param string $val
			 * @return mixed|null
			 */
	        public function set(string $row, $val) {
				try {
	                $query = $this->getConnection()->prepare('UPDATE `' . $this->getTable() . '` SET `value` = :val WHERE `row` = :row');
	                if($query->execute([':row' => $row, ':val' => $val])) {
						$this->{$row} = $val;
						
						return $this;
					} else {
						return null;
					}
	            } catch(PDOException $ex) {
	                echo $ex->getMessage();
	            } finally {
	                return $this;
	            }

				return null;
	        }
	    }
	}
