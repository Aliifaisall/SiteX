<?php
declare(strict_types=1);

namespace App\Policy;

use App\Model\Entity\Signature;
use Authorization\IdentityInterface;

/**
 * Signature policy
 */
class SignaturePolicy
{
    /**
     * Check if $user can add Signature
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Signature $signature
     * @return bool
     */
    public function canAdd(IdentityInterface $user, Signature $signature)
    {
        return true;
    }

    /**
     * Check if $user can edit Signature
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Signature $signature
     * @return bool
     */
    public function canEdit(IdentityInterface $user, Signature $signature)
    {
        return true;
    }

    /**
     * Check if $user can view Signature
     *
     * @param \Authorization\IdentityInterface $user The user.
     * @param \App\Model\Entity\Signature $signature
     * @return bool
     */
    public function canView(IdentityInterface $user, Signature $signature)
    {
        return true;
    }
    public function canIndex(IdentityInterface $user, Signature $signature)
    {
        return false;
    }
    public function canPending(IdentityInterface $user, Signature $signature)
    {
        return true;
    }
}
