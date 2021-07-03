<?php

namespace Modules\MyBlog\Tests\Feature;

use App\Traits\Permissions;
use Tests\Feature\FeatureTestCase;

class AdminMenuTest extends FeatureTestCase
{
    use Permissions;

    public function testItShouldSeeAdminPostsMenuItem()
    {
        $this->loginAs()
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSeeInOrder([
                '<li class="nav-item">',
                '<a class="nav-link" href="' . route('my-blog.posts.index') . '" >',
                '<span class="nav-link-text">' . trans_choice('my-blog::general.posts', 2) . '</span>',
            ], false);
    }

    public function testItShouldNotSeeAdminPostsMenuItem()
    {
        $this->detachPermissionsFromAdminRoles([
            'my-blog-posts' => 'r',
        ]);

        $this->loginAs()
            ->get(route('dashboard'))
            ->assertOk()
            ->assertDontSee('<a class="nav-link" href="' . route('my-blog.posts.index') . '" >', false);
    }

    public function testItShouldSeeAdminCommentsMenuItem()
    {
        $this->loginAs()
            ->get(route('dashboard'))
            ->assertOk()
            ->assertSeeInOrder([
                '<li class="nav-item">',
                '<a class="nav-link" href="' . route('my-blog.comments.index') . '" >',
                '<span class="nav-link-text">' . trans_choice('my-blog::general.comments', 2) . '</span>',
            ], false);
    }

    public function testItShouldNotSeeAdminCommentsMenuItem()
    {
        $this->detachPermissionsFromAdminRoles([
            'my-blog-comments' => 'r',
        ]);

        $this->loginAs()
            ->get(route('dashboard'))
            ->assertOk()
            ->assertDontSee('<a class="nav-link" href="' . route('my-blog.comments.index') . '" >', false);
    }
}
