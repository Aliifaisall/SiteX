<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Document Entity
 *
 * @property int $id
 * @property string $name
 * @property string|null $details
 * @property string|null $document_no
 * @property string $document_type
 * @property bool|null $worker_accessible
 * @property string|null $class
 * @property string|null $issuer
 * @property \Cake\I18n\FrozenDate|null $issue_date
 * @property \Cake\I18n\FrozenDate|null $expiry_date
 * @property string|null $declaration_text
 * @property int|null $related_project_id
 * @property int|null $related_user_id
 * @property int|null $related_company_id
 *
 * @property \App\Model\Entity\Project $project
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Company $company
 * @property \App\Model\Entity\Signature[] $signatures
 */
class Document extends Entity
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
        'name' => true,
        'details' => true,
        'document_no' => true,
        'document_type' => true,
        'worker_accessible' => true,
        'class' => true,
        'issuer' => true,
        'issue_date' => true,
        'expiry_date' => true,
        'declaration_text' => true,
        'related_project_id' => true,
        'related_user_id' => true,
        'related_company_id' => true,
        'project' => true,
        'user' => true,
        'company' => true,
        'signatures' => true,
    ];
}
