<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class UsersController extends AppController {

/**
 * Helpers
 *
 * @var array
 */
	public $helpers = array('Js');

/**
 * Components
 *
 * @var array
 */
	// public $components = array('Paginator', 'Session', 'Flash',
	// 'Auth' => array(
	// 	'loginAction' => array(
	// 		'controller' => 'listing',
	// 		'action' => 'index'
	// 	),
	// 	'logoutRedirect' => array(
	// 		'controller' => 'users',
	// 		'action' => 'login'
	// 	),
	// 	'authenticate' => array(
	// 		'Form' => array(
	// 			'passwordHasher' => 'Blowfish'
	// 		)
	// 		),
	// 	'Form' => array(
	// 		'fields' => array('username' => 'email')
	// 	)
	// )
// );
	
/**
 * index method
 *
 * @return void
 */

	public function beforeFilter() {
		parent::beforeFilter();
	}

	public function index() {
		$this->User->recursive = 0;
		$this->set('users', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$this->set('user', $this->User->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */

 public function generateRandomString($length = 32) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[mt_rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
	public function add() {
		if ($this->request->is('post')) {
			
			
			$create_user = array();
			$create_user['User']['email'] = $this->request->data['User']['email'];
			Security::setHash('blowfish');
			$hashed_password = Security::hash($this->request->data['User']['encrypted_password']);
			$create_user['User']['encrypted_password'] = $hashed_password;
			$create_user['User']['token'] = $this->generateRandomString(32);
			$create_user['User']['type'] = $this->request->data['User']['type'];

			// $hashed_password = Security::hash() 
			$this->User->create();
			if ($this->User->save($create_user)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->User->save($this->request->data)) {
				$this->Flash->success(__('The user has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The user could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
			$this->request->data = $this->User->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->User->delete()) {
			$this->Flash->success(__('The user has been deleted.'));
		} else {
			$this->Flash->error(__('The user could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}

	public function login()
	{
		if($this->request->is('post')){
			$email = $this->request->data['User']['email'];
			// $storedPassword, is a previously generated bcrypt hash.
			$hashed_password = $this->request->data['User']['encrypted_password'];
			$newHash = Security::hash($unhashed_password, 'blowfish', $hashed_password);
			$this->log($unhashed_password);
			$this->log($newHash);
			if($this->Auth->login()){
				// return $this->redirect(array('controller' => 'listings', 'action' => 'index'));
				return $this->redirect($this->Auth->redirect());
			}
			else{
				$this->Session->setFlash(__('Your email and password combination did not match. Please retry.'),'default', array('class' => 'alert alert-danger'));
			}

		}
		else{
			// $this->Session->setFlash(__('Please input your email and password to login.'), 'default', array('class' => 'alert alert-info'));
		}
	}

	public function logout()
	{
		return $this->redirect($this->Auth->logout());
	}
}
