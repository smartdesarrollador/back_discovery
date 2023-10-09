<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Mail\ContactForm;
use App\Mail\CreateOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends ApiController
{
    public function sendContactForm(Request $request)
    {
        sleep(2);
        $reqArray = $request->all();


        Mail::to(Config('values.contact_email'))
            ->send(new ContactForm($reqArray['subject'],$reqArray['name'],$reqArray['email'],$reqArray['message']));
        return $this->showArray($reqArray);


    }
}
