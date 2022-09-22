<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp\Controllers\Note {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	    use GWork\System\GWORK;
	
		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Redirects\PermissionRedirect;
		
		use Plugins\gwork\gwork\acp\Models\Note\NoteFactory;

	    final class NoteDeleteController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				if($route->getName() == 'admin-note-delete') {
					$noteFactory = $this->getControllerParameters()->getModelsManager()->get(NoteFactory::class);
					$note = $noteFactory->getByColumn('id', $vars['id']);
								
					if($note != null) {
						$note->remove();
					}
						
					GWORK::redirect('/admin');
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/note/delete/{int:id}', $this, 'admin-note-delete', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
