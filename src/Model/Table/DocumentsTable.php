<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Documents Model
 *
 * @property \App\Model\Table\ProjectsTable&\Cake\ORM\Association\BelongsTo $Projects
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsTo $Companies
 * @property \App\Model\Table\SignaturesTable&\Cake\ORM\Association\HasMany $Signatures
 *
 * @method \App\Model\Entity\Document newEmptyEntity()
 * @method \App\Model\Entity\Document newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Document[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Document get($primaryKey, $options = [])
 * @method \App\Model\Entity\Document findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Document patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Document[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Document|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Document saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Document[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Document[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Document[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Document[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class DocumentsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('documents');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Projects', [
            'foreignKey' => 'related_project_id',
        ]);
        $this->belongsTo('Users', [
            'foreignKey' => 'related_user_id',
        ]);
        $this->belongsTo('Companies', [
            'foreignKey' => 'related_company_id',
        ]);
        $this->hasMany('Signatures', [
            'foreignKey' => 'document_id',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('details')
            ->maxLength('details', 250)
            ->allowEmptyString('details');

        $validator
            ->scalar('document_no')
            ->maxLength('document_no', 50)
            ->allowEmptyString('document_no');

        $validator
            ->scalar('document_type')
            ->requirePresence('document_type', 'create')
            ->notEmptyString('document_type');

        $validator
            ->boolean('worker_accessible')
            ->allowEmptyString('worker_accessible');

        $validator
            ->scalar('class')
            ->maxLength('class', 50)
            ->allowEmptyString('class');

        $validator
            ->scalar('issuer')
            ->maxLength('issuer', 50)
            ->allowEmptyString('issuer');

        $validator
            ->date('issue_date')
            ->allowEmptyDate('issue_date');

        $validator
            ->date('expiry_date')
            ->allowEmptyDate('expiry_date');

        $validator
            ->scalar('declaration_text')
            ->maxLength('declaration_text', 500)
            ->allowEmptyString('declaration_text');

        $validator
            ->nonNegativeInteger('related_project_id')
            ->allowEmptyString('related_project_id');

        $validator
            ->nonNegativeInteger('related_user_id')
            ->allowEmptyString('related_user_id');

        $validator
            ->nonNegativeInteger('related_company_id')
            ->allowEmptyString('related_company_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('related_project_id', 'Projects'), ['errorField' => 'related_project_id']);
        $rules->add($rules->existsIn('related_user_id', 'Users'), ['errorField' => 'related_user_id']);
        $rules->add($rules->existsIn('related_company_id', 'Companies'), ['errorField' => 'related_company_id']);

        return $rules;
    }
}
