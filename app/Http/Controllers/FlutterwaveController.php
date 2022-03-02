<?php

namespace App\Http\Controllers;

use KingFlamez\Rave\Facades\Rave as Flutterwave;
use App\Models\Wallets;
use App\Models\WalletsTransactions;
use App\Models\Transactions;
use Illuminate\Http\Request;

class FlutterwaveController extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Initialize Rave payment process
     * @return void
     */
    public function initialize()
    {
        //This generates a payment reference
        $reference = Flutterwave::generateReference();

		$user = auth()->user();

        // Enter the details of the payment
        $data = [
            'payment_options' => 'card,banktransfer',
            'amount' => 500,
            'email' => $user->email,
            'tx_ref' => $reference,
            'currency' => "NGN",
            'redirect_url' => route('callback'),
            'customer' => [
                'email' => $user->email,
                "phone_number" => $user->phone,
                "name" => $user->name
            ],

            "customizations" => [
                "title" => 'Movie Ticket',
                "description" => "20th October"
            ]
        ];

        $payment = Flutterwave::initializePayment($data);

        if ($payment['status'] !== 'success') {
            // notify something went wrong
            return;
        }

        return redirect($payment['data']['link']);
    }

    /**
     * Obtain Rave callback information
     * @return void
     */
    public function callback()
    {
		$authuser = auth()->user();
		$user_id = $authuser->id;
        $status = request()->status;

        //if payment is successful
        if ($status ==  'successful') {
        
        $transactionID = Flutterwave::getTransactionIDFromCallback();
        $data = Flutterwave::verifyTransaction($transactionID);

		$currency = $data['data']['currency'];
		$amount = $data['data']['amount'];
		$customer = $data['data']['customer']['name'];

		$data = self::validuserwallet($user_id);
		$data = self::transactions($user_id, $status, $transactionID, $currency, $amount, $customer);
		$data = self::createuserwallettransactions($user_id, $status, $transactionID, $currency, $amount);
		$data = self::updatewallet($user_id, $transactionID, $amount);

		echo "'\ndone'";
        //dd($data);.
		return redirect()->route('home');

        }
        elseif ($status ==  'cancelled'){
            //Put desired action/code after transaction has been cancelled here
        }
        else{
            //Put desired action/code after transaction has failed here
        }
    }

	public function validuserwallet($user_id) {
		$user = Wallets::where('user_id', $user_id)->exists();

		if ($user) {
		echo("User Already Has A Wallet");
		} else {
		echo("Your Wallet has Being Created");
		$data =  Wallets::create([
			'user_id' => $user_id,
		]);
		return $data;
		}
	}

	public function createuserwallettransactions(String $user_id, String $status, int $transactionID, String $currency, String $amount) {

		$transaction = WalletsTransactions::where('trans_id', $transactionID)->exists();

		if ($transaction) {
		echo("\nTranshas being updated in your account.");
		} else {
		echo("Wallets Transaction Table Updated");
		$data =  WalletsTransactions::create([
			'user_id' => $user_id,
			'status' => $status,
			'currency' => $currency,
			'trans_id' => $transactionID,
			'amount' => $amount,
			'isinflow' => true,
			'payment_method' => 'flutterwave',
		]);
		return $data;
		}
	}

	public function transactions(String $user_id, String $status, String $id, String $currency, String $amount, String $customer) {
		$transaction = Transactions::where('transaction_id', $id)->exists();

		if ($transaction) {
		echo("\nTransaction Successful, you will be updated soon");
		} else {
		echo("\nPending Transaction");
		$data =  Transactions::create([
			'user_id' => $user_id,
			'transaction_id' => $id,
			'name' => $customer,
			'email' => $customer,
			'phone' => $customer,
			'currency' => $currency,
			'amount' => $amount,
			'payment_status' => "pending",
			'payment_gateway' => 'flutterwave',
		]);
		return $data;
		}
	}

	public function updatewallet(String $user_id, String $id, String $amount) {

       // $data = Transactions::where('transaction_id', $id)->firstOrFail();
		$deposit = Transactions::where('transaction_id', $id)->first();
        $deposit->payment_status = "successful";
        $deposit->save();

		if ($deposit->payment_status !== "successful") {
			echo "Transaction Processing";

		} else {
			$user = Wallets::where('user_id', $user_id)->first();
			$user->balance += $amount;
			$user->save();
			echo "\n Wallet Updated";
		}
	}

    public function balance(Request $request, $user_id)
    {
        $user = Wallets::where('user_id', $user_id)->first();

        return response()->json([$user->balance], 200);
    }
}