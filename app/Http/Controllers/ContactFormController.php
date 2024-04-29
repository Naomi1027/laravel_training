<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactForm;
use App\Services\CheckFormService;
use App\Http\Requests\StoreContactRequest;

class ContactFormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contactform::select('id', 'name', 'title', 'created_at')
        ->get();

        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreContactRequest $request)
    {
        // dd($request, $request->name);

        // 入力フォームのデータをDBにcreateメソッドを使って保存
        ContactForm::create([
            'name' => $request->name,
            'title' => $request->title,
            'email' => $request->email,
            'url' => $request->url,
            'gender' => $request->gender,
            'age' => $request->age,
            'contact' => $request->contact,
        ]);
        // リダイレクト
        return to_route('contacts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contact = ContactForm::find($id);

        // if($contact->gender === 0){
        //     $gender = '男性';
        // }else {
        //     $gender ='女性';
        // }
        $gender = CheckFormService::checkGender($contact);

        $age = CheckFormService::checkage($contact);

        

        return view('contacts.show', compact('contact', 'gender', 'age'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $contact = ContactForm::find($id);

        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $contact = ContactForm::find($id);
        $contact->name = $request->name;
        $contact->title = $request->title;
        $contact->email = $request->email;
        $contact->url = $request->url;
        $contact->gender = $request->gender;
        $contact->age = $request->age;
        $contact->contact = $request->contact;
        $contact->save();

        return to_route('contacts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $contact = ContactForm::find($id);
        $contact->delete();

        return to_route('contacts.index');
    }
}
