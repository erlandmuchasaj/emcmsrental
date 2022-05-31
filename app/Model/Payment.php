<?php
App::uses('AppModel', 'Model');
/**
 * Payment Model
 */
class Payment extends AppModel {

	/**
	 * Custom database table name, or null/false if no table association is desired.
	 *
	 * @var string|false
	 */
	public $useTable = false;

	private $_suportedPayments = ['paypal', 'stripe', 'credit_card'];

	public function handlePayment($paymentMethod = 'paypal') {
		if (!in_array($paymentMethod, $this->_suportedPayments, true)) {
			throw new MethodNotAllowedException(__('Payment method (%s) not supported!', Inflector::humanize($paymentMethod)));
		}

		if ('paypal' === $paymentMethod) {
			$response = $this->paypal($paymentMethod);
		} elseif ('stripe' === $paymentMethod) {
			$response = $this->stripe($paymentMethod);
		} elseif ('credit_card' === $paymentMethod) {
			$response = $this->creditCard($paymentMethod);
		}

		return $response;
	}

	protected function paypal() {
		return 'paypal payment handeled';
	}

	protected function stripe() {
		return 'stripe payment handeled';
	}

	protected function creditCard() {
		return 'Credit Card payment handeled';
	}

}