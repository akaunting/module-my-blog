<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('my-blog::general.posts', 2) }}
    </x-slot>

    <x-slot name="favorite"
        title="{{ trans_choice('my-blog::general.posts', 2) }}"
        icon="edit"
        route="my-blog.posts.index"
    ></x-slot>

    <x-slot name="buttons">
        @can('create-my-blog-posts')
            <x-link href="{{ route('my-blog.posts.create') }}" kind="primary">
                {{ trans('general.title.new', ['type' => trans_choice('my-blog::general.posts', 1)]) }}
            </x-link>
        @endcan
    </x-slot>

    <x-slot name="moreButtons">
        <x-dropdown id="dropdown-more-actions">
            <x-slot name="trigger">
                <span class="material-icons">more_horiz</span>
            </x-slot>

            @can('create-my-blog-posts')
                <x-dropdown.link href="{{ route('import.create', ['my-blog', 'posts']) }}">
                    {{ trans('import.import') }}
                </x-dropdown.link>
            @endcan

            <x-dropdown.link href="{{ route('my-blog.posts.export', request()->input()) }}">
                {{ trans('general.export') }}
            </x-dropdown.link>
        </x-dropdown>
    </x-slot>

    <x-slot name="content">
        @if ($posts->count() || request()->get('search', false))
            <x-index.container>
                <x-index.search
                    search-string="Modules\MyBlog\Models\Post"
                    bulk-action="Modules\MyBlog\BulkActions\Posts"
                />

                <x-table>
                    <x-table.thead>
                        <x-table.tr class="flex items-center px-1">
                            <x-table.th class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                                <x-index.bulkaction.all />
                            </x-table.th>

                            <x-table.th class="w-4/12">
                                <x-slot name="first">
                                    <x-sortablelink column="name" title="{{ trans('general.name') }}" />
                                </x-slot>
                                <x-slot name="second">
                                    <x-sortablelink column="owner" title="{{ trans_choice('my-blog::general.authors', 1) }}" />
                                </x-slot>
                            </x-table.th>

                            <x-table.th class="w-3/12 hidden sm:table-cell">
                                <x-sortablelink column="category.name" title="{{ trans_choice('general.categories', 1) }}" />
                            </x-table.th>

                            <x-table.th class="w-5/12">
                                <x-sortablelink column="description" title="{{ trans('general.description') }}" />
                            </x-table.th>
                        </x-table.tr>
                    </x-table.thead>

                    <x-table.tbody>
                        @foreach($posts as $item)
                            <x-table.tr href="{{ route('my-blog.posts.show', $item->id) }}">
                                <x-table.td class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                                    <x-index.bulkaction.single id="{{ $item->id }}" name="{{ $item->name }}" />
                                </x-table.td>

                                <x-table.td class="w-4/12 truncate">
                                    <x-slot name="first" class="flex items-center font-bold" override="class">
                                        <div class="truncate">
                                            {{ $item->name }}
                                        </div>

                                        @if (! $item->enabled)
                                            <x-index.disable text="{{ trans_choice('my-blog::general.posts', 1) }}" />
                                        @endif
                                    </x-slot>
                                    <x-slot name="second">
                                        {{ $item->owner->name }}
                                    </x-slot>
                                </x-table.td>

                                <x-table.td class="w-3/12 truncate hidden sm:table-cell">
                                    <div class="flex items-center">
                                        <x-index.category :model="$item->category" />
                                    </div>
                                </x-table.td>

                                <x-table.td class="w-5/12 truncate">
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

                <x-pagination :items="$posts" />
            </x-index.container>
        @else
            <x-empty-page group="my-blog" page="posts" />
        @endif
    </x-slot>

    <x-script alias="my-blog" file="posts" />
</x-layouts.admin>
