<?php
App::uses('AppController', 'Controller');
/**
 * LinkSpecialtiesToDiseases Controller
 *
 * @property LinkSpecialtiesToDisease $LinkSpecialtiesToDisease
 */
class LinkSpecialtiesToDiseasesController extends AppController {

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->LinkSpecialtiesToDisease->recursive = 0;
		$this->set('linkSpecialtiesToDiseases', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->LinkSpecialtiesToDisease->id = $id;
		if (!$this->LinkSpecialtiesToDisease->exists()) {
			throw new NotFoundException(__('Invalid link specialties to disease'));
		}
		$this->set('linkSpecialtiesToDisease', $this->LinkSpecialtiesToDisease->read(null, $id));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->LinkSpecialtiesToDisease->create();
			if ($this->LinkSpecialtiesToDisease->save($this->request->data)) {
				$this->Session->setFlash(__('The link specialties to disease has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The link specialties to disease could not be saved. Please, try again.'));
			}
		}
		$specialties = $this->LinkSpecialtiesToDisease->Specialty->find('list');
		$diseases = $this->LinkSpecialtiesToDisease->Disease->find('list');
		$specialtyDiseaseLinkTypes = $this->LinkSpecialtiesToDisease->SpecialtyDiseaseLinkType->find('list');
		$this->set(compact('specialties', 'diseases', 'specialtyDiseaseLinkTypes'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->LinkSpecialtiesToDisease->id = $id;
		if (!$this->LinkSpecialtiesToDisease->exists()) {
			throw new NotFoundException(__('Invalid link specialties to disease'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->LinkSpecialtiesToDisease->save($this->request->data)) {
				$this->Session->setFlash(__('The link specialties to disease has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The link specialties to disease could not be saved. Please, try again.'));
			}
		} else {
			$this->request->data = $this->LinkSpecialtiesToDisease->read(null, $id);
		}
		$specialties = $this->LinkSpecialtiesToDisease->Specialty->find('list');
		$diseases = $this->LinkSpecialtiesToDisease->Disease->find('list');
		$specialtyDiseaseLinkTypes = $this->LinkSpecialtiesToDisease->SpecialtyDiseaseLinkType->find('list');
		$this->set(compact('specialties', 'diseases', 'specialtyDiseaseLinkTypes'));
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
		$this->LinkSpecialtiesToDisease->id = $id;
		if (!$this->LinkSpecialtiesToDisease->exists()) {
			throw new NotFoundException(__('Invalid link specialties to disease'));
		}
		if ($this->LinkSpecialtiesToDisease->delete()) {
			$this->Session->setFlash(__('Link specialties to disease deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('Link specialties to disease was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
}
