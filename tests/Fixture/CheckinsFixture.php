<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CheckinsFixture
 */
class CheckinsFixture extends TestFixture
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
                'project_id' => 1,
                'user_id' => 1,
                'checkin_datetime' => '2022-08-11 07:41:21',
                'checkout_datetime' => '2022-08-11 07:41:21',
            ],
        ];
        parent::init();
    }
}
