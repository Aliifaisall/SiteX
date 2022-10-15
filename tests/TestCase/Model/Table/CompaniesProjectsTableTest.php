<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CompaniesProjectsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CompaniesProjectsTable Test Case
 */
class CompaniesProjectsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CompaniesProjectsTable
     */
    protected $CompaniesProjects;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.CompaniesProjects',
        'app.Companies',
        'app.Projects',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('CompaniesProjects') ? [] : ['className' => CompaniesProjectsTable::class];
        $this->CompaniesProjects = $this->getTableLocator()->get('CompaniesProjects', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->CompaniesProjects);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CompaniesProjectsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\CompaniesProjectsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
