<div>
    <div class="row mb-4">
        <div class="col form-inline">
            @if ($table_data->total() > 0)
                {{ __('wiretables.per_page') }}: &nbsp;
                <select wire:model="perPage" class="form-control">
                    @foreach($perPageRanges as $range)
                        <option>{{$range}}</option>
                    @endforeach
                </select>
            @endif
        </div>

        <div class="col">
            <input wire:model="searchQuery" class="form-control" type="text" placeholder="{{ __('wiretables.search.placeholder') }}" />
        </div>

    </div>

    @if ($table_data->total() > 0)

        <table class="table">
            @include('wiretables.bootstrap.partials.table-head')
            <tbody>

            @foreach($table_data as $row)
                <tr>
                    @foreach(\Wiretables\Helper::normalizeRow($row) as $field => $value)

                        @if (!\Wiretables\Helper::isFieldVisible($field, $fields))
                            @continue
                        @endif

                        <td>
                            @if(isset($fields[$field]) AND isset($fields[$field]['type']))

                                @switch($fields[$field]['type'])
                                    @case('date')
                                        @include('wiretables.bootstrap.fields.date',
                                        ['field_date' => $value,
                                         'field_date_format' => $fields[$field]['type_format']])
                                        @break
                                    @case('custom')
                                        @include($fields[$field]['type_view'])
                                    @break

                                @endswitch

                            @else

                                {{ $value }}

                            @endif

                        </td>
                    @endforeach

                    @foreach ($customColumns as $field => $column)
                        <td>
                            @include($column['view'])
                        </td>
                    @endforeach

                </tr>
            @endforeach

            </tbody>
        </table>

        {{ $table_data->links() }}

        <div class="col text-right text-muted">
            {{ __('wiretables.footer.showing') }} {{ $table_data->firstItem() }} {{ __('wiretables.footer.to') }} {{ $table_data->lastItem() }} {{ __('wiretables.footer.out-of') }} {{ $table_data->total() }}
        </div>

    @else

        @include('wiretables.bootstrap.partials.no-results')

    @endif

</div>
