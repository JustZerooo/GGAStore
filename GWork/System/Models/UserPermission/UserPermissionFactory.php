<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Models\UserPermission {
	    use GWork\System\Patterns\MVC\Models\AbstractFactory;
	    use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

		use GWork\System\Common;
		use GWork\System\Configurations\Database;

		use \PDO;

	    final class UserPermissionFactory extends AbstractFactory {
	        public function __construct(ModelsManager $modelsManager, PDO $connection) {
				$database = new Database(Common::getConfiguration()->getDatabaseSettings());
				$prefix = $database->getPrefix();

	            parent::__construct($modelsManager, $connection, $prefix . 'users_permissions');
	        }

	        public function create($row): UserPermission {
	            return new UserPermission($row, $this->getConnection(), $this->getModelsManager(), $this->getTable());
	        }
	    }
	}
