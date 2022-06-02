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
                '<li class="group relative pb-2.5">',
                '<a class="flex items-center text-purple" href="' . route('portal.my-blog.posts.index') . '" >',
                '<span class="text-sm ltr:ml-2 rtl:mr-2">' . trans_choice('my-blog::general.posts', 2) . '</span>',
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
            ->assertDontSee('<a class="flex items-center text-purple" href="' . route('portal.my-blog.posts.index') . '" >', false);
    }
}
