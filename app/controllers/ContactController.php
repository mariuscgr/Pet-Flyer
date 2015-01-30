<?php

class ContactController extends BaseController{
    protected $layout = 'layouts.layout';

    public function getIndex(){
        $contacts = Contact::all();
        $this->layout->content = View::make('contact', ['contacts' => $contacts]);
    }

    public function getListing(){
        $contacts = Contact::all();
        $this->layout->content = View::make('contactList', ['contacts' => $contacts]);
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