<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Models\EventListener {
	    use GWork\System\Patterns\MVC\Models\AbstractFactory;
	    use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

		use GWork\System\Common;
		use GWork\System\Configurations\Database;

		use \PDO;

	    final class EventListenerFactory extends AbstractFactory {
			/**
			 * @see GWork\System\Patterns\MVC\Models\AbstractFactory::__construct()
			 */
	        public function __construct(ModelsManager $modelsManager, PDO $connection) {
				$database = new Database(Common::getConfiguration()->getDatabaseSettings());
				$prefix = $database->getPrefix();

	            parent::__construct($modelsManager, $connection, $prefix . 'plugins_event_listeners');
	        }

			/**
			 * @see GWork\System\Patterns\MVC\Models\AbstractFactory::create()
			 */
	        public function create($row): EventListener {
	            return new EventListener($row, $this->getConnection(), $this->getModelsManager(), $this->getTable());
	        }
	    }
	}
