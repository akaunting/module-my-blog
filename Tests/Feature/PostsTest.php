<?php

namespace Tests\Feature\Common;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Modules\MyBlog\Exports\Posts as Export;
use Modules\MyBlog\Jobs\CreatePost;
use Modules\MyBlog\Models\Post;
use Tests\Feature\FeatureTestCase;

class PostsTest extends FeatureTestCase
{
    public function testItShouldSeePostListPage()
    {
        $this->loginAs()
            ->get(route('my-blog.posts.index'))
            ->assertStatus(200)
            ->assertSeeText(trans_choice('my-blog::general.posts', 2));
    }

    public function testItShouldSeePostCreatePage()
    {
        $this->loginAs()
            ->get(route('my-blog.posts.create'))
            ->assertStatus(200)
            ->assertSeeText(trans('general.title.new', ['type' => trans_choice('my-blog::general.posts', 1)]));
    }

    public function testItShouldCreatePost()
    {
        $request = $this->getRequest();

        $this->loginAs()
            ->post(route('my-blog.posts.store'), $request)
            ->assertStatus(200);

        $this->assertFlashLevel('success');

        $this->assertDatabaseHas('my_blog_posts', $request);
    }

    public function testItShouldSeePostUpdatePage()
    {
        $request = $this->getRequest();

        $post = $this->dispatch(new CreatePost($request));

        $this->loginAs()
            ->get(route('my-blog.posts.edit', $post->id))
            ->assertStatus(200)
            ->assertSee($post->name);
    }

    public function testItShouldUpdatePost()
    {
        $request = $this->getRequest();

        $post = $this->dispatch(new CreatePost($request));

        $request['name'] = $this->faker->text(15);

        $this->loginAs()
            ->patch(route('my-blog.posts.update', $post->id), $request)
            ->assertStatus(200)
            ->assertSee($request['name']);

        $this->assertFlashLevel('success');

        $this->assertDatabaseHas('my_blog_posts', $request);
    }

    public function testItShouldDeletePost()
    {
        $request = $this->getRequest();

        $post = $this->dispatch(new CreatePost($request));

        $this->loginAs()
            ->delete(route('my-blog.posts.destroy', $post->id))
            ->assertStatus(200);

        $this->assertFlashLevel('success');

        $this->assertSoftDeleted('my_blog_posts', $request);
    }

    public function testItShouldExportPosts()
    {
        $count = 5;
        Post::factory()->count($count)->create();

        \Excel::fake();

        $this->loginAs()
            ->get(route('my-blog.posts.export'))
            ->assertStatus(200);

        \Excel::matchByRegex();

        \Excel::assertDownloaded(
            '/' . \Str::filename(trans_choice('my-blog::general.posts', 2)) . '-\d{10}\.xlsx/',
            function (Export $export) use ($count) {
                // Assert that the correct export is downloaded.
                return $export->collection()->count() === $count;
            }
        );
    }

    public function testItShouldExportSelectedPosts()
    {
        $create_count = 5;
        $select_count = 3;

        $posts = Post::factory()->count($create_count)->create();

        \Excel::fake();

        $this->loginAs()
            ->post(
                route('bulk-actions.action', ['group' => 'my-blog', 'type' => 'posts']),
                ['handle' => 'export', 'selected' => $posts->take($select_count)->pluck('id')->toArray()]
            )
            ->assertStatus(200);

        \Excel::matchByRegex();

        \Excel::assertDownloaded(
            '/' . \Str::filename(trans_choice('my-blog::general.posts', 2)) . '-\d{10}\.xlsx/',
            function (Export $export) use ($select_count) {
                // Assert that the correct export is downloaded.
                return $export->collection()->count() === $select_count;
            }
        );
    }

    public function testItShouldImportPosts()
    {
        \Excel::fake();

        $this->loginAs()
            ->post(
                route('my-blog.posts.import'),
                [
                    'import' => UploadedFile::fake()->createWithContent(
                        'posts.xlsx',
                        File::get(module_path('my-blog', 'Resources/assets/posts.xlsx'))
                    ),
                ]
            )
            ->assertStatus(200);

        \Excel::assertImported('posts.xlsx');

        $this->assertFlashLevel('success');
    }

    public function getRequest()
    {
        return Post::factory()->enabled()->raw();
    }
}
