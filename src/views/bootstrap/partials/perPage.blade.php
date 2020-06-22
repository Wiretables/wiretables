@if ($table_data->total() > 0)
    <div class="float-right form-inline">
        {{ __('wiretables::wiretables.per_page') }}: &nbsp;
        <select wire:model="perPage" class="form-control-sm" wire:loading.attr="disabled">
            @foreach($perPageRanges as $range)
                <option>{{$range}}</option>
            @endforeach
        </select>
    </div>
@endif
