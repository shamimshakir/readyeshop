<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderHistory;
use Illuminate\Http\Request;
//use Illuminate\Http\Response;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Http\Controllers\Controller;
use Exception;
use Facade\FlareClient\Http\Exceptions\NotFound;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\helper;


class SslCommerzPaymentController extends Controller
{

    public function exampleEasyCheckout()
    {
        return view('payment');
    } 
    public function Orderreturn()
    {
        return view('orderpaymentstatus');
    } 

    public function payViaAjax(Request $request){       
        $cart_data=stdToArray(json_decode($request->cart_json));    
        if($cart_data['customer__id']>0){

            $companysetups= pick('company_setups', 'company_name', null, null); 
            $date = date( 'dmy' );        
            $shopName = strtoupper( substr( $companysetups, 0, 3 ) );
            $random = rand( 0000, 9999 );
            $od_no = $shopName . $date . $random;

            $transaction_id=uniqid();
            $currency="BDT";
            $order = Order::create([
                "od_no" => $od_no,
                "od_date" => date('Y-m-d H:i:s'),
                "cl_id" => $cart_data['customer__id'],
                "order_payment_method" => $cart_data['order_payment_method'],
                "product_cost" => $cart_data['product_cost'],
                "total_cost" => $cart_data['total_cost'],
                "od_shipping_cost" => $cart_data['od_shipping_cost'],
                "od_payment_first_name" => $cart_data['od_payment_first_name'],
                "od_payment_email" => $cart_data['od_payment_email'],
                "od_payment_phone" => $cart_data['od_payment_phone'],
                "od_payment_country" => $cart_data['od_payment_country'],
                "od_payment_address1" => $cart_data['od_payment_address1'],
                "od_payment_postal_code" => $cart_data['od_payment_postal_code'],
                "od_payment_city" => $cart_data['od_payment_city'],
                "od_payment_thana" => $cart_data['od_payment_thana'],
                "od_shipping_first_name" => $cart_data['od_shipping_first_name'],
                "od_shipping_email" => $cart_data['od_shipping_email'],
                "od_shipping_phone" => $cart_data['od_shipping_phone'],
                "od_shipping_address1" => $cart_data['od_shipping_address1'],
                "od_shipping_postal_code" => $cart_data['od_shipping_postal_code'],
                "od_shipping_country" => $cart_data['od_shipping_country'],
                "od_shipping_thana" => $cart_data['od_shipping_thana'],
                "od_shipping_city" => $cart_data['od_shipping_city'],
                "status" => "Pending",
                "transaction_id" => $transaction_id,
                "currency" => $currency,
                "user_id" => $cart_data['customer__id'],
            ]);
            $order_id =  $order->id;

            foreach($cart_data['pd_id'] as $i => $pids ){
              
                $orderitem = OrderItem::create([
                    "od_id" =>$order_id,
                    "pd_id" => $pids,
                    "od_qty" => $cart_data['od_qty'][$i],
                    "size_id" => $cart_data['size_id'][$i],
                    "color_id" => $cart_data['color_id'][$i],
                    "pd_price" => $cart_data['pd_price'][$i],
                    "user_id" => $cart_data['customer__id'],
                    ]);
            }

            $orderhistory = OrderHistory::create([
                    "od_id" =>$order_id,
                    "status" => '1',
                    "comments" => 'Order Placed',
                    "user_id" =>   $cart_data['customer__id'],
                    ]);
           $post_data = array();
            $post_data['total_amount'] = $cart_data['total_cost']; # You cant not pay less than 10
            $post_data['currency'] = "BDT";
            $post_data['tran_id'] = $transaction_id; // tran_id must be unique

            # CUSTOMER INFORMATION
            $post_data['cus_name'] = $cart_data['od_payment_first_name'];
            $post_data['cus_email'] =  $cart_data['od_payment_email'];
            $post_data['cus_add1'] = $cart_data['od_payment_address1'];
            $post_data['cus_add2'] = "";
            $post_data['cus_city'] = "";
            $post_data['cus_state'] = "";
            $post_data['cus_postcode'] = "";
            $post_data['cus_country'] = "Bangladesh";
            $post_data['cus_phone'] = $cart_data['od_payment_phone'];
            $post_data['cus_fax'] = "";

            # SHIPMENT INFORMATION
            $post_data['ship_name'] = "Store Test";
            $post_data['ship_add1'] = "Dhaka";
            $post_data['ship_add2'] = "Dhaka";
            $post_data['ship_city'] = "Dhaka";
            $post_data['ship_state'] = "Dhaka";
            $post_data['ship_postcode'] = '1200';
            $post_data['ship_phone'] = "";
            $post_data['ship_country'] = "Bangladesh";

            $post_data['shipping_method'] = "NO";
            $post_data['product_name'] = "Goods";
            $post_data['product_category'] = "Goods";
            $post_data['product_profile'] = "physical-goods";

            # OPTIONAL PARAMETERS
            

            $post_data[ 'value_a' ] = $order_id;
            $post_data[ 'value_b' ] = $cart_data['customer__id'];
            $post_data[ 'value_c' ] = $od_no;
            $post_data[ 'value_d' ] = $_SERVER['SERVER_NAME'];
//writeLog('customer',print_r($post_data, true));
            $sslc = new SslCommerzNotification();
            # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
            $payment_options = $sslc->makePayment($post_data, 'checkout', 'json');

            if (!is_array($payment_options)) {
                print_r($payment_options);
                $payment_options = array();
            } 

        }
    }

