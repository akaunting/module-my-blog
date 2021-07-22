@extends('layouts.admin')

@section('title', trans('general.title.edit', ['type' => trans_choice('my-blog::general.comments', 1)]))

@section('content')
    <div class="card">
        {!! Form::model($comment, [
            'id' => 'comment',
            'method' => 'PATCH',
            'route' => ['my-blog.comments.update', $comment->id],
            '@submit.prevent' => 'onSubmit',
            '@keydown' => 'form.errors.clear($event.target.name)',
            'files' => true,
            'role' => 'form',
            'class' => 'form-loading-button',
            'novalidate' => true
        ]) !!}

            <div class="card-body">
                <div class="row">
                    {{ Form::selectGroup('post', trans_choice('my-blog::general.posts', 1), 'fa fa-pen', $posts, $comment->post_id) }}

                    {{ Form::textareaGroup('description', trans('general.description')) }}
                </div>
            </div>

            @can('update-my-blog-comments')
                <div class="card-footer">
                    <div class="row save-buttons">
                        {{ Form::saveButtons('my-blog.comments.index') }}
                    </div>
                </div>
            @endcan

        {!! Form::close() !!}
    </div>
@endsection

@push('scripts_start')
    <script src="{{ asset('modules/MyBlog/Resources/assets/js/comments.min.js?v=' . module_version('my-blog')) }}"></script>
@endpush
