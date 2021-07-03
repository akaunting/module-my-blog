@extends('layouts.admin')

@section('title', $post->name)

@section('new_button')
    <div class="dropup header-drop-top">
        <button type="button" class="btn btn-white btn-sm" data-toggle="dropdown" aria-expanded="false">
            <i class="fa fa-chevron-down"></i>&nbsp; {{ trans('general.more_actions') }}
        </button>

        <div class="dropdown-menu" role="menu">
            @can('update-my-blog-posts')
                <a class="dropdown-item" href="{{ route('my-blog.posts.edit', $post->id) }}">
                    {{ trans('general.edit') }}
                </a>
            @endcan

            @can('create-my-blog-posts')
                <a class="dropdown-item" href="{{ route('my-blog.posts.duplicate', $post->id) }}">
                    {{ trans('general.duplicate') }}
                </a>
            @endcan

            <div class="dropdown-divider"></div>

            @can('delete-my-blog-posts')
                {!! Form::deleteLink($post, 'my-blog.posts.destroy', 'my-blog::general.posts') !!}
            @endcan
        </div>
    </div>

    @can('create-my-blog-posts')
        <a href="{{ route('my-blog.posts.create') }}" class="btn btn-white btn-sm">{{ trans('general.add_new') }}</a>
    @endcan
@endsection

@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-6">
                <div class="card-header border-bottom-0 d-flex align-items-center">
                    <strong>{{ trans_choice('general.categories', 1) }}:</strong>
                    <span class="float-right ml-1">{{ $post->category->name }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card-header border-bottom-0 d-flex align-items-center">
                    <strong>{{ trans('general.enabled') }}:</strong>
                    <span class="float-right ml-1">
                        @if ($post->enabled)
                            <badge rounded type="success" class="mw-60">{{ trans('general.yes') }}</badge>
                        @else
                            <badge rounded type="danger" class="mw-60">{{ trans('general.no') }}</badge>
                        @endif
                    </span>
                </div>
            </div>
            <div class="col-12">
                <div class="card-header border-bottom-0 pb-0">
                    <strong>{{ trans('general.description') }}:</strong>
                </div>
                <div class="card-header border-bottom-0 pt-0">
                    <span>{{ $post->description }}</span>
                </div>
            </div>
        </div>
    </div>

    <h3>{{ trans_choice('my-blog::general.comments', 2) }}</h3>

    <div class="card">
        <div class="table-responsive">
            <table class="table table-flush table-hover" id="tbl-comments">
                <thead class="thead-light">
                    <tr class="row table-head-line">
                        <th class="col-md-3">{{ trans_choice('general.users', 1) }}</th>
                        <th class="col-md-7">{{ trans('general.description') }}</th>
                        <th class="col-md-2 text-center">{{ trans('general.actions') }}</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($comments as $comment)
                        <tr class="row align-items-center border-top-1 tr-py">
                            <td class="col-md-3">{{ $comment->owner->name }}</td>
                            <td class="col-md-7  long-texts">{{ $comment->description }}</td>
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

        <div class="card-footer py-4 table-action">
            <div class="row">
                @include('partials.admin.pagination', ['items' => $comments, 'type' => 'comments'])
            </div>
        </div>
    </div>
@endsection

@push('scripts_start')
    <script src="{{ asset('modules/MyBlog/Resources/assets/js/my-blog.min.js?v=' . module_version('my-blog')) }}"></script>
@endpush
