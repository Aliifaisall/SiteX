<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Projects Model
 *
 * @property \App\Model\Table\UsersTable&\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\CheckinsTable&\Cake\ORM\Association\HasMany $Checkins
 * @property \App\Model\Table\InductionsTable&\Cake\ORM\Association\HasMany $Inductions
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsToMany $Companies
 *
 * @method \App\Model\Entity\Project newEmptyEntity()
 * @method \App\Model\Entity\Project newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Project[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Project get($primaryKey, $options = [])
 * @method \App\Model\Entity\Project findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Project patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Project[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Project|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Project saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Project[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Project[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Project[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Project[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ProjectsTable extends Table
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

        $this->setTable('projects');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'builder_id',
        ]);
        $this->hasMany('Checkins', [
            'foreignKey' => 'project_id',
        ]);
        $this->hasMany('Inductions', [
            'foreignKey' => 'project_id',
        ]);
        $this->belongsToMany('Companies', [
            'foreignKey' => 'project_id',
            'targetForeignKey' => 'company_id',
            'joinTable' => 'companies_projects',
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
            ->scalar('project_type')
            ->notEmptyString('project_type');

        $validator
            ->scalar('name')
            ->maxLength('name', 50)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->nonNegativeInteger('builder_id')
            ->allowEmptyString('builder_id');

        $validator
            ->scalar('client_name')
            ->maxLength('client_name', 50)
            ->requirePresence('client_name', 'create')
            ->notEmptyString('client_name');

        $validator
            ->scalar('client_email')
            ->maxLength('client_email', 320)
            ->requirePresence('client_email', 'create')
            ->notEmptyString('client_email');

        $validator
            ->scalar('client_phone')
            ->maxLength('client_phone', 15)
            ->requirePresence('client_phone', 'create')
            ->notEmptyString('client_phone');

        $validator
            ->date('start_date')
            ->allowEmptyDate('start_date');

        $validator
            ->date('est_completion_date')
            ->allowEmptyDate('est_completion_date');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

        $validator
            ->date('completion_date')
            ->allowEmptyDate('completion_date');

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
        $rules->add($rules->existsIn('builder_id', 'Users'), ['errorField' => 'builder_id']);

        return $rules;
    }
}
