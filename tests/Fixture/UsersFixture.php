<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
                'is_admin' => 1,
                'role' => 'Lorem ipsum dolor sit amet',
                'status' => 'Lorem ipsum dolor sit amet',
                'first_name' => 'Lorem ipsum dolor sit amet',
                'last_name' => 'Lorem ipsum dolor sit amet',
                'address_no' => 'Lorem ip',
                'address_street' => 'Lorem ipsum dolor sit amet',
                'address_suburb' => 'Lorem ipsum dolor sit amet',
                'address_state' => 'Lorem ipsum dolor sit amet',
                'address_postcode' => 'Lorem ipsum dolor ',
                'address_country' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'phone_mobile' => 'Lorem ipsum d',
                'phone_office' => 'Lorem ipsum d',
                'emergency_name' => 'Lorem ipsum dolor sit amet',
                'emergency_relationship' => 'Lorem ipsum dolor sit amet',
                'emergency_phone' => 'Lorem ipsum d',
            ],
        ];
        parent::init();
    }
}
