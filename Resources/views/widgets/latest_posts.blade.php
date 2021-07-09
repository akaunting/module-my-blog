<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }}">
    <div class="card">
        @include($class->views['header'], ['header_class' => 'border-bottom-0'])

        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr class="row table-head-line">
                        <th class="col-md-7 text-left">{{ trans('general.name') }}</th>
                        <th class="col-md-5 text-right">{{ trans_choice('general.categories', 1) }}</th>
                    </tr>
                </thead>
                <tbody class="thead-light">
                    @if ($posts->count())
                        @foreach($posts as $post)
                            <tr class="row border-top-1 tr-py">
                                <td class="col-md-7 text-left long-texts" title="{{ $post->name }}">{{ $post->name }}</td>
                                <td class="col-md-5 text-right long-texts" title="{{ $post->category->name }}">{{ $post->category->name }}</td>
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
