<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Models\User {
	    use GWork\System\Patterns\MVC\Models\AbstractFactoryObject;

		use GWork\System\Models\Permission\Permission;
		use GWork\System\Models\Permission\PermissionFactory;
		use GWork\System\Models\UserPermission\UserPermissionFactory;

	    final class User extends AbstractFactoryObject {
			public function hasPermission(Permission $permission): bool {
				$permissionFactory = $this->getModelsManager()->get(PermissionFactory::class);
				$userPermissionFactory = $this->getModelsManager()->get(UserPermissionFactory::class);

				$userPermission = $userPermissionFactory->getAllByColumns(['permission', 'userid'], [$permission->getRow()->id, $this->getRow()->id], ['AND'], false, 1);
				if($userPermission != null) return true;

				$permission = $permissionFactory->getByColumn('permission', 'ALL_PERMISSIONS');
				$userPermission = $userPermissionFactory->getAllByColumns(['permission', 'userid'], [$permission->getRow()->id, $this->getRow()->id], ['AND'], false, 1);

				return $userPermission != null ? true : false;
			}

			public function hasPermissionByName(string $permission): bool {
				$permissionFactory = $this->getModelsManager()->get(PermissionFactory::class);
				$permission = $permissionFactory->getByColumn('permission', $permission);

				if($permission != null) {
					return $this->hasPermission($permission);
				}

				$permission = $permissionFactory->getByColumn('permission', 'ALL_PERMISSIONS');

				return $this->hasPermission($permission);
			}
	    }
	}
