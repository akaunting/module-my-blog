<?php

namespace Modules\MyBlog\Database\Seeds;

use App\Abstracts\Model;
use App\Models\Setting\Category;
use Illuminate\Database\Seeder;

class Categories extends Seeder
{
    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        $company_id = $this->command->argument('company');

        $categories = [
            [
                'company_id' => $company_id,
                'name'       => trans('my-blog::general.demo.categories.php'),
                'type'       => 'post',
                'color'      => '#55588b',
                'enabled'    => '1',
            ],
            [
                'company_id' => $company_id,
                'name'       => trans('my-blog::general.demo.categories.laravel'),
                'type'       => 'post',
                'color'      => '#de4b4b',
                'enabled'    => '1',
            ],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate($category);
        }
    }
}
