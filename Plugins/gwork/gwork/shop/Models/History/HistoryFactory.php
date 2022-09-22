<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop\Models\History {
	    use GWork\System\Patterns\MVC\Models\AbstractFactory;
	    use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

		use GWork\System\Common;
		use GWork\System\Configurations\Database;

		use \PDO;

	    final class HistoryFactory extends AbstractFactory {
			/**
			 * @see GWork\System\Patterns\MVC\Models\AbstractFactory::__construct()
			 */
	        public function __construct(ModelsManager $modelsManager, PDO $connection) {
				$database = new Database(Common::getConfiguration()->getDatabaseSettings());
				$prefix = $database->getPrefix();

	            parent::__construct($modelsManager, $connection, $prefix . 'histories');
	        }

			/**
			 * @see GWork\System\Patterns\MVC\Models\AbstractFactory::create()
			 */
	        public function create($row): History {
	            return new History($row, $this->getConnection(), $this->getModelsManager(), $this->getTable());
	        }
	    }
	}
