<?php

use Vistik\Apm\Sampling\On;
use Vistik\Apm\Sampling\Chance;

return [
    /*
      |--------------------------------------------------------------------------
      | Save the requestedAt attributes on requests in this timezone. Default: UTC
      |--------------------------------------------------------------------------
    */
    'timezone' => 'UTC',

    /*
      |--------------------------------------------------------------------------
      | If you get alot of requests log logging could take up alot of disk space
      | sampling enables you to record only a potion of your requests.
      | Out-of-the-box options: Change() takes a argument 0 to 100.
      | So you can sample let say 10% of your requests by using: new Chance(10)
      | You could implement your on sampler (lets say to only record requests from
      | from your enterprise customers)
      |--------------------------------------------------------------------------
    */
    'sampler' => new Chance(100),

    /*
      |--------------------------------------------------------------------------
      | This will save the full sql's including values (password etc). Default: false
      |--------------------------------------------------------------------------
    */
    'showBindings' => false,

    /*
      |--------------------------------------------------------------------------
      | Log database queries to log file in addition to the database. Default: false
      |--------------------------------------------------------------------------
    */
    'saveQueriesToLog' => false,

    /*
      |--------------------------------------------------------------------------
      | Log HTTP requests to log file in addition to the database. Default: false
      |--------------------------------------------------------------------------
    */
    'saveRequestsToLog' => false,

    /*
      |--------------------------------------------------------------------------
      | Clean up database after x days (both request & queries)
      |--------------------------------------------------------------------------
    */
    'keepRecordsForDays' => 30,
];