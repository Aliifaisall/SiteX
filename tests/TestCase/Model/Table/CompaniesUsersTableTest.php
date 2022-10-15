<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompaniesUsersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompaniesUsersTable Test Case
 */
class CompaniesUsersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CompaniesUsersTable
     */
    protected $CompaniesUsers;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.CompaniesUsers',
        'app.Companies',
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
        $config = $this->getTableLocator()->exists('CompaniesUsers') ? [] : ['className' => CompaniesUsersTable::class];
        $this->CompaniesUsers = $this->getTableLocator()->get('CompaniesUsers', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CompaniesUsers);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CompaniesUsersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CompaniesUsersTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
