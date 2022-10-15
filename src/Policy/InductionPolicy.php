<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Induction;
use Authorization\IdentityInterface;

/**
 * Induction policy
 */
class InductionPolicy
{
    /**
     * Check if $user can add Induction
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Induction $induction
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Induction $induction)
    {
        $role = $user->role;
        if($role == 'Builder'|| $role == 'Contractor'|| $role == 'Subcontractor' || $role == 'Consultant'){
            return true;
        }

        return false;
    }

    /**
     * Check if $user can edit Induction
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Induction $induction
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Induction $induction)
    {
        return true;
    }

    /**
     * Check if $user can delete Induction
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Induction $induction
     * @return bool
     */
    public function canDelete(IdentityInterface $user, Induction $induction)
    {
        return true;
    }

    /**
     * Check if $user can view Induction
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Induction $induction
     * @return bool
     */
    public function canView(IdentityInterface $user, Induction $induction)
    {
        return true;
    }
    public function canIndex(IdentityInterface $user, Induction $induction)
    {
        return false;
    }
}
