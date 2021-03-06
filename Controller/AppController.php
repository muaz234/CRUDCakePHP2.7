<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $components = array('DebugKit.Toolbar','Paginator', 'Session', 'Flash','RequestHandler',
    'Auth' => array(
		'loginRedirect' => array(
			'controller' => 'listings',
			'action' => 'index'
		),
		'logoutRedirect' => array(
			'controller' => 'users',
			'action' => 'login'
		),
		'authenticate' => array(
		'Form' => array(
			'passwordHasher' => 'Blowfish',
			'fields' => array(
				'username' => 'email', 
			'password' => 'encrypted_password'
			)
            
		)
	)
)
);


public function beforeFilter()
{
	$this->Auth->allow('login', 'logout', 'add');
	if(!$this->Auth->loggedIn()) {
		$this->Auth->authError = false;
	}
	// Security::setHash('blowfish');

}


    
}
