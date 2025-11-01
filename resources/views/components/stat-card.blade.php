@props(['icon', 'color', 'title', 'value'])

<div class="col-6 col-lg-3 col-md-6">
    <div class="card">
        <div class="card-body px-3 py-4-5">
            <div class="row">
                <div class="col-md-4">
                    <div class="stats-icon {{ $color }}">
                        <i class="{{ $icon }}"></i>
                    </div>
                </div>
                <div class="col-md-8">
                    <h6 class="text-muted font-semibold">{{ $title }}</h6>
                    <h6 class="font-extrabold mb-0">{{ $value }}</h6>
                </div>
            </div>
        </div>
    </div>
</div>

