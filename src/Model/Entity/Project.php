<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Project Entity
 *
 * @property int $id
 * @property string $project_type
 * @property string $name
 * @property int|null $builder_id
 * @property string $client_name
 * @property string $client_email
 * @property string $client_phone
 * @property \Cake\I18n\FrozenDate|null $start_date
 * @property \Cake\I18n\FrozenDate|null $est_completion_date
 * @property string $status
 * @property \Cake\I18n\FrozenDate|null $completion_date
 * @property string $address_no
 * @property string $address_street
 * @property string $address_suburb
 * @property string $address_state
 * @property string $address_postcode
 * @property string $address_country
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Checkin[] $checkins
 * @property \App\Model\Entity\Induction[] $inductions
 * @property \App\Model\Entity\Company[] $companies
 */
class Project extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'project_type' => true,
        'name' => true,
        'builder_id' => true,
        'client_name' => true,
        'client_email' => true,
        'client_phone' => true,
        'start_date' => true,
        'est_completion_date' => true,
        'status' => true,
        'completion_date' => true,
        'address_no' => true,
        'address_street' => true,
        'address_suburb' => true,
        'address_state' => true,
        'address_postcode' => true,
        'address_country' => true,
        'user' => true,
        'checkins' => true,
        'inductions' => true,
        'companies' => true,
    ];
}
