<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CompaniesUser Entity
 *
 * @property int $id
 * @property int $company_id
 * @property int $user_id
 * @property bool $is_company_admin
 *
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\User $user
 */
class CompaniesUser extends Entity
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
        'company_id' => true,
        'user_id' => true,
        'is_company_admin' => true,
        'company' => true,
        'user' => true,
    ];
}
