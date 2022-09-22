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

	    final class CouponsFormController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				if($route->getName() == 'admin-users-coupons-form') {
					if(isset($_POST['coupons']) && !empty($_POST['coupons'])) {
						if((isset($_POST['action']) && strtolower($_POST['action']) == 'delete') || (isset($_POST['action2']) && strtolower($_POST['action2']) == 'delete')) {
							$couponFactory = $this->getControllerParameters()->getModelsManager()->get(CouponFactory::class);
							
							foreach($_POST['coupons'] as $couponId) {
								$coupon = $couponFactory->getByColumn('id', $couponId);
								
								if($coupon != null) {
									$coupon->remove();
								}
							}
						}
					}
						
					GWORK::redirect('/admin/users/coupons');
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/users/coupons/form', $this, 'admin-users-coupons-form', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
