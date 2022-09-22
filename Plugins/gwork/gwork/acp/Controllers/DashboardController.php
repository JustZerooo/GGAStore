<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp\Controllers {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	    use GWork\System\Common;
	    use GWork\System\GWORK;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

		use GWork\System\Redirects\PermissionRedirect;

		use GWork\System\Models\Settings\SettingsFactory;
		use GWork\System\Models\User\UserFactory;
		
		use Plugins\gwork\gwork\shop\Utils\Bitcoin\Bitcoin;
		use Plugins\gwork\gwork\acp\Models\Note\NoteFactory;

		use Fabiang\Xmpp\Options;
		use Fabiang\Xmpp\Client;
		use Fabiang\Xmpp\Protocol\Message;
	
	    final class DashboardController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				if($route->getName() == 'admin-dashboard') {
					$view = ViewHelper::create($this, 'Dashboard.php', 'dashboardView', ['pageName' => $this->getLanguage()->json()['Dashboard']['PageName']], [], true);

					if($this->getUser()->hasPermissionByName('ACCESS_BTC_SERVER') && isset($_POST['btc_send_toaddress'], $_POST['btc_send_amount'], $_POST['btc_send_fees'])) {
						$settings = $this->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);
						
						$bitcoin = new Bitcoin($settings->BitcoinUsername, $settings->BitcoinPassword, $settings->BitcoinHost, (int) $settings->BitcoinPort);

						if($bitcoin->settxfee($_POST['btc_send_fees'])) {
							$txid = $bitcoin->sendtoaddress($_POST['btc_send_toaddress'], $_POST['btc_send_amount']);
							if($txid != null && strlen($txid) > 0) {
								$successMessage = $this->getLanguage()->json()['Dashboard']['SendBTC']['Succes'];

								$successMessage = str_replace('%txid%', $txid, $successMessage);
								
								$view->btcSendSuccessMessage = $successMessage;
							} else {
								$view->btcSendErrorMessage = $this->getLanguage()->json()['Dashboard']['SendBTC']['ErrorTxID'];
							}
						} else {
							$view->btcSendErrorMessage = $this->getLanguage()->json()['Dashboard']['SendBTC']['ErrorFee'];
						}
					}
					
					if(isset($_POST['note_message']) && strlen($_POST['note_message']) > 0) {
						$noteFactory = $this->getControllerParameters()->getModelsManager()->get(NoteFactory::class);
						$noteFactory->_create([
							'timestamp' => time(),
							'userid' => $this->getUser()->getRow()->id,
							'note' => $_POST['note_message'],
							'readed' => 0
						]);
						
						GWORK::redirect('/admin');
					}
					
					if($this->getUser()->hasPermissionByName('ACCESS_JABBER_NEWSLETTER') && isset($_POST['newsletter_message'])) {
						$userFactory = $this->getControllerParameters()->getModelsManager()->get(UserFactory::class);
						
						$settings = $this->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);

						$jabbers = [];
						
						foreach($userFactory->getAllByColumn('newsletter', 1) as $receiver) {
							if(Common::isValidMail($receiver->getRow()->jabber)) {
								$jabbers[] = $receiver->getRow()->jabber;
							}
						}
						
						if(count($jabbers) > 0) {
							$options = new Options('tcp://' . $settings->JabberHost . ':' . $settings->JabberPort);
							$options->setUsername($settings->JabberUsername)->setPassword($settings->JabberPassword);
							$options->setContextOptions([
								'ssl' => [
									'allow_self_signed' => true,
									'verify_peer_name' => false,
									'verify_peer' => false
								]
							]);
							
							$client = new Client($options);
							$sended = 0;
							
							$client->connect();
							$message = new Message();
							$message->setMessage($_POST['newsletter_message']);
								
							foreach($jabbers as $jid) {
								$message->setTo($jid);
								$client->send($message);
								
								$sended++;
							}
								
							$newsletterSuccessMessage = str_replace('%count%', $sended . '/' . count($jabbers), $this->getLanguage()->json()['Dashboard']['SendNewsletter']['Success']);
							$view->newsletterSuccessMessage = $newsletterSuccessMessage;
								
							$client->disconnect();
						}
					}

					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin', $this, 'admin-dashboard', true),
		            new Route('/admin/dashboard', $this, 'admin-dashboard', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
