<?php

namespace Modules\MyBlog\Database\Seeds;

use App\Abstracts\Model;
use App\Jobs\Common\CreateDashboard;
use App\Traits\Jobs;
use Illuminate\Database\Seeder;

class Dashboards extends Seeder
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

        $this->dispatch(new CreateDashboard([
            'company_id' => $company_id,
            'name' => trans('my-blog::general.name'),
            'all_users' => true,
            'default_widgets' => 'my-blog',
            'created_from' => 'my-blog::seed',
        ]));
    }
}
