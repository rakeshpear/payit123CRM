<?php

namespace App\Http\Controllers;

use App\Models\Ubos;
use App\Models\User;
use App\Models\Countrie;
use App\Mail\WelcomeMail;
use App\Models\Signatory;
use App\Models\Currencies;
use App\Models\kycRequest;
use App\Models\Onboarding;
use App\Models\BoardMembers;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\File;


class HomeController extends Controller
{


    public function index(Request $request)
    {

        $request->validate([

            'email' => 'required|string',

            'password' => 'required|string',

        ]);

        $email = $request->email;

        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password])) {

            $role = Role::findByName('Customer');

            if (Auth::user()->role == $role->id) {

                return redirect('/customer/clients');
            } else {

                return view('index');
            }
        }

        return redirect()->back()->withInput()->with('error', 'Oppes! You have entered invalid credentials');
    }

    public function Dashboard()
    {
        return view('index');
    }

    public function payment_method()
    {
        return view('payment_method.payment_method');
    }

    public function logout()
    {

        Auth::logout();

        return redirect('/');
    }


    // public function updateProfile(Request $request, $id)
    // {
    //     $request->validate([
    //         'name' => ['required', 'string', 'max:255'],
    //         'email' => ['required', 'string', 'email'],
    //         'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
    //     ]);

    //     $user = User::find($id);
    //     $user->name = $request->get('name');
    //     $user->email = $request->get('email');

    //     if ($request->file('avatar')) {
    //         $avatar = $request->file('avatar');
    //         $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
    //         $avatarPath = public_path('/images/');
    //         $avatar->move($avatarPath, $avatarName);
    //         $user->avatar = '/images/' . $avatarName;
    //     }

    //     $user->update();
    //     if ($user) {
    //         Session::flash('message', 'User Details Updated successfully!');
    //         Session::flash('alert-class', 'alert-success');
    //         return response()->json([
    //             'isSuccess' => true,
    //             'Message' => "User Details Updated successfully!"
    //         ], 200); // Status code here
    //     } else {
    //         Session::flash('message', 'Something went wrong!');
    //         Session::flash('alert-class', 'alert-danger');
    //         return response()->json([
    //             'isSuccess' => true,
    //             'Message' => "Something went wrong!"
    //         ], 200); // Status code here
    //     }
    // }

    // public function updatePassword(Request $request, $id)
    // {
    //     $request->validate([
    //         'current_password' => ['required', 'string'],
    //         'password' => ['required', 'string', 'min:6', 'confirmed'],
    //     ]);

    //     if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
    //         return response()->json([
    //             'isSuccess' => false,
    //             'Message' => "Your Current password does not matches with the password you provided. Please try again."
    //         ], 200); // Status code
    //     } else {
    //         $user = User::find($id);
    //         $user->password = Hash::make($request->get('password'));
    //         $user->update();
    //         if ($user) {
    //             Session::flash('message', 'Password updated successfully!');
    //             Session::flash('alert-class', 'alert-success');
    //             return response()->json([
    //                 'isSuccess' => true,
    //                 'Message' => "Password updated successfully!"
    //             ], 200); // Status code here
    //         } else {
    //             Session::flash('message', 'Something went wrong!');
    //             Session::flash('alert-class', 'alert-danger');
    //             return response()->json([
    //                 'isSuccess' => true,
    //                 'Message' => "Something went wrong!"
    //             ], 200); // Status code here
    //         }
    //     }
    // }


    public function account_form(Request $request)
    {
        $data['country'] = Countrie::all();
        $data['currency'] = Currencies::all();
        return view('frontend.account_form', $data);
    }

    public function account_form1(Request $request)
    {
        $data['country'] = Countrie::all();
        $data['currency'] = Currencies::all();
        return view('frontend.account_form1', $data);
    }

    public function account_store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'passport' => 'file|mimes:pdf,jpg,png,jpeg|max:5120',

        ], [

            'passport.mimes' => 'Only Jpg, Png or Pdf files allowed',
            'passport.max' => 'Maximum File Size : 5mb',

        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        $params['client_type']                  = $request->clientType;
        $params['first_name']                   = $request->first_name;
        $params['middle_name']                  = $request->middle_name;
        $params['last_name']                    = $request->last_name;
        $params['company_name']                 = $request->company_name;
        $params['country']                      = $request->country;
        $params['company_address_first']        = $request->company_address_first;
        $params['company_address_second']       = $request->company_address_second;
        $params['city']                         = $request->city;
        $params['country1']                     = $request->country1;
        $params['zip_code']                     = $request->zip_code;
        $params['email']                        = $request->email;
        $params['website']                      = $request->website;
        $params['reporting_email']              = $request->reporting_email;
        $params['accounting_email']             = $request->accounting_email;
        $params['processing_currencies']        = json_encode($request->processing_currencies);
        $params['other_currencies']             = $request->other_currencies;
        $params['client_main_country_1']        = $request->client_main_country_1;
        $params['client_country_1_valume']      = $request->client_country_1_valume;
        $params['client_main_country_2']        = $request->client_main_country_2;
        $params['client_country_2_valume']      = $request->client_country_2_valume;
        $params['client_main_country_3']        = $request->client_main_country_3;
        $params['client_country_3_valume']      = $request->client_country_3_valume;
        $params['payment_method']               = $request->payment_method;
        $params['wallet_address']               = $request->wallet_address;
        $params['bank_name']                    = $request->bank_name;
        $params['iban']                         = $request->iban;
        $params['bic']                          = $request->bic;
        $params['start_processing']             = $request->start_processing;
        $params['epCurrency']                   = $request->epCurrency;
        $params['epAccOpenedDate']              = $request->epAccOpenedDate;
        $params['epPrevDeposits']               = $request->epPrevDeposits;
        $params['epPrevWithDrawals']            = $request->epPrevWithDrawals;
        $params['epAnnualIncome']               = $request->epAnnualIncome;
        $params['epLiquidAssets']               = $request->epLiquidAssets;
        $params['epFinancialLiabilities']       = $request->epFinancialLiabilities;
        $params['epSourceOfFunds']              = $request->epSourceOfFunds;
        $params['epBusinessField']              = $request->epBusinessField;
        $params['epPositionsHeld']              = $request->epPositionsHeld;
        $params['comment']                      = $request->comment;

        $res = Onboarding::create($params);

        $newOnboardingID = $res->id;

        if ($request->hasFile('passport')) {

            if ($request->clientType == 'Individual') {
                $clientCompany =  $request->first_name . '_' . $request->last_name . '_' . $newOnboardingID;
            } else if ($request->clientType == 'Legal Entity') {
                $clientCompany =  $request->company_name . '_' . $newOnboardingID;
            }

            $path = public_path() . '/document/' . $clientCompany;
            if (!Storage::exists($path)) {
                File::makeDirectory($path, $mode = 0777, true, true);
            }

            $file = $request->file('passport');
            // $fileName = '/document/' . $clientCompany . '/' . $file->extension();
            $fileName = $clientCompany . '/' . $clientCompany . '_passport.' . $file->extension();
            $file->move($path, $fileName);
            $passportPath = '/document/' . $fileName;
            Onboarding::where('id', $newOnboardingID)->update(['passport' => $passportPath]);
        }

        if ($request->clientType === 'Legal Entity') {

            // UBOs

            $ro1 = $request->uboName;
            $ro2 = $request->uboMName;
            $ro3 = $request->uboSurName;
            $ro4 = $request->uboResidence;
            $ro5 = $request->uboRegion;
            $ro6 = $request->uboProvince;
            $ro7 = $request->uboAddress;
            $ro8 = $request->uboDob;
            $ro9 = $request->uboCoBirth;
            $ro10 = $request->uboCitizenship;
            $ro11 = $request->uboShareHolding;

            $uboCollection = collect($ro1);
            $uboZipped = $uboCollection->zip($ro2, $ro3, $ro4, $ro5, $ro6, $ro7, $ro8, $ro9, $ro10, $ro11);
            $ubosList = $uboZipped->toArray();

            foreach ($ubosList as $ziip) {

                $paramz['onboarding_ID']    = $newOnboardingID;
                $paramz['uboName']          = $ziip[0];
                $paramz['uboMName']         = $ziip[1];
                $paramz['uboSurName']       = $ziip[2];
                $paramz['uboResidence']     = $ziip[3];
                $paramz['uboRegion']        = $ziip[4];
                $paramz['uboProvince']      = $ziip[5];
                $paramz['uboAddress']       = $ziip[6];
                $paramz['uboDob']           = $ziip[7];
                $paramz['uboCoBirth']       = $ziip[8];
                $paramz['uboCitizenship']   = $ziip[9];
                $paramz['uboShareHolding']  = $ziip[10];

                Ubos::create($paramz);
            }

            // Board Members

            $roww1 = $request->boardName;
            $roww2 = $request->boardMName;
            $roww3 = $request->boardSurName;
            $roww4 = $request->boardPosition;
            $roww5 = $request->boardDob;

            $collection1 = collect($roww1);
            $zippedd = $collection1->zip($roww2, $roww3, $roww4, $roww5);
            $boardList = $zippedd->toArray();


            foreach ($boardList as $zipp) {

                $boardParamz['onboarding_ID']       = $newOnboardingID;
                $boardParamz['boardName']           = $zipp[0];
                $boardParamz['boardMName']          = $zipp[1];
                $boardParamz['boardSurName']        = $zipp[2];
                $boardParamz['boardPosition']       = $zipp[3];
                $boardParamz['boardDob']       = $zipp[4];

                BoardMembers::create($boardParamz);
            }

            // Signatories

            $row1 = $request->signatoryName;
            $row2 = $request->signatoryMName;
            $row3 = $request->signatorySurName;
            $row4 = $request->signatoryPosition;
            $row5 = $request->signatoryResidence;
            $row6 = $request->signatoryDob;

            $collection = collect($row1);
            $zipped = $collection->zip($row2, $row3, $row4, $row5, $row6);
            $signatoryList = $zipped->toArray();

            foreach ($signatoryList as $zip) {

                $signatoryParamz['onboarding_ID']           = $newOnboardingID;
                $signatoryParamz['signatoryName']           = $zip[0];
                $signatoryParamz['signatoryMName']          = $zip[1];
                $signatoryParamz['signatorySurName']        = $zip[2];
                $signatoryParamz['signatoryPosition']       = $zip[3];
                $signatoryParamz['signatoryResidence']      = $zip[4];
                $signatoryParamz['signatoryDob']            = $zip[5];

                Signatory::create($signatoryParamz);
            }
        }

        $paramss['clientId'] = $newOnboardingID;

        $newKYC = kycRequest::create($paramss);

        if ($request->clientType === 'Legal Entity') {
            $clientName = $request->company_name;
        } else {
            $clientName = $request->first_name . ' ' . $request->last_name;
        }

        if ($newKYC) {
            Mail::to($request->email)->send(new WelcomeMail($clientName));
            return back()->with('success', 'Submited Successfully.');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function PYY_create(Request $request)
    {
        return view('PYY.create');
    }
}
