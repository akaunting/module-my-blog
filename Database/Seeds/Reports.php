<?php

namespace Modules\MyBlog\Database\Seeds;

use App\Abstracts\Model;
use App\Jobs\Common\CreateReport;
use App\Traits\Jobs;
use Illuminate\Database\Seeder;

class Reports extends Seeder
{
    use Jobs;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        $company_id = $this->command->argument('company');

        $rows = [
            [
                'company_id' => $company_id,
                'class' => 'Modules\MyBlog\Reports\PostSummary',
                'name' => trans('my-blog::reports.post_name'),
                'description' => trans('my-blog::reports.post_description'),
                'settings' => ['group' => 'category', 'period' => 'monthly'],
            ],
            [
                'company_id' => $company_id,
                'class' => 'Modules\MyBlog\Reports\CommentSummary',
                'name' => trans('my-blog::reports.comment_name'),
                'description' => trans('my-blog::reports.comment_description'),
                'settings' => ['group' => 'post', 'period' => 'monthly'],
            ],
        ];

        foreach ($rows as $row) {
            $row['created_from'] = 'core::seed';

            $this->dispatch(new CreateReport($row));
        }
    }
}
