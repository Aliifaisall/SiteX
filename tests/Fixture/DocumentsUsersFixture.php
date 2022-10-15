<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentsUsersFixture
 */
class DocumentsUsersFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'document_id' => 1,
                'user_id' => 1,
                'signed_datetime' => '2022-08-16 16:26:09',
            ],
        ];
        parent::init();
    }
}
