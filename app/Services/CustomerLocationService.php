<?php

namespace App\Services;

use App\AddressCustomer;

/**
 * 
 */
class CustomerLocationService
{
	
	//create a new team in storage
	public function storeCustomerLocation($data)
	{
		    $address = new AddressCustomer;
            $address->customer_id = $data['customer_id'];
            $address->state = $data['state'];
            $address->city = $data['city'];
            $address->street = $data['street'];
            $address->country = $data['country'];
            $address->landmark = $data['landmark'];
            $address->main_acct_id = getActiveGuardType()->main_acct_id;
            $address->save();
            return $address;
	}

   //Update team 
	public function updateCustomerLocation($data)
	{
		$address = AddressCustomer::findOrFail($data['location_id']);
		 $address->customer_id = $data['customer_id'];
            $address->state = $data['state'];
            $address->city = $data['city'];
            $address->street = $data['street'];
            $address->country = $data['country'];
            $address->landmark = $data['landmark'];
            $address->main_acct_id = getActiveGuardType()->main_acct_id;
            $address->save();
            return $address;
	}

	 public function listLocation()
    {
        return AddressCustomer::where([
            ['main_acct_id', getActiveGuardType()->main_acct_id],
        ])->with(['user', 'customer', 'countryName', 'stateName', 'cityName'])->orderBy('created_at', 'desc')->get();
    }

    public function showLocation($locationId)
    {
        return AddressCustomer::where('id', $locationId)->with(['user', 'customer', 'countryName', 'stateName', 'cityName'])->first();
    }

     public function deleteLocation($locationId)
    {
        $location = AddressCustomer::findOrFail($locationId);
        if($location){
        	$location->delete();
        }
    }
}