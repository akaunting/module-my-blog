@extends('layouts.portal')

@section('title', trans_choice('my-blog::general.posts', 2))

@section('content')
    <div class="card">
        <div class="card-header border-bottom-0">
            {!! Form::open([
                'route' => 'portal.my-blog.posts.index',
                'role' => 'form',
                'method' => 'GET',
                'class' => 'mb-0'
            ]) !!}

                <div class="row">
                    <div class="col-12 align-items-center">
                        <x-search-string model="Modules\MyBlog\Models\Post" />
                    </div>
                </div>

            {!! Form::close() !!}
        </div>

        <div class="table-responsive">
            <table class="table table-flush table-hover">
                <thead class="thead-light">
                    <tr class="row table-head-line">
                        <th class="col-md-3">@sortablelink('name', trans('general.name'))</th>
                        <th class="col-md-5">@sortablelink('description', trans('general.description'))</th>
                        <th class="col-md-2">@sortablelink('category', trans_choice('general.categories', 1))</th>
                        <th class="col-md-2">@sortablelink('enabled', trans('general.enabled'))</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($posts as $post)
                        <tr class="row align-items-center border-top-1 tr-py">
                            <td class="col-md-3">{{ $post->name }}</td>
                            <td class="col-md-5 long-texts">{{ $post->description }}</td>
                            <td class="col-md-2">{{ $post->category->name }}</td>
                            <td class="col-md-2">{{ $post->enabled }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer table-action">
            <div class="row">
                @include('partials.admin.pagination', ['items' => $posts])
            </div>
        </div>
    </div>
@endsection

@push('scripts_start')
    <script src="{{ asset('modules/MyBlog/Resources/assets/js/my-blog.min.js?v=' . module_version('my-blog')) }}"></script>
@endpush
