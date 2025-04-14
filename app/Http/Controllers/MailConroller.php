<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\kycEdd;
use App\Mail\NewEDDMail;
use App\Mail\NewKYCMail;
use App\Models\KycEddQa;
use App\Mail\ResponseMail;
use App\Models\kycRequest;
use App\Models\Onboarding;
use App\Mail\ContractEmail;
use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use App\Mail\PrekycResponseMail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class MailConroller extends Controller
{

    // public function sendNewKYC($id)
    // {

    //     $id = decrypt($id);
    //     $kycRequest = kycRequest::find($id);
    //     $client = Onboarding::find($kycRequest->clientId);

    //     $comments = $kycRequest->comments;
    //     $docsRequired = ["certificate", "passport", "certificate_of_share_holding", "certificate_of_registered_office", "6_months_processing_history", "6_months_chargeback_history", "6_months_refund_history"];
    //     $companyName = $client->company_name;
    //     $subject = "KYC Request from PayIT123";
    //     $uploadLink = "https://payit123crm.com/CRM/public/uploadDoc/" . $id;

    //     kycRequest::where('id', $id)->update(['requiredDocs' => $docsRequired, 'comments' => "Please upload the required documents"]);
    //     $response = Mail::to($client->email)->send(new ContactFormMail($comments, $docsRequired, $subject, $companyName, $uploadLink));

    //     if ($response) {
    //         kycRequest::where('id', $id)->update(['first_mail_sent' => 1, 'status' => 'Pending']);
    //         return back()->with('success', 'Email has been sent.');
    //     } else {
    //         return back()->with('error', 'Try Again.');
    //     }
    // }

    public function sendNewKYC($id)
    {
        $id = decrypt($id);
        $kycRequest = kycRequest::find($id);
        $client = Onboarding::find($kycRequest->clientId);

        $companyName = $client->client_type == 'Individual' ? $client->first_name . ' ' . $client->last_name :  $client->company_name;
        $subject = "New KYC Request from PayIT123";
        $uploadLink = "https://payit123crm.com/CRM/public/kycrequests/newKYCform/" . $id;
        $response = Mail::to($client->email)->send(new NewKYCMail($subject, $companyName, $uploadLink));

        if ($response) {
            kycRequest::where('id', $id)->update(['first_mail_sent' => 1, 'status' => 'newKYCPending']);
            return back()->with('success', 'Email has been sent.');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function sendRequestMail($id)
    {
        $kycRequest = kycRequest::find($id);
        $client = Onboarding::find($kycRequest->clientId);

        $comments = $kycRequest->comments;
        $docsRequired = json_decode($kycRequest->requiredDocs);
        $companyName = $client->company_name;
        $subject = "KYC Update Request from PayIT123";
        $uploadLink = "https://payit123crm.com/CRM/public/uploadDoc/" . $id;


        $response = Mail::to($client->email)->send(new ContactFormMail($comments, $docsRequired, $subject, $companyName, $uploadLink));

        if ($response) {
            kycRequest::where('id', $id)->update(['first_mail_sent' => 1, 'status' => 'Pending']);
            return back()->with('success', 'Email has been sent.');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function sendEDDLink($id)
    {
        $id = decrypt($id);
        $kycRequest = kycRequest::find($id);
        $client = Onboarding::find($kycRequest->clientId);

        $companyName = $client->company_name;
        $subject = "Additional Details Enquiry from PayIT123";
        $uploadLink = "https://payit123crm.com/CRM/public/kycrequests/newEDDform/" . $id;
        $response = Mail::to($client->email)->send(new NewEDDMail($subject, $companyName, $uploadLink));

        if ($response) {
            kycRequest::where('id', $id)->update(['first_mail_sent' => 1, 'eddStatus' => 'Initiated']);
            return back()->with('success', 'Email has been sent.');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function sendEDDResponseLink($id)
    {
        $id = decrypt($id);
        $EddValues = kycEdd::where('id', $id)->get()->first();
        $companyName = $EddValues->onboardDetail->company_name;
        $subject = "Queries on Additional Details from PayIT123";
        $replyLink = "https://payit123crm.com/CRM/public/kycrequests/eddResponse/" . $id;
        $response = Mail::to($EddValues->onboardDetail)->send(new ResponseMail($subject, $companyName, $replyLink));

        if ($response) {
            kycRequest::where('id', $id)->update(['eddStatus' => 'Initiated']);
            $EddValues->update(['status' => 'Initiated']);
            return back()->with('success', 'Email has been sent.');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function sendPrekycResponseLink($id)
    {
        $id = decrypt($id);
        $client = Onboarding::where('id', $id)->get()->first();
        $clientName = ($client->client_type == 'Individual') ? $client->first_name . ' ' . $client->last_name : $client->company_name;
        $subject = "Clarifications needed from PayIT123";
        $replyLink = "https://payit123crm.com/CRM/public/kycrequests/prekycResponseLink/" . $id;
        $response = Mail::to($client->email)->send(new PrekycResponseMail($subject, $clientName, $replyLink));

        if ($response) {
            Onboarding::where('id', $id)->update(['prekycclarification_status' => 'Initiated']);
            return back()->with('success', 'Email has been sent.');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function sendContractMail(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'contractFile' => 'required|mimes:pdf,doc,docx|max:5120'
        ], [
            'contractFile.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'contractFile.max' => 'Maximum File Size : 5mb Exceeded',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        };

        $kycRequest = kycrequest::find($id);
        $client = Onboarding::find($kycRequest->clientId);
        $uploadLink = "https://payit123crm.com/CRM/public/uploadContract/" . $id;
        $subject = "Onboarding Contract from PayIT123";



        if ($request->hasFile('contractFile')) {

            if ($client->client_type == 'Individual') {
                $company_name = $client->first_name . ' ' . $client->last_name;
            } else {
                $company_name = $client->company_name;
            }


            $fileName = $company_name . '_contract.' .  $request->file('contractFile')->extension();
            $request->file('contractFile')->move('contracts', $fileName);
        }

        $response = Mail::to($client->email)->send(new ContractEmail($company_name, $fileName, $uploadLink, $subject));

        if ($response) {
            kycRequest::where('id', $id)->update(['contract_status' => 'Sent']);
            return back()->with('success', 'Email has been sent.');
        } else {
            return back()->with('error', 'Unable to send Contract to Client. Please Try Again.');
        }
    }
}
