<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }}">
    <div class="card">
        @include($class->views['header'], ['header_class' => 'border-bottom-0'])

        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr class="row table-head-line">
                        <th class="col-xs-6 col-md-6 text-left">{{ trans('general.name') }}</th>
                        <th class="col-xs-6 col-md-6 text-right">{{ trans_choice('my-blog::general.posts', 2) }}</th>
                    </tr>
                </thead>
                <tbody class="thead-light">
                    @if ($authors->count())
                        @foreach($authors as $author)
                            <tr class="row border-top-1 tr-py">
                                <td class="col-xs-6 col-md-6 text-left long-texts">{{ $author->name }}</td>
                                <td class="col-xs-6 col-md-6 text-right">{{ $author->my_blog_posts_count }}</td>
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
