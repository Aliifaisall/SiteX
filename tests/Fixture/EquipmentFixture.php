<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EquipmentFixture
 */
class EquipmentFixture extends TestFixture
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
                'equipment_type' => 'Lorem ipsum dolor sit amet',
                'name' => 'Lorem ipsum dolor sit amet',
                'is_licensed' => 1,
                'builder_auth' => 1,
                'hired_from_date' => '2022-08-11',
                'hired_until_date' => '2022-08-11',
            ],
        ];
        parent::init();
    }
}
