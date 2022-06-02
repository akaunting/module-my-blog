<x-layouts.admin>
    <x-slot name="title">
        {{ $post->name }}
    </x-slot>

    <x-slot name="favorite"
        title="{{ $post->name }}"
        icon="edit"
        :route="['my-blog.posts.show', $post->id]"
    ></x-slot>

    <x-slot name="buttons">
        @stack('new_button_start')

        @can('create-my-blog-posts')
        <x-link href="{{ route('my-blog.posts.create') }}" kind="primary">
            {{ trans('general.title.new', ['type' => trans_choice('my-blog::general.posts', 1)]) }}
        </x-link>
        @endcan

        @stack('edit_button_start')

        @can('update-my-blog-posts')
        <x-link href="{{ route('my-blog.posts.edit', $post->id) }}">
            {{ trans('general.edit') }}
        </x-link>
        @endcan

        @stack('more_button_start')

        <x-dropdown id="dropdown-actions">
            <x-slot name="trigger">
                <span class="material-icons">more_horiz</span>
            </x-slot>

            @stack('duplicate_button_start')

            @can('create-my-blog-posts')
            <x-dropdown.link href="{{ route('my-blog.posts.duplicate', $post->id) }}">
                {{ trans('general.duplicate') }}
            </x-dropdown.link>
            @endcan

            @stack('delete_button_start')

            @can('delete-my-blog-posts')
            <x-delete-link :model="$post" route="my-blog.posts.destroy" />
            @endcan

            @stack('delete_button_end')
        </x-dropdown>

        @stack('more_button_end')
    </x-slot>

    <x-slot name="content">
        <x-show.container>
            <x-show.content>

                <x-show.content.left>
                    @stack('category_start')

                    <div class="flex flex-col text-sm mb-5">
                        <div class="font-medium">
                            {{ trans_choice('general.categories', 1) }}
                        </div>

                        <span>
                            {{ $post->category->name }}
                        </span>
                    </div>

                    @stack('status_start')

                    <div class="flex flex-col text-sm mb-5">
                        <div class="font-medium">
                            {{ trans('general.enabled') }}
                        </div>

                        <span>
                            @if ($post->enabled)
                                {{ trans('general.yes') }}
                            @else
                                {{ trans('general.no') }}
                            @endif
                        </span>
                    </div>

                    @stack('status_end')
                </x-show.content.left>

                <x-show.content.right>
                    <div class="w-8/12 pl-12">
                        <span>{{ $post->description }}</span>

                        @if (setting('my-blog.enable_comments'))
                            <h3 class="pt-10">{{ trans_choice('my-blog::general.comments', 2) }}</h3>

                            <x-table>
                                <x-table.thead>
                                    <x-table.tr class="flex items-center px-1">
                                        <x-table.th class="w-4/12">
                                            <x-slot name="first">
                                                <x-sortablelink
                                                    column="created_at"
                                                    title="{{ trans('general.date') }}"
                                                    :query="['filter' => 'active, visible']"
                                                    :arguments="['class' => 'col-aka', 'rel' => 'nofollow']"
                                                />
                                            </x-slot>
                                            <x-slot name="second">
                                                <x-sortablelink column="owner" title="{{ trans_choice('my-blog::general.authors', 1) }}" />
                                            </x-slot>
                                        </x-table.th>

                                        <x-table.th class="w-8/12">
                                            <x-sortablelink column="description" title="{{ trans('general.description') }}" />
                                        </x-table.th>
                                    </x-table.tr>
                                </x-table.thead>

                                <x-table.tbody>
                                    @foreach($comments as $item)
                                        <x-table.tr href="{{ route('my-blog.comments.edit', $item->id) }}" data-table-list class="relative flex items-center border-b hover:bg-gray-100 px-1 group">
                                            <x-table.td class="w-4/12 truncate">
                                                <x-slot name="first" class="flex font-bold" override="class">
                                                    <x-date date="{{ $item->created_at }}" />
                                                </x-slot>
                                                <x-slot name="second">
                                                    {{ $item->owner->name }}
                                                </x-slot>
                                            </x-table.td>

                                            <x-table.td class="w-8/12 truncate">
                                                <div class="w-32">
                                                    {{ $item->description }}
                                                </div>
                                            </x-table.td>

                                            <x-table.td class="p-0" override="class">
                                                <x-table.actions :model="$item" />
                                            </x-table.td>
                                        </x-table.tr>
                                    @endforeach
                                </x-table.tbody>
                            </x-table>

                            <x-pagination :items="$comments" />
                        @endif
                    </div>
                </x-show.content.right>

            </x-show.content>
        </x-show.container>
    </x-slot>

    <x-script alias="my-blog" file="posts" />
</x-layouts.admin>
