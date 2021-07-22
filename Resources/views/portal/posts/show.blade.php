@extends('layouts.admin')

@section('title', $post->name)

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

    @if (setting('my-blog.enable_comments'))
        <h3>{{ trans_choice('my-blog::general.comments', 2) }}</h3>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-flush table-hover" id="tbl-comments">
                    <thead class="thead-light">
                        <tr class="row table-head-line">
                            <th class="col-md-3">{{ trans_choice('general.users', 1) }}</th>
                            <th class="col-md-9">{{ trans('general.description') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($comments as $comment)
                            <tr class="row align-items-center border-top-1 tr-py">
                                <td class="col-md-3">{{ $comment->owner->name }}</td>
                                <td class="col-md-9 long-texts">{{ $comment->description }}</td>
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

        <h3>{{ trans('general.title.new', ['type' => trans_choice('my-blog::general.comments', 1)]) }}</h3>

        <div class="card">
            {!! Form::open([
                'id' => 'comment',
                'route' => 'portal.my-blog.comments.store',
                '@submit.prevent' => 'onSubmit',
                '@keydown' => 'form.errors.clear($event.target.name)',
                'files' => true,
                'role' => 'form',
                'class' => 'form-loading-button',
                'novalidate' => true
            ]) !!}

                <div class="card-body">
                    <div class="row">
                        {{ Form::hidden('post_id', $post->id) }}

                        {{ Form::textareaGroup('description', trans('general.description')) }}
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row save-buttons">
                        {{ Form::saveButtons('portal.my-blog.posts.index') }}
                    </div>
                </div>

            {!! Form::close() !!}
        </div>
    @endif
@endsection

@push('scripts_start')
    <script src="{{ asset('modules/MyBlog/Resources/assets/js/comments.min.js?v=' . module_version('my-blog')) }}"></script>
@endpush
