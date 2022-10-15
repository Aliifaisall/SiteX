<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentsTable Test Case
 */
class DocumentsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentsTable
     */
    protected $Documents;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Documents',
        'app.Projects',
        'app.Users',
        'app.Companies',
        'app.Signatures',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Documents') ? [] : ['className' => DocumentsTable::class];
        $this->Documents = $this->getTableLocator()->get('Documents', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Documents);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DocumentsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DocumentsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
