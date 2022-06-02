<x-layouts.admin>
    <x-slot name="title">{{ trans('general.title.edit', ['type' => trans_choice('my-blog::general.posts', 1)]) }}</x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="post" method="PATCH" :route="['my-blog.posts.update', $post->id]" :model="$post">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('general.general') }}" description="{{ trans('my-blog::general.form_description.post') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.text name="name" label="{{ trans('general.name') }}"  />

                        <x-form.group.category type="post" />

                        <x-form.group.textarea name="description" label="{{ trans('general.description') }}" />
                    </x-slot>
                </x-form.section>

                <x-form.group.switch name="enabled" label="{{ trans('general.enabled') }}" />

                @can('update-my-blog-posts')
                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="my-blog.posts.index" />
                    </x-slot>
                </x-form.section>
                @endcan
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script alias="my-blog" file="posts" />
</x-layouts.admin>
