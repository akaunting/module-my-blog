<x-layouts.admin>
    <x-slot name="title">
        {{ trans_choice('my-blog::general.comments', 2) }}
    </x-slot>

    <x-slot name="favorite"
        title="{{ trans_choice('my-blog::general.comments', 2) }}"
        icon="edit"
        route="my-blog.comments.index"
    ></x-slot>

    <x-slot name="buttons">
        @can('create-my-blog-comments')
            <x-link href="{{ route('my-blog.comments.create') }}" kind="primary">
                {{ trans('general.title.new', ['type' => trans_choice('my-blog::general.comments', 1)]) }}
            </x-link>
        @endcan
    </x-slot>

    <x-slot name="moreButtons">
        <x-dropdown id="dropdown-more-actions">
            <x-slot name="trigger">
                <span class="material-icons">more_horiz</span>
            </x-slot>

            <x-dropdown.link href="{{ route('my-blog.comments.export', request()->input()) }}">
                {{ trans('general.export') }}
            </x-dropdown.link>
        </x-dropdown>
    </x-slot>

    <x-slot name="content">
        @if ($comments->count() || request()->get('search', false))
            <x-index.container>
                <x-index.search
                    search-string="Modules\MyBlog\Models\Comment"
                    bulk-action="Modules\MyBlog\BulkActions\Comments"
                />

                <x-table>
                    <x-table.thead>
                        <x-table.tr class="flex items-center px-1">
                            <x-table.th class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                                <x-index.bulkaction.all />
                            </x-table.th>

                            <x-table.th class="w-4/12">
                                <x-slot name="first">
                                    <x-sortablelink column="created_at" title="{{ trans('general.date') }}" />
                                </x-slot>
                                <x-slot name="second">
                                    <x-sortablelink column="owner" title="{{ trans_choice('my-blog::general.posts', 1) }}" />
                                </x-slot>
                            </x-table.th>

                            <x-table.th class="w-8/12">
                                <x-sortablelink column="description" title="{{ trans('general.description') }}" />
                            </x-table.th>
                        </x-table.tr>
                    </x-table.thead>

                    <x-table.tbody>
                        @foreach($comments as $item)
                            <x-table.tr href="{{ route('my-blog.comments.show', $item->id) }}">
                                <x-table.td class="ltr:pr-6 rtl:pl-6 hidden sm:table-cell" override="class">
                                    <x-index.bulkaction.single id="{{ $item->id }}" name="{{ $item->created_at }}" />
                                </x-table.td>

                                <x-table.td class="w-4/12 truncate">
                                    <x-slot name="first" class="flex font-bold" override="class">
                                        <x-date date="{{ $item->created_at }}" />
                                    </x-slot>
                                    <x-slot name="second">
                                        {{ $item->post->name }}
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
            </x-index.container>
        @else
            <x-empty-page group="my-blog" page="comments" />
        @endif
    </x-slot>

    <x-script alias="my-blog" file="comments" />
</x-layouts.admin>
