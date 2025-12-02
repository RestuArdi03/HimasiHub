@props(['icon', 'color', 'title', 'value'])

<div class="card h-100">
    <div class="card-body px-4 py-4-5">
        <div class="row">
            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                <div class="stats-icon {{ $color }} mb-2">
                    <i class="bi {{ $icon }} text-white fs-3"></i>
                </div>
            </div>
            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                <h6 class="text-muted font-semibold">{{ $title }}</h6>
                <h6 class="font-extrabold mb-0">{{ $value }}</h6>
            </div>
        </div>
    </div>
</div>