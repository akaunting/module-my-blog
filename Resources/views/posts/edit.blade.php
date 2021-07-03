@extends('layouts.admin')

@section('title', trans('general.title.edit', ['type' => trans_choice('my-blog::general.posts', 1)]))

@section('content')
    <div class="card">
        {!! Form::model($post, [
            'id' => 'post',
            'method' => 'PATCH',
            'route' => ['my-blog.posts.update', $post->id],
            '@submit.prevent' => 'onSubmit',
            '@keydown' => 'form.errors.clear($event.target.name)',
            'files' => true,
            'role' => 'form',
            'class' => 'form-loading-button',
            'novalidate' => true
        ]) !!}

            <div class="card-body">
                <div class="row">
                    {{ Form::textGroup('name', trans('general.name'), 'fa fa-font') }}

                    {{ Form::selectRemoteAddNewGroup('category_id', trans_choice('general.categories', 1), 'fa fa-folder', $categories, $post->category_id, ['path' => route('modals.categories.create') . '?type=post', 'remote_action' => route('categories.index'). '?search=type:post']) }}

                    {{ Form::textareaGroup('description', trans('general.description')) }}

                    {{ Form::radioGroup('enabled', trans('general.enabled'), $post->enabled) }}
                </div>
            </div>

            @can('update-my-blog-posts')
                <div class="card-footer">
                    <div class="row save-buttons">
                        {{ Form::saveButtons('my-blog.posts.index') }}
                    </div>
                </div>
            @endcan

        {!! Form::close() !!}
    </div>
@endsection

@push('scripts_start')
    <script src="{{ asset('modules/MyBlog/Resources/assets/js/my-blog.min.js?v=' . module_version('my-blog')) }}"></script>
@endpush
