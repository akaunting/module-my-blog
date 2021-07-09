<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }}">
    <div class="card">
        @include($class->views['header'], ['header_class' => 'border-bottom-0'])

        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr class="row table-head-line">
                        <th class="col-md-7 text-left">{{ trans('general.description') }}</th>
                        <th class="col-md-5 text-right">{{ trans_choice('my-blog::general.authors', 1) }}</th>
                    </tr>
                </thead>
                <tbody class="thead-light">
                    @if ($comments->count())
                        @foreach($comments as $comment)
                            <tr class="row border-top-1 tr-py">
                                <td class="col-md-7 text-left long-texts" title="{{ $comment->description }}">{{ $comment->description }}</td>
                                <td class="col-md-5 text-right long-texts" title="{{ $comment->owner->name }}">{{ $comment->owner->name }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr class="border-top-1">
                            <td colspan="3">
                                <div class="text-muted nr-py" id="datatable-basic_info" role="status" aria-live="polite">
                                    {{ trans('general.no_records') }}
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