    public function success(Request $request)
    {       

        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'total_cost')->first();

        if ($order_detials->status == 'Pending') {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation == TRUE) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(
                        ['status' => 'Processing',
                        'payment_status'=>'1',
                        'pay_remark'=>'Online Payment',
                        'od_payment_date'=>date('Y-m-d H:i:s')
                        ]);

                echo "<br >Transaction is successfully Completed";
            } else {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel and Transation validation failed.
                Here you need to update order status as Failed in order table.
                */
                $update_product = DB::table('orders')
                    ->where('transaction_id', $tran_id)
                    ->update(
                        ['status' => 'Failed',
                        'payment_status'=>'4',
                        'pay_remark'=>'Online Payment Fail',
                        'od_payment_date'=>date('Y-m-d H:i:s')
                        ]);
                echo "validation Fail";
            }
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            echo "Transaction is successfully Completed";
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            echo "Invalid Transaction";
        }


    }

    public function fail(Request $request)
    {
       

        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'total_cost')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Failed','payment_status'=>'4','od_payment_date'=>date('Y-m-d H:i:s')]);
                return response()->json(["status" => "failed", "error" => true, "message" => "Transaction is Falied."], 400);
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
                return response()->json(["status" => "success", "error" => false, "message" => "Transaction is already Successful."], 200);
        } else {           
                return response()->json(["status" => "failed", "error" => true, "message" => "Transaction is Invalid."], 400);
        }

    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');

        $order_detials = DB::table('orders')
            ->where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'total_cost')->first();

        if ($order_detials->status == 'Pending') {
            $update_product = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->update(['status' => 'Canceled','payment_status'=>'3','od_payment_date'=>date('Y-m-d H:i:s')]);

            return response()->json(["status" => "failed", "error" => true, "message" => "Transaction is Cancel."], 400);    
          
        } else if ($order_detials->status == 'Processing' || $order_detials->status == 'Complete') {
            return response()->json(["status" => "success", "error" => false, "message" => "Transaction is already Successful."], 200);
        } else {
            return response()->json(["status" => "failed", "error" => true, "message" => "Transaction is Invalid."], 400);
        }


    }

    public function ipn(Request $request)
    {
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');

            #Check order status in order tabel against the transaction id or order id.
            $order_details = DB::table('orders')
                ->where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'total_cost')->first();

            if ($order_details->status == 'Pending') {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->total_cost, $order_details->currency);
                if ($validation == TRUE) {
                   
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update([
                            'status' => 'Processing',
                            'payment_status'=>'1',
                            'od_payment_date'=>date('Y-m-d H:i:s'),
                            'od_payment_amount'=>$order_details->total_cost
                             ]);

                    

                    return response()->json(["status" => "success", "error" => false, "message" => "Transaction is successfully Completed"], 200);  

                } else {
                    /*
                    That means IPN worked, but Transation validation failed.
                    Here you need to update order status as Failed in order table.
                    */
                    $update_product = DB::table('orders')
                        ->where('transaction_id', $tran_id)
                        ->update([
                            'status' => 'Failed',
                            'payment_status'=>'4',
                            'od_payment_date'=>date('Y-m-d H:i:s')
                        ]);
                    return response()->json(["status" => "failed", "error" => true, "message" => "validation Fail"], 400);

                }

            } else if ($order_details->status == 'Processing' || $order_details->status == 'Complete') {
               

                return response()->json(["status" => "success", "error" => false, "message" => "Transaction is already Successful."], 200);
            } else {              

               return response()->json(["status" => "failed", "error" => true, "message" => "Transaction is Invalid."], 400);
            }
        } else {
            return response()->json(["status" => "failed", "error" => true, "message" => "Invalid Data."], 400);
        }
    }

}
