<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\SignaturesTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\SignaturesTable Test Case
 */
class SignaturesTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\SignaturesTable
     */
    protected $Signatures;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Signatures',
        'app.Documents',
        'app.Users',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Signatures') ? [] : ['className' => SignaturesTable::class];
        $this->Signatures = $this->getTableLocator()->get('Signatures', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Signatures);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\SignaturesTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\SignaturesTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
