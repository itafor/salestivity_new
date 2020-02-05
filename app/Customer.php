<?php

namespace App;

use App\AddressCustomer;
use App\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = ['name','email','main_acct_id',
                          'industry','phone','website','profession',
                          'turn_over','employee_count','office_address',
                         'home_address','customer_type','account_id','account_type'];

    public function address()
    {
        return $this->hasOne('App\AddressCustomer', 'customer_id','id');
    }

     public function customerIndustry()
    {
        return $this->belongsTo('App\Industry', 'industry','id');
    }

    public function invoice()
    {
    	return $this->hasMany('App\Invoice');
    }

    public function renewal()
    {
    	return $this->hasMany('App\Renewal');
    }

    /**
     * Get the corporate account record associated with the account.
     */
    public function corporate()
    {
        return $this->belongsTo('App\CustomerCorporate', 'account_id');
    }

     /**
     * Get the individual account record associated with the account.
     */
    public function individual()
    {
        return $this->belongsTo('App\CustomerIndividual', 'account_id');
    }

    /**
     * Get the individual account record associated with the account.
     */
    public function contacts()
    {
        return $this->hasMany('App\Contact', 'customer_id','id');
    }

    protected $casts = [
        'cont' => 'array'
    ];

    public function renewalPayment(){
        return $this->hasMany(RenewalPayment::class);
    }

    public static function createIndividualCustomer($data) {
        $individualCustomer = self::create([
        'name' => $data['first_name'] .' '. $data['last_name'],
        'profession' => $data['profession'],
        'industry' => $data['industry'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'website' => $data['website'],
        'main_acct_id' => auth()->user()->id,
        'account_type' => $data['account_type'],
        'account_id' => null,
        'customer_type' => 'Individual',
        ]);

        if($individualCustomer){
            self::createCustomerAddress($individualCustomer,$data);
            self::createContact($individualCustomer,$data);
        }

        return $individualCustomer;
    }

 public static function createCorporateCustomer($data) {

        $corporateCustomer = self::create([
        'name' => $data['company_name'],
        'industry' => $data['industry'],
        'email' => $data['company_email'],
        'phone' => $data['company_phone'],
        'website' => $data['website'],
        'turn_over' => $data['turn_over'],
        'employee_count' => $data['employee_count'],
        'main_acct_id' => auth()->user()->id,
        'account_type' => $data['account_type'],
        'account_id' => null,
        'customer_type' => 'Corporate',
        ]);
 
        if($corporateCustomer){
            self::createCustomerAddress($corporateCustomer,$data);
            self::createContact($corporateCustomer,$data);
        }

        return $corporateCustomer;
    }

     public static function createCustomerAddress($customer,$data) {

            $address = new AddressCustomer;
            $address->customer_id = $customer->id;
            $address->state = $data['state'];
            $address->city = $data['city'];
            $address->street = $data['street'];
            $address->country = $data['country'];
            $address->main_acct_id = auth()->user()->id;
            $address->save();
    }

public static function createContact($customer,$data)
    {
    if($data['contacts'][112211]['contact_email'] !=null )
   {
        foreach($data['contacts'] as $contact){
            Contact::create([
                'customer_id' => $customer->id,
                'title' => $contact['contact_title'],
                'surname' => $contact['contact_surname'],
                'name' => $contact['contact_name'],
                'phone' => $contact['contact_phone'],
                'email' => $contact['contact_email'],
                'main_acct_id' => auth()->user()->id,
            ]);
        }
    }
}
 public static function deleteContacts($customer_id) {
    $contacts = Contact::where('customer_id',$customer_id)
    ->where('main_acct_id',auth()->user()->id)
    ->get();
    if($contacts){
      foreach ($contacts as $key => $val) {
        $val->delete();
    }
  }
}

 public static function deleteAddress($customer_id) {
    $address = AddressCustomer::where('customer_id',$customer_id)
    ->where('main_acct_id',auth()->user()->id)
    ->first();
    if($address){
    $address->delete();
  }
}

}
