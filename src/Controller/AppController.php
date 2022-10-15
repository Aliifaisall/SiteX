<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use App\Model\Table\ProjectsTable;
use Cake\Controller\Controller;
use Cake\Datasource\FactoryLocator;
use Cake\Event\EventInterface;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function beforeRender(EventInterface  $event)
    {
        $this->viewBuilder()->setTheme('AdminLTE');
        $this->viewBuilder()->setClassName('AdminLTE.AdminLTE');

        $session = $this->getRequest()->getSession();
        $session->write('hasPendingDocuments', FALSE);

        $currentUser = $this->request->getAttribute('identity');
        if($currentUser){
            $signatures = FactoryLocator::get('Table')->get('Signatures')->find();
            $unsignedDocuments = $signatures->select(['document_id'])->where(['user_id' => $currentUser->id])->where(['signed_datetime is' => NULL])->enableAutoFields();
            if($unsignedDocuments->count() > 0){
                $session->write('hasPendingDocuments', TRUE);
            }

            $employer = FactoryLocator::get('Table')->get('CompaniesUsers')->find()->select(['company_id'])
                ->where([
                    'user_id' => $currentUser->id,
                ])->first();
            if ($employer){
                $session->write('company_id', $employer->company_id);
            } else {
                $session->write('company_id', 0);
                $controller = $this->request->getParam('controller');
                $action = $this->request->getParam('action');
                if ($currentUser->role == 'Contractor' || $currentUser->role == 'Builder'){
                    if ($controller == 'Companies' && $action == 'add'){
                        //All is right with the world.
                    } else {
                        return $this->redirect(['controller' => 'companies', 'action' => 'add']);
                    }
                } else {
                    if ($controller == 'Companies' && $action == 'change'){
                        //All is right with the world.
                    } else {
                        return $this->redirect(['controller' => 'companies', 'action' => 'change']);
                    }
                }
            }
        }
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['controller' => 'Pages', 'action' => 'display', 'home']);
        $this->Authentication->addUnauthenticatedActions(['controller' => 'Checkins', 'action' => 'reminders']);
    }
}
