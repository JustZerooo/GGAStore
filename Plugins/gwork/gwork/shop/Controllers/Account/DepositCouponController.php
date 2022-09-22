<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop\Controllers\Account {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

		use GWork\System\Models\Settings\SettingsFactory;

		use Plugins\gwork\gwork\shop\Models\Coupon\CouponFactory;
		use Plugins\gwork\gwork\shop\Models\CouponLog\CouponLogFactory;

		use Plugins\gwork\gwork\shop\Utils\CSRF\CSRF;

		use Plugins\gwork\gwork\shop\Redirects\UserNullRedirect;

	    final class DepositCouponController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				$this->getRedirectsManager()->get(UserNullRedirect::class)->redirect('/login');

				if($route->getName() == 'account-deposit-coupon') {
					$view = ViewHelper::create($this, 'Account/Deposit.php', 'accountDepositView', ['pageName' => $this->getLanguage()->json()['Account']['Deposit']['PageName']], [], true);

					$couponFactory = $this->getControllerParameters()->getModelsManager()->get(CouponFactory::class);
					$couponLogFactory = $this->getControllerParameters()->getModelsManager()->get(CouponLogFactory::class);

					if(isset($_POST['csrf_token']) && CSRF::validateCSRFToken($_POST['csrf_token'], $this)) {
						if(isset($_POST['coupon_use'], $_POST['coupon_code'])) {
							$data = $this->checkCoupon($_POST['coupon_code']);

							if(!$data['valid'] || $data['coupon'] == null) {
								$view->errorCoupon = $data['message'];
							} else {
								if(intval($this->getUser()->getRow()->can_redeem_coupons) == 1) {
									$coupon = $data['coupon'];

									$couponLog = $couponLogFactory->getAllByColumns(['userid', 'couponid'], [$this->getUser()->getRow()->id, $coupon->getRow()->id], ['AND'], false, 1, '-', '', ['=', '=']);

									if($couponLog == null) {
										$coupon->set('used', (intval($coupon->getRow()->used) + 1));
										$balance = intval($this->getUser()->getRow()->balance);
										$this->getUser()->set('balance', ($balance + intval($coupon->getRow()->value)));

										$couponLogFactory->_create([
											'userid'	=> $this->getUser()->getRow()->id,
											'couponid'	=> $coupon->getRow()->id,
											'timestamp'	=> time()
										]);

										$view->successCoupon = $this->getLanguage()->json()['Account']['Deposit']['Coupon']['Success'];
									} else {
										$view->errorCoupon = $this->getLanguage()->json()['Account']['Deposit']['Coupon']['Errors']['AlreadyUsed'];
									}
								} else {
									$view->errorCoupon = $this->getLanguage()->json()['Account']['Deposit']['Coupon']['Errors']['Blocked'];
								}
							}
						} else if(isset($_POST['coupon_check'], $_POST['coupon_code'])) {
							$data = $this->checkCoupon($_POST['coupon_code']);

							if(!$data['valid']) {
								$view->errorCoupon = $data['message'];
							} else {
								$view->infoCoupon = $data['message'];
							}
						}
					}

					$view->display();
				}
	        }

			private function checkCoupon($couponCode): array {
				$data = [
					'valid' 	=> false,
					'message' 	=> '',
					'coupon' 	=> null
				];

				$couponFactory = $this->getControllerParameters()->getModelsManager()->get(CouponFactory::class);

				$coupon = $couponFactory->getByColumn('code', $couponCode);
				$data['coupon'] = $coupon;

				if($coupon == null) {
					$data['message'] = $this->getLanguage()->json()['Account']['Deposit']['Coupon']['Errors']['Invalid'];
				} else if($coupon->getRow()->used >= $coupon->getRow()->max_usable) {
					$data['message'] = $this->getLanguage()->json()['Account']['Deposit']['Coupon']['Errors']['Used'];
				} else {
					$settings = $this->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);

					$currency = strtoupper($settings->Currency);

					$info = $this->getLanguage()->json()['Account']['Deposit']['Coupon']['Info'];
					$info = str_replace([
						'%value%', '%type%'
					], [
						number_format(intval($coupon->getRow()->value) / 100, 2, ',', '.') . ' ' . $currency,
						 $this->getLanguage()->json()['Account']['Deposit']['Coupon']['Types'][ucfirst($coupon->getRow()->type)]
					], $info);

					$data['valid'] = true;
					$data['message'] = $info;
				}

				return $data;
			}

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/account/deposit/coupon', $this, 'account-deposit-coupon', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
