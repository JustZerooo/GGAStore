<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Patterns\MVC\Models {
	    use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

		use \PDO;
		use \PDOException;

	    class AbstractFactoryObject {
	        private $row;
	        private $table;
	        private $connection;
	        private $modelsManager;

			/**
			 * AbstractFactoryObject constructor.
			 * @param string        $row
			 * @param PDO           $connection
			 * @param ModelsManager $modelsManager
			 * @param string        $table
			 */
	        public function __construct($row, PDO $connection, ModelsManager $modelsManager, string $table = '') {
	            $this->row = $row;
				$this->connection = $connection;
	            $this->modelsManager = $modelsManager;
	            $this->table = $table;
	        }

			/**
			 * Removes the entry from the database table.
			 * @return bool
			 */
	        public function remove() {
	            try {
	                $stmt = $this->getConnection()->prepare('DELETE FROM `' . $this->getTable() . '` WHERE `id` = :id');

					if($stmt->execute([':id' => $this->row->id])) {
						return true;
					}
	            } catch(PDOException $ex) {
	                echo $ex->getMessage();
	            }

				return false;
	        }

			/**
			 * Returns an array as object with the rows of the entry.
			 * @return mixed
			 */
	        public function getRow() {
	            return $this->row;
	        }

			/**
			 * Returns the name of the database table.
			 * @return string
			 */
	        public function getTable(): string {
	            return $this->table;
	        }

			/**
			 * Returns the database connection.
			 * @return PDO
			 */
	        public function getConnection(): PDO {
	            return $this->connection;
	        }

			/**
			 * Returns the models manager.
			 * @return ModelsManager
			 */
	        public function getModelsManager(): ModelsManager {
	            return $this->modelsManager;
	        }

			/**
			 * Changes the value by row.
			 * @param string $row
			 * @param string $val
			 * @return mixed|null
			 */
	        public function set(string $row, $val) {
				try {
	                $query = $this->getConnection()->prepare('UPDATE `' . $this->getTable() . '` SET `' . $row . '` = :val WHERE `id` = :id');
	                if($query->execute([':id' => $this->getRow()->id, ':val' => $val])) {
						$this->updateRowByColumn('id', $this->getRow()->id);

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

			/**
			 * Updates the value by row.
			 * @param  string $column
			 * @param  string $val
			 * @return mixed
			 */
	        public function updateRowByColumn(string $column, $val) {
	            try {
	                $query = $this->getConnection()->prepare('SELECT * FROM `' . $this->getTable() . '` WHERE `' . $column . '` = :val');
	                $query->execute([':val' => $val]);

	                if($query->rowCount() > 0) {
	                    $this->row = $query->fetchObject();
	                    return true;
	                }
	            } catch(PDOException $ex) {
	                echo $ex->getMessage();
	            }
	        }
	    }
	}
