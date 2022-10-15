<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $id
 * @property bool $is_admin
 * @property string $role
 * @property string $status
 * @property string $first_name
 * @property string $last_name
 * @property string $address_no
 * @property string $address_street
 * @property string $address_suburb
 * @property string $address_state
 * @property string $address_postcode
 * @property string $address_country
 * @property string $email
 * @property string $password
 * @property string|null $phone_mobile
 * @property string|null $phone_office
 * @property string $emergency_name
 * @property string $emergency_relationship
 * @property string $emergency_phone
 *
 * @property \App\Model\Entity\Checkin[] $checkins
 * @property \App\Model\Entity\Induction[] $inductions
 * @property \App\Model\Entity\Signature[] $signatures
 * @property \App\Model\Entity\Company[] $companies
 */
class User extends Entity
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
        'is_admin' => true,
        'role' => true,
        'status' => true,
        'first_name' => true,
        'last_name' => true,
        'address_no' => true,
        'address_street' => true,
        'address_suburb' => true,
        'address_state' => true,
        'address_postcode' => true,
        'address_country' => true,
        'email' => true,
        'password' => true,
        'phone_mobile' => true,
        'phone_office' => true,
        'emergency_name' => true,
        'emergency_relationship' => true,
        'emergency_phone' => true,
        'checkins' => true,
        'inductions' => true,
        'signatures' => true,
        'companies' => true,
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array<string>
     */
    protected $_hidden = [
        'password',
    ];
    /**
     * @var mixed
     */
}
