<?php
App::uses('AppController', 'Controller');
/**
 * DoctorConsultLocations Controller
 *
 * @property DoctorConsultLocation $DoctorConsultLocation
 */
class DoctorConsultLocationsController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->DoctorConsultLocation->recursive = 0;
		$this->set('doctorConsultLocations', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->DoctorConsultLocation->id = $id;
		if (!$this->DoctorConsultLocation->exists()) {
			throw new NotFoundException(__('Invalid doctor consult location'));
		}
		$this->set('doctorConsultLocation', $this->DoctorConsultLocation->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->DoctorConsultLocation->create();
			if ($this->DoctorConsultLocation->save($this->request->data)) {
				$this->Session->setFlash(__('The doctor consult location has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The doctor consult location could not be saved. Please, try again.'));
			}
		}
		$locations = $this->DoctorConsultLocation->Location->find('list');
		$doctors = $this->DoctorConsultLocation->Doctor->find('list');
		$consultLocationTypes = $this->DoctorConsultLocation->ConsultLocationType->find('list');
		$this->set(compact('locations', 'doctors', 'consultLocationTypes'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->DoctorConsultLocation->id = $id;
		if (!$this->DoctorConsultLocation->exists()) {
			throw new NotFoundException(__('Invalid doctor consult location'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->DoctorConsultLocation->save($this->request->data)) {
				$this->Session->setFlash(__('The doctor consult location has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The doctor consult location could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->DoctorConsultLocation->read(null, $id);
		}
		$locations = $this->DoctorConsultLocation->Location->find('list');
		$doctors = $this->DoctorConsultLocation->Doctor->find('list');
		$consultLocationTypes = $this->DoctorConsultLocation->ConsultLocationType->find('list');
		$this->set(compact('locations', 'doctors', 'consultLocationTypes'));
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
		$this->DoctorConsultLocation->id = $id;
		if (!$this->DoctorConsultLocation->exists()) {
			throw new NotFoundException(__('Invalid doctor consult location'));
		}
		if ($this->DoctorConsultLocation->delete()) {
			$this->Session->setFlash(__('Doctor consult location deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Doctor consult location was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
