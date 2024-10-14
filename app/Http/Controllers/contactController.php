<?php

namespace App\Http\Controllers;

use App\Models\contactModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\ContactMail;
use Exception;


class contactController extends Controller
{
    //
    public function getAllContact($key)
    {
        if ($key != env('PUBLIC_KEY')) {
            return response([
                'message' => "Unauthorized access",
            ], 401);
        }

        $contact = contactModel::orderBy('created_at', 'desc')->get();

        return response([
            'message' => "All contact email displayed successfully",
            'results' => $contact
        ], 200);
    }
    
    public function createContactEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'company' => 'nullable',
            'position' => 'nullable',
            'email' => 'required|email',
            'phone' => 'nullable',
            'subject' => 'required',
            'message' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'message' => $validator->errors(),
            ], 400);
        }

        $subject = strtolower($request->subject);
        switch ($subject) {
            case 'support inquiry':
                $recipients = ['dan@smsglobal.net','danwardbautista@gmail.com'];
                break;
            case 'general inquiry':
                $recipients = ['danwarddeveloper@gmail.com'];
                break;
            case 'sales inquiry':
                $recipients = ['danwardbautista@gmail.com'];
                break;
            case 'partnership inquiry':
                $recipients = ['baron@smsglobal.net'];
                break;
            default:
                $recipients = ['baron@smsglobal.net'];
                break;
        }

        // $subject = strtolower($request->subject);
        // switch ($subject) {
        //     case 'support inquiry':
        //         $recipients = ['sysadmin@smsglobal.net'];
        //         break;
        //     case 'general inquiry':
        //         $recipients = ['info@smsglobal.net'];
        //         break;
        //     case 'sales inquiry':
        //         $recipients = ['order@smsglobal.net'];
        //         break;
        //     case 'partnership inquiry':
        //         $recipients = ['andreheggem@smsglobal.net', 'wilfred@smsglobal.net'];
        //         break;
        //     default:
        //         $recipients = ['info@smsglobal.net'];
        //         break;
        // }

        $contact = contactModel::create([
            'name' => $request->name,
            'company' => $request->company,
            'position' => $request->position,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'receiver' => implode(',', $recipients)
        ]);

        try {
            Mail::to($recipients)->send(new ContactMail($contact->toArray(), $request->subject));

            return response([
                'message' => "Contact email sent successfully",
            ], 201);
        } catch (Exception $e) {
            return response([
                'message' => "Failed to send contact email",
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
