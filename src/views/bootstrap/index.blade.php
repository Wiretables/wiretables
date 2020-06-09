<div>

@if ($table_data->total() > 0 OR $queries > 1)

    @section('wiretables.top')
        <div class="mb-4 row">
            <div class="col-md-6">
                @section('wiretables.top.left')
                    @include('wiretables::bootstrap.partials.search')
                @show
            </div>

            <div class="col-md-6">
                @section('wiretables.top.right')
                    @include('wiretables::bootstrap.partials.perPage')
                @show
            </div>
        </div>
    @show

    @section('wiretables.loading')

        <div wire:loading>
            @include($viewloading)
        </div>

    @show

    @if ($table_data->total() > 0)

    <table class="table" wire:loading.remove>

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

    @else

        @include('wiretables::bootstrap.partials.no-results-filter')

    @endif

    @section('wiretables.footer')

        <div class="mb-4 row" wire:loading.remove>
            <div class="col-md-6">
                @section('wiretables.footer.left')
                    {{ $table_data->links() }}
                @show
            </div>

            <div class="col-md-6">
                @section('wiretables.footer.right')
                    @include('wiretables::bootstrap.partials.meta')
                @show
            </div>
        </div>

    @show

    @else

        @include($viewNoResults)

@endif

</div>
