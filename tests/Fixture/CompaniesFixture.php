<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CompaniesFixture
 */
class CompaniesFixture extends TestFixture
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
                'admin_id' => 1,
                'company_type' => 'Lorem ipsum dolor sit amet',
                'abn' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'address_no' => 'Lorem ip',
                'address_street' => 'Lorem ipsum dolor sit amet',
                'address_suburb' => 'Lorem ipsum dolor sit amet',
                'address_state' => 'Lorem ipsum dolor sit amet',
                'address_postcode' => 'Lorem ipsum dolor ',
                'address_country' => 'Lorem ipsum dolor sit amet',
                'contact_name' => 'Lorem ipsum dolor sit amet',
                'contact_email' => 'Lorem ipsum dolor sit amet',
                'contact_phone' => 'Lorem ipsum d',
            ],
        ];
        parent::init();
    }
}
