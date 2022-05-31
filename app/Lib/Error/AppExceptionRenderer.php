<?php
App::uses('ExceptionRenderer', 'Error');

class AppExceptionRenderer extends ExceptionRenderer {

    public function notFound($error) {
		// // redirect the user to a new page
		// $this->controller->redirect(array('controller' => 'errors', 'action' => 'error404'), $error->getCode());

		// dispaly the error on the current page
		$this->controller->beforeFilter();
		$this->controller->header('HTTP/1.1 404 Not Found');
		$this->controller->header('Status: 404 Not Found');
		$this->controller->set('title_for_layout', 'Not Found');
		$this->controller->set('message', $error->getMessage());
		$this->controller->render('/Errors/error404', 'error');
		$this->controller->response->send();
    }

    public function missingController($error) {
    	$this->notFound($error);
    }
    public function missingAction($error) {
    	$this->notFound($error);
    }
    public function missingView($error) {
    	$this->notFound($error);
    }

	protected function _outputMessage($template) {
		$this->controller->layout = 'error';
		//$this->controller->layout = false;
		parent::_outputMessage($template);
	}
}