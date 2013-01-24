<?php
App::uses('AppController', 'Controller');
/**
 * Tours Controller
 *
 * @property Tour $Tour
 */
class ToursController extends AppController {

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Tour->recursive = 0;
		$this->set('tours', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Tour->id = $id;
		if (!$this->Tour->exists()) {
			throw new NotFoundException(__('Invalid tour'));
		}
		$this->set('tour', $this->Tour->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Tour->create();
			if ($this->Tour->save($this->request->data)) {
				$this->Session->setFlash(__('The tour has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tour could not be saved. Please, try again.'));
			}
		}
		$users = $this->Tour->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Tour->id = $id;
		if (!$this->Tour->exists()) {
			throw new NotFoundException(__('Invalid tour'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Tour->save($this->request->data)) {
				$this->Session->setFlash(__('The tour has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The tour could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Tour->read(null, $id);
		}
		$users = $this->Tour->User->find('list');
		$this->set(compact('users'));
	}

/**
 * admin_delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Tour->id = $id;
		if (!$this->Tour->exists()) {
			throw new NotFoundException(__('Invalid tour'));
		}
		if ($this->Tour->delete()) {
			$this->Session->setFlash(__('Tour deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Tour was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
