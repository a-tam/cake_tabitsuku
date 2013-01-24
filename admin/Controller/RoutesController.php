<?php
App::uses('AppController', 'Controller');
/**
 * Routes Controller
 *
 * @property Route $Route
 */
class RoutesController extends AppController {

/**
 * admin_index method
 *
 * @return void
 */
	public function admin_index() {
		$this->Route->recursive = 0;
		$this->set('routes', $this->paginate());
	}

/**
 * admin_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_view($id = null) {
		$this->Route->id = $id;
		if (!$this->Route->exists()) {
			throw new NotFoundException(__('Invalid route'));
		}
		$this->set('route', $this->Route->read(null, $id));
	}

/**
 * admin_add method
 *
 * @return void
 */
	public function admin_add() {
		if ($this->request->is('post')) {
			$this->Route->create();
			if ($this->Route->save($this->request->data)) {
				$this->Session->setFlash(__('The route has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The route could not be saved. Please, try again.'));
			}
		}
		$tours = $this->Route->Tour->find('list');
		$spots = $this->Route->Spot->find('list');
		$this->set(compact('tours', 'spots'));
	}

/**
 * admin_edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function admin_edit($id = null) {
		$this->Route->id = $id;
		if (!$this->Route->exists()) {
			throw new NotFoundException(__('Invalid route'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->Route->save($this->request->data)) {
				$this->Session->setFlash(__('The route has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The route could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->Route->read(null, $id);
		}
		$tours = $this->Route->Tour->find('list');
		$spots = $this->Route->Spot->find('list');
		$this->set(compact('tours', 'spots'));
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
		$this->Route->id = $id;
		if (!$this->Route->exists()) {
			throw new NotFoundException(__('Invalid route'));
		}
		if ($this->Route->delete()) {
			$this->Session->setFlash(__('Route deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Route was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
