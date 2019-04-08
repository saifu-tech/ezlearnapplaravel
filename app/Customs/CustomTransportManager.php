<?php 
namespace App\Customs;

use Illuminate\Mail\TransportManager;
use App\Options; //my models are located in app\models

class CustomTransportManager extends TransportManager 
{

    /**
     * Create a new manager instance.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        $this->app = $app;

        //if( $settings = Options::all() ){

            $this->app['config']['mail'] = [
                'driver'        => "smtp",
                'host'          => Options::getvalue("smtpHost")!=""?Options::getvalue("smtpHost"):"mail.cloudelabs.com",
                'port'          => Options::getvalue("smtpPort")!=""?Options::getvalue("smtpPort"):25,
                'from'          => [
                'address'   => Options::getvalue("sentEmail")!=""?Options::getvalue("sentEmail"):"sales@cloudelabs.com",
                'name'      => Options::getvalue("senderName")!=""?Options::getvalue("senderName"):"sales@cloudelabs.com"
                ],
                'encryption'    => "tls",
                'username'      => Options::getvalue("smtpEmail")!=""?Options::getvalue("smtpEmail"):"sales@cloudelabs.com",
                'password'      => Options::getvalue("smtpPassword")!=""?Options::getvalue("smtpPassword"):"Cloud@123",
                'sendmail'      => "/usr/sbin/sendmail -bs",
                'pretend'       => false
           ];
       }

    //}
}