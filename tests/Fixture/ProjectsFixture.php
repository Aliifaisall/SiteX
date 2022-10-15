<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ProjectsFixture
 */
class ProjectsFixture extends TestFixture
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
                'project_type' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'builder_id' => 1,
                'client_name' => 'Lorem ipsum dolor sit amet',
                'client_email' => 'Lorem ipsum dolor sit amet',
                'client_phone' => 'Lorem ipsum d',
                'start_date' => '2022-09-04',
                'est_completion_date' => '2022-09-04',
                'status' => 'Lorem ipsum dolor sit amet',
                'completion_date' => '2022-09-04',
                'address_no' => 'Lorem ip',
                'address_street' => 'Lorem ipsum dolor sit amet',
                'address_suburb' => 'Lorem ipsum dolor sit amet',
                'address_state' => 'Lorem ipsum dolor sit amet',
                'address_postcode' => 'Lorem ipsum dolor ',
                'address_country' => 'Lorem ipsum dolor sit amet',
            ],
        ];
        parent::init();
    }
}
