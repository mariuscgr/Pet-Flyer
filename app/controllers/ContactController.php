<?php

class ContactController extends BaseController{
    protected $layout = 'layouts.layout';

    public function getIndex(){
        $this->layout->content = View::make('contact');
        View::share('menu_active', 'contact');
    }

    public function getListing(){
        $contacts = Contact::all();
        $this->layout->content = View::make('contactList', ['contacts' => $contacts]);
        View::share('menu_active', 'contactList');
    }

    public function contactSave(){
        $contact = new Contact;
        $contact->Name = Input::get('name');
        $contact->Email = Input::get('email');
        $contact->Data = Input::get('data');
        $contact->save();

        return Redirect::to('/contactList');
    }

}