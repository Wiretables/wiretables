<?php

namespace Wiretables\Commands;

use Illuminate\Console\GeneratorCommand;

class MakeComponent extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'wiretables:make';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Livewire Component that uses Wiretables';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Livewire';

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        return parent::replaceClass($stub, $name);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/wiretable.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return config('livewire.class_namespace', 'App\\Http\\Livewire');
    }
}
