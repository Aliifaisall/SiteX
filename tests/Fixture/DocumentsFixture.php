<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * DocumentsFixture
 */
class DocumentsFixture extends TestFixture
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
                'name' => 'Lorem ipsum dolor sit amet',
                'details' => 'Lorem ipsum dolor sit amet',
                'document_no' => 'Lorem ipsum dolor sit amet',
                'document_type' => 'Lorem ipsum dolor sit amet',
                'worker_accessible' => 1,
                'class' => 'Lorem ipsum dolor sit amet',
                'issuer' => 'Lorem ipsum dolor sit amet',
                'issue_date' => '2022-10-07',
                'expiry_date' => '2022-10-07',
                'declaration_text' => 'Lorem ipsum dolor sit amet',
                'related_project_id' => 1,
                'related_user_id' => 1,
                'related_company_id' => 1,
            ],
        ];
        parent::init();
    }
}
