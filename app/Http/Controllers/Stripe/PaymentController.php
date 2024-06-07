<?php

namespace App\Http\Controllers\Stripe;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use Exception;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Stripe\Charge;
use Stripe\Exception\ApiErrorException;
use Stripe\Stripe;
class PaymentController extends Controller
{
    public function index()
    {
        return view('stripe.payments.index', [
            'intent' => auth()->user()->createSetupIntent()
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $paymentMethod = $request->input('payment-method');

        $user->update([
            'line1'         => $request->line1,
            'line2'         => $request->line2,
            'city'          => $request->city,
            'state'         => $request->state,
            'country'       => $request->country,
            'postal_code'   => $request->postal_code,
        ]);

        $plan = Plan::where('stripe_name', $request->plan)->first();

        $user->newSubscription($plan->stripe_name, $plan->stripe_price_id)
            ->create($paymentMethod);

        $user->update([
            'trial_ends_at' => NULL,
        ]);

        return redirect()->route('billing')->with('success', 'Thank you for subscribing!');
    }

    public function payWithCard($plan)
    {
        $intent = auth()->user()->createSetupIntent();
        return view('payments.card', compact('plan', 'intent'));
    }

    public function showQrCode(Request $request, $plan)
    {
        try {
            // Tạo URL để xử lý thanh toán
            $paymentUrl = route('process.payment', ['plan' => $plan]);

            // Tạo mã QR với URL
            $qrCode = QrCode::generate($paymentUrl);

            return view('payments.qr', ['qrCode' => $qrCode, 'plan' => $plan]);

        } catch (Exception $e) {
            Session::flash('error', $e->getMessage());
            return Redirect::back()->withInput();
        }
    }

        public function processPayment(Request $request, $plan)
        {
            try {
                // Tạo URL thanh toán Stripe
                $amount = 2000;
                $currency = 'usd';
                $description = 'Payment for ' . $plan;


                $session = \Stripe\Checkout\Session::create([
                    'payment_method_types' => ['card'],
                    'line_items' => [[
                        'price_data' => [
                            'currency' => $currency,
                            'product_data' => [
                                'name' => $description,
                            ],
                            'unit_amount' => $amount,
                        ],
                        'quantity' => 1,
                    ]],
                    'mode' => 'payment',
                    'success_url' => url('/success'),
                    'cancel_url' => url('/cancel'),
                ]);

                // Chuyển hướng đến trang thanh toán của Stripe
                return redirect($session->url);
            } catch (Exception $e) {
                Session::flash('error', $e->getMessage());
                return Redirect::back()->withInput();
            }
        }



}
