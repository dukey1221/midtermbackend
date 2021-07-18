<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Exception;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show(Contact $contact) {
        return response()->json($contact,200);
    }

    public function search(Request $request) {
        $request->validate(['key'=>'string|required']);

        $contacts = Contact::where('name','like',"%$request->key%")
            ->orWhere('email','like',"%$request->key%")->get();

        return response()->json($assets, 200);
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'string|required',
            'email' => 'string|required',
            'phone' => 'string|required',
            'address' => 'string|required',
            'job' => 'string|required',
        ]);

        try {
            $contact = Contact::create($request->all());
            return response()->json($contact, 202);
        }catch(Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ],500);
        }

    }

    public function update(Request $request, Contact $contact) {
        try {
            $contact->update($request->all());
            return response()->json($contact, 202);
        }catch(Exception $ex) {
            return response()->json(['message'=>$ex->getMessage()], 500);
        }
    }

    public function destroy(Contact $contact) {
        $asset->delete();
        return response()->json(['message'=>'Asset deleted.'],202);
    }

    public function index() {
        $contacts = Contact::orderBy('name')->get();
        return response()->json($contacts, 200);
    }
}