@extends('layouts.admin')

@section('title', trans('general.title.new', ['type' => trans_choice('my-blog::general.comments', 1)]))

@section('content')
    <div class="card">
        {!! Form::open([
            'id' => 'comment',
            'route' => 'my-blog.comments.store',
            '@submit.prevent' => 'onSubmit',
            '@keydown' => 'form.errors.clear($event.target.name)',
            'files' => true,
            'role' => 'form',
            'class' => 'form-loading-button',
            'novalidate' => true
        ]) !!}

            <div class="card-body">
                <div class="row">
                    {{ Form::selectGroup('post_id', trans_choice('my-blog::general.posts', 1), 'fa fa-pen', $posts) }}

                    {{ Form::textareaGroup('description', trans('general.description')) }}
                </div>
            </div>

            <div class="card-footer">
                <div class="row save-buttons">
                    {{ Form::saveButtons('my-blog.comments.index') }}
                </div>
            </div>

        {!! Form::close() !!}
    </div>
@endsection

@push('scripts_start')
    <script src="{{ asset('modules/MyBlog/Resources/assets/js/comments.min.js?v=' . module_version('my-blog')) }}"></script>
@endpush
