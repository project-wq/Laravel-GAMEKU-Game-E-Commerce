<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TransactionCreated;

use Illuminate\Support\Facades\Notification;

class CheckoutController extends Controller
{
    private function generateUniqueCode($prefix, $email)
    {
        $dateNow = now()->format('YmdHis');
        $uniqueString = $email . $dateNow;

        $code = $prefix . strtoupper(substr(hash('sha256', $uniqueString), 0, 9));

        return $code;
    }

    private function calculateTotalPrice()
    {
        $totalProduct = 0;
        $tax = 2500;
        $allTotal = $tax;

        $carts = Cart::where('users_id', auth()->id())->get();
        foreach ($carts as $cart) {
            $totalProduct += $cart->product->price * $cart->quantity;
        }
        $allTotal += $totalProduct;

        return [$totalProduct, $allTotal];
    }

    public function index()
    {
        return view('pages.success');
    }

    public function process(Request $request)
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.serverKey');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.isProduction');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        //? Calculate Total Price
        [$totalProduct, $allTotal] = $this->calculateTotalPrice();

        //? Ambil User Data
        $user = Auth::user();

        //? Generate Code
        $code = $this->generateUniqueCode('GMK', $user->email);

        $carts = Cart::with(['product', 'user'])
            ->where('users_id', Auth::user()->id)
            ->get();

        //? Check if Stock Product Empty
        foreach ($carts as $cart) {
            $product = Product::find($cart->product->id);
            if ($product->quantity < $cart->quantity) {
                return response()->json(
                    [
                        'status' => 'error',
                        'message' => 'Stok produk ' . $cart->product->name . ' tidak mencukupi.',
                    ],
                );
            }
        }

        //? Transaction Create
        $transaction = Transaction::create([
            'users_id' => Auth::user()->id,
            'tax_price' => 2500,
            'total_price' => $allTotal,
            'transaction_status' => 'PENDING',
            'code' => $code,
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $code,
                'gross_amount' => $allTotal,
            ],
            'customer_details' => [
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ],
        ];

        $snapToken = \Midtrans\Snap::getSnapToken($params);

        $transaction->snap_token = $snapToken;
        $transaction->save();

        //? Foreach Transaction Detail
        foreach ($carts as $cart) {
            $code = $this->generateUniqueCode('STF', $user->email);

            TransactionDetail::create([
                'transactions_id' => $transaction->id,
                'products_id' => $cart->product->id,
                'price' => $cart->product->price,
                'delivery_status' => 'PENDING',
                'code' => $code,
                'notes' => $cart->notes,
                'quantity' => $cart->quantity,
            ]);

            //? Reduce Product Stock
            $product = Product::find($cart->product->id);
            if ($product) {
                $product->quantity -= $cart->quantity;
                $product->save();
            }

            $sellerIds[] = $cart->product->users_id;
        }

        $detailToSeller = [
            'greeting' => 'Terdapat Transaksi Cuy',
            'body' => 'Ini pembayaranmu',
            'actiontext' => 'Ini Isinya',
            'actionurl' => '/',
            'lastline' => 'Footer',
        ];

        $detailToBuyyer = [
            'greeting' => 'Transaksimu Sukses Cuy',
            'body' => 'Ini pembayaranmu',
            'actiontext' => 'Ini Isinya',
            'actionurl' => '/',
            'lastline' => 'Footer',
        ];

        // Send Email to Multi Seller
        foreach ($sellerIds as $sellerId) {
            $seller = User::find($sellerId);
            /* $sellers[] = $seller; */
            Notification::route('mail', [
                $seller->email => $seller->name,
            ])->notify(new TransactionCreated($detailToSeller));
            /* Notification::send($seller, new TransactionCreated($details)); */
        }

        // Send Mail to Buyyer
        Notification::route('mail', [
            Auth::user()->email => Auth::user()->name,
        ])->notify(new TransactionCreated($detailToBuyyer));

        /* dd('Done!'); */

        /* dd($sellers); */

        /* dd('Terkirim!'); */

        // Delete Cart Data
        Cart::where('users_id', Auth::user()->id)->delete();

        /*  return view('pages.success', [
            'transaction'=> $transaction
        ]); */

        return response()->json([
            'status' => 'success',
            'snap_token' => $transaction->snap_token,
        ]);
    }

    /* public function callback(Request $request){

    } */
}
