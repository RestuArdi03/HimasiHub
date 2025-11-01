@props(['avatar', 'name', 'username'])

<div class="card">
    <div class="card-body py-4 px-5">
        <div class="d-flex align-items-center">
            <div class="avatar avatar-xl">
                <img src="{{ $avatar }}" alt="{{ $name }}">
            </div>
            <div class="ms-3 name">
                <h5 class="font-bold">{{ $name }}</h5>
                <h6 class="text-muted mb-0">{{ $username }}</h6>
            </div>
        </div>
    </div>
</div>


