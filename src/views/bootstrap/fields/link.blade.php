@if (!empty($field_link))
    <a href="{{ str_replace('[id]', $row->id, $field_link) }}">{{ $value }}</a>
@endif
