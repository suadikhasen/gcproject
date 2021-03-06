<?php

namespace App\Http\Controllers\ServiceProvider;

use App\Http\Controllers\Controller;
use App\Http\Requests\ServiceProvider\AddServiceRequest;
use App\Http\Requests\ServiceProvider\EditServiceProviderRequest;
use App\Models\Service;
use App\Models\ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function addService(AddServiceRequest $addServiceRequest)
    {
    $extension = $addServiceRequest->file('image')->getClientOriginalExtension();
    $name = $addServiceRequest->file('image')->getClientOriginalName();
    $file_name = time().$name;
    $addServiceRequest->file('image')->move(public_path('service_images'),$file_name);
      $fields = $addServiceRequest->all();
      $fields['image'] = 'service_images/'.$file_name;
      $service_provider = Auth::guard('service_provider')->user();
      $service = $service_provider->services()->create($fields);
      if($service){
            return response()->json([
                'status'=>'success',
                'service'=>$service
            ],Response::HTTP_CREATED);
        }
    }

    public function allServices()
    {
       $service_provider = Auth::guard('service_provider')->user();
       $services =  $service_provider->services;
       return response()->json([
           'services'=>$services,

       ],200);
    }

    public function editService(EditServiceProviderRequest $editServiceProviderRequest,$id)
    {
        $service = Service::findOrFail($id);
        $extension = $editServiceProviderRequest->file('image')->getClientOriginalExtension();
        $name = $editServiceProviderRequest->file('image')->getClientOriginalName();
        $file_name = time().$name;
        $editServiceProviderRequest->file('image')->move(public_path('service_images'),$file_name);
        $fields = $editServiceProviderRequest->all();
        $fields['image'] = 'service_images/'.$file_name;
    //   $service_provider = Auth::guard('service_provider')->user();
        $service->update($fields);
        $service->refresh();
        return response()->json([
            'service'=>$service,

        ],200);    
    }

    public function deleteService($id)
    {
        $service = Service::findOrFail($id);
        $delete = $service->delete();
        return response()->json(['status'=>'success'],200);

    }
}
