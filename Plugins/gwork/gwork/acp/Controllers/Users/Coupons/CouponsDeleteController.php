<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp\Controllers\Users\Coupons {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	    use GWork\System\GWORK;
	
		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Redirects\PermissionRedirect;
		
		use Plugins\gwork\gwork\shop\Models\Coupon\CouponFactory;

	    final class CouponsDeleteController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				if($route->getName() == 'admin-users-coupons-delete') {
					$couponFactory = $this->getControllerParameters()->getModelsManager()->get(CouponFactory::class);
					$coupon = $couponFactory->getByColumn('id', $vars['id']);
								
					if($coupon != null) {
						$coupon->remove();
					}
						
					GWORK::redirect('/admin/users/coupons');
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/users/coupons/delete/{int:id}', $this, 'admin-users-coupons-delete', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
