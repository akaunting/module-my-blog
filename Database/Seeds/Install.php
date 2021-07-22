<?php

namespace Modules\MyBlog\Database\Seeds;

use App\Abstracts\Model;
use Illuminate\Database\Seeder;

class Install extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(Categories::class);
        $this->call(Dashboards::class);
        $this->call(EmailTemplates::class);

        Model::reguard();
    }
}
