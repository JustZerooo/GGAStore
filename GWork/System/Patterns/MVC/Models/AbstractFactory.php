<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Patterns\MVC\Models {
	    use GWork\System\Exceptions\GWorkException;
	    use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

		use \PDO;
		use \PDOException;

	    abstract class AbstractFactory {
	        abstract public function create($row);

	        private $modelsManager,
					$connection,
					$table,
					$cachedRows = [];

			/**
			 * AbstractFactory constructor.
			 * @param ModelsManager $modelsManager
			 * @param PDO           $connection
			 * @param string        $table
			 */
	        public function __construct(ModelsManager $modelsManager, PDO $connection, string $table = '') {
	            $this->modelsManager = $modelsManager;
	            $this->connection = $connection;

	            $this->table = $table;
	        }

			/**
			 * Returns the table name.
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
			 * Deletes all from the database table.
			 */
			public function empty() {
				try {
	                $query = $this->connection->query('DELETE FROM `' . $this->table . '`');
	            } catch(PDOException $ex) {
	                echo $ex->getMessage();
	            }
			}

			/**
			 * Adds an entry in the database table.
			 * @param 	array $params
			 * @return 	mixed
			 */
	        public function _create(array $params) {
	            $queryString = 'INSERT INTO `' . $this->table . '` SET ';
	            $executeParams = [];

	            $i = 0;
	            foreach($params as $param => $val) {
	                $queryString .= '`' . $param . '` = :'.$param;
	                $executeParams[':' . $param] = $val;

	                if(!($i + 1 == count($params))) {
	                    $queryString .= ',';
	                }

	                $i++;
	            }

	            try {
	                $query = $this->connection->prepare($queryString);
	                $query->execute($executeParams);

	                return $this->getById($this->connection->lastInsertId());
	            } catch(PDOException $ex) {
	                echo $ex->getMessage();
	            }

				return null;
	        }

			/**
			 * Returns the models manager.
			 * @return ModelsManager
			 */
	        public function getModelsManager(): ModelsManager {
	            return $this->modelsManager;
	        }

			/**
			 * Returns an database entry by columns.
			 * @param  array  			$rows
			 * @param  array  			$values
			 * @param  array 			$arr
			 * @param  int|string|null	$limit
			 * @param  string 			$orderBy
			 * @param  string 			$orderType
			 * @param  array 			$selectors
			 * @return mixed
			 */
			public function getRowCountByColumns(array $rows, array $values, array $arr = [], $limit = null, string $orderBy = '-', string $orderType = '', array $selectors = [], $syntax = true): int {
				if($this->table == null) {
	                throw new GWorkException(__DIR__ . '/AbstractFactory.php', 28, 'Cannot get object by not given table.');
	                //return;
	            }

	            try {
					$where = '';
					if($rows != null && $values != null) {
						$where = ' WHERE ';
						for($i = 0; $i < count($rows); $i++) {
							$selector = $selectors[$i] ?? '=';

							$where .= '`' . $rows[$i] . '` ' . $selector . ' ?';
							if($i != (count($rows) - 1)) {
								if(count($arr) > 0) {
									$where .= ' ' . $arr[$i] . ' ';
								} else {
									$where .= ' AND ';
								}
							}
						}
					}

					$qry = 'SELECT NULL FROM `' . $this->table . '`' . $where;

					if($orderBy != '-') {
						if(!$syntax) {
							$qry .= ' ORDER BY ' . $orderBy . '';
						} else {
							$qry .= ' ORDER BY `' . $orderBy . '`';
						}

						if($orderType != '') {
							$qry .= ' ' . $orderType;
						}
					}

					if($limit != null) {
						$qry .= ' LIMIT ' . $limit;
					}

					$query = $this->connection->prepare($qry);
					for($i = 0; $i < count($rows); $i++) {
						$query->bindParam(($i + 1), $values[$i]);
					}

	                $query->execute();

					return $query->rowCount();
	            } catch(PDOException $ex) {
	                echo $ex->getMessage();
	            }

	            return 0;
			}

			/**
			 * Returns the row count of all entries.
			 * @param  int|string|null $limit
			 * @return int
			 */
			public function getRowCount($limit = null): int {
				return $this->getRowCountByColumns([], [], [], $limit);
			}

			/**
			 * Returns the row count of all entries by column.
			 * @param  string 			$row
			 * @param  string 			$val
			 * @param  int|string|null	$limit
			 * @return int
			 */
			public function getRowCountByColumn(string $row, string $val, $limit = null): int {
				return $this->getRowCountByColumns([$row], [$val], ['AND'], $limit);
			}

			/**
			 * Returns all entries from the database table.
			 * @param  bool  $reload
			 * @param  int 		$limit
			 * @param  string  	$orderBy
			 * @param  string  	$orderType
			 * @return mixed
			 */
	        public function getAll(bool $reload = false, $limit = null, string $orderBy = '-', string $orderType = '', $syntax = true) {
	            if($this->table == null) {
	                throw new GWorkException(__DIR__ . '/AbstractFactory.php', 28, 'Cannot get object by not given table.');
	                return;
	            }

	            if(!$reload) {
	                foreach($this->cachedRows as $_row) {
	                    if($_row->getRow()->$row == $val) {
	                        return $row;
	                    }
	                }
	            }

	            try {
					$qry = 'SELECT * FROM `' . $this->table . '`';

					if($orderBy != '-') {
						if(!$syntax) {
							$qry .= ' ORDER BY ' . $orderBy . '';
						} else {
							$qry .= ' ORDER BY `' . $orderBy . '`';
						}

						if($orderType != '') {
							$qry .= ' ' . $orderType;
						}
					}

					if($limit != null) {
						$qry .= ' LIMIT ' . $limit;
					}

	                $query = $this->connection->query($qry);

					$objects = [];
	                while($row = $query->fetchObject()) {
	                    $object = $this->create($row);
						$objects[] = $object;
	                }

					return $objects;
	            } catch(PDOException $ex) {
	                echo $ex->getMessage();
	            }

	            return null;
	        }

			/**
			 * Returns all entries from the database table by column.
			 * @param  string 			$row
			 * @param  mixed 			$val
			 * @param  bool 			$reload
			 * @param  int|string|null 	$limit
			 * @param  string 			$selector
			 * @param  string 			$orderBy
			 * @param  string 			$orderType
			 * @return array|null
			 */
 	        public function getAllByColumn(string $row, $val, bool $reload = false, $limit = null, $selector = '=', string $orderBy = '-', string $orderType = '', $syntax = true) {
	            if($this->table == null) {
	                throw new GWorkException(__DIR__ . '/AbstractFactory.php', 28, 'Cannot get object by not given table.');
	                return;
	            }

	            if(!$reload) {
	                foreach($this->cachedRows as $_row) {
	                    if($_row->getRow()->$row == $val) {
	                        return $row;
	                    }
	                }
	            }

	            try {
					$qry = 'SELECT * FROM `' . $this->table . '` WHERE `' . $row . '` ' . $selector . ' :val';

					if($orderBy != '-') {
						if(!$syntax) {
							$qry .= ' ORDER BY ' . $orderBy . '';
						} else {
							$qry .= ' ORDER BY `' . $orderBy . '`';
						}

						if($orderType != '') {
							$qry .= ' ' . $orderType;
						}
					}

					if($limit != null) {
						$qry .= ' LIMIT ' . $limit;
					}

	                $query = $this->connection->prepare($qry);
	                $query->execute([':val' => $val]);

					$objects = [];
	                while($row = $query->fetchObject()) {
	                    $object = $this->create($row);
						$objects[] = $object;
	                }

					return $objects;
	            } catch(PDOException $ex) {
	                echo $ex->getMessage();
	            }

	            return null;
	        }

			/**
			 * Returns all entries from the database table where the value be like a search term.
			 * @param  string 	$row
			 * @param  string 	$val
			 * @param  bool 	$reload
			 * @return mixed
			 */
	        public function getAllByLikeColumn(string $row, $val, bool $reload = false, $limit = null) {
	            if($this->table == null) {
	                throw new GWorkException(__DIR__ . '/AbstractFactory.php', 28, 'Cannot get object by not given table.');
	                return;
	            }

	            if(!$reload) {
	                foreach($this->cachedRows as $_row) {
	                    if($_row->getRow()->$row == $val) {
	                        return $row;
	                    }
	                }
	            }

	            try {
	                if(strlen($val) > 0) {
						$sql = 'SELECT * FROM `' . $this->table . '` WHERE `' . $row . '` LIKE :val';

						if($limit != null) {
							$sql .= ' LIMIT ' . $limit;
						}

						$query = $this->connection->prepare($sql);
		                $query->execute([':val' => '%' . $val . '%']);

						$objects = [];
		                while($row = $query->fetchObject()) {
		                    $object = $this->create($row);
							$objects[] = $object;
		                }

						return $objects;
					}
	            } catch(PDOException $ex) {
	                echo $ex->getMessage();
	            }

	            return null;
	        }

			/**
			 * Returns all entries from the database table by columns.
			 * @param  array 	$rows
			 * @param  array 	$values
			 * @param  bool 	$reload
			 * @return mixed
			 */
	        public function getAllByColumns(array $rows, array $values, array $arr = [], bool $reload = false, $limit = null, string $orderBy = '-', string $orderType = '', array $selectors = [], $syntax = false) {
	            if($this->table == null) {
	                throw new GWorkException(__DIR__ . '/AbstractFactory.php', 28, 'Cannot get object by not given table.');
	                return;
	            }

	            if(!$reload) {
	                foreach($this->cachedRows as $_row) {
	                    if($_row->getRow()->$row == $val) {
	                        return $row;
	                    }
	                }
	            }

	            try {
					$where = '';
					for($i = 0; $i < count($rows); $i++) {
						$selector = $selectors[$i] ?? '=';

						$where .= '`' . $rows[$i] . '` ' . $selector . ' ?';
						if($i != (count($rows) - 1)) {
							if(count($arr) > 0) {
								$where .= ' ' . $arr[$i] . ' ';
							} else {
								$where .= ' AND ';
							}
						}
					}

					$qry = 'SELECT * FROM `' . $this->table . '` WHERE ' . $where;

					if($orderBy != '-') {
						if(!$syntax) {
							$qry .= ' ORDER BY ' . $orderBy . '';
						} else {
							$qry .= ' ORDER BY `' . $orderBy . '`';
						}

						if($orderType != '') {
							$qry .= ' ' . $orderType;
						}
					}

					if($limit != null) {
						$qry .= ' LIMIT ' . $limit;
					}

					$query = $this->connection->prepare($qry);
					for($i = 0; $i < count($rows); $i++) {
						$query->bindParam(($i + 1), $values[$i]);
					}

	                $query->execute();

					$objects = [];
	                while($row = $query->fetchObject()) {
	                    $object = $this->create($row);
						$objects[] = $object;
	                }

					return $objects;
	            } catch(PDOException $ex) {
	                echo $ex->getMessage();
	            }

	            return null;
	        }

			/**
			 * Returns an entry from the database table by column.
			 * @param  string 	$row
			 * @param  string 	$val
			 * @param  bool 	$reload
			 * @return mixed
			 */
	        public function getByColumn(string $row, $val, bool $reload = false) {
	            if($this->table == null) {
	                throw new GWorkException(__DIR__ . '/AbstractFactory.php', 28, 'Cannot get object by not given table.');
	                return;
	            }

	            if(!$reload) {
	                foreach($this->cachedRows as $_row) {
	                    if($_row->getRow()->$row == $val) {
	                        return $row;
	                    }
	                }
	            }

	            try {
	                $query = $this->connection->prepare('SELECT * FROM `' . $this->table . '` WHERE `' . $row . '` = :val');
	                $query->execute([':val' => $val]);

	                if ($query->rowCount() > 0) {
	                    $row = $query->fetchObject();

	                    $object = $this->create($row);

	                    return $object;
	                }
	            } catch(PDOException $ex) {
	                echo $ex->getMessage();
	            }

	            return null;
	        }

			/**
			 * Returns an entry from the database table from entry id.
			 * @param  int $id
			 * @param  bool $reload
			 * @return mixed
			 */
	        public function getById(int $id, bool $reload = false) {
	            return $this->getByColumn('id', $id, $reload);
	        }
	    }
	}
