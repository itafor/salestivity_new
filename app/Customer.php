<?php

namespace App;

use App\AddressCustomer;
use App\Contact;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    // protected $fillable = ['name','email','main_acct_id',
    //                       'industry','phone','website','profession',
    //                       'turn_over','employee_count','office_address',
    //                      'home_address','customer_type','account_id','account_type',
    //                     'user_type', 'created_by'];

    protected $guarded = ['id'];

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

        // store the creator's id and main_acct_id
        if(auth()->check()) {
            $main_acct_id = auth()->user()->id;
            $created_by = auth()->user()->id;
            $userType = 'users';
        }
        if(auth()->guard('sub_user')->check()) {
            // get the sub_user's main_acct_id
            $main_acct_id = auth()->guard('sub_user')->user()->main_acct_id;
            $created_by = auth()->guard('sub_user')->user()->id;
            $userType = 'sub_users';
        }
        // dd($userType);
        $individualCustomer = self::create([
        'name' => $data['first_name'] .' '. $data['last_name'],
        'profession' => $data['profession'],
        'industry' => $data['industry'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'website' => isset($data['website']) ? $data['website'] : null,
        'main_acct_id' => $main_acct_id,
        'created_by' => $created_by,
        'user_type' => $userType,
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

    // if creator is a main user, store 
    if(auth()->check()) {
        $main_acct_id = auth()->user()->id;
        $created_by = auth()->user()->id;
        $userType = 'users';
    }
    if(auth()->guard('sub_user')->check()) {
        // get the sub_user's main_acct_id
        $main_acct_id = auth()->guard('sub_user')->user()->main_acct_id;
        $created_by = auth()->guard('sub_user')->user()->id;
        $userType = 'sub_users';
    }
    // dd($main_acct_id);
        // dd($data);
        $corporateCustomer = self::create([
        'name' => $data['company_name'],
        'industry' => $data['industry'],
        'email' => $data['company_email'],
        'phone' => $data['company_phone'],
        'website' => isset($data['website']) ? $data['website'] : null,
        'turn_over' => $data['turn_over'],
        'employee_count' => $data['employee_count'],
        'main_acct_id' => $main_acct_id,
        'created_by' => $created_by,
        'user_type' => $userType,
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
            $address->main_acct_id = getActiveGuardType()->main_acct_id;
            $address->save();
    }

public static function createContact($customer,$data)
    {

        self::addCustomerToContact($customer);

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
                'main_acct_id' => getActiveGuardType()->main_acct_id,
            ]);
        }
    }
}

 public static function updateCorporateCustomerAcount($data)
    {
       //dd($data);
        self::where('id', $data['id'])->update([
        'name' => $data['company_name'],
        'industry' => $data['industry'],
        'email' => $data['company_email'],
        'phone' => $data['company_phone'],
        'website' => isset($data['website']) ? $data['website'] : null,
        'turn_over' => $data['turn_over'],
        'employee_count' => $data['employee_count'],
        'main_acct_id' => getActiveGuardType()->main_acct_id,
        'account_type' => $data['account_type'],
        'account_id' => null,
        'customer_type' => 'Corporate',
        ]); 

        $customer = self::where('id', $data['id'])->first();
        $address = AddressCustomer::where('customer_id', $data['id'])->first();
        $contactExist = Contact::where('email', $customer->email)->first();


        self::updateAddress($address,$data);
        self::updateContacts($data,$customer);

         if(!$contactExist){
            self::addCustomerToContact($customer);
        }
    }

     public static function updateIndividualCustomerAcount($data)
    {
       //dd($data);
        self::where('id', $data['id'])->update([
        'name' => $data['name'],
        'profession' => $data['profession'],
        'industry' => $data['industry'],
        'email' => $data['email'],
        'phone' => $data['phone'],
        'website' => isset($data['website']) ?  $data['website'] : null,
        'customer_type' => 'Individual',
        ]); 

        $customer = self::where('id', $data['id'])->first();
        $address = AddressCustomer::where('customer_id', $data['id'])->first();
        $contactExist = Contact::where('email', $customer->email)->first();

        self::updateAddress($address,$data);
        self::updateContacts($data,$customer);

        if(!$contactExist){
            self::addCustomerToContact($customer);
        }
    }

    public static function updateContacts($data,$customer)
    {
         if(isset($data['customerContacts'])){
        foreach($data['customerContacts'] as $key => $contact){
            $cont = Contact::where('id', $key)->first();
            if($cont){
                $cont->title = $contact['contact_title'];
                $cont->surname = $contact['contact_surname'];
                $cont->name = $contact['contact_name'];
                $cont->email = $contact['contact_email'];
                $cont->phone = $contact['contact_phone'];
                $cont->save();
            }
        }
    }
     if(isset($data['contacts']))
        {
           foreach($data['contacts'] as $contact){
            Contact::create([
                'customer_id' => $data['id'],
                'title' => $contact['contact_title'],
                'surname' => $contact['contact_surname'],
                'name' => $contact['contact_name'],
                'phone' => $contact['contact_phone'],
                'email' => $contact['contact_email'],
                'main_acct_id' => getActiveGuardType()->main_acct_id,
            ]);
        }  
    }
}

public static function updateAddress($address,$data){
    AddressCustomer::where('id', $address->id)->update([
        'country' => $data['country'],
        'state' => $data['state'],
        'city' => $data['city'],
        'street' => $data['street'],
        ]); 
}

 public static function deleteContacts($customer_id) {
    $contacts = Contact::where('customer_id',$customer_id)
    ->where('main_acct_id',getActiveGuardType()->main_acct_id)
    ->get();
    if($contacts){
      foreach ($contacts as $key => $val) {
        $val->delete();
    }
  }
}

 public static function deleteAddress($customer_id) {
    $address = AddressCustomer::where('customer_id',$customer_id)
    ->where('main_acct_id',getActiveGuardType()->main_acct_id)
    ->first();
    if($address){
    $address->delete();
  }
}

public static function addCustomerToContact($customer)
{
    Contact::create([
    'customer_id' => $customer->id,
    'name' => $customer->first_name ? $customer->first_name : $customer->name,
    'phone' => $customer->phone,
    'email' => $customer->email,
    'main_acct_id' => getActiveGuardType()->main_acct_id,
    ]);
}

}
