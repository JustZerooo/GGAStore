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

	    final class CouponsAddController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				if($route->getName() == 'admin-users-coupons-add') {
					$couponFactory = $this->getControllerParameters()->getModelsManager()->get(CouponFactory::class);
					
					if(isset($_POST['coupon_code'], $_POST['coupon_value'], $_POST['coupon_max_usable'], $_POST['coupon_used'])) {
						if(strlen($_POST['coupon_code']) >= 3 && strlen($_POST['coupon_value']) >= 3) {
							$couponFactory->_create([
								'coupon' => $_POST['coupon_code'],
								'value' => $_POST['coupon_value'],
								'max_usable' => intval($_POST['coupon_max_usable']),
								'used' => intval($_POST['coupon_used'])
							]);
							
							GWORK::redirect('/admin/users/coupons');
						}
					}
					
					$view = ViewHelper::create($this, 'Users/Coupons/Add.php', 'usersView', ['pageName' => $this->getLanguage()->json()['Users']['Coupons']['PageName']], [], true);

					$postCode = $_POST['coupon_code'] ?? '';
					$postValue = $_POST['coupon_value'] ?? '';
					$postType = 'balance';
					$postMaxUsable = $_POST['coupon_max_usable'] ?? 1;
					$postUsed = $_POST['coupon_used'] ?? 0;
					
					$view->postCode = $postCode;
					$view->postValue = $postValue;
					$view->postType = $postType;
					$view->postMaxUsable = $postMaxUsable;
					$view->postUsed = $postUsed;
						
					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/users/coupons/add', $this, 'admin-users-coupons-add', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
