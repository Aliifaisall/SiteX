<?php
declare(strict_types=1);

namespace App\Controller;
use App\Test\Fixture\InductionsFixture;
use Cake\Datasource\FactoryLocator;
use Cake\I18n\FrozenTime;
use Cake\http\Client;

/**
 * Projects Controller
 *
 * @property \App\Model\Table\ProjectsTable $Projects
 * @method \App\Model\Entity\Project[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProjectsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $project = $this->Projects->newEmptyEntity();
        $this->Authorization->authorize($project);

        $currentUser = $this->request->getAttribute('identity');
        $assignedProjects = 0;

        if($currentUser->role == 'Builder'){
            $company = FactoryLocator::get('Table')->get('CompaniesUsers')->find()->select('company_id')->where([
                'user_id' => $currentUser->id,
                'is_company_admin' => 1
            ])->first();
            if (!$company){
                return $this->redirect(['controller' => 'companies', 'action' => 'add']);
            }
            $assignedProjects = $this->Projects->find()->where(['builder_id' => $currentUser->id]);
        } elseif ($currentUser->role == 'Contractor'){
            $company = FactoryLocator::get('Table')->get('CompaniesUsers')->find()->select('company_id')->where([
                'user_id' => $currentUser->id,
                'is_company_admin' => 1
            ])->first();
            if (!$company){
                return $this->redirect(['controller' => 'companies', 'action' => 'add']);
            }
            $company_id = $company->company_id;

            $assignedProjectsIds = FactoryLocator::get('Table')->get('CompaniesProjects')->find()->select('project_id')->where([
                'company_id' => $company_id
            ]);
            $assignedProjects = $this->Projects->find();
            $assignedProjects->select(['id' => 'Projects.id', 'name' => 'Projects.name', 'project_type' => 'Projects.project_type', 'builder_id' => 'Projects.builder_id',
                'address_no' => 'Projects.address_no', 'address_street' => 'Projects.address_street', 'address_suburb' => 'Projects.address_suburb',
                'address_postcode' => 'Projects.address_postcode', 'address_state' => 'Projects.address_state', 'start_date' => 'Projects.start_date',
                'status' => 'Projects.status', 'project_id' => 'Projects.id', 'builder_fname' => 'u2.first_name', 'builder_lname' => 'u2.last_name', 'user_status' => 'u2.status'])
                ->join([
                "table" => "users u2",
                "type" => "LEFT",
                "conditions" => "builder_id = u2.id"
                ])->where([
                'Projects.id IN' => $assignedProjectsIds
            ]);
        } else {
            $assignedProjects = FactoryLocator::get('Table')->get('Inductions')->find();
            $assignedProjects->select(['inducted_date' => 'Inductions.inducted_date', 'name' => 'projects.name', 'project_type' => 'projects.project_type', 'builder_id' => 'projects.builder_id',
                'address_no' => 'projects.address_no', 'address_street' => 'projects.address_street', 'address_suburb' => 'projects.address_suburb',
                'address_postcode' => 'projects.address_postcode', 'address_state' => 'projects.address_state', 'start_date' => 'projects.start_date',
                'status' => 'projects.status', 'project_id' => 'projects.id', 'builder_fname' => 'u2.first_name', 'builder_lname' => 'u2.last_name', 'user_status' => 'u2.status'])->join([
                "table" => "projects",
                "type" => "LEFT",
                "conditions" => "Inductions.project_id = projects.id"])->join([
                "table" => "users u2",
                "type" => "LEFT",
                "conditions" => "builder_id = u2.id"
            ])->where(['user_id' => $currentUser->id])->enableAutoFields();
        }

        $selected = 0;
        if($this->request->is('get') && $this->request->getQuery('status')){
            $status = $this->request->getQuery('status');
            if ($status != 'All'){
                if ($currentUser->role == 'Builder'){
                    $assignedProjects->where(['Projects.status' => $status]);
                } else {
                    $assignedProjects->where(['projects.status' => $status]);
                }
                foreach($assignedProjects as $assignedProject){
                    $assignedProject->status = $status;
                }
            }
            $selected = $status;
        }

        $this->paginate = [
            'contain' => ['Users'],
        ];
        $projects = $this->paginate($assignedProjects);


        $this->set(compact('projects', 'selected', 'project'));
    }

    /**
     * View method
     *
     * @param string|null $id Project id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $project = $this->Projects->get($id, ['contain' => ['Users', 'Companies', 'Checkins', 'Inductions']]);

        $this->Authorization->authorize($project);

        $documents = FactoryLocator::get('Table')->get('Documents')->find()->where('related_project_id ='.$project->id);

        $checkins = FactoryLocator::get('Table')->get('Checkins')->find();
        $checkins->select(['fname' => 'users.first_name', 'lname' => 'users.last_name', 'role' => 'users.role', 'checkin_datetime', 'checkout_datetime'])->join([
            "table" => "users",
            "type" => "LEFT",
            "conditions" => "Checkins.user_id = users.id"
        ])->where(['Checkins.project_id' => $project->id])->enableAutoFields();

        $workers = FactoryLocator::get('Table')->get('Inductions')->find();
        $workers->select(['id', 'user_id', 'fname' => 'users.first_name', 'lname' => 'users.last_name', 'role' => 'users.role', 'inducted_date'])->join([
            "table" => "users",
            "type" => "LEFT",
            "conditions" => "Inductions.user_id = users.id"
        ])->enableAutoFields();

        $maxHours = 8;
        $currentDateTime = FrozenTime::now();
        $currentDateTime->i18nFormat('y-MM-dd H:i:s');

        $this->set(compact('project', 'documents', 'checkins', 'workers', 'currentDateTime', 'maxHours'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $project = $this->Projects->newEmptyEntity();
        $this->Authorization->authorize($project);

        if ($this->request->is('post')) {
            $project = $this->Projects->patchEntity($project, $this->request->getData());
            $currentUser = $this->request->getAttribute('identity');
            $project->builder_id = $currentUser->id;
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));
                $company = FactoryLocator::get('Table')->get('CompaniesUsers')->find()
                    ->where([
                        'user_id' => $currentUser->id,
                        'is_company_admin' => TRUE
                    ])->first();
                $assignment = FactoryLocator::get('Table')->get('CompaniesProjects')->find();
                $assignment->insert(['company_id', 'project_id'])
                    ->values([
                        'company_id' => $company->company_id,
                        'project_id' => $project->id])
                    ->execute();
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project could not be saved. Please, try again.'));
        }
        $users = $this->Projects->Users->find('list', ['limit' => 200])->all();
        $companies = $this->Projects->Companies->find('list', ['limit' => 200])->all();

        $this->set(compact('project', 'users', 'companies'));


    }

    /**
     * Edit method
     *
     * @param string|null $id Project id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => ['Companies'],
        ]);
        $this->Authorization->authorize($project);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $project = $this->Projects->patchEntity($project, $this->request->getData());
            if ($this->Projects->save($project)) {
                $this->Flash->success(__('The project has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The project could not be saved. Please, try again.'));
        }
        $users = $this->Projects->Users->find('list', ['limit' => 200])->all();
        $companies = $this->Projects->Companies->find('list', ['limit' => 200])->all();
        $this->set(compact('project', 'users', 'companies'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Project id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $project = $this->Projects->get($id);
        $this->Authorization->authorize($project);
        if ($this->Projects->delete($project)) {
            $this->Flash->success(__('The project has been deleted.'));
        } else {
            $this->Flash->error(__('The project could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function generateqr($id = null)
    {
        $project = $this->Projects->get($id, [
            'contain' => ['Users', 'Companies', 'Checkins', 'Inductions'],
        ]);
        $this->Authorization->authorize($project);

        $this->set(compact('project'));
    }

    public function pdf($id = null)
    {
        $project = $this->Projects->get($id);
        $this->Authorization->authorize($project);
        require_once('lib/phpqrcode/qrlib.php');

        $this->viewBuilder()->enableAutoLayout(false);
        $this->viewBuilder()->setClassName('CakePdf.Pdf');
        $CakePdf = new \CakePdf\Pdf\CakePdf();
        $address = $project->address_no.' '.$project->address_street.', '.$project->address_suburb.', '.$project->address_state.' '.$project->address_postcode;

        if ($this->request->getQuery('type') == 'checkin'){
            $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    'download' => true, // This can be omitted if "filename" is specified.
                    'filename' => 'checkin_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
                ]
            );
            $CakePdf->template('checkin', 'checkin');
            $title = $project->name.' Checkin Poster';
            $CakePdf->viewVars(['id' => $project->id, 'title' => $title, 'name' => $project->name, 'address' => $address]);
            $fileDestination = WWW_ROOT.'uploads/qr_checkin/'.$project->id.'/'.$title.'.pdf';
            $CakePdf->write($fileDestination);

            if (file_exists($fileDestination)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($fileDestination) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($fileDestination));
                debug(readfile($fileDestination));
            } else {
                $this->Flash->error(__('Error locating checkin poster PDF.'));
            }

        } elseif ($this->request->getQuery('type') == 'induction'){
            $this->viewBuilder()->setOption(
                'pdfConfig',
                [
                    'orientation' => 'portrait',
                    'download' => true, // This can be omitted if "filename" is specified.
                    'filename' => 'induction_' . $id . '.pdf' //// This can be omitted if you want file name based on URL.
                ]
            );

            $CakePdf->template('induction', 'induction');
            $title = $project->name.' Induction Poster';
            $CakePdf->viewVars(['id' => $project->id, 'title' => $title, 'name' => $project->name, 'address' => $address]);
            $fileDestination = WWW_ROOT.'uploads/qr_induction/'.$project->id.'/'.$title.'.pdf';
            $CakePdf->write($fileDestination);

            if (file_exists($fileDestination)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . basename($fileDestination) . '"');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($fileDestination));
                debug(readfile($fileDestination));
            } else {
                $this->Flash->error(__('Error locating induction poster PDF.'));
            }
        }

        return $this->redirect(['action' => 'generateqr', $project->id]);
    }

    public function staff($id = null)
    {
        $project = $this->Projects->get($id);
        $this->Authorization->authorize($project);
        $key = $this->request->getQuery('key');
        $type = $this->request->getQuery('type');

        $workers = FactoryLocator::get('Table')->get('Inductions')->find();
        $workers->select(['id', 'user_id', 'inducted_date', 'company_id', 'company_name' => 'companies.name',
            'fname' => 'users.first_name', 'lname' => 'users.last_name', 'full_name' => 'concat(users.first_name, users.last_name)', 'role' => 'users.role', 'inducted_date'
        ])->join([
            "table" => "users",
            "type" => "LEFT",
            "conditions" => "Inductions.user_id = users.id"
        ])->join([
            "table" => "companies",
            "type" => "LEFT",
            "conditions" => "Inductions.company_id = companies.id"
        ])->where([
            'project_id' => $project->id
        ])->enableAutoFields();

        $search_words = 0;
        if ($key){$search_words = $key;}

        if ($type == 0){
            if ($key) {$workers->find('all')->where(['companies.name like' => '%' . $key . '%'] );}
        } elseif ($type == 1){
            $key = str_replace(' ', '', $key);
            if ($key) {$workers->find('all')->where(['concat(users.first_name, users.last_name) like' => '%' . $key . '%'] );}
        }

        if ($this->request->getQuery('type') && $search_words == 0){
            $this->Flash->error(__('Please enter search terms.'));
        }
        $workers = $this->paginate($workers);
        $this->set(compact('project', 'workers', 'search_words', 'type'));
    }

    public function removeContractor ($id = null){
        $project = $this->Projects->get($id);
        $this->Authorization->authorize($project);
        if ($this->request->is('get')){
            $company_id = $this->request->getQuery('company');
            $assignment = FactoryLocator::get('Table')->get('CompaniesProjects')->find()->where([
                'company_id' => $company_id,
                'project_id' => $id
            ])->first();
            if (FactoryLocator::get('Table')->get('CompaniesProjects')->delete($assignment)){
                $contractors = FactoryLocator::get('Table')->get('Inductions')->find()->where([
                    'company_id' => $company_id,
                    'project_id' => $id
                ]);

                if ($contractors != NULL){
                    foreach ($contractors as $c){
                        FactoryLocator::get('Table')->get('Inductions')->delete($c);
                    }
                }
                $this->Flash->success(__('The contractor has been removed.'));
            } else {
                $this->Flash->error(__('The contractor could not be removed. Please, try again.'));
            }
        } else {
            $this->Flash->error(__('No contractor selected.'));
        }
        return $this->redirect(['controller' => 'projects', 'action' => 'view', $id]);

    }
}
