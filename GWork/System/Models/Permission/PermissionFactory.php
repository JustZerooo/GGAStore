<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Models\Permission {
	    use GWork\System\Patterns\MVC\Models\AbstractFactory;
	    use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

		use GWork\System\Common;
		use GWork\System\Configurations\Database;

		use \PDO;

	    final class PermissionFactory extends AbstractFactory {
	        public function __construct(ModelsManager $modelsManager, PDO $connection) {
				$database = new Database(Common::getConfiguration()->getDatabaseSettings());
				$prefix = $database->getPrefix();

	            parent::__construct($modelsManager, $connection, $prefix . 'permissions');
	        }

	        public function create($row): Permission {
	            return new Permission($row, $this->getConnection(), $this->getModelsManager(), $this->getTable());
	        }
	    }
	}
