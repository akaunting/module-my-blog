<x-layouts.portal>
    <x-slot name="title">
        {{ trans_choice('my-blog::general.posts', 2) }}
    </x-slot>

    <x-slot name="content">
        <x-index.container>
            <x-index.search search-string="Modules\MyBlog\Models\Post" />

            <x-table>
                <x-table.thead>
                    <x-table.tr class="flex items-center px-1">
                        @stack('name_th_start')

                        <x-table.th class="w-4/12 hidden sm:table-cell">
                            @stack('name_th_inside_start')

                            <x-slot name="first">
                                <x-sortablelink column="name" title="{{ trans('general.name') }}" />
                            </x-slot>

                            @stack('author_th_inside_start')

                            <x-slot name="second">
                                <x-sortablelink column="owner" title="{{ trans_choice('my-blog::general.authors', 1) }}" />
                            </x-slot>

                            @stack('author_th_inside_end')
                        </x-table.th>

                        @stack('category_th_start')

                        <x-table.th class="w-3/12 hidden sm:table-cell">
                            <x-sortablelink column="category.name" title="{{ trans_choice('general.categories', 1) }}" />
                        </x-table.th>

                        @stack('description_th_start')

                        <x-table.th class="w-5/12">
                            <x-sortablelink column="description" title="{{ trans('general.description') }}" />
                        </x-table.th>

                        @stack('description_th_end')
                    </x-table.tr>
                </x-table.thead>

                <x-table.tbody>
                    @foreach($posts as $item)
                        <x-table.tr href="{{ route('portal.my-blog.posts.show', $item->id) }}">
                            <x-table.td class="p-0" override="class"></x-table.td>

                            @stack('name_td_start')

                            <x-table.td class="w-4/12 hidden sm:table-cell">
                                @stack('name_td_inside_start')

                                <x-slot name="first" class="font-bold truncate" override="class">
                                    {{ $item->name }}

                                    @if (! $item->enabled)
                                        <x-index.disable text="{{ trans_choice('my-blog::general.posts', 1) }}" />
                                    @endif
                                </x-slot>

                                @stack('author_td_inside_start')

                                <x-slot name="second">
                                    {{ $item->owner->name }}
                                </x-slot>

                                @stack('author_td_inside_end')
                            </x-table.td>

                            @stack('category_td_start')

                            <x-table.td class="w-3/12 truncate hidden sm:table-cell">
                                <div class="flex items-center">
                                    <x-index.category :model="$item->category" />
                                </div>
                            </x-table.td>

                            @stack('description_td_start')

                            <x-table.td class="w-5/12 truncate">
                                <div class="w-32">
                                    {{ $item->description }}
                                </div>
                            </x-table.td>

                            @stack('description_td_end')
                        </x-table.tr>
                    @endforeach
                </x-table.tbody>
            </x-table>

            <x-pagination :items="$posts" />
        </x-index.container>
    </x-slot>

    <x-script alias="my-blog" file="posts" />
</x-layouts.portal>
