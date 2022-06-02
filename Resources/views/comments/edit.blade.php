<x-layouts.admin>
    <x-slot name="title">{{ trans('general.title.edit', ['type' => trans_choice('my-blog::general.comments', 1)]) }}</x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="comment" method="PATCH" :route="['my-blog.comments.update', $comment->id]" :model="$comment">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('general.general') }}" description="{{ trans('my-blog::general.form_description.comment') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.select name="post_id" label="{{ trans_choice('my-blog::general.posts', 1) }}" :options="$posts" />

                        <x-form.group.textarea name="description" label="{{ trans('general.description') }}" />
                    </x-slot>
                </x-form.section>

                @can('update-my-blog-comments')
                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="my-blog.comments.index" />
                    </x-slot>
                </x-form.section>
                @endcan
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script alias="my-blog" file="comments" />
</x-layouts.admin>
