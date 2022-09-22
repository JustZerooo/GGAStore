<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Patterns\MVC\Models\Handlers {
		use \PDO;

	    final class ModelsManager {
	        private $cachedModels = [];
	        private $connection = null;

			/**
			 * ModelsManager constructor.
			 * @param PDO $pdo
			 */
	        public function __construct(PDO $pdo) {
	            $this->connection = $pdo;
	        }

			/**
			 * Returns a model factory.
			 * @param  	mixed 	$instance
			 * @param  	PDO 	$connection
			 * @return	mixed
			 */
	        public function get($instance, PDO $connection = null) {
	            if(isset($this->cachedModels[$instance])) {
	                return $this->cachedModels[$instance];
	            } else {
	                $con = $connection != null ? $connection : $this->connection;
	                $model = new $instance($this, $con);

	                $this->cachedModels[$instance] = $model;

	                return $model;
	            }
	        }
	    }
	}
