<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\FactoryLocator;
use Cake\I18n\FrozenTime;

/**
 * Documents Controller
 *
 * @property \App\Model\Table\DocumentsTable $Documents
 * @method \App\Model\Entity\Document[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class DocumentsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $document = $this->Documents->newEmptyEntity();
        $this->Authorization->authorize($document);
        $documents = $this->paginate($this->Documents);

        $this->set(compact('documents'));
    }

    /**
     * View method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $document = $this->Documents->get($id, [
            'contain' => ['Projects', 'Users'],
        ]);
        $this->Authorization->authorize($document);

        $this->set(compact('document'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $document = $this->Documents->newEmptyEntity();
        $this->Authorization->authorize($document);
        $projectid = $this->request->getQuery('project');

        if ($this->request->is('post')) {
            $file = $this->request->getData('file_upload');
            $document = $this->Documents->patchEntity($document, $this->request->getData());
            $relation_id = $this->request->getData('relation_id');
            $document_relation = $this->request->getData('document_relation');
            $fileDestination = "";
            $signaturerequired = $this->request->getData('requires_signature');

            if ($document_relation == 'user'){
                //Upload to user's personal document folder Personal/user->id
                $directory = WWW_ROOT.'uploads'.DS.'Personal'.DS.$relation_id.DS;
                $document->related_user_id = $relation_id;
                is_dir($directory) || mkdir($directory);
            } elseif ($document_relation == 'project'){
                //Upload documents to Induction/project->id
                $directory = WWW_ROOT.'uploads'.DS.'Induction'.DS.$relation_id.DS;
                $document->related_project_id = $relation_id;
                is_dir($directory) || mkdir($directory);
            } elseif ($document_relation == 'company'){
                //Upload documents to company folder
                $directory = WWW_ROOT.'uploads'.DS.'Company'.DS.$relation_id.DS;
                $document->related_company_id = $relation_id;
                is_dir($directory) || mkdir($directory);
                if ($this->request->getData('worker_accessible')){
                    $document->worker_accessible = 1;
                } else {
                    $document->worker_accessible = 0;
                }
            } else {
                $this->Flash->error(__('Error getting document relationship. Please try again.'));
                return $this->redirect(['action' => 'add']);
            }

            if ($this->Documents->save($document)) {

                $fileDestination = $directory.h($document->id).'.pdf';
                $file->moveTo($fileDestination);

                if($signaturerequired == 'y'){
                $signaturesTable = FactoryLocator::get('Table')->get('Signatures')->find();
                $isInducted = FactoryLocator::get('Table')->get('Inductions')->find()->where([
                    'project_id' => $projectid
                ]);
                foreach($isInducted as $inductee){
                    $signaturesTable -> insert(['Document_id', 'User_id'])
                        ->values([
                            'Document_id' => $document -> id,
                            'User_id' => $inductee -> user_id
                        ])
                        ->execute();
                    }
                }
                $this->Flash->success(__('Document Saved'));
                if ($document_relation == 'user'){
                    return $this->redirect(['controller' => 'users', 'action' => 'view', $relation_id]);
                } elseif ($document_relation == 'project'){
                    return $this->redirect(['controller' => 'projects', 'action' => 'index']);
                } elseif ($document_relation == 'company'){
                    return $this->redirect(['controller' => 'companies', 'action' => 'view', $relation_id]);
                }
            }
            $this->Flash->error(__('The document could not be saved. Please try again.'));
        }

        $this->set(compact('document'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $document = $this->Documents->get($id, [
            'contain' => ['Projects', 'Users'],
        ]);
        $this->Authorization->authorize($document);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $document = $this->Documents->patchEntity($document, $this->request->getData());
            if ($this->Documents->save($document)) {
                $this->Flash->success(__('The document has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The document could not be saved. Please, try again.'));
        }
        $projects = $this->Documents->Projects->find('list', ['limit' => 200])->all();
        $users = $this->Documents->Users->find('list', ['limit' => 200])->all();
        $this->set(compact('document', 'projects', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Document id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $document = $this->Documents->get($id);
        $this->Authorization->authorize($document);
        if ($this->Documents->delete($document)) {
            $this->Flash->success(__('The document has been deleted.'));
        } else {
            $this->Flash->error(__('The document could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function review($id = null)
    {
        $document = $this->Documents->get($id, [
            'contain' => ['Projects'],
        ]);
        $this->Authorization->authorize($document);
        $this->set(compact('document'));

        if ($this->request->is("post") && $this->request->getData('signed') == NULL && $this->request->getData('signature') != 'Y'){
            $this->Flash->error("A signature is required.");
        } elseif ($this->request->is("post") && $this->request->getData('signature') == 'Y'){
            $currentUser = $this->request->getAttribute('identity');
            $record_id = $this->request->getQuery('rid');

            $documentsUser = FactoryLocator::get('Table')->get('Signatures');
            $record = $documentsUser->get($record_id);
            $record->signed_datetime = date('Y-m-d H:i:s');

            if ($documentsUser->save($record)) {
                $projects = FactoryLocator::get('Table')->get('Projects')->find();
                $project = $projects->where(['id' => $document->related_project_id])->first();

                $signatures = FactoryLocator::get('Table')->get('Signatures')->find();
                $signatures->select(['project_name' => 'projects.name'])->join([
                    "table" => "documents",
                    "type" => "LEFT",
                    "conditions" => "Signatures.document_id = documents.id"])->join([
                    "table" => "projects",
                    "type" => "LEFT",
                    "conditions" => "documents.related_project_id = projects.id"])->where([
                    'user_id' => $currentUser->id,
                    'documents.related_project_id' => $project->id,
                    'signed_datetime is' => NULL
                ])->enableAutoFields();

                if ($signatures->count() == 0){
                    $currentDate = FrozenTime::now();
                    $currentDate->i18nFormat('y-MM-dd');
                    $inductions = FactoryLocator::get('Table')->get('Inductions')->find();
                    $inductions->update()
                        ->set(['inducted_date' => $currentDate])
                        ->where([
                            'project_id' => $project->id,
                            'user_id' => $currentUser->id])
                        ->execute();
                    $this->Flash->success("Signature saved. Induction complete for ".$project->name);
                } else {
                    $this->Flash->success("Signature saved successfully");
                }
            } else {
                $this->Flash->error(__('The signing activity could not be recorded.'));
            }

            return $this->redirect(['controller' => 'signatures', 'action' => 'pending']);
        } elseif ($this->request->is("post")) {
            // To save a signature
            $file_string = $this->request->getData('signed');
            $image = explode(";base64,", $file_string);
            $image_type = explode("image/", $image[0]);
            $image_type_png = $image_type[1];
            $image_base64 = 'base64_decode'($image[1]);
            $folderPath = WWW_ROOT . 'uploads/Signature/';
            $file = $folderPath . $document->id . '.' . $image_type_png;
            file_put_contents($file, $image_base64);

            $currentUser = $this->request->getAttribute('identity');
            $record_id = $this->request->getQuery('rid');

            $documentsUser = FactoryLocator::get('Table')->get('Signatures');
            $record = $documentsUser->get($record_id);
            $record->signed_datetime = date('Y-m-d H:i:s');

            if ($documentsUser->save($record)) {
                $projects = FactoryLocator::get('Table')->get('Projects')->find();
                $project = $projects->where(['id' => $document->related_project_id])->first();

                $signatures = FactoryLocator::get('Table')->get('Signatures')->find();
                $signatures->select(['project_name' => 'projects.name'])->join([
                    "table" => "documents",
                    "type" => "LEFT",
                    "conditions" => "Signatures.document_id = documents.id"])->join([
                    "table" => "projects",
                    "type" => "LEFT",
                    "conditions" => "documents.related_project_id = projects.id"])->where([
                    'user_id' => $currentUser->id,
                    'documents.related_project_id' => $project->id,
                    'signed_datetime is' => NULL
                ])->enableAutoFields();

                if ($signatures->count() == 0){
                    $currentDate = FrozenTime::now();
                    $currentDate->i18nFormat('y-MM-dd');
                    $inductions = FactoryLocator::get('Table')->get('Inductions')->find();
                    $inductions->update()
                        ->set(['inducted_date' => $currentDate])
                        ->where([
                            'project_id' => $project->id,
                            'user_id' => $currentUser->id])
                        ->execute();
                    $this->Flash->success("Signature saved. Induction complete for ".$project->name);
                } else {
                    $this->Flash->success("Signature saved successfully");
                }
            } else {
                $this->Flash->error(__('The signing activity could not be recorded.'));
            }
            return $this->redirect(['controller' => 'signatures', 'action' => 'pending']);
        }

    }

    public function download($id = null)
    {
        $this->Authorization->skipAuthorization();
        $document = $this->Documents->get($id);
        if ($document->related_project_id){
            $document_type = 'Induction';
            $related_id = $document->related_project_id;
        } elseif ($document->related_company_id){
            $document_type = 'Company';
            $related_id = $document->related_company_id;
        } elseif ($document->related_user_id){
            $document_type = 'Personal';
            $related_id = $document->related_user_id;
        } else {
            $this->Flash->error(__('Error, no valid file found.'));
        }
        $fileDestination = WWW_ROOT.'uploads'.DS.$document_type.DS.$related_id.DS.$document->id.'.pdf';
        // create an if statement
        if (file_exists($fileDestination)) {
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="'.$document->name.'.pdf"');
            //download
            header('Content-Length: ' . filesize($fileDestination));
            debug(readfile($fileDestination));
        } else {
            $this->Flash->error(__('Error. Could not download PDF.'));
        }
    }
}
