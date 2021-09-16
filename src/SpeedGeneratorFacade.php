<?php

namespace MagedAhmad\SpeedGenerator;

use Illuminate\Support\Facades\Facade;

/**
 * @see \MagedAhmad\SpeedGenerator\Skeleton\SkeletonClass
 */
class SpeedGeneratorFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'speed-generator';
    }
}
