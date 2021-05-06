<?php

namespace App\Providers;

use App\CompanyEmail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // if(isset(Auth::user()->id)) {

                // $configuration = CompanyEmail::where("main_acct_id", Auth::user()->id)->first();

                // if(!is_null($configuration)) {
                    $config = array(
                        'driver'     =>     'smtp',
                        'host'       =>     'smtp.mailtrap.io',
                        'port'       =>     25,
                        'username'   =>     '30cd411d798855',
                        'password'   =>     '9b354768f5a89d',
                        'encryption' =>     'TLS',
                        'from'       =>     array('address' => 'francissample@frank.com', 'name' => 'SamleEmail'),
                    );
                    Config::set('mail', $config);
                // }
            // }
    }
}
