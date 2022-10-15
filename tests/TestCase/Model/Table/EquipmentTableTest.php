<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EquipmentTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EquipmentTable Test Case
 */
class EquipmentTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EquipmentTable
     */
    protected $Equipment;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Equipment',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Equipment') ? [] : ['className' => EquipmentTable::class];
        $this->Equipment = $this->getTableLocator()->get('Equipment', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Equipment);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\EquipmentTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
