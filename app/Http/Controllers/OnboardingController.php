<?php

namespace App\Http\Controllers;


use App\Models\Ubos;
use App\Models\Countrie;
use App\Models\Signatory;
use App\Models\kycRequest;

use App\Models\Onboarding;
use App\Models\BoardMembers;
use App\Models\Currencies;
use Illuminate\Http\Request;
use function Laravel\Prompts\alert;
use Illuminate\Support\Facades\File;

class OnboardingController extends Controller
{
    public function index()
    {
        $data['datas'] = Onboarding::orderBy('id', 'desc')->get();

        return view('onboarding.index', $data);
    }

    public function status($id = '')
    {
        $data = Onboarding::find($id);

        if ($data) {

            if ($data->status == '1') {
                $params['status'] = '0';
            } else {
                $params['status'] = '1';
            }
            Onboarding::whereId($id)->update($params);
            return back()->with('success', 'Status Updated Successfully');
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    // RK

    public function edit($id)
    {

        $id = decrypt($id);
        $client = Onboarding::find($id);
        $contractDoc = kycRequest::where('clientId', $id)->value('contract');
        $client['processing_currencies'] = json_decode($client->processing_currencies);
        $boardMembers = BoardMembers::where('onboarding_ID', $id)->get()->toArray();
        $ubos = Ubos::where('onboarding_ID', $id)->get()->toArray();
        $signatory = Signatory::where('onboarding_ID', $id)->get()->toArray();
        $country = Countrie::all();
        $currency = Currencies::all();
        return view('onboarding.edit', compact('client', 'boardMembers', 'currency', 'ubos', 'signatory', 'contractDoc', 'country'));
    }

    public function view($id)
    {
        $id = decrypt($id);
        $client = Onboarding::find($id);
        $kycDetails = kycRequest::where('clientId', $id)->get()->first();
        // dd($kycDetails);
        $contractDoc = kycRequest::where('clientId', $id)->value('contract');
        $boardMembers = BoardMembers::where('onboarding_ID', $id)->get()->toArray();
        $ubos = Ubos::where('onboarding_ID', $id)->get()->toArray();
        $signatory = Signatory::where('onboarding_ID', $id)->get()->toArray();
        $client['processing_currencies'] = json_decode($client->processing_currencies);
        return view('onboarding.view', compact('client', 'boardMembers', 'ubos', 'signatory', 'contractDoc', 'kycDetails'));
    }

    public function update(Request $request, $id)
    {

        $client = Onboarding::find($id);

        // if ($request->hasFile('certificate')) {

        //     if (File::exists($_SERVER['DOCUMENT_ROOT'] . $client->certificate)) {
        //         File::delete($_SERVER['DOCUMENT_ROOT'] . $client->certificate);
        //     }

        //     $file = $request->file('certificate');
        //     $fileName = $file->getClientOriginalName();
        //     $file->move(public_path('/document/'), $fileName);
        //     $certificateValue     = '/document/' . $fileName;
        // } else {
        //     $certificateValue = $client->certificate;
        // }



        // if ($request->hasFile('passport')) {
        //     if (File::exists($_SERVER['DOCUMENT_ROOT'] . $client->passport)) {
        //         File::delete($_SERVER['DOCUMENT_ROOT'] . $client->passport);
        //     }

        //     $file = $request->file('passport');
        //     $fileName = $file->getClientOriginalName();
        //     $file->move(public_path('/document/'), $fileName);
        //     $passportValue     = '/document/' . $fileName;
        // } else {
        //     $passportValue = $client->passport;
        // }

        if ($client->client_type === 'Legal Entity') {

            // Board Members Updation

            BoardMembers::where('onboarding_ID', $id)->delete();

            $roww1 = $request->boardName;
            $roww2 = $request->boardMName;
            $roww3 = $request->boardSurName;
            $roww4 = $request->boardPosition;
            $roww5 = $request->boardDob;

            $collection1 = collect($roww1);
            $zippedd = $collection1->zip($roww2, $roww3, $roww4, $roww5);
            $boardList = $zippedd->toArray();

            foreach ($boardList as $zipp) {

                $boardParamz['onboarding_ID']       = $id;
                $boardParamz['boardName']           = $zipp[0];
                $boardParamz['boardMName']          = $zipp[1];
                $boardParamz['boardSurName']        = $zipp[2];
                $boardParamz['boardPosition']       = $zipp[3];
                $boardParamz['boardDob']            = $zipp[4];

                BoardMembers::create($boardParamz);
            }

            // UBOs Updation

            Ubos::where('onboarding_ID', $id)->delete();

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

                $paramz['onboarding_ID']    = $id;
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

            // Signatories Updation

            Signatory::where('onboarding_ID', $id)->delete();

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

                $signatoryParamz['onboarding_ID']           = $id;
                $signatoryParamz['signatoryName']           = $zip[0];
                $signatoryParamz['signatoryMName']          = $zip[1];
                $signatoryParamz['signatorySurName']        = $zip[2];
                $signatoryParamz['signatoryPosition']       = $zip[3];
                $signatoryParamz['signatoryResidence']      = $zip[4];
                $signatoryParamz['signatoryDob']            = $zip[5];

                Signatory::create($signatoryParamz);
            }
        }


        $client->update([
            'first_name'                    => $request->first_name,
            'middle_name'                    => $request->middle_name,
            'last_name'                     => $request->last_name,
            'company_name'                  => $request->company_name,
            'country'                       => $request->country,
            'company_address_first'         => $request->company_address_first,
            'company_address_second'        => $request->company_address_second,
            'city'                          => $request->city,
            'country1'                      => $request->country1,
            'zip_code'                      => $request->zip_code,
            'email'                         => $request->email,
            'website'                       => $request->website,
            'reporting_email'               => $request->reporting_email,
            'accounting_email'              => $request->accounting_email,
            'processing_currencies'         => json_encode($request->processing_currencies),
            'other_currencies'              => $request->other_currencies,
            'client_main_country_1'         => $request->client_main_country_1,
            'client_country_1_valume'       => $request->client_country_1_valume,
            'client_main_country_2'         => $request->client_main_country_2,
            'client_country_2_valume'       => $request->client_country_2_valume,
            'client_main_country_3'         => $request->client_main_country_3,
            'client_country_3_valume'       => $request->client_country_3_valume,
            'payment_method'                => $request->payment_method,
            'wallet_address'                => $request->wallet_address,
            'bank_name'                     => $request->bank_name,
            'iban'                          => $request->iban,
            'bic'                           => $request->bic,
            'start_processing'              => $request->start_processing,
            // 'certificate'                   => $certificateValue,
            // 'passport'                      => $passportValue,
            'comment'                       => $request->comment,
        ]);

        return redirect('onboardings')->with('success', 'Client Updated successfully');
    }

    public function deleteUBO($id)
    {
        $result = Ubos::where('id', $id)->delete();
        if ($result) {
            return redirect()->back();
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function deleteBoard($id)
    {
        $result = BoardMembers::where('id', $id)->delete();
        if ($result) {
            return redirect()->back();
        } else {
            return back()->with('error', 'Try Again.');
        }
    }

    public function deleteSignatory($id)
    {
        $result = Signatory::where('id', $id)->delete();
        if ($result) {
            return redirect()->back();
        } else {
            return back()->with('error', 'Try Again.');
        }
    }


    // RK
}
