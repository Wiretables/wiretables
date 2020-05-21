<thead class="table-dark">
<tr class="bg-primary">

    @foreach($tableHead as $field)

        @if (!\Wiretables\Helper::isFieldVisible($field, $fields))
            @continue
        @endif

        <th scope="col">
            <a role="button" href="#" class="text-white" wire:click.prevent="sortBy('{{ $field }}')">

                @if (isset($fields[$field]) AND isset($fields[$field]['label']))

                    {{ $fields[$field]['label'] }}

                @else

                    {{ ucfirst(str_replace(['-', '_', '_id'], ' ', $field)) }}

                @endif

                @include('wiretables.bootstrap.partials.sort', ['field'=> $field])

            </a>
        </th>

    @endforeach

</tr>
</thead>
