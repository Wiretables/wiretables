<?php

namespace Wiretables\Traits;

use Livewire\WithPagination;
use Wiretables\Helper;

/**
 * Trait Wiretable
 * @package Wiretables\Traits
 */
trait Wiretable
{
    use WithPagination;

    /**
     * @var array
     */
    public $perPageRanges = [10, 20, 30, 40, 50];

    /**
     * @var int
     */
    public $perPage = 10;

    /**
     * Field by which the query is sorted, must be defined in ->mount()
     *
     * @var string
     */
    public $sortField;

    /**
     * Query sort direction
     *
     * @var string
     */
    public $sortDirection = 'asc';

    /**
     * When !empty a search query will be added to the query
     *
     * @var string
     */
    public $searchQuery = '';

    /**
     * Fields in which to search when $searchQuery is !empty
     *
     * @var array
     */
    public $searchFields = [];

    /**
     * By default all the fields from the DB result will be rendered, to overwrite how they are displayed define here.
     * Examples in the readme
     *
     * @var array
     */
    public $fields = [];

    /**
     * @var array
     */
    public $tableHead = [];

    /**
     * @var array
     */
    public $customColumns = [];

    /**
     * @var string
     */
    public $view = 'wiretables::bootstrap.index';

    /**
     * @var string
     */
    public $viewNoResults = 'wiretables::bootstrap.partials.no-results';

    /**
     * @var string
     */
    public $viewNoResultsForFilter = 'wiretables::bootstrap.partials.no-results-filter';

    /**
     * @var string
     */
    public $viewloading = 'wiretables::bootstrap.partials.loading';

    /**
     * No of DB queries performed, used to determine if we don't have results by default or because of filters
     *
     * @var int
     */
    public $queries = 0;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        // data
        $paginator = $this->buildPaginator();

        if ($paginator->total() > 0)
        {
            // resolve the table head if missing
            if (empty($this->table_head))
            {
                $this->resolveTableHead($paginator);
            }

            // if no search fields are define we search in all
            if (empty($this->searchFields))
            {
                $this->resolveSearchFields();
            }
        }

        return view($this->view, [
            'table_data' => $paginator
        ]);
    }

    /**
     * @param Illuminate\Pagination\LengthAwarePaginator $paginator
     */
    protected function resolveTableHead(\Illuminate\Pagination\LengthAwarePaginator $paginator)
    {
        $this->tableHead = array_keys (
            Helper::normalizeRow($paginator->items()[0])
        );

        // resolve possible custom columns
        if (count($this->customColumns) > 0)
        {
            $this->tableHead = array_merge($this->tableHead, array_keys($this->customColumns));
        }
    }

    /**
     *
     */
    protected function resolveSearchFields()
    {
        $this->searchFields = $this->tableHead;
    }

    /**
     * Reverse the sort direction of the query
     */
    protected function reverseSort()
    {
        if ($this->sortDirection == 'asc')
        {
            $this->sortDirection = 'desc';
        }
        else
        {
            $this->sortDirection = 'asc';
        }
    }

    /**
     * Sort the query by another field or reverse the sort direction
     *
     * @param $field
     */
    public function sortBy($field)
    {
        if ($this->sortField == $field)
        {
            $this->reverseSort();
        }
        $this->sortField = $field;
    }

    /**
     * Define the model to be used or a DB::table() instance.
     *
     * If you don't define the fields to be selected ->select() all fields returned will be shown
     *
     * @return \Illuminate\Database\Query\Builder|Illuminate\Database\Eloquent\Builder
     */
    protected abstract function model();

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected function buildPaginator() : \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = $this->model();

        if (!empty($this->searchQuery))
        {
            $query = $this->addSearchQuery($query);
        }

        if (!empty($this->sortField))
        {
            $query = $query->orderBy($this->sortField, $this->sortDirection);
        }

        $this->queries++;

        return $query
            ->take($this->perPage)
            ->paginate($this->perPage);
    }

    /**
     * Add search query if fields are defined
     *
     * @param \Illuminate\Database\Query\Builder|Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder|Illuminate\Database\Eloquent\Builder
     */
    protected function addSearchQuery($query)
    {
        if (count($this->searchFields) > 0)
        {
            $isFirst = true;

            foreach ($this->searchFields as $field)
            {
                if ($isFirst)
                {
                    $query->where($field, 'like', '%'.$this->searchQuery.'%');
                    $isFirst = false;
                }
                else
                {
                    $query->orWhere($field, 'like', '%'.$this->searchQuery.'%');
                }
            }
        }
        return $query;
    }

    /**
     * Reset the page to 1 when we are searching otherwise the query will contain offset #page number
     */
    public function updatingSearchQuery()
    {
        $this->resetPage();
    }
}
