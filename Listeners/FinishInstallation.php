<?php

namespace Modules\MyBlog\Listeners;

use App\Events\Module\Installed as Event;
use App\Traits\Permissions;
use Illuminate\Support\Facades\Artisan;

class FinishInstallation
{
    use Permissions;

    public $alias = 'my-blog';

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event)
    {
        if ($event->alias != $this->alias) {
            return;
        }

        $this->updatePermissions();

        $this->callSeeds();
    }

    protected function updatePermissions()
    {
        // c=create, r=read, u=update, d=delete
        $this->attachPermissionsToAdminRoles([
            $this->alias . '-posts' => 'c,r,u,d',
            $this->alias . '-comments' => 'c,r,u,d',
            $this->alias . '-settings' => 'r',
        ]);

        // c=create, r=read, u=update, d=delete
        $this->attachPermissionsToPortalRoles([
            $this->alias . '-portal-posts' => 'r',
            $this->alias . '-portal-comments' => 'c,r',
        ]);
    }

    protected function callSeeds()
    {
        Artisan::call('company:seed', [
            'company' => company_id(),
            '--class' => 'Modules\MyBlog\Database\Seeds\Install',
        ]);
    }
}
