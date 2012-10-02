<?php
App::uses('AppController', 'Controller');
/**
 * LinkDoctorsToSpecialties Controller
 *
 * @property LinkDoctorsToSpecialty $LinkDoctorsToSpecialty
 */
class LinkDoctorsToSpecialtiesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->LinkDoctorsToSpecialty->recursive = 0;
		$this->set('linkDoctorsToSpecialties', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->LinkDoctorsToSpecialty->id = $id;
		if (!$this->LinkDoctorsToSpecialty->exists()) {
			throw new NotFoundException(__('Invalid link doctors to specialty'));
		}
		$this->set('linkDoctorsToSpecialty', $this->LinkDoctorsToSpecialty->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->LinkDoctorsToSpecialty->create();
			if ($this->LinkDoctorsToSpecialty->save($this->request->data)) {
				$this->Session->setFlash(__('The link doctors to specialty has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The link doctors to specialty could not be saved. Please, try again.'));
			}
		}
		$doctors = $this->LinkDoctorsToSpecialty->Doctor->find('list');
		$specialties = $this->LinkDoctorsToSpecialty->Specialty->find('list');
		$this->set(compact('doctors', 'specialties'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->LinkDoctorsToSpecialty->id = $id;
		if (!$this->LinkDoctorsToSpecialty->exists()) {
			throw new NotFoundException(__('Invalid link doctors to specialty'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->LinkDoctorsToSpecialty->save($this->request->data)) {
				$this->Session->setFlash(__('The link doctors to specialty has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The link doctors to specialty could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->LinkDoctorsToSpecialty->read(null, $id);
		}
		$doctors = $this->LinkDoctorsToSpecialty->Doctor->find('list');
		$specialties = $this->LinkDoctorsToSpecialty->Specialty->find('list');
		$this->set(compact('doctors', 'specialties'));
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
		$this->LinkDoctorsToSpecialty->id = $id;
		if (!$this->LinkDoctorsToSpecialty->exists()) {
			throw new NotFoundException(__('Invalid link doctors to specialty'));
		}
		if ($this->LinkDoctorsToSpecialty->delete()) {
			$this->Session->setFlash(__('Link doctors to specialty deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Link doctors to specialty was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
