<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }} my-8">
    @include($class->views['header'], ['header_class' => ''])

    @if ($authors->count())
        <ul class="text-sm space-y-3 my-3">
            @foreach($authors as $author)
                <li class="flex justify-between truncate">
                    {{ $author->name }}
                    <span class="font-medium">{{ $author->my_blog_posts_count }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-sm space-y-3 my-3">
            {{ trans('general.no_records') }}
        </div>
    @endif
</div>
