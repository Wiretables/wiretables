<div>

@if ($table_data->total() > 0)

    <div wire:loading>
        @include($viewNoResults)
    </div>

    <div class="mb-4 row">
        <div class="col-md-6">
            @section('index.search')
                <input wire:model="searchQuery" class="form-control" type="text" placeholder="{{ __('wiretables::wiretables.search.placeholder') }}" />
            @show
        </div>

        <div class="col-md-6">
            @section('index.per_page')
                @if ($table_data->total() > 0)
                    <div class="float-right form-inline">
                        {{ __('wiretables::wiretables.per_page') }}: &nbsp;
                        <select wire:model="perPage" class="form-control">
                            @foreach($perPageRanges as $range)
                                <option>{{$range}}</option>
                            @endforeach
                        </select>
                    </div>
                @endif
            @show
        </div>
    </div>

    <table class="table">

        @include('wiretables::bootstrap.partials.table-head')

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
                                    @include('wiretables::bootstrap.fields.date',
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
        {{ __('wiretables::wiretables.footer.showing') }} {{ $table_data->firstItem() }} {{ __('wiretables::wiretables.footer.to') }} {{ $table_data->lastItem() }} {{ __('wiretables::wiretables.footer.out-of') }} {{ $table_data->total() }}
    </div>

    @else

        @include($viewNoResults)

    @endif

</div>
