<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Datasource\FactoryLocator;
use Cake\I18n\FrozenTime;
use DateInterval;
use Cake\Mailer\Mailer;

/**
 * Checkins Controller
 *
 * @property \App\Model\Table\CheckinsTable $Checkins
 * @method \App\Model\Entity\Checkin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */

class CheckinsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {

        $checkin = $this->Checkins->newEmptyEntity();
        $this->Authorization->authorize($checkin);
        $key = $this->request->getQuery('key');
        $type = $this->request->getQuery('type');
        $target_date_time = $this->request->getQuery('date');


        $maxHours = 8;

        $this->paginate = [
            'contain' => ['Projects', 'Users'],
        ];

        $project = FactoryLocator::get('Table')->get('Projects')->get($this->request->getQuery('project'));
        $checkins = FactoryLocator::get('Table')->get('Checkins')->find();
        $checkins->select(['id', 'checkin_datetime', 'checkout_datetime', 'user_id', 'company_id' => 'inductions.company_id',
            'company_name' => 'companies.name', 'fname' => 'u2.first_name', 'lname' => 'u2.last_name','full_name'=>'concat(u2.first_name,u2.last_name)',
            'role' => 'u2.role',
        ])->join([
            "table" => "users u2",
            "type" => "LEFT",
            "conditions" => "Checkins.user_id = u2.id"
        ])->join([
            "table" => "inductions",
            "type" => "LEFT",
            "conditions" => "Checkins.user_id = inductions.user_id"
        ])->join([
            "table" => "companies",
            "type" => "LEFT",
            "conditions" => "inductions.company_id = companies.id"
        ])->where([
            'Checkins.project_id' => $project->id
        ])->enableAutoFields();


        $currentDateTime = FrozenTime::now();
        $currentDateTime->i18nFormat('y-MM-dd H:i:s');

        $search_words = 0;
        if ($key){$search_words = $key;}

        if ($type == 0){
            if ($key) {$checkins->find('all')->where(['companies.name like' => '%' . $key . '%' ] );}
        } elseif ($type == 1){
            $key = str_replace(' ', '', $key);
            if ($key) {$checkins->find('all')->where(['concat(u2.first_name, u2.last_name) like' => '%' . $key . '%'] );}
        }

        if ($this->request->getQuery('type') && $search_words == 0){
            $this->Flash->error(__('Please enter search terms.'));
        }

        if($target_date_time){
            $target_date_time = str_replace('/','-', $target_date_time);
            $checkins->find('all')->where(['checkin_datetime like' => $target_date_time . '%'] );
        }

