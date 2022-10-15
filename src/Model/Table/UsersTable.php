<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Users Model
 *
 * @property \App\Model\Table\CheckinsTable&\Cake\ORM\Association\HasMany $Checkins
 * @property \App\Model\Table\InductionsTable&\Cake\ORM\Association\HasMany $Inductions
 * @property \App\Model\Table\SignaturesTable&\Cake\ORM\Association\HasMany $Signatures
 * @property \App\Model\Table\CompaniesTable&\Cake\ORM\Association\BelongsToMany $Companies
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class UsersTable extends Table
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('Checkins', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Inductions', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('Signatures', [
            'foreignKey' => 'user_id',
        ]);
        $this->belongsToMany('Companies', [
            'foreignKey' => 'user_id',
            'targetForeignKey' => 'company_id',
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
            ->boolean('is_admin')
            ->notEmptyString('is_admin');

        $validator
            ->scalar('role')
            ->requirePresence('role', 'create')
            ->notEmptyString('role');

        $validator
            ->scalar('status')
            ->notEmptyString('status');

        $validator
            ->scalar('first_name')
            ->maxLength('first_name', 50)
            ->requirePresence('first_name', 'create')
            ->notEmptyString('first_name');

        $validator
            ->scalar('last_name')
            ->maxLength('last_name', 50)
            ->requirePresence('last_name', 'create')
            ->notEmptyString('last_name');

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
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('password')
            ->maxLength('password', 128)
            ->requirePresence('password', 'create')
            ->notEmptyString('password');

        $validator
            ->scalar('phone_mobile')
            ->maxLength('phone_mobile', 15)
            ->allowEmptyString('phone_mobile');

        $validator
            ->scalar('phone_office')
            ->maxLength('phone_office', 15)
            ->allowEmptyString('phone_office');

        $validator
            ->scalar('emergency_name')
            ->maxLength('emergency_name', 100)
            ->requirePresence('emergency_name', 'create')
            ->notEmptyString('emergency_name');

        $validator
            ->scalar('emergency_relationship')
            ->maxLength('emergency_relationship', 50)
            ->requirePresence('emergency_relationship', 'create')
            ->notEmptyString('emergency_relationship');

        $validator
            ->scalar('emergency_phone')
            ->maxLength('emergency_phone', 15)
            ->requirePresence('emergency_phone', 'create')
            ->notEmptyString('emergency_phone');

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
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);

        return $rules;
    }
}
