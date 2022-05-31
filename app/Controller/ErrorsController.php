<?php
/**
 * ErrorHandler class
 * Provides Error Capturing for Framework errors.
 * @package       Cake.Error
 * @see ExceptionRenderer for more information on how to customize exception rendering.
 */
class ErrorsController extends AppController {
    public $name = 'Errors';

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('error404');
    }

    public function error404($message = '') {
    	$this->layout = 'error';
    	$this->set('title_for_layout', __('Page Not Found'));
        $this->set('message', $message);
    }
}