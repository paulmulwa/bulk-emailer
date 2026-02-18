<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Jobs\SendBulkEmailJob;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\EmailsImport;

class EmailController extends Controller
{
    public function index()
    {
        return view('emails.index');
    }

    public function store(Request $request)
    {
        $request->validate(['file' => 'required|mimes:xlsx,csv']);

        Excel::import(new EmailsImport, $request->file('file'));

        return redirect()->route('emails.create')->with('success', 'File uploaded successfully!');
    }

    public function create()
    {
        $emails = Email::all();
        return view('emails.create', compact('emails'));
    }

    public function sendBulkEmail(Request $request)
    {
        $request->validate([
            'subject' => 'required|string',
            'message' => 'required|string',
        ]);

        $subject = $request->subject;
        $rawMessage = $request->message;

        // Convert HTML to plain text to prevent encoding issues
        $plainMessage = html_entity_decode(strip_tags(nl2br($rawMessage)));

        $emails = Email::all(); // Fetch emails from database

        if ($emails->isEmpty()) {
            return back()->with('error', 'No emails found.');
        }

        $chunks = $emails->chunk(50);
        $delay = now();

        foreach ($chunks as $batch) {
            foreach ($batch as $emailData) {
                // Personalize message
                $personalizedMessage = str_replace('{FirstName}', $emailData->first_name, $plainMessage);
                SendBulkEmailJob::dispatch($emailData, $subject, $personalizedMessage)->delay($delay);
            }
            $delay->addMinutes(2); // Delay each batch by 2 minutes
        }

        return back()->with('success', 'Emails are being sent in batches.');
    }

}
