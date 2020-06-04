# Wiretables

An extension for [Livewire](https://laravel-livewire.com/docs/quickstart/) that offers a better alternative to Datatables

## Requirements
Wiretables must be installed in a Laravel Project that already has Livewire installed and included in the template.

Additionally, the application template must include bootstrap 4.


## Installation

Via Composer

``` bash
$ composer require wiretables/wiretables
```

The package will automatically register its service provider.

Assets must be published

````bash
php artisan vendor:publish --provider="Wiretables\WiretablesServiceProvider"
````

This provide a basic localized template to get started

## Usage

1. Generate a new Wiretable component. You need one for each table (UI).

```bash
php artisan wiretables:make User 
```

This will generate an empty component

```php
<?php

namespace App\Http\Livewire;

use Livewire\Component;

class User extends Component
{
    use \Wiretables\Traits\Wiretable;

    /**
     * @return \Illuminate\Database\Query\Builder
     */
    protected function model()
    {
        // example
        // return \DB::table('users')->select(['first_name', 'last_name', 'email']);
        // return \App\Models\User::select(['first_name', 'last_name', 'email']);
    }
}
```
2. Tell Wiretable which data to display by returning either an instance of \Illuminate\Database\Query\Builder or Illuminate\Database\Eloquent\Builder
in the model() method

3. Include the component in the desired view

```php
@livewire('user')
```

That's it! 

## Configuration

By default all returned fields will be displayed, sorting and search will use all as well. 

Columns will be generated in the same order as they are defined in the query (select) 
 
The first configuration should be to define a select() in the query.

Sorting and search is active on all fields unless specified otherwise.

All configurations are defined in the ->mount() method

### Search

By default Wiretables will search in all fields, to overwrite this behaviour define the fields

```php
public function mount()
{
    $this->searchFields = ['name'];
}
```

### Fields

To change the default behaviour of the fields you must define the rules in $this->fields array. 
The key is the name of the field and the value an array of possible configurations

#### Column name

```php
$this->fields = [
    'name' => [
        'label' => 'Store name',
    ]
];
```

#### Hidden fields
Sometimes you want to return a field and use it but not display it

```php
$this->fields = [
    'id' => [
        'display' => false,
    ]
];
```

#### Date fields

```php
$this->fields = [
    'created_at' => [
        'type' => 'date',
        'type_format' => 'Y-m-d',
    ]
];
```

#### Custom field view

Inside the view you have access to all variables. The context related variables are $row, $field, $value

```php
$this->fields = [
    'email' => [
        'type' => 'custom',
        'type_view' => 'wiretables.bootstrap.fields.custom'
    ],
];
```

### Custom fields

Sometimes you need to add an additional column that does not exist in the database, for example an "actions" column.

```php
$this->customColumns = [
    'actions' => [
        'label' => 'Actions',
        'view' => 'wiretables.bootstrap.fields.actions'
    ]
];
```

The context related variables in these views are:

    $field; // name of the custom field/column
    $row; // current row instance
    $column; // Column data as defined above
    
Custom fields are not sortable

### Sorting

Update the default field (none) by which to sort the default query

```php
public function mount()
{
    $this->sortField = 'name';
}
```

Disable sorting for a field

```php
$this->fields = [
    'created_at' => [
        'sortable' => false
    ]
];
```

### Results per page

```php
$this->perPage = 5;

$this->perPageRanges = [5, 10, 20, 25];
```


### Template

By default Wiretables uses a simple bootstrap 4 template.
To update/extend the template create a view that extends the main view

```php
@extends('wiretables::bootstrap.index')
```
In the index file you can find all sections that can be extended

To change the view update $this->view

### Example

```php
<?php

namespace App\Http\Livewire;

use Livewire\Component;

class User extends Component
{
    use \Wiretables\Traits\Wiretable;

    /**
     * @return \Illuminate\Database\Query\Builder|Illuminate\Database\Eloquent\Builder
     */
    protected function model()
    {
         return \App\Models\User::select(['id', 'email', 'last_name', 'first_name', 'created_at']);
    }

    /**
     * Wiretable configuration
     */
    public function mount()
    {
        $this->fields = [
            'id' => [
                'display' => false,
            ],
            'email' => [
                'type' => 'custom',
                'type_view' => 'wiretables.bootstrap.fields.custom'
            ],
            'created_at' => [
                'label' => 'Created',
                'type' => 'date',
                'type_format' => 'Y-m-d',
                'sortable' => false
            ]
        ];

        $this->customColumns = [
            'actions' => [
                'label' => 'Actions',
                'view' => 'wiretables.bootstrap.fields.actions'
            ]
        ];

        $this->searchFields = ['email'];

        $this->sortField = 'email';

        $this->perPage = 5;

        $this->perPageRanges = [5, 10, 20, 25];
    }
}

```


## Credits

- [Laravel Livewire](https://laravel-livewire.com/docs/quickstart/)

## License

MIT
