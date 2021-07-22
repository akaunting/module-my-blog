@extends('layouts.admin')

@section('title', trans_choice('my-blog::general.comments', 2))

@section('new_button')
    @can('create-my-blog-comments')
        <a href="{{ route('my-blog.comments.create') }}" class="btn btn-success btn-sm">{{ trans('general.add_new') }}</a>
    @endcan
    <a href="{{ route('my-blog.comments.export', request()->input()) }}" class="btn btn-white btn-sm">{{ trans('general.export') }}</a>
@endsection

@section('content')
    @if ($comments->count() || request()->get('search', false))
        <div class="card">
            <div class="card-header border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">
                {!! Form::open([
                    'method' => 'GET',
                    'route' => 'my-blog.comments.index',
                    'role' => 'form',
                    'class' => 'mb-0'
                ]) !!}
                    <div class="align-items-center" v-if="!bulk_action.show">
                        <x-search-string model="Modules\MyBlog\Models\Comment" />
                    </div>

                    {{ Form::bulkActionRowGroup('my-blog::general.comments', $bulk_actions, ['group' => 'my-blog', 'type' => 'comments']) }}
                {!! Form::close() !!}
            </div>

            <div class="table-responsive">
                <table class="table table-flush table-hover">
                    <thead class="thead-light">
                        <tr class="row table-head-line">
                            <th class="col-md-1 d-none d-sm-block">{{ Form::bulkActionAllGroup() }}</th>
                            <th class="col-md-7">@sortablelink('description', trans('general.description'))</th>
                            <th class="col-md-2">@sortablelink('post', trans_choice('my-blog::general.posts', 1))</th>
                            <th class="col-md-2 text-center"><a>{{ trans('general.actions') }}</a></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($comments as $comment)
                            <tr class="row align-items-center border-top-1">
                                <td class="col-md-1 d-none d-sm-block">
                                    {{ Form::bulkActionGroup($comment->id, $comment->id) }}
                                </td>
                                <td class="col-md-7 long-texts">
                                    <a href="{{ route('my-blog.comments.edit', $comment->id) }}">{{ $comment->description }}</a>
                                </td>
                                <td class="col-md-2">
                                    {{ $comment->post->name }}
                                </td>
                                <td class="col-md-2 text-center">
                                    <div class="dropdown">
                                        <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-h text-muted"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" href="{{ route('my-blog.comments.edit', $comment->id) }}">{{ trans('general.edit') }}</a>
                                            @can('delete-my-blog-comments')
                                                <div class="dropdown-divider"></div>
                                                {!! Form::deleteLink($comment, 'my-blog.comments.destroy', 'my-blog::general.comments') !!}
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="card-footer table-action">
                <div class="row align-items-center">
                    @include('partials.admin.pagination', ['items' => $comments])
                </div>
            </div>
        </div>
    @else
        <x-empty-page page="items" />
    @endif
@endsection

@push('scripts_start')
    <script src="{{ asset('modules/MyBlog/Resources/assets/js/comments.min.js?v=' . module_version('my-blog')) }}"></script>
@endpush
