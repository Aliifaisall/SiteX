<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\DocumentsUsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\DocumentsUsersTable Test Case
 */
class DocumentsUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\DocumentsUsersTable
     */
    protected $DocumentsUsers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.DocumentsUsers',
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
        $config = $this->getTableLocator()->exists('DocumentsUsers') ? [] : ['className' => DocumentsUsersTable::class];
        $this->DocumentsUsers = $this->getTableLocator()->get('DocumentsUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->DocumentsUsers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\DocumentsUsersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\DocumentsUsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
