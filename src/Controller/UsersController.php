<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\FactoryLocator;
use Cake\Mailer\TransportFactory;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\TableRegistry;
use Cake\Utility\Security;
use Cake\Mailer\Mailer;

define('PRIVATE_CODE', 'shining_glass');
/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
        $this->Authentication->addUnauthenticatedActions(['login', 'signup', 'forgot', 'requestpassword', 'verify']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $user = $this->Users->newEmptyEntity();
        $this->Authorization->authorize($user);

        $users = $this->paginate($this->Users);

        $this->set(compact('users'));

    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $currentUser = $this->request->getAttribute('identity');
        $user = $this->Users->get($id, [
            'contain' => ['Companies', 'Signatures', 'Checkins', 'Inductions'],
        ]);

        $this->Authorization->authorize($user);

        $employerAccess = FALSE;
        //Code here that sets acccess to TRUE if currentuser is the user's employer

        $assignedProjects = FactoryLocator::get('Table')->get('Inductions')->find();
        $assignedProjects->select(['id', 'inducted_date', 'project_id' => 'projects.id', 'project_name' => 'projects.name'])->join([
            "table" => "projects",
            "type" => "LEFT",
            "conditions" => "Inductions.project_id = projects.id"
            ])->where(['user_id' => $currentUser->id])->enableAutoFields();

        $documents = FactoryLocator::get('Table')->get('Documents')->find()->where([
            'related_user_id' => $id
        ]);

        $this->set(compact('user', 'employerAccess', 'assignedProjects', 'documents'));
    }


    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id);
        $this->Authorization->authorize($user);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Changes saved.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The changes could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        /*
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
        */
    }

    public function login()
    {
        $this->Authorization->skipAuthorization();
        $redirect = FALSE;
        if ($this->request->getQuery('redirect')) {
            $redirect = $this->request->getQuery('redirect');
        }
        $this->set(compact('redirect'));

        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        if ($result && $result->isValid()) {
            if ($redirect) {
                return $this->redirect($redirect);
            } else {
                return $this->redirect(['controller' => 'projects', 'action' => 'index']);
            }
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Invalid username or password'));
        }
    }

    public function logout()
    {
        $this->Authorization->skipAuthorization();
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success(__('Logout Successful.'));
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
    }

    public function signup()
    {
        $this->Authorization->skipAuthorization();

        $hashing = new DefaultPasswordHasher();
        $password = $this->request->getData('password');
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {

            $user = $this->Users->patchEntity($user, $this->request->getData());
            $hashed_password = $hashing->hash($password);
            $user->password = $hashed_password;

            $role = $this->request->getData('role');
            if ($role == 'Employee'){
                $role = 'On-site Worker';
                if(!$this->request->getData('company_name')){
                    $this->Flash->error(__('Error creating account. Please fill out all fields, including your company.'));
                    return $this->redirect(['?' => ['role' => $this->request->getData('role')]]);
                }
            }
            $user->role = $role;

            if ($this->Users->save($user)) {
                if($this->request->getData('company_name')){
                    $company = explode('[', $this->request->getData('company_name'));
                    $company = explode(']', $company[1]);
                    $company_id = $company[0];
                    $companies = FactoryLocator::get('Table')->get('CompaniesUsers')->find();
                    $companies->insert(['company_id', 'user_id'])
                        ->values([
                            'company_id' => $company_id,
                            'user_id' => $user->id])
                        ->execute();
                }

                // email verification
                $code = md5($user->password . PRIVATE_CODE);
                $mailer = new Mailer('default');
                $mailer
                    ->setEmailFormat('html')
                    ->setFrom(['sitex@u22s1010.monash-ie.me' => 'SiteX'])
                    ->setTo($user->email)
                    ->setSubject('SiteX Account verification')
                    ->viewBuilder()
                    ->setTemplate('verification');

                $mailer ->setViewVars([
                    'id'=>$user->id,
                    'email' => $this->request->getData('email'),
                    'name' => $user->first_name,
                    'code' => $code,
                ]);

                // Deliver mail
                if ($mailer->deliver()){
                    //$this->Flash->success(__('Verification email sent.'));
                } else {
                    $this->Flash->error(__('Failed to send verification email.'));
                }

                if ($role == 'Builder' || $role == 'Contractor'){
                    $this->Flash->success(__('Account created. Please log in and add your business details to continue.'));
                    return $this->redirect(['controller' => 'companies', 'action' => 'add']);
                } else {
                    $this->Flash->success(__('Account successfully created. You can now log in.'));
                    return $this->redirect(['controller' => 'projects', 'action' => 'index']);
                }

            }
            $this->Flash->error(__('Error creating account. Please make sure your email address is valid and try again. Try something like siteX@siteX.com'));
            // return $this->redirect(['?' => ['role' => $this->request->getData('role')]]);
        }
        $companies = FactoryLocator::get('Table')->get('Companies')->find();

        $this->set(compact('user', 'companies'));
    }

    public function forgot()
    {
        $this->Authorization->skipAuthorization();

        $hashing = new DefaultPasswordHasher();

        if ($this->request->is('post')) {
            $user = $this->Users->find('all', array(
                'conditions' => array('email' => $this->request->getData('email'))
            ))->first();
            if (!$user) {
                //$this->Flash->error(__('This email is not registered.'));
            } else {
                $correctCode = md5($user->password . PRIVATE_CODE);
                if ($this->request->getData('code') == $correctCode) {
                    $password = $this->request->getData('password');
                    $hashed_password = $hashing->hash($password);
                    $user->password = $hashed_password;
                    if ($this->Users->save($user)) {

                        $this->Flash->success(__('Password updated, please log in.'));

                        return $this->redirect([
                            'controller' => 'Users',
                            'action' => 'login',
                            '?' => array('result' => 'reset')
                        ]);
                    }
                    $this->Flash->error(__('The password could not be updated. Please, try again.'));
                } else {
                    $this->Flash->error(__('This link has expired. Please request a new password reset email.'));
                }
            }
        }
    }

    public function requestpassword()
    {
        $this->Authorization->skipAuthorization();

        if ($this->request->is('post')) {

            $recipient = $this->getTableLocator()->get('Users')
                ->find()
                ->where(['email =' => $this->request->getData('email')])
                ->first();
            if (!$recipient) {
                $this->Flash->error(__('This email is not registered.'));
            } else {
                $code = md5($recipient->password . PRIVATE_CODE);

                $mailer = new Mailer('default');
                $mailer
                    ->setEmailFormat('html')
                    ->setFrom(['sitex_noreply@u22s1010.monash-ie.me' => 'SiteX [No Reply]'])
                    ->setTo($recipient->email)
                    ->setSubject('SiteX password reset request')
                    ->viewBuilder()
                    ->setTemplate('resetpassword');

                $mailer->setViewVars([
                    'email' => $this->request->getData('email'),
                    'name' => $recipient->first_name,
                    'code' => $code,
                ]);

                // Deliver mail
                if ($mailer->deliver()) {
                    $this->Flash->success(__('Password reset email sent.'));
                } else {
                    $this->Flash->error(__('Failed to send password reset email.'));
                }
            }

            return $this->redirect(['action' => 'requestpassword']);
        }
    }

     public function verify()
     {
        $this->Authorization->skipAuthorization();

        $id = $this->request->getQuery('id');
        $user = $this->Users->get($id);

        $correctCode = md5($user->password . PRIVATE_CODE);
        $code = $this->request->getQuery('code');

        if ($code == $correctCode){
            $user->status ='Verified';
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Your account has been verified'));
                return $this->redirect(['controller' => 'projects', 'action' => 'index']);
            }
            $this->Flash->error(__('account could not be verified'));
        }
     }
}
