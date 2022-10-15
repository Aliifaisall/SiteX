<?php
declare(strict_types=1);


namespace App\Controller;
use Cake\Datasource\FactoryLocator;
use Cake\Mailer\Mailer;
use Cake\ORM\Locator\TableLocator;

/**
 * Inductions Controller
 *
 * @property \App\Model\Table\InductionsTable $Inductions
 * @method \App\Model\Entity\Induction[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InductionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $induction = $this->Inductions->newEmptyEntity();
        $this->Authorization->authorize($induction);

        $this->paginate = [
            'contain' => ['Projects', 'Users'],
        ];
        $inductions = $this->paginate($this->Inductions);

        $this->set(compact('inductions'));
    }

    /**
     * View method
     *
     * @param string|null $id Induction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $induction = $this->Inductions->get($id, [
            'contain' => ['Projects', 'Users'],
        ]);
        $this->Authorization->authorize($induction);

        $this->set(compact('induction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $induction = $this->Inductions->newEmptyEntity();
        $this->Authorization->authorize($induction);
        $currentUser = $this->request->getAttribute('identity');

        $projectid = $this->request->getQuery('project');
        $company = FactoryLocator::get('Table')->get('Companies')->find()->where(['admin_id' => $currentUser->id])->first();

        if ($this->request->is('post')) {
            $induction = $this->Inductions->patchEntity($induction, $this->request->getData());
            $project_id = $this->request->getData('Project');
            if ($this->request->getData('Worker')){
                $user_id = $this->request->getData('Worker');
                $induction->project_id = $project_id;
                $induction->user_id = $user_id;
                $induction->company_id = $company->id;

                if ($this->Inductions->save($induction)) {
                    $inductee = FactoryLocator::get('Table')->get('Users')->get($user_id);
                    $project = FactoryLocator::get('Table')->get('Projects')->get($project_id);
                    $mailer = new Mailer('default');
                    $mailer
                        ->setEmailFormat('html')
                        ->setFrom(['sitex@u22s1010.monash-ie.me' => 'SiteX'])
                        ->setTo($inductee->email)
                        ->setSubject('SiteX: You have been assigned a project.')
                        ->viewBuilder()
                        ->setTemplate('assignedtoproject');

                    $mailer ->setViewVars([
                        'id' => $inductee->id,
                        'email' => $this->request->getData('email'),
                        'name' => $inductee->first_name,
                        'project' => $project->name,
                        'assigner' => $currentUser->first_name.' '.$currentUser->last_name
                    ]);

                    // Deliver mail
                    if ($mailer->deliver()){
                        //$this->Flash->success(__('Assignment email sent.'));
                    } else {
                        $this->Flash->error(__('Failed to send assignment email.'));
                    }
                    $this->Flash->success(__('Worker assigned successfully.'));
                    return $this->redirect(['controller' => 'projects', 'action' => 'index']);
                }
                $this->Flash->error(__('Worker could not be added. Please try again.'));
            } elseif ($this->request->getData('Contractor')){
                $contractor = $this->request->getData('Contractor');
                $assignment = FactoryLocator::get('Table')->get('CompaniesProjects')->find();
                $assignment->insert(['company_id', 'project_id',])
                    ->values([
                        'company_id' => $contractor,
                        'project_id' => $project_id
                    ])->execute();
                $this->Flash->success(__('Contractor assigned successfully.'));
                return $this->redirect(['controller' => 'projects', 'action' => 'index']);
            }
        }
        $projects = $this->Inductions->Projects->find('list', ['limit' => 200])->all();

        $projectsTable = FactoryLocator::get('Table')->get('Projects');
        $project = $projectsTable->get($projectid);

        $unconfirmedIds = FactoryLocator::get('Table')->get('CompaniesUsers')->find();
        $unconfirmedIds->select(['user_id'])->where([
            'company_id' => $company->id,
            'confirmed' => 0
        ]);
        $usersAlreadyAdded = $this->Inductions->find()->select(['user_id'])->where(['project_id' => $projectid]);
        $users = $this->Inductions->Users->find()->select(['id', 'first_name', 'last_name'])->where([
            'cu.company_id' => $company->id,
            'role' => 'On-site Worker',
            'Users.id NOT IN' => $usersAlreadyAdded,
            'Users.id NOT IN' => $unconfirmedIds,
        ])->join([
            "table" => "companies_users cu",
            "type" => "LEFT",
            "conditions" => "Users.id = cu.user_id"
        ]);

        $contractorsAlreadyAdded = FactoryLocator::get('Table')->get('CompaniesProjects')->find()->select('company_id')->where([
            'project_id' => $projectid
        ]);

        $contractors = FactoryLocator::get('Table')->get('Companies')->find()->where([
            'company_type' => 'Contractor',
            'id NOT IN' => $contractorsAlreadyAdded
        ]);


        $this->set(compact('induction', 'projects', 'project', 'users', 'contractors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Induction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $induction = $this->Inductions->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($induction);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $induction = $this->Inductions->patchEntity($induction, $this->request->getData());
            if ($this->Inductions->save($induction)) {
                $this->Flash->success(__('Induction complete.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Could not finalize induction. Please try again.'));
        }
        $projects = $this->Inductions->Projects->find('list', ['limit' => 200])->all();
        $users = $this->Inductions->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('induction', 'projects', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Induction id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $induction = $this->Inductions->get($id);
        $this->Authorization->authorize($induction);
        if ($this->Inductions->delete($induction)) {
            $this->Flash->success(__('The induction has been deleted.'));
        } else {
            $this->Flash->error(__('The induction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'projects', 'action' => 'index']);
    }
}
