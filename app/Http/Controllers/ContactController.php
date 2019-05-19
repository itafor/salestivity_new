<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Contact;

class ContactController extends Controller
{
    public function index()
    {
        return view('customer.show');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contact::where('customer_id', $id)->get()->first();
        
        return view('customer.contact.show', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);
        // dd($contact->id);
        
        $this->validate($request, [
            'contact_title' => 'required',
            'contact_email' => 'required|email',
            'contact_phone' => 'required',
            'contact_surname' => 'required',
            'contact_name' => 'required'
        ]);
        $contact->title = $request->input('contact_title');
        $contact->email = $request->input('contact_email');
        $contact->phone = $request->input('contact_phone');
        $contact->surname = $request->input('contact_surname');
        $contact->name = $request->input('contact_name');
        $contact->save();
    
        return redirect()->route('customer.contact.show', $contact->id);

    }


    /**
     * Save a newly added Contact in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function saveContacts(Request $request, $id)
    {
        $account = Customer::where('id',$id)->first();
        $contacts = Contact::where('customer_id', $account->id)->first();
    }

}
