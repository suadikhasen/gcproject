<?php

namespace Tests\Feature\ServiceProvider;

use Tests\TestCase;
use Illuminate\Http\Response;
use App\Models\ServiceProvider;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ServiceProviderRateAndReviewTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_review()
    {
        $serviceProvider = ServiceProvider::find(132);
        $token = $serviceProvider->createToken('test device')->plainTextToken;
        // $token="dksfjskldjfkl";
        $response = $this->withHeaders(['Accept'=>'application/json','Authorization'=>'Bearer '.$token])->get('/service_provider/reviews');
        $response->dump();
        // $response->assertJson(['status'=>true]);
        $response->assertStatus(Response::HTTP_OK);
    }
}
