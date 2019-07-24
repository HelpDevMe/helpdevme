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

<h4 class="badge {{ $class }}">
    @lang('questions.status.' . $status)
</h4>
