<?php

namespace Owenzhou\LaravelAsset;

use Illuminate\Support\Facades\Facade as LaravelFacade;

class Facade extends LaravelFacade{

	protected static function getFacadeAccessor(){
        return 'assets';
    }

}