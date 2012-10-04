<?php
App::uses('AppController', 'Controller');
/**
 * ConsultLocationTypes Controller
 *
 * @property ConsultLocationType $ConsultLocationType
 */
class ConsultLocationTypesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->ConsultLocationType->recursive = 0;
		$this->set('consultLocationTypes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->ConsultLocationType->id = $id;
		if (!$this->ConsultLocationType->exists()) {
			throw new NotFoundException(__('Invalid consult location type'));
		}
		$this->set('consultLocationType', $this->ConsultLocationType->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->ConsultLocationType->create();
			if ($this->ConsultLocationType->save($this->request->data)) {
				$this->Session->setFlash(__('The consult location type has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The consult location type could not be saved. Please, try again.'));
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
		$this->ConsultLocationType->id = $id;
		if (!$this->ConsultLocationType->exists()) {
			throw new NotFoundException(__('Invalid consult location type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->ConsultLocationType->save($this->request->data)) {
				$this->Session->setFlash(__('The consult location type has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The consult location type could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->ConsultLocationType->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->ConsultLocationType->id = $id;
		if (!$this->ConsultLocationType->exists()) {
			throw new NotFoundException(__('Invalid consult location type'));
		}
		if ($this->ConsultLocationType->delete()) {
			$this->Session->setFlash(__('Consult location type deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Consult location type was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
