<?php

use App\Http\Controllers\ServiceApprovalController;
use App\Http\Controllers\ServiceProvider\FeaturedController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\AuthenticationController;
use App\Http\Controllers\User\BookingController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\RateAnReviewController;
use App\Http\Controllers\User\ServiceController;
use App\Http\Controllers\User\ServiceProviderController;
use App\Http\Controllers\User\UserProfileController;

Route::post('/check_phone_number_existence',[AuthenticationController::class,'checkPhoneNumberExistence']);
Route::post('/register',[AuthenticationController::class,'register']);
Route::post('/verify_code',[AuthenticationController::class,'verify']);
Route::post('/resend_code',[AuthenticationController::class,'resend']);
Route::post('/login',[AuthenticationController::class,'login']);


Route::controller(ServiceProviderController::class)->middleware('auth:user')->group(function(){
  Route::get('/service_providers/{latitude}/{longitude}','listOfServiceProviders');
});

Route::controller(ServiceController::class)->middleware('auth:user')->group(function(){
  Route::get('/services/{service_provider_id}','listOfServices');
});
Route::controller(PaymentController::class)->middleware('auth:user')->group(function(){
 Route::post('/deposit/{is_on_booking}','deposit');
});

Route::controller(BookingController::class)->middleware('auth:user')->group(function(){
  Route::post('/book/{deposit_id?}','booking');
  Route::get('check_booking_eligibility/{service_id}','checkBookingEligibility');
  Route::get('/user_bookings','userBookings');

 });

 Route::controller(RateAnReviewController::class)->middleware('auth:user')->group(function(){
   Route::post('/add_review','add');
   Route::post('/edit_review/{id}','edit');
   Route::get('service_provider_reviews/{service_provider_id}','serviceProviderReviews');
   Route::get('/check_review_eligibility/{service_provider_id}','checkReviewEligibility');
 });

 Route::controller(UserProfileController::class)->middleware('auth:user')->group(function(){
    Route::get('/profile','profile');
    Route::get('log_out','logOut');
    Route::post('/edit_profile','editProfile');
  });

  Route::controller(FeaturedController::class)->middleware('auth:user')->group(function(){
    Route::get('/featureds','featureds');
  });

  Route::controller(ServiceApprovalController::class)->middleware('auth:user')->group(function(){
    Route::get('get_approval_token/{booking_id}','generateBarcodeForUser');
  });
