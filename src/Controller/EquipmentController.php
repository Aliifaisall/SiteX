<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Equipment Controller
 *
 * @property \App\Model\Table\EquipmentTable $Equipment
 * @method \App\Model\Entity\Equipment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EquipmentController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $equipment = $this->paginate($this->Equipment);

        $this->set(compact('equipment'));
    }

    /**
     * View method
     *
     * @param string|null $id Equipment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $equipment = $this->Equipment->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('equipment'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $equipment = $this->Equipment->newEmptyEntity();
        if ($this->request->is('post')) {
            $equipment = $this->Equipment->patchEntity($equipment, $this->request->getData());
            if ($this->Equipment->save($equipment)) {
                $this->Flash->success(__('The equipment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The equipment could not be saved. Please, try again.'));
        }
        $this->set(compact('equipment'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Equipment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $equipment = $this->Equipment->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $equipment = $this->Equipment->patchEntity($equipment, $this->request->getData());
            if ($this->Equipment->save($equipment)) {
                $this->Flash->success(__('The equipment has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The equipment could not be saved. Please, try again.'));
        }
        $this->set(compact('equipment'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Equipment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $equipment = $this->Equipment->get($id);
        if ($this->Equipment->delete($equipment)) {
            $this->Flash->success(__('The equipment has been deleted.'));
        } else {
            $this->Flash->error(__('The equipment could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
