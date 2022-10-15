<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\FactoryLocator;

/**
 * Signatures Controller
 *
 * @property \App\Model\Table\SignaturesTable $Signatures
 * @method \App\Model\Entity\Signature[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class SignaturesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $signature = $this->Signatures->newEmptyEntity();
        $this->Authorization->authorize($signature);

        $this->paginate = [
            'contain' => ['Documents', 'Users'],
        ];
        $signatures = $this->paginate($this->Signatures);

        $this->set(compact('signatures'));
    }

    /**
     * View method
     *
     * @param string|null $id Signature id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $signature = $this->Signatures->get($id, [
            'contain' => ['Documents', 'Users'],
        ]);
        $this->Authorization->authorize($signature);

        $this->set(compact('signature'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $signature = $this->Signatures->newEmptyEntity();
        $this->Authorization->authorize($signature);
        if ($this->request->is('post')) {
            $signature = $this->Signatures->patchEntity($signature, $this->request->getData());
            if ($this->Signatures->save($signature)) {
                $this->Flash->success(__('The signature has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The signature could not be saved. Please, try again.'));
        }
        $documents = $this->Signatures->Documents->find('list', ['limit' => 200])->all();
        $users = $this->Signatures->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('signature', 'documents', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Signature id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $signature = $this->Signatures->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($signature);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $signature = $this->Signatures->patchEntity($signature, $this->request->getData());
            if ($this->Signatures->save($signature)) {
                $this->Flash->success(__('The signature has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The signature could not be saved. Please, try again.'));
        }
        $documents = $this->Signatures->Documents->find('list', ['limit' => 200])->all();
        $users = $this->Signatures->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('signature', 'documents', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Signature id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $signature = $this->Signatures->get($id);
        $this->Authorization->authorize($signature);
        if ($this->Signatures->delete($signature)) {
            $this->Flash->success(__('The signature has been deleted.'));
        } else {
            $this->Flash->error(__('The signature could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }


    public function pending($id = null)
    {
        $signature = $this->Signatures->newEmptyEntity();
        $this->Authorization->authorize($signature);

        $currentUser = $this->request->getAttribute('identity');

        $signatures = FactoryLocator::get('Table')->get('Signatures')->find();

        $signatures->select(['name' => 'documents.name', 'issue_date' => 'documents.issue_date',
            'project_id' => 'p.id', 'project_name' => 'p.name'])->join([
            "table" => "documents",
            "type" => "LEFT",
            "conditions" => "Signatures.document_id = documents.id"])->join([
            "table" => "projects p",
            "type" => "LEFT",
            "conditions" => "documents.related_project_id = p.id"])->where([
            'user_id' => $currentUser->id,
            'signed_datetime is' => NULL,
            ])->enableAutoFields();

        $signatures = $this->paginate($signatures);

        $this->set(compact('signatures'));
    }
}
