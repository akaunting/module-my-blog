<div id="widget-{{ $class->model->id }}" class="{{ $class->model->settings->width }}">
    <div class="card bg-gradient-default card-stats">
        @include($class->views['header'], ['header_class' => 'border-bottom-0'])

        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h5 class="text-uppercase text-white mb-0">{{ $class->model->name }}</h5>
                    <span class="font-weight-bold text-white mb-0">{{ $total_comments }}</span>
                </div>

                <div class="col-auto">
                    <div class="icon icon-shape bg-white text-default rounded-circle shadow">
                        <i class="fa fa-comments"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
