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

		use GWork\System\Helpers\ViewHelper\ViewHelper;
		
		use \Plugins\gwork\gwork\shop\Models\Coupon\CouponFactory;

	    final class CouponsEditController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				if($route->getName() == 'admin-users-coupons-id') {
					$couponFactory = $this->getControllerParameters()->getModelsManager()->get(CouponFactory::class);
					
					$coupon = $couponFactory->getByColumn('id', $vars['id']);
					
					if($coupon == null) {
						GWORK::redirect('/admin/users/coupons');
						return;
					}
					
					if(isset($_POST['coupon_code'])) {
						$coupon->set('code', $_POST['coupon_code']);
					}
					
					if(isset($_POST['coupon_value'])) {
						$coupon->set('value', $_POST['coupon_value']);
					}
					
					if(isset($_POST['coupon_max_usable']) && intval($_POST['coupon_max_usable']) >= 0) {
						$coupon->set('max_usable', intval($_POST['coupon_max_usable']));
					}
					
					if(isset($_POST['coupon_used']) && intval($_POST['coupon_used']) >= 0) {
						$coupon->set('used', intval($_POST['coupon_used']));
					}
					
					$view = ViewHelper::create($this, 'Users/Coupons/Edit.php', 'usersView', ['pageName' => $this->getLanguage()->json()['Users']['Coupons']['PageName']], [], true);

					$view->coupon = $coupon;
						
					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/users/coupons/edit/{int:id}', $this, 'admin-users-coupons-id', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
