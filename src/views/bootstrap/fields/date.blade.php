@if (!empty($field_date))
    {{ \Carbon\Carbon::parse($field_date)->format($field_date_format) }}
@endif
