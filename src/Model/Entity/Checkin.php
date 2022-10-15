<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Checkin Entity
 *
 * @property int $project_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime $checkin_datetime
 * @property \Cake\I18n\FrozenTime|null $checkout_datetime
 *
 * @property \App\Model\Entity\Project $project
 * @property \App\Model\Entity\User $user
 */
class Checkin extends Entity
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
        'checkin_datetime' => true,
        'checkout_datetime' => true,
        'project' => true,
        'user' => true,
    ];
}
