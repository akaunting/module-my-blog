<?php

namespace Modules\MyBlog\Database\Seeds;

use App\Abstracts\Model;
use App\Traits\Jobs;
use Illuminate\Database\Seeder;
use App\Jobs\Setting\CreateEmailTemplate;

class EmailTemplates extends Seeder
{
    use Jobs;

    public function run()
    {
        Model::unguard();

        $this->create();

        Model::reguard();
    }

    private function create()
    {
        $company_id = $this->command->argument('company');

        $templates = [
            [
                'alias' => 'comment_new_author',
                'class' => 'Modules\MyBlog\Notifications\Comment',
                'name'  => 'my-blog::settings.email.templates.comment_new_author',
            ],
            [
                'alias' => 'comment_delete_author',
                'class' => 'Modules\MyBlog\Notifications\Comment',
                'name'  => 'my-blog::settings.email.templates.comment_delete_author',
            ],
        ];

        foreach ($templates as $template) {
            $this->dispatch(new CreateEmailTemplate([
                'company_id'    => $company_id,
                'alias'         => $template['alias'],
                'class'         => $template['class'],
                'name'          => $template['name'],
                'subject'       => trans('my-blog::email_templates.' . $template['alias'] . '.subject'),
                'body'          => trans('my-blog::email_templates.' . $template['alias'] . '.body'),
                'created_from'  => 'my-blog::seed',
            ]));
        }
    }
}
