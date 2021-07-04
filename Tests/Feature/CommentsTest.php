<?php

namespace Tests\Feature\Common;

use Modules\MyBlog\Exports\Comments as Export;
use Modules\MyBlog\Jobs\CreateComment;
use Modules\MyBlog\Models\Comment;
use Modules\MyBlog\Models\Post;
use Tests\Feature\FeatureTestCase;

class CommentsTest extends FeatureTestCase
{
    public function testItShouldSeeCommentListPage()
    {
        $this->loginAs()
            ->get(route('my-blog.comments.index'))
            ->assertStatus(200)
            ->assertSeeText(trans_choice('my-blog::general.comments', 2));
    }

    public function testItShouldSeeCommentCreatePage()
    {
        $this->loginAs()
            ->get(route('my-blog.comments.create'))
            ->assertStatus(200)
            ->assertSeeText(trans('general.title.new', ['type' => trans_choice('my-blog::general.comments', 1)]));
    }

    public function testItShouldCreateComment()
    {
        Post::factory()->enabled()->count(5)->create();

        $request = $this->getRequest();

        $this->loginAs()
            ->post(route('my-blog.comments.store'), $request)
            ->assertStatus(200);

        $this->assertFlashLevel('success');

        $this->assertDatabaseHas('my_blog_comments', $request);
    }

    public function testItShouldSeeCommentUpdatePage()
    {
        Post::factory()->enabled()->count(5)->create();

        $request = $this->getRequest();

        $comment = $this->dispatch(new CreateComment($request));

        $this->loginAs()
            ->get(route('my-blog.comments.edit', $comment->id))
            ->assertStatus(200)
            ->assertSee($comment->description);
    }

    public function testItShouldUpdateComment()
    {
        Post::factory()->enabled()->count(5)->create();

        $request = $this->getRequest();

        $comment = $this->dispatch(new CreateComment($request));

        $request['description'] = $this->faker->text(15);

        $this->loginAs()
            ->patch(route('my-blog.comments.update', $comment->id), $request)
            ->assertStatus(200)
            ->assertSee($request['description']);

        $this->assertFlashLevel('success');

        $this->assertDatabaseHas('my_blog_comments', $request);
    }

    public function testItShouldDeleteComment()
    {
        Post::factory()->enabled()->count(5)->create();

        $request = $this->getRequest();

        $comment = $this->dispatch(new CreateComment($request));

        $this->loginAs()
            ->delete(route('my-blog.comments.destroy', $comment->id))
            ->assertStatus(200);

        $this->assertFlashLevel('success');

        $this->assertSoftDeleted('my_blog_comments', $request);
    }

    public function testItShouldExportComments()
    {
        Post::factory()->enabled()->count(5)->create();

        $count = 5;
        Comment::factory()->count($count)->create();

        \Excel::fake();

        $this->loginAs()
            ->get(route('my-blog.comments.export'))
            ->assertStatus(200);

        \Excel::matchByRegex();

        \Excel::assertDownloaded(
            '/' . \Str::filename(trans_choice('my-blog::general.comments', 2)) . '-\d{10}\.xlsx/',
            function (Export $export) use ($count) {
                // Assert that the correct export is downloaded.
                return $export->collection()->count() === $count;
            }
        );
    }

    public function testItShouldExportSelectedComments()
    {
        Post::factory()->enabled()->count(5)->create();

        $create_count = 5;
        $select_count = 3;

        $comments = Comment::factory()->count($create_count)->create();

        \Excel::fake();

        $this->loginAs()
            ->post(
                route('bulk-actions.action', ['group' => 'my-blog', 'type' => 'comments']),
                ['handle' => 'export', 'selected' => $comments->take($select_count)->pluck('id')->toArray()]
            )
            ->assertStatus(200);

        \Excel::matchByRegex();

        \Excel::assertDownloaded(
            '/' . \Str::filename(trans_choice('my-blog::general.comments', 2)) . '-\d{10}\.xlsx/',
            function (Export $export) use ($select_count) {
                // Assert that the correct export is downloaded.
                return $export->collection()->count() === $select_count;
            }
        );
    }

    public function getRequest()
    {
        return Comment::factory()->raw();
    }
}
