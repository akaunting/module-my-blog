<x-layouts.admin>
    <x-slot name="title">{{ trans('general.title.new', ['type' => trans_choice('my-blog::general.comments', 1)]) }}</x-slot>

    <x-slot name="favorite"
        title="{{ trans('general.title.new', ['type' => trans_choice('my-blog::general.comments', 1)]) }}"
        icon="chat"
        route="my-blog.comments.create"
    ></x-slot>

    <x-slot name="content">
        <x-form.container>
            <x-form id="comment" route="my-blog.comments.store">
                <x-form.section>
                    <x-slot name="head">
                        <x-form.section.head title="{{ trans('general.general') }}" description="{{ trans('my-blog::general.form_description.comment') }}" />
                    </x-slot>

                    <x-slot name="body">
                        <x-form.group.select name="post_id" label="{{ trans_choice('my-blog::general.posts', 1) }}" :options="$posts" />

                        <x-form.group.textarea name="description" label="{{ trans('general.description') }}" />
                    </x-slot>
                </x-form.section>

                <x-form.section>
                    <x-slot name="foot">
                        <x-form.buttons cancel-route="my-blog.comments.index" />
                    </x-slot>
                </x-form.section>
            </x-form>
        </x-form.container>
    </x-slot>

    <x-script alias="my-blog" file="comments" />
</x-layouts.admin>
