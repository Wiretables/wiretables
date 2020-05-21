<?php

// if this field is defined not to be sorted
$noSort = (isset($fields[$field]) // if the field has definitions
    AND isset($fields[$field]['sortable']) // and sortable flag defined
    AND $fields[$field]['sortable'] == false); // and is set to false

// custom fields should not be sortable
$noSort = isset($customColumns[$field]);

?>

@if (!$noSort)

    @if ($sortField !== $field)
        <i class="text-muted fas fa-sort"></i>
    @elseif ($sortDirection == 'asc')
        <i class="fas fa-sort-up"></i>
    @else
        <i class="fas fa-sort-down"></i>
    @endif

@endif
