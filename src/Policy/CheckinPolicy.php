<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Checkin;
use Authorization\IdentityInterface;

/**
 * Checkin policy
 */
class CheckinPolicy
{
    /**
     * Check if $user can add Checkin
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Checkin $checkin
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Checkin $checkin)
    {
        return true;
    }

    /**
     * Check if $user can edit Checkin
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Checkin $checkin
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Checkin $checkin)
    {
        return false;
    }

    public function canIndex(IdentityInterface $user, Checkin $checkin)
    {
        return true;
    }
    public function canReminders(IdentityInterface $user, Checkin $checkin)
    {
        return true;
    }
}
