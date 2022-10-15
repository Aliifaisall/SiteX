<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Company Entity
 *
 * @property int $id
 * @property int|null $admin_id
 * @property string|null $company_type
 * @property int $abn
 * @property string $name
 * @property string $address_no
 * @property string $address_street
 * @property string $address_suburb
 * @property string $address_state
 * @property string $address_postcode
 * @property string $address_country
 * @property string $contact_name
 * @property string $contact_email
 * @property string $contact_phone
 *
 * @property \App\Model\Entity\Project[] $projects
 * @property \App\Model\Entity\User[] $users
 */
class Company extends Entity
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
        'admin_id' => true,
        'company_type' => true,
        'abn' => true,
        'name' => true,
        'address_no' => true,
        'address_street' => true,
        'address_suburb' => true,
        'address_state' => true,
        'address_postcode' => true,
        'address_country' => true,
        'contact_name' => true,
        'contact_email' => true,
        'contact_phone' => true,
        'projects' => true,
        'users' => true,
    ];
}
