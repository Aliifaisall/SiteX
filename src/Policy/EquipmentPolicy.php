<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Equipment;
use Authorization\IdentityInterface;

/**
 * Equipment policy
 */
class EquipmentPolicy
{
    /**
     * Check if $user can add Equipment
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Equipment $equipment
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Equipment $equipment)
    {
        // you have to be of a certain type of user to add equipments to a project
        // hence check the user identity
        // only users that create projects should be able to add equipments

        return true;
    }

    /**
     * Check if $user can edit Equipment
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Equipment $equipment
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Equipment $equipment)
    {

        return true;
    }

    /**
     * Check if $user can delete Equipment
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Equipment $equipment
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Equipment $equipment)
    {
        return true;
    }

    /**
     * Check if $user can view Equipment
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Equipment $equipment
     * @return bool
     */
    public function canView(IdentityInterface $user, Equipment $equipment)
    {
        return true;
    }

    public function canIndex(IdentityInterface $user, Equipment $equipment)
    {
        return true;
    }
}
