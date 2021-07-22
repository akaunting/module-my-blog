@extends('layouts.admin')

@section('title', trans_choice('my-blog::general.posts', 2))

@section('new_button')
    @can('create-my-blog-posts')
        <a href="{{ route('my-blog.posts.create') }}" class="btn btn-success btn-sm">{{ trans('general.add_new') }}</a>
        <a href="{{ route('import.create', ['my-blog', 'posts']) }}" class="btn btn-white btn-sm">{{ trans('import.import') }}</a>
    @endcan
    <a href="{{ route('my-blog.posts.export', request()->input()) }}" class="btn btn-white btn-sm">{{ trans('general.export') }}</a>
@endsection

@section('content')
    @if ($posts->count() || request()->get('search', false))
        <div class="card">
            <div class="card-header border-bottom-0" :class="[{'bg-gradient-primary': bulk_action.show}]">
                {!! Form::open([
                    'method' => 'GET',
                    'route' => 'my-blog.posts.index',
                    'role' => 'form',
                    'class' => 'mb-0'
                ]) !!}
                    <div class="align-items-center" v-if="!bulk_action.show">
                        <x-search-string model="Modules\MyBlog\Models\Post" />
                    </div>

                    {{ Form::bulkActionRowGroup('my-blog::general.posts', $bulk_actions, ['group' => 'my-blog', 'type' => 'posts']) }}
                {!! Form::close() !!}
            </div>

            <div class="table-responsive">
                <table class="table table-flush table-hover">
                    <thead class="thead-light">
                        <tr class="row table-head-line">
                            <th class="col-md-1 d-none d-sm-block">{{ Form::bulkActionAllGroup() }}</th>
                            <th class="col-md-3">@sortablelink('name', trans('general.name'))</th>
                            <th class="col-md-2">@sortablelink('owner', trans_choice('my-blog::general.authors', 1))</th>
                            <th class="col-md-2">@sortablelink('category', trans_choice('general.categories', 1))</th>
                            <th class="col-md-2 text-center">@sortablelink('enabled', trans('general.enabled'))</th>
                            <th class="col-md-2 text-center">{{ trans('general.actions') }}</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($posts as $post)
                            <tr class="row align-items-center border-top-1">
                                <td class="col-md-1 d-none d-sm-block">
                                    {{ Form::bulkActionGroup($post->id, $post->name) }}
                                </td>
                                <td class="col-md-3">
                                    <a href="{{ route('my-blog.posts.show', $post->id) }}">{{ $post->name }}</a>
                                </td>
                                <td class="col-md-2">
                                    <a href="{{ route('users.edit', $post->owner->id) }}">{{ $post->owner->name }}</a>
                                </td>
                                <td class="col-md-2">
                                    {{ $post->category->name }}
                                </td>
                                <td class="col-md-2 text-center">
                                    @if (user()->can('update-my-blog-posts'))
                                        {{ Form::enabledGroup($post->id, $post->name, $post->enabled) }}
                                    @else
                                        @if ($post->enabled)
                                            <badge rounded type="success" class="mw-60">{{ trans('general.yes') }}</badge>
                                        @else
                                            <badge rounded type="danger" class="mw-60">{{ trans('general.no') }}</badge>
                                        @endif
                                    @endif
                                </td>
                                <td class="col-md-2 text-center">
                                    <div class="dropdown">
                                        <a class="btn btn-neutral btn-sm text-light items-align-center p-2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-ellipsis-h text-muted"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            <a class="dropdown-item" href="{{ route('my-blog.posts.edit', $post->id) }}">{{ trans('general.edit') }}</a>
                                            @can('create-my-blog-posts')
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="{{ route('my-blog.posts.duplicate', $post->id) }}">{{ trans('general.duplicate') }}</a>
                                            @endcan
                                            @can('delete-my-blog-posts')
                                                <div class="dropdown-divider"></div>
                                                {!! Form::deleteLink($post, 'my-blog.posts.destroy', 'my-blog::general.posts') !!}
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
                    @include('partials.admin.pagination', ['items' => $posts])
                </div>
            </div>
        </div>
    @else
        <x-empty-page page="items" />
    @endif
@endsection

@push('scripts_start')
    <script src="{{ asset('modules/MyBlog/Resources/assets/js/posts.min.js?v=' . module_version('my-blog')) }}"></script>
@endpush
