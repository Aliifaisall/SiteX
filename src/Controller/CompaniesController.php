<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\FactoryLocator;
use Cake\View\JsonView;

/**
 * Companies Controller
 *
 * @property \App\Model\Table\CompaniesTable $Companies
 * @method \App\Model\Entity\Company[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CompaniesController extends AppController
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['listCompaniesAjax']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $company = $this->Companies->newEmptyEntity();
        $this->Authorization->authorize($company);

        $companies = $this->paginate($this->Companies);

        $this->set(compact('companies'));
    }

    /**
     * View method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $company = $this->Companies->get($id, [
            'contain' => ['Projects', 'Users'],
        ]);
        $this->Authorization->authorize($company);
        $currentUser = $this->request->getAttribute('identity');
        $documents = FactoryLocator::get('Table')->get('Documents')->find()->where([
            'related_company_id' => $id
        ]);

        $employment = FactoryLocator::get('Table')->get('CompaniesUsers')->find();
        $employment->select(['user_id'])
            ->where([
                'company_id' => $id,
                'is_company_admin' => TRUE
            ])->first();

        foreach($employment as $e){
            $admin_id = $e->user_id;
        }

        $this->set(compact('company', 'admin_id', 'documents'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $company = $this->Companies->newEmptyEntity();
        $this->Authorization->authorize($company);
        $currentUser = $this->request->getAttribute('identity');

        $companyPresent = FactoryLocator::get('Table')->get('CompaniesUsers')->find()->select('company_id')->where([
            'user_id' => $currentUser->id
        ])->first();
        if ($companyPresent){
            $this->Flash->error(__('You have already added your company.'));
            return $this->redirect(['controller' => 'projects', 'action' => 'index']);
        }

        if ($this->request->is('post')) {
            $company = $this->Companies->patchEntity($company, $this->request->getData());
            $company->admin_id = $currentUser->id;
            if ($this->Companies->save($company)) {
                $this->Flash->success(__('The company has been saved.'));
                $employment = FactoryLocator::get('Table')->get('CompaniesUsers')->find();
                $employment->insert(['company_id', 'user_id', 'is_company_admin'])
                    ->values([
                        'company_id' => $company->id,
                        'user_id' => $currentUser->id,
                        'is_company_admin' => TRUE
                    ])->execute();
                return $this->redirect(['controller' => 'projects', 'action' => 'index']);
            }
            $this->Flash->error(__('The company could not be saved. Please, try again.'));
        }
        $this->set(compact('company'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $company = $this->Companies->get($id, [
            'contain' => ['Projects', 'Users'],
        ]);
        $this->Authorization->authorize($company);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $company = $this->Companies->patchEntity($company, $this->request->getData());
            if ($this->Companies->save($company)) {
                $this->Flash->success(__('The company has been saved.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The company could not be saved. Please, try again.'));
        }
        $projects = $this->Companies->Projects->find('list', ['limit' => 200])->all();
        $users = $this->Companies->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('company', 'projects', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Company id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $company = $this->Companies->get($id);
        $this->Authorization->authorize($company);
        if ($this->Companies->delete($company)) {
            $this->Flash->success(__('The company has been deleted.'));
        } else {
            $this->Flash->error(__('The company could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function staff($id = null)
    {
        $company = $this->Companies->get($id, [
            'contain' => ['Projects', 'Users'],
        ]);
        $this->Authorization->authorize($company);

        if ($this->request->is("get") && $this->request->getQuery('deleteUser')){
            $deleteUser = $this->request->getQuery('deleteUser');
            $employee = FactoryLocator::get('Table')->get('CompaniesUsers')->find()->where([
                'company_id' => $id,
                'user_id' => $deleteUser
            ])->first();
            if (FactoryLocator::get('Table')->get('CompaniesUsers')->delete($employee)){
                $this->Flash->success(__('Employee removed from company.'));
            } else {
                $this->Flash->error(__('The employee could not be removed. Please, try again.'));
            }
            return $this->redirect(['action' => 'staff', $id]);
        }

        $employeeIds = FactoryLocator::get('Table')->get('CompaniesUsers')->find();
        $employeeIds->select(['user_id'])->where([
            'company_id' => $id,
            'confirmed' => '1'
        ]);

        $employees = FactoryLocator::get('Table')->get('Users')->find()->where([
            'id IN' => $employeeIds,
        ]);

        $employment = FactoryLocator::get('Table')->get('CompaniesUsers')->find();
        $employment->select(['user_id'])
            ->where([
                'company_id' => $id,
                'is_company_admin' => TRUE
            ])->first();

        foreach($employment as $e){
            $admin_id = $e->user_id;
        }

        $this->set(compact('company', 'admin_id', 'employees'));
    }

    public function change($id = null)
    {
        $company = $this->Companies->newEmptyEntity();
        $this->Authorization->authorize($company);
        $currentUser = $this->request->getAttribute('identity');

        $companyPresent = FactoryLocator::get('Table')->get('CompaniesUsers')->find()->select('company_id')->where([
            'user_id' => $currentUser->id
        ])->first();
        if ($companyPresent){
            $this->Flash->error(__('You are already assigned to a company.'));
            return $this->redirect(['controller' => 'projects', 'action' => 'index']);
        }

        if ($this->request->is('post') && $this->request->getData('company_name')) {
            $company = explode('[', $this->request->getData('company_name'));
            $company = explode(']', $company[1]);
            $company_id = $company[0];
            $employment = FactoryLocator::get('Table')->get('CompaniesUsers')->find();
            $employment->insert(['company_id', 'user_id', 'is_company_admin'])
                ->values([
                    'company_id' => $company_id,
                    'user_id' => $currentUser->id,
                    'is_company_admin' => 0
                ])->execute();
            $this->Flash->success(__('Registered with selected company.'));
            return $this->redirect(['controller' => 'projects', 'action' => 'index']);
            }
            //$this->Flash->error(__('The company could not be saved. Please, try again.'));
        $companies = FactoryLocator::get('Table')->get('Companies')->find();
        $this->set(compact('company', 'companies'));
    }

    public function pending($id = null)
    {
        $company = $this->Companies->get($id, [
            'contain' => ['Projects', 'Users'],
        ]);
        $this->Authorization->authorize($company);

        if ($this->request->is("get") && $this->request->getQuery('rejectUser')){
            $deleteUser = $this->request->getQuery('rejectUser');
            $employee = FactoryLocator::get('Table')->get('CompaniesUsers')->find()->where([
                'company_id' => $id,
                'user_id' => $deleteUser
            ])->first();
            if (FactoryLocator::get('Table')->get('CompaniesUsers')->delete($employee)){
                $this->Flash->success(__('Employee rejected from your company.'));
            } else {
                $this->Flash->error(__('The employee could not be rejected. Please, try again.'));
            }
            return $this->redirect(['action' => 'pending', $id]);
        } else if ($this->request->is("get") && $this->request->getQuery('acceptUser')){
            $acceptUser = $this->request->getQuery('acceptUser');
            $employee = FactoryLocator::get('Table')->get('CompaniesUsers')->find()->where([
                'company_id' => $id,
                'user_id' => $acceptUser
            ])->first();
            $employee->confirmed = 1;
            if (FactoryLocator::get('Table')->get('CompaniesUsers')->save($employee)){
                $this->Flash->success(__('Employee added to your company.'));
            } else {
                $this->Flash->error(__('The employee could not be added. Please, try again.'));
            }
            return $this->redirect(['action' => 'pending', $id]);
        }

        $unconfirmedIds = FactoryLocator::get('Table')->get('CompaniesUsers')->find();
        $unconfirmedIds->select(['user_id'])->where([
            'company_id' => $id,
            'confirmed' => 0
        ]);

        $employees = FactoryLocator::get('Table')->get('Users')->find()->where([
            'id IN' => $unconfirmedIds,
        ]);

        $this->set(compact('company', 'employees'));
    }
}
