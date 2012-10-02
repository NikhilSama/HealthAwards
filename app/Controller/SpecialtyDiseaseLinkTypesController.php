<?php
App::uses('AppController', 'Controller');
/**
 * SpecialtyDiseaseLinkTypes Controller
 *
 * @property SpecialtyDiseaseLinkType $SpecialtyDiseaseLinkType
 */
class SpecialtyDiseaseLinkTypesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->SpecialtyDiseaseLinkType->recursive = 0;
		$this->set('specialtyDiseaseLinkTypes', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->SpecialtyDiseaseLinkType->id = $id;
		if (!$this->SpecialtyDiseaseLinkType->exists()) {
			throw new NotFoundException(__('Invalid specialty disease link type'));
		}
		$this->set('specialtyDiseaseLinkType', $this->SpecialtyDiseaseLinkType->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->SpecialtyDiseaseLinkType->create();
			if ($this->SpecialtyDiseaseLinkType->save($this->request->data)) {
				$this->Session->setFlash(__('The specialty disease link type has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The specialty disease link type could not be saved. Please, try again.'));
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
		$this->SpecialtyDiseaseLinkType->id = $id;
		if (!$this->SpecialtyDiseaseLinkType->exists()) {
			throw new NotFoundException(__('Invalid specialty disease link type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->SpecialtyDiseaseLinkType->save($this->request->data)) {
				$this->Session->setFlash(__('The specialty disease link type has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The specialty disease link type could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->SpecialtyDiseaseLinkType->read(null, $id);
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
		$this->SpecialtyDiseaseLinkType->id = $id;
		if (!$this->SpecialtyDiseaseLinkType->exists()) {
			throw new NotFoundException(__('Invalid specialty disease link type'));
		}
		if ($this->SpecialtyDiseaseLinkType->delete()) {
			$this->Session->setFlash(__('Specialty disease link type deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Specialty disease link type was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