        $checkins = $this->paginate($checkins);
        $this->set(compact('checkins', 'currentDateTime', 'maxHours', 'project','search_words','type', 'target_date_time'));
    }

    /**
     * View method
     *
     * @param string|null $id Checkin id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $checkin = $this->Checkins->get($id, [
            'contain' => ['Projects', 'Users'],
        ]);

        $this->Authorization->authorize($checkin);

        $this->set(compact('checkin'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $checkin = $this->Checkins->newEmptyEntity();
        $this->Authorization->authorize($checkin);

        $currentUser = $this->request->getAttribute('identity');
        $projectsTable = FactoryLocator::get('Table')->get('Projects');
        $project = $projectsTable->get($this->request->getQuery('project'));

        $inducted = FactoryLocator::get('Table')->get('Inductions')->find()->where([
            'user_id' => $currentUser->id,
            'project_id' => $project->id
        ])->first();

        if ($inducted->inducted_date == NULL && $inducted->user_id == NULL){
            $this->Flash->error(__('You are not assigned to this project.'));
            return $this->redirect(['controller' => 'projects', 'action' => 'index']);
        } elseif ($inducted->inducted_date == NULL){
            $this->Flash->error(__('Please complete your induction before checking in.'));
            return $this->redirect(['controller' => 'signatures', 'action' => 'pending']);
        }

        $checkout = FALSE;
        $maxHours = 8;
        $currentDateTime = FrozenTime::now();
        $currentDateTime->i18nFormat('y-MM-dd H:i:s');

        $checkoutsMissing = $this->Checkins->find()->where([
            'project_id' => $project->id,
            'user_id' => $currentUser->id,
            'checkout_datetime is' => NULL,
        ]);

        foreach ($checkoutsMissing as $checkoutMissing){
            $checkOutLimit = $checkoutMissing->checkin_datetime->add(new DateInterval("PT{$maxHours}H"));
            if($checkOutLimit > $currentDateTime) {
                $selectedCheckout = $checkoutMissing;
                $checkout = TRUE;
            }
        }

        if ($checkout){
            $selectedCheckout->checkout_datetime = date('Y-m-d H:i:s');
            if ($this->Checkins->save($selectedCheckout)) {
                $this->Flash->success(__('Checkout successful.'));
                return $this->redirect(['controller' => 'projects', 'action' => 'index']);
            }
        }

        if (!$checkout) {
            $checkin = $this->Checkins->patchEntity($checkin, $this->request->getData());
            $checkin->project_id = $project->id;
            $checkin->user_id = $currentUser->id;
            $checkin->checkin_datetime = date('Y-m-d H:i:s');

            if ($this->Checkins->save($checkin)) {
                $this->Flash->success(__('Checkin successful.'));

                return $this->redirect(['controller' => 'projects', 'action' => 'index']);
            }
            $this->Flash->error(__('The checkin could not be saved. Please, try again.'));
        }

        $this->set(compact('checkin', 'project', 'checkout'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Checkin id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $checkin = $this->Checkins->get($id, [
            'contain' => [],
        ]);
        $this->Authorization->authorize($checkin);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $checkin = $this->Checkins->patchEntity($checkin, $this->request->getData());
            $checkin->checkout_datetime = date('Y-m-d H:i:s');
            if ($this->Checkins->save($checkin)) {
                $this->Flash->success(__('The checkin has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The checkin could not be saved. Please, try again.'));
        }
        $projects = $this->Checkins->Projects->find('list', ['limit' => 200])->all();
        $users = $this->Checkins->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('checkin', 'projects', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Checkin id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $checkin = $this->Checkins->get($id);
        $this->Authorization->authorize($checkin);
        if ($this->Checkins->delete($checkin)) {
            $this->Flash->success(__('The checkin has been deleted.'));
        } else {
            $this->Flash->error(__('The checkin could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    public function reminders($id = null)
    {
        $this->Authorization->skipAuthorization();

        $checkInList = FactoryLocator::get('Table')->get('Checkins')->find();
        $checkInList->select(['id' => 'Checkins.id', 'projectid' => 'Checkins.project_id', 'user_id' => 'u2.id', 'user_email' => 'u2.email', 'user_firstName' => 'u2.first_name', 'checkin_time' => 'Checkins.checkin_datetime', 'checkin_sent' => 'Checkins.email_sent'])
            ->join([
                "table" => "users u2",
                "type" => "LEFT",
                "conditions" => "user_id = u2.id"
            ])->where([
                'checkout_datetime IS' => NULL
            ]);
        $currentDateTime = FrozenTime::now();
        $currentDateTime->i18nFormat('y-MM-dd H:i:s');
        $maxHours = 8;

            foreach($checkInList as $recipient) {
                $site = FactoryLocator::get('Table')->get('Projects')->get($recipient->projectid);
                $checkoutLimit = $recipient->checkin_time->add(new DateInterval("PT{$maxHours}H"));
                if($currentDateTime > $checkoutLimit && $recipient -> checkin_sent != 1) {

                $mailer = new Mailer('default');
                $mailer
                    ->setEmailFormat('html')
                    ->setFrom(['sitex_noreply@u22s1010.monash-ie.me' => 'SiteX [No Reply]'])
                    ->setTo($recipient->user_email)
                    ->setSubject('SiteX: Reminder to check out of site')
                    ->viewBuilder()
                    ->setTemplate('checkoutreminder');

                $mailer->setViewVars([
                    'email' => $this->request->getData('email'),
                    'name' => $recipient->first_name,
                    'site' => $site->name,
                ]);

                // Deliver mail
                if ($mailer->deliver()) {
                    $this->Flash->success(__('Reminder has been sent.'));
                    $recipient -> email_sent = 1;
                    $this->Checkins->save($recipient);

                } else {
                    $this->Flash->error(__('Failed to send reminder email.'));
                }
            }
        }
        $this->redirect(['controller' => 'users', 'action' => 'login']);
    }
}
