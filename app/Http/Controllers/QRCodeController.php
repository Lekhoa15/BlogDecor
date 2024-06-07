<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\StripeClient;
use BaconQrCode\Writer;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\Svg;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Common\ErrorCorrectionLevel;

class QRCodeController extends Controller
{
    public function payWithQr($plan)
    {
        // Tạo một PaymentIntent trên Stripe
        $stripe = new StripeClient('sk_test_51PGBfuDutMMW2UrrPDcXQpw3qLR8OYDzJ15hgRuciyVbNfKuoj4itgHWzvm3nuaGQx0MOqX4WlgAphPumVOI4FNQ00D4mzDdsO');
        $paymentIntent = $stripe->paymentIntents->create([
            'amount' => 2000, // Số tiền cần thanh toán (đơn vị là cent), bạn có thể thay đổi tùy theo plan
            'currency' => 'usd',
        ]);

        // Tạo thông tin mã QR từ PaymentIntent
        $qrCodeData = [
            'amount' => 2000,
            'currency' => 'usd',
            'description' => 'Payment for ' . $plan,
            'payment_intent_id' => $paymentIntent->id,
        ];

        // Chuyển dữ liệu mã QR thành chuỗi JSON
        $qrCodeJson = json_encode($qrCodeData);

        // Tạo mã QR từ chuỗi JSON
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new Svg(),
            new ErrorCorrectionLevel(ErrorCorrectionLevel::HIGH)
        );

        $writer = new Writer($renderer);
        $qrCodeImage = $writer->writeString($qrCodeJson);

        // Trả về view hiển thị mã QR
        return view('payments.qr', ['qrCodeImage' => $qrCodeImage]);
    }
}
