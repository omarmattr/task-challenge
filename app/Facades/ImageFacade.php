<?php
namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class ImageFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ImageService'; // This should match the binding name in the service container
    }
}