@if (session()->has('success'))
    <div class="alert alert-success" role="alert" x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
        x-transition>
        <strong>Success!</strong> <span id="success-message">{{ session('success') }}</span>
    </div>
@endif

@if (session()->has('error'))
    <div class="alert alert-danger" role="alert" x-data="{ show: true }" x-init="setTimeout(() => show = false, 4000)" x-show="show"
        x-transition>
        <strong>Error!</strong> <span id="success-message">{{ session('error') }}</span>
    </div>
@endif
