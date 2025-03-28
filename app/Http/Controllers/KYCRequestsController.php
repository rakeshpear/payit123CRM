<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\kycEdd;
use App\Models\Countrie;
use App\Models\KycEddQa;
use App\Mail\PassportMail;
use App\Models\clientTeam;
use App\Models\kycRequest;
use App\Models\Onboarding;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Services\SumsubService;
use App\Models\clientDemography;
use App\Models\Prekyc_qas;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\Collection;

// use Dotenv\Validator;

class KYCRequestsController extends Controller
{

    public function index()
    {
        $kycLists = kycRequest::all();
        $prekycqs = Prekyc_qas::all();

        return view('kycrequests.index', compact('kycLists', 'prekycqs'));
    }

    // public function create()
    // {

    //     $kycRequestList = kycRequest::all();
    //     $kyc_already_requested = array();
    //     foreach ($kycRequestList as $value) {
    //         if (!($value->status == 'Closed')) {
    //             $kyc_already_requested[] = $value->userName->company_name;
    //         }
    //     }

    //     $applicants = Onboarding::all();

    //     return view('kycrequests.create', ['kyc_already_requested' => $kyc_already_requested, 'applicants' => $applicants]);
    // }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'userID' => 'required|string',
            'comments' => 'required',
            'reqDocs' => 'required|min:1'
        ], [
            'userID.required' => 'Please choose a Client',
            'comments.required' => 'Please leave a comment',
            'reqDocs.required' => 'Please select atleast one document'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $date = Carbon::now()->format('d-m-Y');

        //    request()->validate([
        //     'userID' => 'required|string',
        //     'comments' => 'required',
        //     'reqDocs' =>'required|min:1'
        //    ],[
        //     'userID.required' => 'Please choose a Client',
        //     'comments.required' => 'Please leave a comment',
        //     'reqDocs.required' => 'Please select atleast one document'
        //    ]); 

        $params['clientId'] = $request->userID;
        $params['requiredDocs'] = json_encode($request->reqDocs);
        $params['comments'] = $date . " : " . $request->comments;

        $res = kycRequest::create($params);

        if ($res) {
            return redirect('kycrequests')->with('success', 'Request Created Successfully.');;
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function view(string $id)
    {
        $client = kycRequest::find(decrypt($id));
        $client['processing_currencies'] = json_decode($client->userName->processing_currencies);
        return view('kycrequests.view', compact('client'));
    }

    public function edit(string $id)
    {
        $kycRequest = kycRequest::find($id);
        $kycRequest['requiredDocs'] = json_decode($kycRequest->requiredDocs);
        return view('kycrequests.edit', compact('kycRequest'));
    }

    public function update(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [
            'reqDocs' => 'required|min:1'
        ], [
            'reqDocs.required' => 'Please select atleast one document'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $updatedRequiredDocs = $request->reqDocs;
        $date = Carbon::now()->format('d-m-Y');
        $comments = $date . " : " . $request->comments;

        $result = kycRequest::where('id', $id)->update(['requiredDocs' => $updatedRequiredDocs, 'first_mail_sent' => 0, 'status' => 'Pending', 'comments' => $comments]);
        if ($result) {
            return redirect('kycrequests')->with('success', 'Request Updated Successfully.');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function destroy(string $id)
    {
        //
    }

    public function uploadDoc(string $id)
    {
        $kycRequest = kycRequest::find($id);

        if ($kycRequest->status === 'New' || $kycRequest->status === 'Pending') {
            return view('kycrequests.uploadDoc', compact('kycRequest'));
        } else {
            return redirect('/success');
        }
    }

    public function uploadContract(string $id)
    {
        $kycRequest = kycRequest::find($id);

        if ($kycRequest->status !== 'Approved' && $kycRequest->status !== 'Signed') {
            return view('kycrequests.uploadContract', compact('kycRequest'));
        } else {
            return redirect('/success');
        }
    }

    public function storeDoc(Request $request, string $id)
    {

        $validator = Validator::make($request->all(), [

            // 'passportIssue' => 'date',
            // 'passportExpiry' => 'date',
            // 'passport' => 'mimes:pdf,jpg,png,jpeg|max:5120',
            'nationalIDIssue' => 'date',
            'nationalIDExpiry' => 'date',
            'nationalID' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'licenseIssue' => 'date',
            'licenseExpiry' => 'date',
            'license' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'otherID' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'utilityBillIssue' => 'date',
            'utilityBill' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'bankStatementIssue' => 'date',
            'bankStatement' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'leaseAgreementIssue' => 'date',
            'leaseAgreement' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'incorporation' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'shareholding' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'coro' => 'mimes:pdf,jpg,png,jpeg|max:5120',
            'processing' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'refund' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'comments' => 'nullable'
        ], [

            // 'passportIssue.date' => 'Invalid Date',
            // 'passportExpiry.date' => 'Invalid Date',
            // 'passport.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'passport.max' => 'File Size Limit 5mb - Exceeded',
            'nationalIDIssue.date' => 'Invalid Date',
            'nationalIDExpiry.date' => 'Invalid Date',
            'nationalID.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'nationalID.max' => 'File Size Limit 5mb - Exceeded',
            'licenseIssue.date' => 'Invalid Date',
            'licenseExpiry.date' => 'Invalid Date',
            'license.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'license.max' => 'File Size Limit 5mb - Exceeded',
            'otherID.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'otherID.max' => 'File Size Limit 5mb - Exceeded',
            'utilityBill.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'utilityBillIssue.date' => 'Invalid Date',
            'utilityBill.max' => 'File Size Limit 5mb - Exceeded',
            'bankStatement.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'bankStatementIssue.date' => 'Invalid Date',
            'bankStatement.max' => 'File Size Limit 5mb - Exceeded',
            'leaseAgreement.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'leaseAgreementIssue.date' => 'Invalid Date',
            'leaseAgreement.max' => 'File Size Limit 5mb - Exceeded',
            'incorporation.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'incorporation.max' => 'File Size Limit 5mb - Exceeded',
            'shareholding.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'shareholding.max' => 'File Size Limit 5mb - Exceeded',
            'coro.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'coro.max' => 'File Size Limit 5mb - Exceeded',
            'processing.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'processing.max' => 'File Size Limit 5mb - Exceeded',
            'refund.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'refund.max' => 'File Size Limit 5mb - Exceeded',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $kycRequest = kycRequest::find($id);
        $clientName = Onboarding::find($kycRequest->clientId);

        if ($clientName->client_type == 'Individual') {
            $clientCompany =  $clientName->first_name . '_' . $clientName->last_name . '_' .  $clientName->id;
        } else if ($clientName->client_type == 'Legal Entity') {
            $clientCompany =  $clientName->company_name . '_' . $clientName->id;
        }

        $path = public_path() . '/document/' . $clientCompany;
        if (!Storage::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        // Passport
        // if (in_array('Passport', json_decode($kycRequest->requiredDocs))) {
        //     if ($request->hasFile('passport')) {

        //         if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->passportt)) {
        //             File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->passportt);
        //         }

        //         $file = $request->file('passport');
        //         $fileName = $clientCompany . '_Passport.' . $file->extension();
        //         $file->move($path, $fileName);
        //         $passportValue     = '/document/' . $clientCompany . '/' . $fileName;
        //         $passportIssueNew = $request->passportIssue;
        //         $passportExpiryNew = $request->passportExpiry;
        //         $passportReasonNew = null;
        //         $passportStatusNew = null;
        //     }
        // } else {
        //     $passportValue = $kycRequest->passportt;
        //     $passportIssueNew = $kycRequest->passportIssue;
        //     $passportExpiryNew = $kycRequest->passportExpiry;
        //     $passportReasonNew = $kycRequest->passportt_reason;
        //     $passportStatusNew = $kycRequest->passportt_status;
        // }

        // National ID
        if (in_array('National ID', json_decode($kycRequest->requiredDocs))) {
            if ($request->hasFile('nationalID')) {

                if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->nationalID)) {
                    File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->nationalID);
                }

                $file = $request->file('nationalID');
                $fileName = $clientCompany . '_National_ID.' . $file->extension();
                $file->move($path, $fileName);
                $nationalIDValue     = '/document/' . $clientCompany . '/' . $fileName;
                $nationalIDIssueNew = $request->nationalIDIssue;
                $nationalIDExpiryNew = $request->nationalIDExpiry;
                $nationalIDReasonNew = null;
                $nationalIDStatusNew = null;
            }
        } else {
            $nationalIDValue = $kycRequest->nationalID;
            $nationalIDIssueNew = $kycRequest->nationalIDIssue;
            $nationalIDExpiryNew = $kycRequest->nationalIDExpiry;
            $nationalIDReasonNew = $kycRequest->nationalID_reason;
            $nationalIDStatusNew = $kycRequest->nationalID_status;
        }

        // Driving License
        if (in_array('Driving License', json_decode($kycRequest->requiredDocs))) {
            if ($request->hasFile('license')) {

                if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->license)) {
                    File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->license);
                }

                $file = $request->file('license');
                $fileName = $clientCompany . '_License.' . $file->extension();
                $file->move($path, $fileName);
                $licenseValue     = '/document/' . $clientCompany . '/' . $fileName;
                $licenseIssueNew = $request->licenseIssue;
                $licenseExpiryNew = $request->licenseExpiry;
                $licenseReasonNew = null;
                $licenseStatusNew = null;
            }
        } else {
            $licenseValue = $kycRequest->license;
            $licenseIssueNew = $kycRequest->licenseIssue;
            $licenseExpiryNew = $kycRequest->licenseExpiry;
            $licenseReasonNew = $kycRequest->license_reason;
            $licenseStatusNew = $kycRequest->license_status;
        }

        // Other ID
        if (in_array('Other ID', json_decode($kycRequest->requiredDocs))) {
            if ($request->hasFile('otherID')) {

                if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->otherID)) {
                    File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->otherID);
                }

                $file = $request->file('otherID');
                $fileName = $clientCompany . '_OtherID.' . $file->extension();
                $file->move($path, $fileName);
                $otherIDValue     = '/document/' . $clientCompany . '/' . $fileName;
                $otherIDStatusNew = null;
                $otherIDReasonNew = null;
            }
        } else {
            $otherIDValue = $kycRequest->otherID;
            $otherIDStatusNew = $kycRequest->otherID_status;
            $otherIDReasonNew = $kycRequest->otherID_status;
        }

        // Utility Bill
        if (in_array('Utility Bill', json_decode($kycRequest->requiredDocs))) {
            if ($request->hasFile('utilityBill')) {

                if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->utilityBill)) {
                    File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->utilityBill);
                }

                $file = $request->file('utilityBill');
                $fileName = $clientCompany . '_Utility_Bill.' . $file->extension();
                $file->move($path, $fileName);
                $utilityBillValue     = '/document/' . $clientCompany . '/' . $fileName;
                $utilityBillIssueNew = $request->utilityBillIssue;
                $utilityBillStatusNew = null;
                $utilityBillReasonNew = null;
            }
        } else {
            $utilityBillValue = $kycRequest->utilityBill;
            $utilityBillIssueNew = $kycRequest->utilityBillIssue;
            $utilityBillStatusNew = $kycRequest->utilityBill_status;
            $utilityBillReasonNew = $kycRequest->utilityBill_reason;
        }

        // Bank Statement
        if (in_array('Bank Statement', json_decode($kycRequest->requiredDocs))) {
            if ($request->hasFile('bankStatement')) {

                if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->bankStatement)) {
                    File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->bankStatement);
                }

                $file = $request->file('bankStatement');
                $fileName = $clientCompany . '_Bank_Statement.' . $file->extension();
                $file->move($path, $fileName);
                $bankStatementValue     = '/document/' . $clientCompany . '/' . $fileName;
                $bankStatementIssueNew = $request->bankStatementIssue;
                $bankStatementStatusNew = null;
                $bankStatementReasonNew = null;
            }
        } else {
            $bankStatementValue = $kycRequest->bankStatement;
            $bankStatementIssueNew = $kycRequest->bankStatementIssue;
            $bankStatementStatusNew = $kycRequest->bankStatement_status;
            $bankStatementReasonNew = $kycRequest->bankStatement_reason;
        }

        // Lease Agreement
        if (in_array('Lease Agreement', json_decode($kycRequest->requiredDocs))) {
            if ($request->hasFile('leaseAgreement')) {

                if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->leaseAgreement)) {
                    File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->leaseAgreement);
                }

                $file = $request->file('leaseAgreement');
                $fileName = $clientCompany . '_Lease_Agreement.' . $file->extension();
                $file->move($path, $fileName);
                $leaseAgreementValue     = '/document/' . $clientCompany . '/' . $fileName;
                $leaseAgreementIssueNew = $request->leaseAgreementIssue;
                $leaseAgreementStatusNew = null;
                $leaseAgreementReasonNew = null;
            }
        } else {
            $leaseAgreementValue = $kycRequest->leaseAgreement;
            $leaseAgreementIssueNew = $kycRequest->leaseAgreementIssue;
            $leaseAgreementStatusNew = $kycRequest->leaseAgreement_status;
            $leaseAgreementReasonNew = $kycRequest->leaseAgreement_reason;
        }

        // Certificate of Incorporation
        if ($request->hasFile('incorporation')) {

            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->incorporation)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->incorporation);
            }

            $file = $request->file('incorporation');
            $fileName = $clientCompany . '_Incorporation_Certificate.' . $file->extension();
            $file->move($path, $fileName);
            $incorporationValue     = '/document/' . $clientCompany . '/' . $fileName;
            $incorporationStatusNew = null;
            $incorporationReasonNew = null;
        } else {
            $incorporationValue = $kycRequest->incorporation;
            $incorporationStatusNew = $kycRequest->incorporation_status;
            $incorporationReasonNew = $kycRequest->incorporation_reason;
        }

        // certificate_of_share_holding
        if ($request->hasFile('shareHolding')) {

            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->shareHolding)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->shareHolding);
            }

            $file = $request->file('shareHolding');
            $fileName = $clientCompany . '_Shareholding_certificate.' . $file->extension();

            $file->move($path, $fileName);
            $shareHoldingValue  = '/document/' . $clientCompany . '/' . $fileName;
            $shareHoldingReasonNew = null;
            $shareHoldingStatusNew = null;
        } else {
            $shareHoldingValue = $kycRequest->shareHolding;
            $shareHoldingReasonNew = $kycRequest->shareHolding_reason;
            $shareHoldingStatusNew = $kycRequest->shareHolding_status;
        }

        // certificate_of_registered_office
        if ($request->hasFile('coro')) {

            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->coro)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->coro);
            }

            $file = $request->file('coro');
            $fileName = $clientCompany . '_coro.' . $file->extension();
            $file->move($path, $fileName);
            $coroValue  = '/document/' . $clientCompany . '/' . $fileName;
            $coroReasonNew = null;
            $coroStatusNew = null;
        } else {
            $coroValue = $kycRequest->coro;
            $coroReasonNew = $kycRequest->coro_reason;
            $coroStatusNew = $kycRequest->coro_status;
        }

        // 6_months_processing_history
        if ($request->hasFile('processing')) {

            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->processing)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->processing);
            }

            $file = $request->file('processing');
            $fileName = $clientCompany . '_Processing_History.' . $file->extension();
            $file->move($path, $fileName);
            $processingValue  = '/document/' . $clientCompany . '/' . $fileName;
            $processingStatusNew  = null;
            $processingReasonNew  = null;
        } else {
            $processingValue = $kycRequest->processing;
            $processingStatusNew  = $kycRequest->processing_status;
            $processingReasonNew  = $kycRequest->processing_reason;
        }

        // 6_months_refund_history
        if ($request->hasFile('refund')) {

            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->refund)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->refund);
            }

            $file = $request->file('refund');
            $fileName = $clientCompany . '_Refund_History.' . $file->extension();
            $file->move($path, $fileName);
            $refundValue  = '/document/' . $clientCompany . '/' . $fileName;
            $refundReasonNew = $kycRequest->refund_reason;
            $refundStatusNew = $kycRequest->refund_status;
        } else {
            $refundValue = $kycRequest->refund;
            $refundReasonNew = $kycRequest->refund_reason;
            $refundStatusNew = $kycRequest->refund_status;
        }

        $response = $kycRequest->update([

            'nationalID'                    => $nationalIDValue,
            'nationalIDIssue'               => $nationalIDIssueNew,
            'nationalIDExpiry'              => $nationalIDExpiryNew,
            'nationalID_reason'             => $nationalIDReasonNew,
            'nationalID_status'             => $nationalIDStatusNew,

            'license'                       => $licenseValue,
            'licenseIssue'                  => $licenseIssueNew,
            'licenseExpiry'                 => $licenseExpiryNew,
            'license_reason'                => $licenseReasonNew,
            'license_status'                => $licenseStatusNew,

            'otherID'                       => $otherIDValue,
            'otherID_reason'                => $otherIDReasonNew,
            'otherID_status'                => $otherIDStatusNew,

            'utilityBill'                   => $utilityBillValue,
            'utilityBillIssue'              => $utilityBillIssueNew,
            'utilityBill_reason'            => $utilityBillReasonNew,
            'utilityBill_status'            => $utilityBillStatusNew,

            'bankStatement'                 => $bankStatementValue,
            'bankStatementIssue'            => $bankStatementIssueNew,
            'bankStatement_reason'          => $bankStatementReasonNew,
            'bankStatement_status'          => $bankStatementStatusNew,

            'leaseAgreement'                => $leaseAgreementValue,
            'leaseAgreementIssue'           => $leaseAgreementIssueNew,
            'leaseAgreement_reason'         => $leaseAgreementReasonNew,
            'leaseAgreement_status'         => $leaseAgreementStatusNew,

            'incorporation'                 => $incorporationValue,
            'incorporation_reason'          => $incorporationReasonNew,
            'incorporation_status'          => $incorporationStatusNew,

            'shareHolding'                  => $shareHoldingValue,
            'shareHolding_reason'           => $shareHoldingReasonNew,
            'shareHolding_status'           => $shareHoldingStatusNew,

            'coro'                          => $coroValue,
            'coro_reason'                   => $coroReasonNew,
            'coro_status'                   => $coroStatusNew,

            'processing'                    => $processingValue,
            'processing_reason'             => $processingReasonNew,
            'processing_status'             => $processingStatusNew,

            'refund'                        => $refundValue,
            'refund_reason'                 => $refundReasonNew,
            'refund_status'                 => $refundStatusNew,

            'comments'                      => $clientName->company_name . " : " . $request->comments,
            'status'                        => 'Files Received',
            'requiredDocs'                  => '["",""]'
        ]);

        if ($response) {
            return redirect('/success');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function storeContract(Request $request, string $id)
    {


        $validator = Validator::make($request->all(), [

            'contract' => 'mimes:pdf,jpg,png,jpeg,doc,docx|max:5120',
        ], [

            'contract.mimes' => 'Only Jpg, Png or Pdf files allowed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }


        $kycRequest = kycRequest::find($id);

        $clientName = Onboarding::find($kycRequest->clientId);

        $clientCompany =  $clientName->company_name;

        $date = Carbon::now()->format('d-m-Y');

        // Certificate of Incorporation
        if ($request->hasFile('contract')) {

            if (File::exists(public_path() . $kycRequest->contract)) {
                File::delete(public_path() . $kycRequest->contract);
            }

            $file = $request->file('contract');
            $fileName = $clientCompany . '_contract_signed.' . $file->extension();
            $file->move(public_path('/contracts/'), $fileName);
            $contractValue     = '/contracts/' . $fileName;
            $contractCommentsValue = "Contract Signed & Received on " . $date;
            $status = "Signed";
            $contractCommentFlag = 0;
            $contract_status = 'Signed';
        } else {
            $contractValue = $kycRequest->contract;
            if ($request->comments) {
                $contractCommentsValue = $date . " : " . $request->comments;
                $status = "Closed";
                $contractCommentFlag = 1;
                $contract_status = null;
            }
        }

        $response = $kycRequest->update([
            'contract'                      => $contractValue,
            'contract_comments'             =>  $contractCommentsValue,
            'status'                        => $status,
            'contract_comment_flag'         => $contractCommentFlag,
            'contract_status'               => $contract_status
        ]);


        if ($response) {
            return redirect('/success');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function closeWithLowRisk(string $id)
    {

        $result = kycRequest::where('id', $id)->update(['status' => 'Closed', 'riskFactor' => 0]);
        if ($result) {
            return redirect('kycrequests')->with('success', 'Request Closed Successfully.');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function closeWithHighRisk(string $id)
    {

        $onboardingID = kycRequest::where('id', $id)->value('clientId');

        $paramss['onboarding_ID'] = $onboardingID;
        $paramss['kyc_ID'] = $id;

        kycEdd::create($paramss);
        $result = kycRequest::where('id', $id)->update(['status' => 'Closed', 'riskFactor' => 1, 'first_mail_sent' => 0]);
        if ($result) {
            return redirect('kycrequests')->with('success', 'Request Closed Successfully.');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function approve(string $id)
    {

        $client = kycRequest::find($id);
        Onboarding::where('id', $client->clientId)->update(['status' => '0']);

        $result = kycRequest::where('id', $id)->update(['status' => 'Approved']);
        if ($result) {
            return redirect('kycrequests')->with('success', 'Client Approved Successfully.');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function disapprove(string $id)
    {

        $client = kycRequest::find($id);
        Onboarding::where('id', $client->clientId)->update(['status' => '1']);
        $result = kycRequest::where('id', $id)->update(['status' => 'Closed']);
        if ($result) {
            return redirect('kycrequests')->with('success', 'Client Approval Reverted Successfully.');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function rejectClient(string $id)
    {
        $id = decrypt($id);
        $clientKyc = kycRequest::findOrFail($id);
        $clientOnboarding = Onboarding::findOrFail($clientKyc->clientId);
        $clientKyc->update(['rejectionFlag' => 1]);
        $clientOnboarding->update(['rejectionFlag' => 1]);
        return redirect()->back()->with('success', 'Client rejected successfully');
    }

    public function revertRejection(string $id)
    {
        $id = decrypt($id);
        $clientOnboarding = Onboarding::findOrFail($id);
        $clientKyc = kycRequest::where('clientId', $id)->first();
        $clientKyc->update(['rejectionFlag' => 0]);
        $clientOnboarding->update(['rejectionFlag' => 0]);
        return redirect()->back()->with('success', 'Client rejection reverted successfully');
    }

    public function success()
    {
        return view('kycrequests.successPage');
    }

    public function docApprove(string $id, string $docName, string $docReasonName)
    {

        $result = kycRequest::where('id', decrypt($id))->update([$docName => 1, $docReasonName => null]);
        if ($result) {
            return redirect()->back()->with('code', decrypt($id));
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function docReject(string $id, Request $request)
    {

        $result = kycRequest::where('id', decrypt($id))->update([$request->docName => 0, $request->docReasonName => $request->reason]);
        if ($result) {
            return redirect()->back()->with('code',  decrypt($id));
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function intimateClient(string $id)
    {

        $id = decrypt($id);
        $client = kycRequest::findOrFail($id);
        $rejectedDocs = [];


        // if ($client->passportt_status == 0) {
        //     if (File::exists(public_path() . $client->passportt)) {
        //         File::delete(public_path() . $client->passportt);
        //     }
        //     $client->passportt = null;
        //     $client->passportIssue = null;
        //     $client->passportExpiry = null;
        //     $client->passportt_status = null;

        //     array_push($rejectedDocs, 'Passport');
        // }
        if ($client->nationalID_status == 0) {
            if (File::exists(public_path() . $client->nationalID)) {
                File::delete(public_path() . $client->nationalID);
            }
            $client->nationalID = null;
            $client->nationalID_status = null;
            $client->nationalIDIssue = null;
            $client->nationalIDExpiry = null;
            array_push($rejectedDocs, 'National ID');
        }
        if ($client->license_status == 0) {
            if (File::exists(public_path() . $client->license)) {
                File::delete(public_path() . $client->license);
            }
            $client->license = null;
            $client->license_status = null;
            $client->licenseIssue = null;
            $client->licenseExpiry = null;
            array_push($rejectedDocs, 'Driving License');
        }
        if ($client->otherID_status == 0) {
            if (File::exists(public_path() . $client->otherID)) {
                File::delete(public_path() . $client->otherID);
            }
            $client->otherID = null;
            $client->otherID_status = null;
            array_push($rejectedDocs, 'Other ID');
        }
        if ($client->utilityBill_status == 0) {
            if (File::exists(public_path() . $client->utilityBill)) {
                File::delete(public_path() . $client->utilityBill);
            }
            $client->utilityBill = null;
            $client->utilityBillIssue = null;
            $client->utilityBill_status = null;
            array_push($rejectedDocs, 'Utility Bill');
        }
        if ($client->bankStatement_status == 0) {
            if (File::exists(public_path() . $client->bankStatement)) {
                File::delete(public_path() . $client->bankStatement);
            }
            $client->bankStatement = null;
            $client->bankStatementIssue = null;
            $client->bankStatement_status = null;
            array_push($rejectedDocs, 'Bank Statement');
        }
        if ($client->leaseAgreement_status == 0) {
            if (File::exists(public_path() . $client->leaseAgreement)) {
                File::delete(public_path() . $client->leaseAgreement);
            }
            $client->leaseAgreement = null;
            $client->leaseAgreementIssue = null;
            $client->leaseAgreement_status = null;
            array_push($rejectedDocs, 'Lease Agreement');
        }

        if ($client->incorporation_status == 0) {
            if (File::exists(public_path() . $client->incorporation)) {
                File::delete(public_path() . $client->incorporation);
            }
            $client->incorporation = null;
            $client->incorporation_status = null;
            array_push($rejectedDocs, 'Certificate of Incorporation');
        }
        if ($client->shareHolding_status == 0) {
            if (File::exists(public_path() . $client->shareHolding)) {
                File::delete(public_path() . $client->shareHolding);
            }
            $client->shareHolding = null;
            $client->shareHolding_status = null;
            array_push($rejectedDocs, 'Certificate of Share Holding');
        }
        if ($client->coro_status == 0) {
            if (File::exists(public_path() . $client->coro)) {
                File::delete(public_path() . $client->coro);
            }
            $client->coro = null;
            $client->coro_status = null;
            array_push($rejectedDocs, 'Certificate of Registered Office');
        }
        if ($client->processing_status == 0) {
            if (File::exists(public_path() . $client->processing)) {
                File::delete(public_path() . $client->processing);
            }
            $client->processing = null;
            $client->processing_status = null;
            array_push($rejectedDocs, '6 Months Processing History');
        }
        if ($client->refund_status == 0) {
            if (File::exists(public_path() . $client->refund)) {
                File::delete(public_path() . $client->refund);
            }
            $client->refund = null;
            $client->refund_status = null;
            array_push($rejectedDocs, '6 Months Refund History');
        }

        $client->requiredDocs = $rejectedDocs;
        $client->status = "Pending";
        $client->first_mail_sent = 0;
        $client->comments = "Please re-submit the documents asked above.";
        $client->save();


        return redirect('kycrequests')->with('success', 'Client moved to Pending Status.');
    }

    public function passportApprove(string $id)
    {
        $result = Onboarding::where('id', decrypt($id))->update(['passport_status' => 1]);
        if ($result) {
            return redirect()->back()->with('success', 'Client Passport approved successfully.');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function passportReject(string $id, Request $request)
    {
        $result = Onboarding::where('id', decrypt($id))->update(['passport_status' => 0, 'passport_reason' => $request->rejectReason, 'passport_mail_sent_status' => 0]);
        if ($result) {
            return redirect()->back()->with('error', 'Client Passport rejected successfully.');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function passportReask(string $id)
    {

        $client = kycRequest::where('clientId', decrypt($id))->get()->first();
        if ($client->userName->client_type == 'Legal Entity') {
            $clientName = $client->userName->company_name;
        } else {
            $clientName = $client->userName->first_name . ' ' . $client->userName->last_name;
        }
        $uploadLink = "https://payit123crm.com/CRM/public/uploadPassport/" . $id;
        $reason = $client->userName->passport_reason;
        $res = Mail::to($client->userName->email)->send(new PassportMail($clientName, $uploadLink, $reason));


        if ($res) {
            Onboarding::where('id', $client->clientId)->update(['passport_mail_sent_status' => 1]);
            return redirect()->back()->with('success', 'Mail sent successfully.');;
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function uploadPassport(string $id)
    {
        $clientName = Onboarding::find(decrypt($id));
        if ($clientName->passport_status == 0) {
            return view('kycrequests.uploadPassport', compact('clientName'));
        } else {
            return redirect()->route('kycrequests.success');
        }
    }

    public function storePassport(string $id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'passport' => 'mimes:pdf,jpg,png,jpeg|max:5120',
        ], [
            'passport.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'passport.max' => 'Maximum size allowed : 5mb',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }

        $client = Onboarding::find($id);

        if ($request->hasFile('passport')) {

            if ($client->client_type == 'Individual') {
                $clientCompany =  $client->first_name . '_' . $client->last_name . '_' . $client->id;
            } else if ($client->client_type == 'Legal Entity') {
                $clientCompany =  $client->company_name . '_' . $client->id;
            }

            $path = public_path() . '/document/' . $clientCompany;
            if (!Storage::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }

            if (File::exists(public_path($client->passport))) {
                    File::delete(public_path($client->passport));
                }


            $file = $request->file('passport');
            $fileName = $clientCompany . '_passport.' . $file->extension();
            $file->move($path, $fileName);
            $passportValue = '/document/' . $clientCompany . '/' . $fileName;
            $passport_reason = null;
            $passport_status = null;
        } else {

            $passportValue = $client->passport;
            $passport_reason = $client->passport_reason;
            $passport_status = $client->passport_status;
        }

        $result = Onboarding::where('id',  $id)->update([
            'passport' => $passportValue,
            'passport_status' => $passport_status,
            'passport_reason' => $passport_reason
        ]);

        if ($result) {
            return redirect()->route('kycrequests.success');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function preKycClarification(string $id, Request $request)
    {
        $onboarding_id = kycRequest::where('id', $id)->value('clientId');

        $params['kyc_ID'] = $id;
        $params['onboarding_ID'] = $onboarding_id;
        $params['question'] = $request->clarificationQs;

        $res = Prekyc_qas::create($params);
        if ($res) {
            Onboarding::where('id', $onboarding_id)->update(['prekycclarification_status' => 'Query Initiated']);
            return redirect()->back()->with('codes',  $id);
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function prekycResponseLink(string $id)
    {
        $client = Onboarding::find($id);
        $qs = Prekyc_qas::where('onboarding_ID', $id)->get();
        if ($client->prekycclarification_status !== 'Response Received')
            return view('kycrequests.prekycResponse', compact('client', 'qs'));
        else
            return redirect()->route('kycrequests.success');
    }

    public function recordprekycResponse(Request $request)
    {
        $qsIDs = $request->questionIDs;
        $answers = $request->answers;

        $idsCollection = Collect($qsIDs);
        $AnswerCollection = $idsCollection->zip($answers);

        foreach ($AnswerCollection as $col) {
            Prekyc_qas::where('id', $col[0])->update(['response' => $col[1], 'status' => 'Received']);
        }

        $client = Onboarding::where('id', $request->clientID)->get()->first();
        $client->update(['prekycclarification_status' => 'Response Received']);

        return redirect()->route('kycrequests.success');
    }

    public function worldCheckApprove(string $id)
    {
        $kycClient = kycRequest::where('id', decrypt($id))->first();
        $result = $kycClient->update(['worldCheck' => 1]);

        if ($kycClient->worldCheck === 1 && $kycClient->sumSub === 1) {
            Onboarding::where('id', $kycClient->clientId)->update(['prekycclarification_status' => 'Finished']);
        }

        if ($result) {
            return redirect()->back()->with('codess', decrypt($id));;
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function worldCheckDecline(string $id)
    {
        $kycClient = kycRequest::where('id', decrypt($id))->first();
        $kycClient->update(['worldCheck' => 0]);
        $result = Onboarding::where('id', $kycClient->clientId)->update(['prekycclarification_status' => null]);

        if ($result) {
            return redirect()->back()->with('codess', decrypt($id));
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function sumsubApprove(string $id)
    {
        $kycClient = kycRequest::where('id', decrypt($id))->first();
        $kycClient->update(['sumSub' => 1]);
        $result = Onboarding::where('id', $kycClient->clientId)->update(['prekycclarification_status' => 'Finished']);
        if ($result) {
            return redirect()->back()->with('codess', decrypt($id));
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function sumsubDecline(string $id)
    {
        $kycClient = kycRequest::where('id', decrypt($id))->first();
        $kycClient->update(['sumSub' => 0]);
        $result = Onboarding::where('id', $kycClient->clientId)->update(['prekycclarification_status' => null]);
        if ($result) {
            return redirect()->back()->with('codess', decrypt($id));
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function preKYCapproval(string $id)
    {
        $result = kycRequest::where('id', decrypt($id))->update(['status' => "New"]);
        if ($result) {
            return redirect()->back();
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function newKYCform(string $id)
    {

        $client = kycRequest::find($id);
        $country = Countrie::all();
        if ($client->status !== 'Files Received') {
            return view('kycrequests.newKYCform', compact('client', 'country'));
        } else {
            return redirect()->route('kycrequests.success');
        }
    }

    public function store1(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullName' => 'required|string',
            'nationality' => 'required|String',
            'dob' => 'required|String',
            'gender' => 'required|String',
        ], [
            'fullName.required' => 'Please enter your full name',
            'nationality.required' => 'Please choose your Nationality',
            'dob.required' => 'Please enter your Date of Birth',
            'gender.required' => 'Please select your Gender',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $eFullName = $request->fullName;
        $eNationality = $request->nationality;
        $eDob = $request->dob;
        $eGender = $request->gender;

        $result = kycRequest::where('id', $request->clientID)
            ->update(
                [
                    'eFullName' => $eFullName,
                    'eNationality' => $eNationality,
                    'eDob' => $eDob,
                    'eGender' => $eGender
                ]
            );
        if ($result) {
            return redirect()->route('kycrequests.newKYCform1', $request->clientID);
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function newKYCform1(string $id)
    {
        $client = kycRequest::find($id);
        $country = Countrie::all();
        if ($client->status !== 'Files Received') {
            return view('kycrequests.newKYCform1', compact('client', 'country'));
        } else {
            return redirect()->route('kycrequests.success');
        }
    }

    public function store2(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'eAddr1' => 'required|regex:/^[#.0-9a-zA-Z\s,-]+$/',
            'eAddr2' => 'nullable|regex:/^[#.0-9a-zA-Z\s,-]+$/',
            'eCountry' => 'required|alpha',
            'eCity' => 'required|alpha',
            'eZip' => 'required|numeric',
            'eEmail' => 'required|email',
            'eContact' => 'required|numeric',
        ], [
            'eAddr1.required' => 'Please enter address',
            'eAddr1.regex' => 'No Special Characters allowed',
            'eAddr2.regex' => 'No Special Characters allowed',
            'eCountry.required' => 'Please select Country',
            'eCity.required' => 'Please enter City',
            'eCity.alpha' => 'Only Alphabets allowed',
            'eZip.required' => 'Please enter Zip Code',
            'eZip.numeric' => 'Only numeric values allowed',
            'eEmail.required' => 'Please enter your Email',
            'eEmail.email' => 'Please enter valid Email Address',
            'eContact.required' => 'Please select your Contact',
            'eContact.numeric' => 'Only numeric values allowed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $eAddr1 = $request->eAddr1;
        $eAddr2 = $request->eAddr2;
        $eCountry = $request->eCountry;
        $eCity = $request->eCity;
        $eZip = $request->eZip;
        $eEmail = $request->eEmail;
        $eContact = $request->eContact;

        $result = kycRequest::where('id', $request->clientID)
            ->update(
                [
                    'eAddr1' => $eAddr1,
                    'eAddr2' => $eAddr2,
                    'eCountry' => $eCountry,
                    'eCity' => $eCity,
                    'eZip' => $eZip,
                    'eEmail' => $eEmail,
                    'eContact' => $eContact,
                ]
            );
        if ($result) {
            return redirect()->route('kycrequests.newKYCform2', $request->clientID);
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function newKYCform2(string $id)
    {
        $client = kycRequest::find($id);
        $country = Countrie::all();
        if ($client->status !== 'Files Received') {
            return view('kycrequests.newKYCform2', compact('client', 'country'));
        } else {
            return redirect()->route('kycrequests.success');
        }
    }

    public function store3(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'ePassportIssueDate' => 'date',
            'ePassportExpiryDate' => 'date',
            'ePassport' => 'mimes:pdf,jpg,png,jpeg|max:5120',
            'eNidCardIssueDate' => 'date',
            'eNidCardExpiryDate' => 'date',
            'eNidCard' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'eDLicenseIssueDate' => 'date',
            'eDLicenseExpiryDate' => 'date',
            'eDLicense' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'eOthers' => 'file|mimes:pdf,jpg,png,jpeg|max:5120'

        ], [

            'ePassportIssueDate.date' => 'Invalid Date',
            'ePassportExpiryDate.date' => 'Invalid Date',
            'ePassport.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'eNidCardIssueDate.date' => 'Invalid Date',
            'eNidCardExpiryDate.date' => 'Invalid Date',
            'eNidCard.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'eDLicenseIssueDate.date' => 'Invalid Date',
            'eDLicenseExpiryDate.date' => 'Invalid Date',
            'eDLicense.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'eOthers.mimes' => 'Only Jpg, Png or Pdf files allowed',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }


        $kycRequest = kycRequest::find($request->clientID);


        $client = Onboarding::where('id', $kycRequest->clientId)->get()->first();


        if ($client->client_type == 'Individual') {
            $clientCompany =  $client->first_name . '_' . $client->last_name . '_' . $client->id;
        } else if ($client->client_type == 'Legal Entity') {
            $clientCompany =  $client->company_name . '_' . $client->id;
        }



        $path = public_path() . '/document/' . $clientCompany;
        if (!Storage::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        // // ePassport
        // if ($request->hasFile('ePassport')) {
        //     if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->passportt)) {
        //         File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->passportt);
        //     }

        //     $file = $request->file('ePassport');
        //     $fileName = $clientCompany . '_Passport.' . $file->extension();
        //     $file->move($path, $fileName);
        //     $passportValue     = '/document/' . $clientCompany . '/' . $fileName;
        // } else {
        //     $passportValue = $kycRequest->passportt;
        // }

        // National ID Card
        if ($request->hasFile('eNidCard')) {
            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->nationalID)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->nationalID);
            }

            $file = $request->file('eNidCard');
            $fileName = $clientCompany . '_National_ID.' . $file->extension();
            $file->move($path, $fileName);
            $nidValue     = '/document/' . $clientCompany . '/' . $fileName;
        } else {
            $nidValue = $kycRequest->nationalID;
        }

        // Driving License
        if ($request->hasFile('eDLicense')) {
            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->license)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->license);
            }

            $file = $request->file('eDLicense');
            $fileName = $clientCompany . '_License.' . $file->extension();
            $file->move($path, $fileName);
            $licenseValue     = '/document/' . $clientCompany . '/' . $fileName;
        } else {
            $licenseValue = $kycRequest->license;
        }

        // Other ID
        if ($request->hasFile('eOthers')) {
            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->otherID)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->otherID);
            }

            $file = $request->file('eOthers');
            $fileName = $clientCompany . '_OtherID.' . $file->extension();
            $file->move($path, $fileName);
            $otherIDValue     = '/document/' . $clientCompany . '/' . $fileName;
        } else {
            $otherIDValue = $kycRequest->otherID;
        }

        // Utility Bill
        if ($request->hasFile('eUBill')) {
            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->utilityBill)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->utilityBill);
            }

            $file = $request->file('eUBill');
            $fileName = $clientCompany . '_Utility_Bill.' . $file->extension();
            $file->move($path, $fileName);
            $uBillValue     = '/document/' . $clientCompany . '/' . $fileName;
        } else {
            $uBillValue = $kycRequest->utilityBill;
        }

        // Bank Statement
        if ($request->hasFile('eBStatement')) {
            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->bankStatement)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->bankStatement);
            }

            $file = $request->file('eBStatement');
            $fileName = $clientCompany . '_Bank_Statement.' . $file->extension();
            $file->move($path, $fileName);
            $BStatementValue     = '/document/' . $clientCompany . '/' . $fileName;
        } else {
            $BStatementValue = $kycRequest->bankStatement;
        }

        // Lease Agreement
        if ($request->hasFile('eLAgreement')) {
            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->leaseAgreement)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->leaseAgreement);
            }

            $file = $request->file('eLAgreement');
            $fileName = $clientCompany . '_Lease_Agreement.' . $file->extension();
            $file->move($path, $fileName);
            $LAgreementValue     = '/document/' . $clientCompany . '/' . $fileName;
        } else {
            $LAgreementValue = $kycRequest->leaseAgreement;
        }


        // $passportIssue = $request->ePassportIssueDate ? $request->ePassportIssueDate : $kycRequest->passportIssue;
        // $passportExpiry = $request->ePassportExpiryDate ? $request->ePassportExpiryDate : $kycRequest->passportExpiry;
        $nationalIDIssue = $request->eNidCardIssueDate ? $request->eNidCardIssueDate : $kycRequest->nationalIDIssue;
        $nationalIDExpiry = $request->eNidCardExpiryDate ? $request->eNidCardExpiryDate : $kycRequest->nationalIDExpiry;
        $licenseIssue = $request->eDLicenseIssueDate ? $request->eDLicenseIssueDate : $kycRequest->licenseIssue;
        $licenseExpiry = $request->eDLicenseExpiryDate ? $request->eDLicenseExpiryDate : $kycRequest->licenseExpiry;

        $utilityBillIssue = $request->eUBillIssueDate ? $request->eUBillIssueDate : $kycRequest->utilityBillIssue;
        $bankStatementIssue = $request->eBStatementIssueDate ? $request->eBStatementIssueDate : $kycRequest->bankStatementIssue;
        $leaseAgreementIssue = $request->eLAgreementIssueDate ? $request->eLAgreementIssueDate : $kycRequest->leaseAgreementIssue;



        $result = kycRequest::where('id', $request->clientID)
            ->update(
                [
                    // 'passportt' => $passportValue,
                    // 'passportIssue' => $passportIssue,
                    // 'passportExpiry' => $passportExpiry,
                    'nationalID' => $nidValue,
                    'nationalIDIssue' => $nationalIDIssue,
                    'nationalIDExpiry' => $nationalIDExpiry,
                    'license' => $licenseValue,
                    'licenseIssue' => $licenseIssue,
                    'licenseExpiry' => $licenseExpiry,
                    'otherID' => $otherIDValue,
                    'utilityBill' => $uBillValue,
                    'utilityBillIssue' => $utilityBillIssue,
                    'bankStatement' => $BStatementValue,
                    'bankStatementIssue' => $bankStatementIssue,
                    'leaseAgreement' => $LAgreementValue,
                    'leaseAgreementIssue' => $leaseAgreementIssue,

                ]
            );
        if ($result) {
            return redirect()->route('kycrequests.newKYCform3', $request->clientID);
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function newKYCform3(string $id)
    {
        $client = kycRequest::find($id);
        $country = Countrie::all();
        if ($client->status !== 'Files Received') {
            return view('kycrequests.newKYCform3', compact('client', 'country'));
        } else {
            return redirect()->route('kycrequests.success');
        }
    }

    public function store4(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'coro' => 'mimes:pdf,jpg,png,jpeg|max:5120',
            'shareHolding' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'incorporation' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'processing' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',
            'refund' => 'file|mimes:pdf,jpg,png,jpeg|max:5120'

        ], [


            'coro.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'coro.max' => 'Maximum File Size : 5mb Exceeded',
            'shareHolding.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'shareHolding.max' => 'Maximum File Size : 5mb Exceeded',
            'incorporation.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'incorporation.max' => 'Maximum File Size : 5mb Exceeded',
            'processing.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'processing.max' => 'Maximum File Size : 5mb Exceeded',
            'refund.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'refund.max' => 'Maximum File Size : 5mb Exceeded',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }


        $kycRequest = kycRequest::find($request->clientID);

        $clientName = Onboarding::find($kycRequest->clientId);

        if ($clientName->client_type == 'Individual') {
            $clientCompany =  $clientName->first_name . '_' . $clientName->last_name . '_' .  $clientName->id;
        } else if ($clientName->client_type == 'Legal Entity') {
            $clientCompany =  $clientName->company_name . '_' . $clientName->id;
        }

        $path = public_path() . '/document/' . $clientCompany;
        if (!Storage::exists($path)) {
            File::makeDirectory($path, $mode = 0777, true, true);
        }

        // coro
        if ($request->hasFile('coro')) {
            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->coro)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->coro);
            }

            $file = $request->file('coro');
            $fileName = $clientCompany . '_CORO.' . $file->extension();
            $file->move($path, $fileName);
            $coroValue     = '/document/' . $clientCompany . '/' . $fileName;
        } else {
            $coroValue = $kycRequest->coro;
        }

        // Shareholding Certificate
        if ($request->hasFile('shareHolding')) {
            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->shareHolding)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->shareHolding);
            }

            $file = $request->file('shareHolding');
            $fileName = $clientCompany . '_shareholding_certificate.' . $file->extension();
            $file->move($path, $fileName);
            $shareHoldingValue     = '/document/' . $clientCompany . '/' . $fileName;
        } else {
            $shareHoldingValue = $kycRequest->shareHolding;
        }

        // Incorporation Certificate
        if ($request->hasFile('incorporation')) {
            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->incorporation)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->incorporation);
            }

            $file = $request->file('incorporation');
            $fileName = $clientCompany . '_incorporation_certificate.' . $file->extension();
            $file->move($path, $fileName);
            $incorporationValue     = '/document/' . $clientCompany . '/' . $fileName;
        } else {
            $incorporationValue = $kycRequest->incorporation;
        }

        // 6 Months Processing History
        if ($request->hasFile('processing')) {
            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->processing)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->processing);
            }

            $file = $request->file('processing');
            $fileName = $clientCompany . '_processing_history.' . $file->extension();
            $file->move($path, $fileName);
            $processingValue     = '/document/' . $clientCompany . '/' . $fileName;
        } else {
            $processingValue = $kycRequest->processing;
        }

        // 6 Months Refund History
        if ($request->hasFile('refund')) {
            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $kycRequest->refund)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $kycRequest->refund);
            }

            $file = $request->file('refund');
            $fileName = $clientCompany . '_refund_history.' . $file->extension();
            $file->move($path, $fileName);
            $refundValue     = '/document/' . $clientCompany . '/' . $fileName;
        } else {
            $refundValue = $kycRequest->refund;
        }



        $result = kycRequest::where('id', $request->clientID)
            ->update(
                [
                    'coro' => $coroValue,
                    'shareholding' => $shareHoldingValue,
                    'incorporation' => $incorporationValue,
                    'refund' => $refundValue,
                    'processing' => $processingValue,
                ]
            );
        if ($result) {
            return redirect()->route('kycrequests.newKYCform4', $request->clientID);
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function newKYCform4(string $id)
    {
        $client = kycRequest::find($id);
        $country = Countrie::all();
        $today = date("Y-m-d");
        if ($client->status !== 'Files Received') {
            return view('kycrequests.newKYCform4', compact('client', 'country', 'today'));
        } else {
            return redirect()->route('kycrequests.success');
        }
    }

    public function viewKYCLive(string $id)
    {

        $client = kycRequest::where('id', $id)->get()->first();
        return view('kycrequests.kycLiveView', compact('client'));
    }

    public function riskFactorToggle(string $id)
    {
        $client = kycRequest::find(decrypt($id));
        $newRiskFactor = !($client->riskFactor);
        $result = kycRequest::where('id', decrypt($id))->update(['riskFactor' => $newRiskFactor, 'status' => 'Closed']);
        if ($result) {
            return redirect()->back();
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function declaration(string $id)
    {
        $result = kycRequest::where('id', $id)->update(['declaration' => 1, 'declarationDate' => date('Y-m-d H:i:s'), 'status' => 'Files Received']);
        if ($result) {
            return redirect()->route('kycrequests.success');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function newEDDform(string $id)
    {

        $client = kycRequest::find($id);
        $kycEdd = kycEdd::where('kyc_ID', $id)->get()->first();
        $clientTeam = clientTeam::where('kycID', $id)->get()->toArray();
        if($client->eddStatus !== 'Completed'){
            return view('kycrequests.newEDDform', compact('client', 'kycEdd', 'clientTeam'));    
        }
        else{
            return redirect()->route('kycrequests.success');    
        }
        
    }

    public function eddStore(Request $request)
    {

        clientTeam::where('kycID', $request->clientID)->delete();

        // Storing Team Members List

        $row1 = $request->mTeamName;
        $row2 = $request->mTeamTitle;
        $row3 = $request->mTeamBackground;

        $collection = collect($row1);
        $zipped = $collection->zip($row2, $row3);
        $teamList = $zipped->toArray();

        foreach ($teamList as $zip) {

            $params['kycID']   = $request->clientID;
            $params['name']    = $zip[0];
            $params['title']   = $zip[1];
            $params['background'] = $zip[2];

            clientTeam::create($params);
        }

        $EddkycRequest = kycEdd::where('kyc_ID', $request->clientID);

        $response = $EddkycRequest->update(
            [
                'legalName' => $request->legalName,
                'businessAddress' => $request->businessAddress,
                'businessNature' => $request->businessNature,
                'businessYears' => $request->businessYears,
                'bOwnerName' => $request->bOwnerName,
                'bOwnerAddr' => $request->bOwnerAddr,
                'bOwnerPercentage' => $request->bOwnerPercentage,
                'thirdPartyName' => $request->thirdPartyName,
            ]
        );

        $client = kycRequest::find($request->clientID);
        $country = Countrie::all();
        $kycEdd = kycEdd::where('kyc_ID', $request->clientID)->get()->first();
        $demographyList = clientDemography::where('kycID', $request->clientID)->get()->toArray();
        // $kycEdd['paymentServices'] = json_decode($kycEdd->paymentServices);


        return view('kycrequests.newEDDform1', compact('client', 'country', 'kycEdd', 'demographyList'));
    }

    public function viewEddLive(string $id)
    {
        $client = kycRequest::find($id);
        $kycEdd = kycEdd::where('kyc_ID', $id)->get()->first();
        $clientTeam = clientTeam::where('kycID', $id)->get()->toArray();
        $demographyList = clientDemography::where('kycID', $id)->get()->toArray();
        $country = Countrie::all();
        return view('kycrequests.viewEddLive', compact('client', 'kycEdd', 'clientTeam', 'demographyList', 'country'));
    }

    public function removeTeamMember(string $id)
    {
        $result = clientTeam::where('id', $id)->delete();
        if ($result) {
            return redirect()->back();
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function newEDDform1(string $id)
    {
        $client = kycRequest::find($id);
        $kycEdd = kycEdd::where('kyc_ID', $id)->get()->first();
        $country = Countrie::all();
        $demographyList = clientDemography::where('kycID', $id)->get()->toArray();
        if($client->eddStatus !== 'Completed'){
            return view('kycrequests.newEDDform1', compact('client', 'country', 'kycEdd', 'demographyList'));
        }
        else{
            return redirect()->route('kycrequests.success');    
        }
    }

    public function eddStore1(Request $request)
    {


        clientDemography::where('kycID', $request->clientID)->delete();

        $row1 = $request->regions;
        $row2 = $request->transactionType;

        $collection = collect($row1);
        $zipped = $collection->zip($row2);
        $demographyList = $zipped->toArray();

        foreach ($demographyList as $zip) {

            $params['kycID']   = $request->clientID;
            $params['region']    = $zip[0];
            $params['transType']   = $zip[1];

            clientDemography::create($params);
        }

        $EddkycRequest = kycEdd::where('kyc_ID', $request->clientID)->first();

        $response = $EddkycRequest->update(
            [
                'paymentServices' => json_encode($request->paymentServices),
                'otherPayServices' => $request->otherPayServices,
                'avgTransSize' => $request->avgTransSize,
                'transFreq' => $request->transFreq,
                'transList' => $request->transList,
                'countriesOfOperation' => json_encode($request->countriesOfOperation),
                'countriesTransactions' => $request->countriesTransactions,
                'highRiskIndustry' => $request->highRiskIndustry,
            ]
        );

        if ($response) {
            return redirect()->route('kycrequests.newEDDform2', $request->clientID);
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function removeDemographyCountry(string $id, $clientID)
    {
        $result = clientDemography::where('id', $id)->delete();
        if ($result) {
            return redirect()->route('kycrequests.newEDDform1', $clientID);
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function newEDDform2(string $id)
    {
        $client = kycRequest::find($id);
        $kycEdd = kycEdd::where('kyc_ID', $id)->get()->first();
        if($client->eddStatus !== 'Completed'){
            return view('kycrequests.newEDDform2', compact('client',  'kycEdd'));
        }
        else{
            return redirect()->route('kycrequests.success');    
        }
    }

    public function eddStore2(Request $request)
    {

        $kycRequest = kycRequest::find($request->clientID);
        $clientName = Onboarding::find($kycRequest->clientId);
        $EddkycRequest = kycEdd::where('kyc_ID', $request->clientID)->get()->first();
        $clientCompany =  $clientName->company_name . '_' . $clientName->id;

        $path = public_path() . '/document/' . $clientCompany;

        // financialStatement
        if ($request->hasFile('financialStatement')) {
            if (File::exists($_SERVER['DOCUMENT_ROOT'] . $EddkycRequest->financialStatement)) {
                File::delete($_SERVER['DOCUMENT_ROOT'] . $EddkycRequest->financialStatement);
            }

            $file = $request->file('financialStatement');
            $fileName = $clientCompany . '_Financial_statement.' . $file->extension();
            $file->move($path, $fileName);
            $financialStatementPath     = '/document/' . $clientCompany . '/' . $fileName;
        } else {
            $financialStatementPath = $EddkycRequest->financialStatement;
        }

        $EddkycRequest = kycEdd::where('kyc_ID', $request->clientID)->get()->first();

        $response = $EddkycRequest->update(
            [
                'cMeasure' => $request->cMeasure,
                'cOfficerName' => $request->cOfficerName,
                'cOfficerContact' => $request->cOfficerContact,
                'cOfficerEmail' => $request->cOfficerEmail,
                'regInvestigations' => $request->regInvestigations,
                'financialStatement' => $financialStatementPath,
                'sourceOfFunding' => $request->sourceOfFunding,
                'debtsLiabilities' => $request->debtsLiabilities,
                'internalControls' => $request->internalControls,
                'monitoringProcedures' => $request->monitoringProcedures,
                'handlingSAR' => $request->handlingSAR,
            ]
        );

        if ($response) {
            return redirect()->route('kycrequests.newEDDform3', $request->clientID);
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function newEDDform3(string $id)
    {
        $client = kycRequest::find($id);
        $kycEdd = kycEdd::where('kyc_ID', $id)->get()->first();
        $country = Countrie::all();
        if($client->eddStatus !== 'Completed'){
            return view('kycrequests.newEDDform3', compact('client', 'country', 'kycEdd'));
        }
        else{
            return redirect()->route('kycrequests.success');    
        }
    }

    public function newEDDform4(string $id)
    {
        $client = kycRequest::find($id);
        $today = date("Y-m-d");
        if($client->eddStatus !== 'Completed'){
            return view('kycrequests.newEDDform4', compact('client', 'today'));
        }
        else{
            return redirect()->route('kycrequests.success');    
        }
    }

    public function eddStore3(Request $request)
    {

        $client = kycRequest::find($request->clientID);

        $EddkycRequest = kycEdd::where('kyc_ID', $request->clientID)->get()->first();

        $response = $EddkycRequest->update(
            [
                'criminalActivities' => $request->criminalActivities,
                'pep' => $request->pep,
                'negativeReports' => $request->negativeReports,
                'techPlatforms' => $request->techPlatforms,
                'securityMeasures' => $request->securityMeasures,
                'cyberSecurity' => $request->cyberSecurity,
            ]
        );

        if ($response) {
            return redirect()->route('kycrequests.newEDDform4', $request->clientID);
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function declaration1(string $id)
    {

        $result = kycRequest::where('id', $id)->update(['status' => 'EDD Completed', 'eddStatus' => 'Completed']);
        if ($result) {
            return redirect()->route('kycrequests.success');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function viewEDD(string $id)
    {
        $EddValues = kycEdd::where('kyc_ID', decrypt($id))->get()->first();
        $mTeam = clientTeam::where('kycID', decrypt($id))->get()->toArray();
        $demography = clientDemography::where('kycID', decrypt($id))->get()->toArray();
        $questions = KycEddQa::where('edd_ID', $EddValues->id)->get();

        $tick = 0;

        foreach ($questions as $qs) {
            if ($qs->status == 'Open' || $qs->status == 'Received' || $qs->status == 'Rejected') {
                $tick = 1;
            }
        }

        return view('kycrequests.EDDView', compact('EddValues', 'mTeam', 'demography', 'questions', 'tick'));
    }

    public function eddFormSubmission(Request $request)
    {
        $category = $request->category;
        $questions = $request->eddQs;

        foreach ($questions as $qs) {
            $params['edd_ID'] = $request->EddValue;
            $params['category'] = $category;
            $params['question'] = $qs;

            KycEddQa::create($params);
        }

        $eddValue = kycEdd::where('id', $request->EddValue)->get()->first();

        $eddValue->update(['status' => 'Queries Raised']);

        kycRequest::where('id', $eddValue->kyc_ID)->update(['status' => 'EDD Queries Raised']);

        return back()->with('success', 'Questions added successfully...');
    }

    public function approveResponse(string $id)
    {
        $response = KycEddQa::where('id', $id)->update(['status' => 'Closed']);
        if ($response) {
            return back()->with('success', 'Successfully approved the response.');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function rejectResponse(string $id)
    {
        $response = KycEddQa::where('id', $id)->update(['status' => 'Rejected']);
        if ($response) {
            return back()->with('success', 'Successfully rejected the response.');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function eddResponse(string $id)
    {
        $questions = KycEddQa::where('edd_ID', $id)->get();
        $EddValues = kycEdd::where('id', $id)->get()->first();
        return view('kycrequests.eddResponse', compact('EddValues', 'questions'));
    }

    public function recordResponse(Request $request)
    {
        $qsIDs = $request->questionIDs;
        $answers = $request->answers;

        $idsCollection = Collect($qsIDs);
        $AnswerCollection = $idsCollection->zip($answers);

        foreach ($AnswerCollection as $col) {
            KycEddQa::where('id', $col[0])->update(['answer' => $col[1], 'status' => 'Received']);
        }

        $kycEddValue = kycEdd::where('id', $request->eddID)->get()->first();
        $kycEddValue->update(['status' => 'Response Received']);
        kycRequest::where('id', $kycEddValue->kyc_ID)->update(['status' => 'EDD Response Received']);

        return redirect()->route('kycrequests.success');
    }

    public function closeEdd(string $id)
    {

        $eddValue = kycEdd::where('id', decrypt($id))->first();
        $kycValue = kycRequest::where('id', $eddValue->kyc_ID);
        $eddValue->update(['status' => 'EDD Approved']);
        $kycValue->update(['eddStatus' => 'Verified', 'status' => 'EDD Approved']);


        return back()->with('success', 'Successfully Updated');
    }

    public function sumSub()
    {

        // require_once('vendor/autoload.php');

        // $client = new \GuzzleHttp\Client();


        // $response = $client->request('POST', 'https://api.sumsub.com/resources/accessTokens/sdk', [
        //     'body' => '{"ttlInSecs":600,"userId":"Ragavendra","levelName":"basic-kyc-level"}',
        //     'headers' => [
        //         'X-App-Token' => '_act-sbx-jwt-eyJhbGciOiJub25lIn0.eyJqdGkiOiJfYWN0LXNieC02NjIxZTRiZS1hMWVjLTQxNWQtODlmNS1hZTdjODU1MTZhMmQtdjIiLCJ1cmwiOiJodHRwczovL2FwaS5zdW1zdWIuY29tIn0.-v2',
        //         'content-type' => 'application/json',
        //     ],
        // ]);

        // $response->getBody();
        return view('kycrequests.sumSub');
    }
}
