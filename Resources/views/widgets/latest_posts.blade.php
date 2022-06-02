<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }} my-8">
    @include($class->views['header'], ['header_class' => ''])

    @if ($posts->count())
        <ul class="text-sm space-y-3 my-3">
            @foreach($posts as $post)
                <li class="flex justify-between truncate">
                    {{ $post->name }}
                    <span class="font-medium">{{ $post->category->name }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-sm space-y-3 my-3">
            {{ trans('general.no_records') }}
        </div>
    @endif
</div>
