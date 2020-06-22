<thead class="{{ $tableHeadClass }}">
<tr class="{{ $tableHeadTrClass }}">

    @foreach($tableHead as $field)

        @if (!\Wiretables\Helper::isFieldVisible($field, $fields))
            @continue
        @endif

        <?php
            // if this field is defined not to be sorted
            $noSort = (isset($fields[$field]) // if the field has definitions
                AND isset($fields[$field]['sortable']) // and sortable flag defined
                AND $fields[$field]['sortable'] == false); // and is set to false

            if (!$noSort)
            {
                // custom fields should not be sortable
                $noSort = isset($customColumns[$field]);
            }
        ?>

        <th scope="{{ $tableHeadThClass }}">
            <a href="#" class="text-white"
               @if (!$noSort)
                    wire:click.prevent="sortBy('{{ $field }}')"
                @endif
            >

                @if (isset($fields[$field]) AND isset($fields[$field]['label']))

                    {{ $fields[$field]['label'] }}

                @else

                    {{ ucfirst(str_replace(['-', '_', '_id'], ' ', $field)) }}

                @endif

                @include('wiretables::bootstrap.partials.sort', ['field'=> $field])

            </a>
        </th>

    @endforeach

</tr>
</thead>
