<?php
App::uses('AppController', 'Controller');
App::uses('Paypal', 'Paypal.Lib');

/**
* Payments Controller
* 
* @property Payment $Payment
* @property PaginatorComponent $Paginator
* @property SessionComponent $Session
*/
define("PAYPAL_OK_URL", Router::url(array('user'=>true,'controller'=>'payments','action'=>'paymentSuccess'), true));
define("PAYPAL_CANCEL_URL", Router::url(array('user'=>true,'controller'=>'payments','action'=>'paymentCancel'), true));
class PaymentsController extends AppController {
/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session');

////////////////////////////////////////////////////////////////////////////////////
/**
 * variables for paypal
 *
 * @return void
 */
	// set these using the constructor
	private $API_username = "info-facilitator_api1.biriola.com";
	private $API_password = "97RJ7UBNPTJRKSBS";
	private $API_signature = "ANWt-97R036ncQy4eT0FWroHF2QcAv-W821csoDV305Z3zQQX6985wMB";
	private $SANDBOX_flag = true;
	private $RETURN_url = PAYPAL_OK_URL;
	private $CANCEL_url = PAYPAL_CANCEL_URL;	
	private $PAYMENT_type = 'sale';
	private $CURRENCY_code = 'USD';
////////////////////////////////////////////////////////////////////////////////////


/**
 * add method
 *
 * @return void
 */
	public function user_add($id = null) {
		if ($this->request->is(array('post', 'put'))) {
			if(!empty($this->request->data['Payment'])){
				if (!isset($this->request->data['Payment']['type']) || empty($this->request->data['Payment']['type'])) {
					$this->Session->setFlash(__('Payment type is missing. Please refresh the page and try again!'),'flash_error');
					return $this->redirect($this->referer(array('controller'=>'properties','action' => 'index')));
					exit;
				} 
				$type = $this->request->data['Payment']['type'];
				if (!in_array($type, $available_types)) {
					$this->Session->setFlash(__('Payment type is invalid. Please refresh the page and try again!'),'flash_error');
					return $this->redirect($this->referer(array('controller'=>'properties','action' => 'index')));
					exit;
				}

				$price = 0.01;
				$credits = 0;


				$this->Paypal = new Paypal(array(
					'sandboxMode' => $this->SANDBOX_flag,
					'nvpUsername' => $this->API_username,
					'nvpPassword' => $this->API_password,
					'nvpSignature' => $this->API_signature
				));
				$order = array(
					'description' =>'description',
					'currency' => $this->CURRENCY_code,
					'return' => $this->RETURN_url,
					'cancel' => $this->CANCEL_url,
					'custom' => 'Erland Muchasaj',
					'shipping' => '0',
				);
				$temp_product = array(
					'name' =>'Reservation Credit.',
					'description' => 'Buy extra reservation credits.',
					'tax' => 0,
					'subtotal' => $price,
					'qty' => 1,
				);
				$order['items'][] = $temp_product;
				try {
					$redirectUrl = $this->Paypal->setExpressCheckout($order);
					// this will return to the return url as above
					return $this->redirect($redirectUrl);
					exit;
				} catch (Exception $e) {
					$message = $e->getMessage();
					echo "<pre>";
					print_r($message);
					echo '</pre>';
					die();
				}
			}
		} 
	}
////////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////////	
/**
 *Process data for paypal  
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function user_paymentSuccess() {
		if (!isset($this->request->query['token']) || !isset($this->request->query['PayerID'])) {
			$this->Session->setFlash(__('Token ID Or Payer ID is not Set!'),'flash_error');
			return $this->redirect(array('controller'=>'properties','action' => 'index'));
			exit();
		}
		$this->Paypal = new Paypal(array(
			'sandboxMode' => $this->SANDBOX_flag,
			'nvpUsername' => $this->API_username,
			'nvpPassword' => $this->API_password,
			'nvpSignature' => $this->API_signature
		));
		$token = $this->request->query['token'];
		$payer_id = $this->request->query['PayerID'];
		try {
			$getExpressCheckoutReturn = $this->Paypal->getExpressCheckoutDetails($token);
			$order = array(
				'description' => 'Description',
				'currency' => $this->CURRENCY_code,
				'return' => $this->RETURN_url,
				'cancel' => $this->CANCEL_url,
				'custom' => 'Erland Muchasaj',
				'shipping' => '0',
			);
			$temp_product = array(
				'name' => 'Reservation Credit.',
				'description' => 'Buy extra reservation credits.',
				'tax' => 0,
				'subtotal' => $getExpressCheckoutReturn['PAYMENTREQUEST_0_AMT'],
				'qty' => 1,
			);
			$order['items'][] = $temp_product;
			try {
				$doExpressCheckoutReturn = $this->Paypal->doExpressCheckoutPayment($order, $token, $payer_id);	
				if(isset($doExpressCheckoutReturn['L_SHORTMESSAGE0']) && ($doExpressCheckoutReturn['L_SHORTMESSAGE0'] === 'Duplicate Request')){
					$this->Session->setFlash(__('Dublicate Request!'),'flash_error');
					return $this->redirect(array('controller'=>'properties','action' => 'index'));
				}
				// EVERYTHING IS OK SO PROCESS THE DATA
				$amt = $doExpressCheckoutReturn['PAYMENTINFO_0_AMT'];
				$currency = $doExpressCheckoutReturn['PAYMENTINFO_0_CURRENCYCODE'];
			} catch (PaypalRedirectException $e) {
				$this->redirect($e->getMessage());
			} catch (Exception $e) {
				$message = $e->getMessage();
				debug($message);
				die();
			}
		} catch (Exception $e) {
			$message = $e->getMessage();
			debug($message);
			die();
		}
	}
}