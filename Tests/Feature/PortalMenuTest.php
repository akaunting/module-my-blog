<?php

namespace Modules\MyBlog\Tests\Feature;

use App\Models\Common\Contact;
use App\Traits\Permissions;
use Tests\Feature\FeatureTestCase;

class PortalMenuTest extends FeatureTestCase
{
    use Permissions;

    public function testItShouldSeePortalPostsMenuItem()
    {
        $this->loginAs(Contact::first()->user)
            ->get(route('portal.dashboard'))
            ->assertOk()
            ->assertSeeInOrder([
                '<li class="nav-item">',
                '<a class="nav-link" href="' . route('portal.my-blog.posts.index') . '" >',
                '<span class="nav-link-text">' . trans_choice('my-blog::general.posts', 2) . '</span>',
            ], false);
    }

    public function testItShouldNotSeePortalPostsMenuItem()
    {
        $this->detachPermissionsFromPortalRoles([
            'my-blog-portal-posts' => 'r',
        ]);

        $this->loginAs(Contact::first()->user)
            ->get(route('portal.dashboard'))
            ->assertOk()
            ->assertDontSee('<a class="nav-link" href="' . route('portal.my-blog.posts.index') . '" >', false);
    }
}
