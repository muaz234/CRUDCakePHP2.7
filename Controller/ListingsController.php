<?php
App::uses('AppController', 'Controller');
/**
 * Listings Controller
 *
 * @property Listing $Listing
 * @property PaginatorComponent $Paginator
 * @property SessionComponent $Session
 * @property FlashComponent $Flash
 */
class ListingsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator', 'Session', 'Flash');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->Listing->recursive = 0;
		$this->set('listings', $this->Paginator->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Listing->exists($id)) {
			throw new NotFoundException(__('Invalid listing'));
		}
		$options = array('conditions' => array('Listing.' . $this->Listing->primaryKey => $id));
		$this->set('listing', $this->Listing->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Listing->create();
			if ($this->Listing->save($this->request->data)) {
				$this->Flash->success(__('The listing has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The listing could not be saved. Please, try again.'));
			}
		}
		$users = $this->Listing->User->find('list');
		$this->set(compact('users'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Listing->exists($id)) {
			throw new NotFoundException(__('Invalid listing'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Listing->save($this->request->data)) {
				$this->Flash->success(__('The listing has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Flash->error(__('The listing could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Listing.' . $this->Listing->primaryKey => $id));
			$this->request->data = $this->Listing->find('first', $options);
		}
		$users = $this->Listing->User->find('list');
		$this->set(compact('users'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Listing->id = $id;
		if (!$this->Listing->exists()) {
			throw new NotFoundException(__('Invalid listing'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Listing->delete()) {
			$this->Flash->success(__('The listing has been deleted.'));
		} else {
			$this->Flash->error(__('The listing could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
