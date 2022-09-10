<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\transactions_api as Trx;
use \GuzzleHttp\Client as GuzzleClient;
use Illuminate\Support\Facades\DB;

use App\http\Controllers\notifxxxController as Note;

class UserAPIController extends Controller
{

    private static $api = "https://www.affatech.com.ng/api/";
    private $trx;
    private $api_token = "Token 07729ed8e95251acf1055ebaf9d979eba656e98a";
    private $header_info = array(
            'Authorization: Token 07729ed8e95251acf1055ebaf9d979eba656e98a',
            'Content-Type: application/json'
        );

    function __construct(){
        $this -> trx = new Trx;
        // $this -> $header_info =
    }

    public function fetch_data_plands(Request $request)
    {
        try{
            $network = $request -> network;
        
            $netPlans = strtoupper($network)."_PLAN";
            
            
            $header = [
                'content-Type' => 'Application/json',
                'Authorization' => $this -> api_token    
            ];
            
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => UserAPIController::$api."get/network",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '', 
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => $this -> header_info,
            ));
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            
            // }
            
            
            // return $client;
        
            // $response = $client -> request(
            //     'GET',
            //     'network'
            // );
    
            // echo "nnull";
            // $profit = $this -> trx -> profit_tracker($network, 'data');
            // // return $profit;
        
            $plans = json_decode($response);
            // return $plans;
            
        
            $plans -> $netPlans -> plan_amount = $netPlans['plan_amount'] + 10;
        
            // return response()->json(['status' => 200, 'message' => $plans -> $netPlans], 200);
    
    
            // $dataplans = [];
            // foreach($plans -> $netPlans as $plan){
            //     $cost = $profit;
            //     $eachPlan = array(
            //         'id' => $plan -> id,
            //         'network_id' => $plan -> network,
            //         'plan_type' => $plan -> plan_type,
            //         'network_name' => $plan -> plan_network,
            //         'validity' => $plan -> month_validate,
            //         'package' => $plan -> plan,
            //         'amount' => (number_format($plan -> plan_amount + 5))
            //     );
            //     array_push($dataplans, $eachPlan);
            // };
    
