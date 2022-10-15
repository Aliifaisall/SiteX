<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="users form container" style="max-width: 500px">
    <br/><br/><br/><br/><br/><br/>
    <?= $this->Flash->render() ?>
    <h3>Reset Password</h3>
    <form method="post" accept-charset="utf-8" action="<?= $this->Url->build(['controller' => 'users', 'action' => 'forgot',])?>">
        <fieldset>
            <legend>Please enter a new password for your account.</legend>
            <div class="input password required pt-3"><label for="password">New Password for <?= $this->request->getQuery('email') ?>:</label><br/>
                <input class="form-control w-25" style="min-width: 200px; max-width: 400px" type="password" name="password" required="required" id="password" aria-required="true" minlength="8"></div>
            <input type="hidden" name="email" required="required" id="email" value="<?= $this->request->getQuery('email') ?>">
            <input type="hidden" name="code" required="required" id="code" value="<?= $this->request->getQuery('code') ?>">
        </fieldset>
        <br/>
        <div class="submit"><input type="submit" value="Confirm"></div>
    </form>
    <br/>
</div>
