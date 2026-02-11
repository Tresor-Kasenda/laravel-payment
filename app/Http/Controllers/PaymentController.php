<?php

namespace App\Http\Controllers;

use Shwary\Shwary;
use App\Models\BlogPost;
use Shwary\Enums\Country;
use App\Services\PaymentOptions;
use Illuminate\Contracts\View\View;
use App\Http\Requests\StorePaymentRequest;

class PaymentController extends Controller
{
    public function create(BlogPost $blogPost): View
    {
        return view('blog.payment', [
            'blogPost' => $blogPost,
            'countryCodes' => PaymentOptions::countryCodes(),
            'planOptions' => PaymentOptions::planOptions(),
        ]);
    }

    public function store(StorePaymentRequest $request)
    {
        $validated = $request->validated();

        Shwary::initFromArray([
            'merchant_id'  => config('services.shwary.merchant_id'),
            'merchant_key' => config('services.shwary.merchant_key'),
            'sandbox'      => config('services.shwary.sandbox'),
        ]);

        $country = Country::DRC;
        
       /// $callbackUrl = route('subscription.dashboard');

        $phoneNumber = $validated['country_code'] . $validated['phone_number'];

        $transaction = Shwary::pay(
            amount: (int)$validated['amount'],
            phone: $phoneNumber,
            country: $country,
        );

        if ($transaction->isPending()) {
            echo "Waiting for customer confirmation...";
        }
    }
}