            // return response() -> json([
            //     'status' => 200,
            //     'message' => $dataplans
            // ],200);
        }
        catch(\Throwable $thr){
              return $thr;
            return "SERVER ERROR";
        } 
    }
    
    public function dataplans_list (Request $request)
    {
        try{
            
        }
        catch(\Throwable $th){
            return $th;
        }
    }
    
    public function fetch_data_plans(Request $request)
    {
     try{
        $network = $request -> network."_PLAN";

        $netPlans = strtoupper($network);

        $client = new GuzzleClient([
            'base_uri' => transactions_api::$api."network",
            'headers' => [
                'content-Type' => 'Application/json',
                'Authorization' => $this -> api_token
            ],

        ]);
        
        // return $client;

        $response = $client -> request(
            'GET',
            'network'
        );

        // echo "nnull";
        $profit = $this -> trx -> profit_tracker($network, 'data');
        // return $profit;

        $plans = json_decode($response -> getBody());
       // return $plans;
        

        // $plans -> $netPlans -> plan_amount = $netPlans['plan_amount'] + 30;

        // return response()->json(['status' => 200, 'message' => $plans -> $netPlans], 200);


        $dataplans = [];
        foreach($plans -> $netPlans as $plan){
            $cost = $profit;
            $eachPlan = array(
                'id' => $plan -> id,
                'network_id' => $plan -> network,
                'plan_type' => $plan -> plan_type,
                'network_name' => $plan -> plan_network,
                'validity' => $plan -> month_validate,
                'package' => $plan -> plan,
                'amount' => (number_format($plan -> plan_amount + 5))
            );
            array_push($dataplans, $eachPlan);
        };

        return response() -> json([
            'status' => 200,
            'message' => $dataplans
        ],200);
      }
      catch(\Throwable $thr){
      //    return $thr;
           return "SERVER ERROR";
      }
    }
    
    // public function fetchDataPlans2 (Request $request){
    //     try{
    //         $network = $request -> network;

    //         $netPlans = strtoupper($network)."_PLAN";
    
    //         $curl = curl_init();
            
    //         curl_setopt_array($curl, array(
    //               CURLOPT_URL => 'topup',
    //               CURLOPT_RETURNTRANSFER => true,
    //               CURLOPT_ENCODING => '',
    //               CURLOPT_MAXREDIRS => 10,
    //               CURLOPT_TIMEOUT => 0,
    //               CURLOPT_FOLLOWLOCATION => true,
    //               CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    //               CURLOPT_CUSTOMREQUEST => 'POST',
    //               CURLOPT_POSTFIELDS =>'{
    //                 "network": '.$network_id.',
    //                 "mobile_number": "'.$contact.'",
    //                 "plan": '.$plan.',
    //                 "Ported_number": true
    //             }',
    //               CURLOPT_HTTPHEADER => $this -> header_info,
    //             ));
    //             // return $this -> api_token;
        
    //             $response = curl_exec($curl);
        
    //             curl_close($curl);
            
    //     }
    // }

    public function datasub (Request $request) {
        try{
            $network = $request -> network;
            $contact = $request -> tel;
    
            $plans = explode('-,-', $request -> plans);
            // return $plans[2];
            
            $plan = $plans[0];
            $amount = $plans[1];
            $plan_desc = $plans[2];
            
            // return $amount;
            
            // return $plans;
            // return $network;
    
            $network_id_fetcher = DB::table('network_ids') -> where('network_name', $network) -> get();
            // return $network_id_fetcher;
            $network_id = $network_id_fetcher[0] -> network_id;
            // return $network_id;
            
            // return Auth() -> user() -> wbalance;
            
            if(Auth() -> user() -> wbalance >= $amount) {
                $curl = curl_init();
        
                curl_setopt_array($curl, array(
                  CURLOPT_URL => 'https://www.affatech.com.ng/api/data/',
                  CURLOPT_RETURNTRANSFER => true,
                  CURLOPT_ENCODING => '',
                  CURLOPT_MAXREDIRS => 10,
                  CURLOPT_TIMEOUT => 0,
                  CURLOPT_FOLLOWLOCATION => true,
                  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                  CURLOPT_CUSTOMREQUEST => 'POST',
                  CURLOPT_POSTFIELDS =>'{
                    "network": '.$network_id.',
                    "mobile_number": "'.$contact.'",
                    "plan": '.$plan.',
                    "Ported_number": true
                }',
                  CURLOPT_HTTPHEADER => $this -> header_info,
                ));
                // return $this -> api_token;
        
                $response = curl_exec($curl);
        
                curl_close($curl);
                $res = json_decode($response);
        
        
                $data = [];
                $status = 1;
        
                if(isset($res -> error)){
                    $data = [
                        'message' => $res -> error[0],
                        'status' => 500,
                    ];
                    $status = 0;
                }
                else{
                    $data = [
                        "message" => ($res -> Status)?"You have succesfully purchased {$plan_desc} data for {$contact}":"Not successful",
                        'status' => 200,
                    ];
                    $status = 2;
                }
        
                $add_to_rec = $this -> trx -> update_sales_rec('Mobile Data',$plan_desc,$network,$amount,'5',$contact,$status);
                // return $add_to_rec;
                if($add_to_rec == "201"){
                    if($status == 2){
                        $debit_user = $this -> trx -> debitUser($amount);
                        if($debit_user == "200"){
                            return response()->json($data, 200);
                        }
                        elseif($debit_user == "400"){
                            return response()->json([
                                'status' => 400,
                                'message' => "Transaction has been completed but an error occurred in the process. Please contact an admin for help"
                            ], 200);
                        }
                        else{
                            // return $debit_user;
                            return response()->json([
                                'status' => 500,
                                'message' => "A server error occured while completing the action. Please contact an admin for help!"
                            ], 200);
                        }
                    }
                    else{
                        return response()->json($data, 200);
                    }
                    // return 100;
                }
                else{
                    // return $add_to_rec;
                    return response()->json([
                        'status' => 400,
                        'message' => "An error occurred while processing your request"
                    ], 200);
                    
                }
            }
            
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "You don't have enough fund for this."
                ], 200);
            }
        }
        catch(\Throwable $th){
            return $th;
            return response()->json([
                'status' => 500,
                'message' => "Internal Server Error"
            ], 200);
        }
    }

    public function sendAirtime(Request $request) {
        try{
            $contact = $request -> tel;
            $amount = $request -> amount;
            $network = $request ->network;

            if(Auth() -> user() -> wbalance >= $amount) {
            
                $network_name = DB::table('network_ids') -> where('network_id', $network) -> get();
                

                $curl = curl_init();
                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://www.affatech.com.ng/api/topup/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS =>'{
                    "network": '.$network.',
                    "amount": '.$amount.',
                    "mobile_number": "'.$contact.'",
                    "Ported_number": true,
                    "airtime_type": "VTU"
                }',
                    CURLOPT_HTTPHEADER => $this -> header_info,
                ));
                // return $this -> api_token;

                $response = curl_exec($curl);

                curl_close($curl);
                $res = json_decode($response);

                $resp = [];
                $status = 1;

                if(isset($res -> error)){
                    $resp = [
                        "status" => 500,
                        "message" => $res -> error[0],
                        "transaction_status" => 0
                    ];
                    $status = 0;
                }
                else{
                    $resp = [
                        "status" => 200,
                        "message" => ($res -> Status)?"You have succesfully purchased {$amount}NGN {$network_name[0] -> network_name} airtime for {$contact}":"Not successful",
                        "transaction_status" => 2
                    ];
                    $status = 2;
                }

                $status_code = $resp['transaction_status'];
                // return $debit_user;
               // $add_to_rec = $this -> trx -> update_sales_rec('Airtime VTU',$amount.'NGN', ($network == 1)?"MTN":($network == 2)?"GLO":($network == 3)?"9Mobile":($network == 4)?"Airtel":"Undefined", $amount,'5', $contact, $status_code);
               
               $add_to_rec = $this -> trx -> update_sales_rec('Airtime VTU',$amount.'NGN', $network_name[0] -> network_name, $amount,'5', $contact, $status_code);

                if($add_to_rec == 201){
                    $debit_user = $this -> trx -> debitUser($amount);
                    if($debit_user == "200"){
                        return response()->json($resp, 200);
                    }
                    elseif($debit_user == "400"){
                        return response()->json([
                            'status' => 400,
                            'message' => "Transaction has been completed but an error occurred in the process. Please contact an admin for help"
                        ], 200);
                    }
                    else{
                        // return $debit_user;
                        return response()->json([
                            'status' => 500,
                            'message' => "A server error occured while completing the action. Please contact an admin for help!"
                        ], 200);
                    }
                }
                else{
                    return response()->json([
                        'status' => 400,
                        'message' => "An error occurred while processing your request"
                    ], 200);
                }
            }
            else{
                return response()->json([
                    'status' => 400,
                    'message' => "You don't have enough fund for this."
                ], 200);
            }

        }
        catch(Throwable $th){
            return response()->json([
                "status" => 500,
                "message" => "An error occcurred"
            ], 500);
        }


    }
    
    // A TEMPORARY METHOD FOR THE PAGE ROUTERS
    public function dashboard (Request $request) {

        $note = new Note;
        return view('user.dashboard', array(
            'welcomeModalNote' => $note -> index()
        ));
    }
}