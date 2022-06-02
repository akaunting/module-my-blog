<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }} my-8">
    @include($class->views['header'], ['header_class' => ''])

    @if ($comments->count())
        <ul class="text-sm space-y-3 my-3">
            @foreach($comments as $comment)
                <li class="flex justify-between truncate">
                    <div class="w-32">
                        {{ $comment->description }}
                    </div>
                    <span class="font-medium">{{ $comment->owner->name }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <div class="text-sm space-y-3 my-3">
            {{ trans('general.no_records') }}
        </div>
    @endif
</div>
