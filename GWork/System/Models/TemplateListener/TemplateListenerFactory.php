<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Models\TemplateListener {
	    use GWork\System\Patterns\MVC\Models\AbstractFactory;
	    use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

		use GWork\System\Common;
		use GWork\System\Configurations\Database;

		use \PDO;

	    final class TemplateListenerFactory extends AbstractFactory {
			/**
			 * @see GWork\System\Patterns\MVC\Models\AbstractFactory::__construct()
			 */
	        public function __construct(ModelsManager $modelsManager, PDO $connection) {
				$database = new Database(Common::getConfiguration()->getDatabaseSettings());
				$prefix = $database->getPrefix();

	            parent::__construct($modelsManager, $connection, $prefix . 'plugins_template_listeners');
	        }

			/**
			 * @see GWork\System\Patterns\MVC\Models\AbstractFactory::create()
			 */
	        public function create($row): TemplateListener {
	            return new TemplateListener($row, $this->getConnection(), $this->getModelsManager(), $this->getTable());
	        }
	    }
	}
