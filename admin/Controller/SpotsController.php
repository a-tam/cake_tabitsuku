<?php
App::uses('AppController', 'Controller');
/**
 * Spots Controller
 *
 * @property Spot $Spot
 */
class SpotsController extends AppController {

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Spot->recursive = 0;
		$this->set('spots', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Spot->id = $id;
		if (!$this->Spot->exists()) {
			throw new NotFoundException(__('Invalid spot'));
		}
		$this->set('spot', $this->Spot->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Spot->create();
			if ($this->Spot->save($this->request->data)) {
				$this->Session->setFlash(__('The spot has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The spot could not be saved. Please, try again.'));
			}
		}
		$users = $this->Spot->User->find('list');
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
		$this->Spot->id = $id;
		if (!$this->Spot->exists()) {
			throw new NotFoundException(__('Invalid spot'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Spot->save($this->request->data)) {
				$this->Session->setFlash(__('The spot has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The spot could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Spot->read(null, $id);
		}
		$users = $this->Spot->User->find('list');
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
		$this->Spot->id = $id;
		if (!$this->Spot->exists()) {
			throw new NotFoundException(__('Invalid spot'));
		}
		if ($this->Spot->delete()) {
			$this->Session->setFlash(__('Spot deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Spot was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
