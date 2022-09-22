<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Models\User {
	    use GWork\System\Patterns\MVC\Models\AbstractFactory;
	    use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

		use GWork\System\Common;
		use GWork\System\Configurations\Database;

		use \PDO;
		use \PASSWORD_BCRYPT;

	    final class UserFactory extends AbstractFactory {
			public function __construct(ModelsManager $modelsManager, PDO $connection) {
				$database = new Database(Common::getConfiguration()->getDatabaseSettings());
				$prefix = $database->getPrefix();
				
				parent::__construct($modelsManager, $connection, $prefix . 'users');
	        }

			public function getPasswordSalt(string $password): string {
				return sha1($password);
			}

			public function getPasswordHash(string $password): string {
				return password_hash($password, PASSWORD_BCRYPT, ['corst' => 12]);
			}

			public function passwordVerify(string $password, string $hash): bool {
				if(strlen($password) > 0) {
					return password_verify($password, $hash);
				}

				return false;
			}

			/**
			 * @deprecated
			 * @param  string $string
			 * @return string
			 */
			public function getHashedString($string): string {
				return sha1($string);
			}

	        public function create($row): User {
	            return new User($row, $this->getConnection(), $this->getModelsManager(), $this->getTable());
	        }
	    }
	}
