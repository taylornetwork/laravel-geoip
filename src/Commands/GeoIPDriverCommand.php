<?php

namespace TaylorNetwork\GeoIP\Commands;

use Illuminate\Console\GeneratorCommand;

class GeoIPDriverCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'geoip:driver';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new GeoIP Driver class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'GeoIP Driver';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/stubs/driver.stub';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\\GeoIP\\Drivers';
    }

}
