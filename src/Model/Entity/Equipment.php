<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Equipment Entity
 *
 * @property int $id
 * @property string|null $equipment_type
 * @property string $name
 * @property bool $is_licensed
 * @property int $builder_auth
 * @property \Cake\I18n\FrozenDate|null $hired_from_date
 * @property \Cake\I18n\FrozenDate|null $hired_until_date
 */
class Equipment extends Entity
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
        'equipment_type' => true,
        'name' => true,
        'is_licensed' => true,
        'builder_auth' => true,
        'hired_from_date' => true,
        'hired_until_date' => true,
    ];
}
