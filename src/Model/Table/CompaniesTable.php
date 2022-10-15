<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Companies Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ProjectsTable&\Cake\ORM\Association\BelongsToMany $Projects
 *
 * @method \App\Model\Entity\Company newEmptyEntity()
 * @method \App\Model\Entity\Company newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Company[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Company get($primaryKey, $options = [])
 * @method \App\Model\Entity\Company findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Company patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Company[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Company|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Company saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Company[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Company[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Company[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Company[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CompaniesTable extends Table
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

        $this->setTable('companies');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'admin_id',
        ]);
        $this->belongsToMany('Projects', [
            'foreignKey' => 'company_id',
            'targetForeignKey' => 'project_id',
            'joinTable' => 'companies_projects',
        ]);
        $this->belongsToMany('Users', [
            'foreignKey' => 'company_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'companies_users',
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
            ->nonNegativeInteger('admin_id')
            ->allowEmptyString('admin_id');

        $validator
            ->scalar('company_type')
            ->allowEmptyString('company_type');

        $validator
            ->nonNegativeInteger('abn')
            ->requirePresence('abn', 'create')
            ->notEmptyString('abn');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('address_no')
            ->maxLength('address_no', 10)
            ->requirePresence('address_no', 'create')
            ->notEmptyString('address_no');

        $validator
            ->scalar('address_street')
            ->maxLength('address_street', 50)
            ->requirePresence('address_street', 'create')
            ->notEmptyString('address_street');

        $validator
            ->scalar('address_suburb')
            ->maxLength('address_suburb', 50)
            ->requirePresence('address_suburb', 'create')
            ->notEmptyString('address_suburb');

        $validator
            ->scalar('address_state')
            ->maxLength('address_state', 50)
            ->requirePresence('address_state', 'create')
            ->notEmptyString('address_state');

        $validator
            ->scalar('address_postcode')
            ->maxLength('address_postcode', 20)
            ->requirePresence('address_postcode', 'create')
            ->notEmptyString('address_postcode');

        $validator
            ->scalar('address_country')
            ->maxLength('address_country', 50)
            ->requirePresence('address_country', 'create')
            ->notEmptyString('address_country');

        $validator
            ->scalar('contact_name')
            ->maxLength('contact_name', 50)
            ->requirePresence('contact_name', 'create')
            ->notEmptyString('contact_name');

        $validator
            ->scalar('contact_email')
            ->maxLength('contact_email', 320)
            ->requirePresence('contact_email', 'create')
            ->notEmptyString('contact_email');

        $validator
            ->scalar('contact_phone')
            ->maxLength('contact_phone', 15)
            ->requirePresence('contact_phone', 'create')
            ->notEmptyString('contact_phone');

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
        $rules->add($rules->existsIn('admin_id', 'Users'), ['errorField' => 'admin_id']);

        return $rules;
    }
}
