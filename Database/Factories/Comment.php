<?php

namespace Modules\MyBlog\Database\Factories;

use App\Abstracts\Factory;
use Modules\MyBlog\Models\Comment as Model;
use Modules\MyBlog\Models\Post;

class Comment extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'company_id' => $this->company->id,
            'post_id' => Post::enabled()->get()->random(1)->pluck('id')->first(),
            'description' => $this->faker->text(100),
        ];
    }
}
