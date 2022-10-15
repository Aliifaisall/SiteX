<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Signature Entity
 *
 * @property int $id
 * @property int $document_id
 * @property int $user_id
 * @property \Cake\I18n\FrozenTime|null $signed_datetime
 *
 * @property \App\Model\Entity\Document $document
 * @property \App\Model\Entity\User $user
 */
class Signature extends Entity
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
        'document_id' => true,
        'user_id' => true,
        'signed_datetime' => true,
        'document' => true,
        'user' => true,
    ];
}
