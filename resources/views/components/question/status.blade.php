@php
    switch ($status) {
        case 1:
            $class = 'badge-primary';
        break;
        case 2:
            $class = 'badge-success';
        break;
        default:
            $class = 'badge-secondary';
        break;
    }
@endphp

<span class="badge {{ $class }}">
    @lang('questions.status.' . $status)
</span>