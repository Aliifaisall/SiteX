<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Induction Entity
 *
 * @property int $id
 * @property int $project_id
 * @property int $user_id
 * @property int $company_id
 * @property \Cake\I18n\FrozenDate|null $inducted_date
 *
 * @property \App\Model\Entity\Project $project
 * @property \App\Model\Entity\User $user
 */
class Induction extends Entity
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
        'project_id' => true,
        'user_id' => true,
        'company_id' => true,
        'inducted_date' => true,
        'project' => true,
        'user' => true,
    ];
}
