<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Fragrent;
use App\Models\Verification_otp;
use App\Models\Review_product;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Modules\Seller\Entities\SellerProduct;
use Modules\Product\Entities\Product;
use Modules\GeneralSetting\Entities\GeneralSetting;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $generalsetting = GeneralSetting::first();
        if($generalsetting){
            if($generalsetting->membeship_url == 1){
                   return view("frontend.default.auth.membership");
            } else {
                abort(404);
            }
        } else {

        return view("frontend.default.auth.membership");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   if(auth()->check()){
        return redirect('membership-register')->with('success',"Contact To Admin For Membership Approval");
    }
       else{
        $request->validate([
        'first_name' => 'required',
        'phone'  =>  'required',
        'email' => 'required|email|unique:users',
        'password' => [
            'required',
            'string',
            'min:8',             // must be at least 10 characters in length
            'regex:/[a-z]/',      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
            'regex:/[@$!%*#?&]/', // must contain a special character
        ],
        ]);
        
        $url = 'http://scentoria.ebslon.com/membershipRegi';
        $currentUrl = url()->current();
        if($url == $currentUrl){
            $member = 1 ;
        }

        $user = new User();
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->email = $request['email'];
        $user->phone = $request['phone'];
        $user->verify_code = sha1(time());
        $user->role_id  =  '4';
        $user->password = Hash::make($request['password']);
        $user->is_membership = $member;
        $user->random_string = Str::random(30);
        $user->save();
        if($user){
        return redirect('register')->with('success',"form submitted successfully");
    }else{
         return redirect('register')->with('error',"something went wrong");
    }
    }}

    public function getReferral($random_string){
        $getReferral = User::where('random_string',$random_string)->firstOrFail();
         // dd($getReferral );
        return view('frontend.default.auth.referral_membership',compact('getReferral'));
    }


    public function storeReferrals(Request $request)
    {  
        $this->validate($request, [
        'first_name' => 'required', 
        'last_name' => 'required',  
        'phone'  =>  'required',  
        'email'     => 'required|email',  
        'password' => 
          [
            'required',
            'string',             
            'regex:/[a-z]/',      
            'regex:/[A-Z]/',   
            'regex:/[0-9]/',    
            'regex:/[@$!%*#?&]/',
            'min:8', 
          ],
        'password_confirmation' => 'required|same:password'
        ]);

        $url = 'http://scentoria.ebslon.com/membership_referral';
        $currentUrl = url()->current();

        if($url == $currentUrl){
            $member = 0 ;
        }

        $user = new User();
        $user->first_name = $request['first_name'];
        $user->last_name = $request['last_name'];
        $user->email = $request['email'];
        $user->phone = $request['phone'];
        $user->verify_code = sha1(time());
        $user->role_id = '4';
        $user->password = Hash::make($request['password']);
        $user->is_membership = $member;
        $user->random_string = Str::random(30);
        $user->referral_code = $request['old_referral'];
        $user->save();
        if($user){
        return redirect('membership-register')->with('success',"form submitted successfully");
    }else{
         return redirect('membership-register')->with('error',"something went wrong");
    }
    }


    public function requestFragrent(Request $request){
        $request->validate([
         'email' => 'required|email',
         'phone' => 'required',
        ]);

        $fragrent = new Fragrent();
        $fragrent->name = $request['name'];
        $fragrent->email = $request['email'];
        $fragrent->phone = $request['phone'];
        $fragrent->brand = $request['brand'];
        $fragrent->item = $request['item'];
        $fragrent->size = $request['size'];
        $fragrent->message = $request['message'];
        $fragrent->save();
        if($fragrent){
            return back()->with('success', 'Thank you for your enquiry, we will get back !!');
        }else{
            return back()->with('error', 'Something went wrong');
        }
    }

    public function referralCode(){
        return view("frontend.default.pages.profile.referral-code");
    }

    public function phoneOtp(){
        return view("frontend.default.auth.phone_login");
    }
    
    public function confirmOtp(){
        return view("frontend.default.auth.confirm-otp");
    }

    public function confirmOtpSend(Request $request){
        $request->validate([
            'phone' => 'required',
        ]);
        $phone = $request['phone'];
        $otp  =  rand(100000, 999999);

        $resArr = $this->sendOtpApi($phone, $otp);
        if($phone){
        return view('frontend.default.auth.confirm-otp', compact('phone'));
       }else{
        return back()->with('error','something went wrong');
       }
    }

    public function sendOtpApi($phone, $otp){
        try{ 
            $verification = Verification_otp::where('phone',$phone)->first();
        if(!$verification){
            $verification = new Verification_otp;
            $verification->phone = $phone;
        }
            $verification->otp = $otp;
            $verification->save();
        
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://sms.erisk.in/api/mt/SendSMS?APIKey=WzlWgHhf2UWqgPqYvCnCnA&senderid=SCNTOR&channel=2&DCS=0&flashsms=0&number=91'.$phone.'&text=Thank%20you%20for%20registering%20with%20us.%20Your%20OTP%20for%20verification%20with%20scentoria.co.in%20(SCENTORIA%20LUXURY%20TRADING)%20is%20'.$otp.'%20Do%20not%20share%20it%20with%20anyone.&route=31',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
       ));

      $response = curl_exec($curl);
      curl_close($curl);
    // dd($response);
    $res = json_decode($response,true);
    if(isset($res['ErrorCode']) && ($res['ErrorCode'] == '000')){
    return ['status'=>true,'msg'=>'success'];
    }
    else{
        return ['status'=>true,'msg'=>'please Try again'];
    }

    }catch(\Exception $e) {
        return ['status'=>true,'msg'=>$e->getMessage()];
    }
    }

    public function loadCartData(){
        $cartCount = Cart::where('user_id',Auth::id())->count();
        return response()->json(['count'=> $cartCount]);
    }

    public function otpCompare(Request $request){
        $phone = $request->phone;
        $otp = $request->otp;

        $verfication = Verification_otp::where('phone',$phone)->first();
        
        if(!$verfication){
            return response()->json(['status'=>true, 'msg'=>'Please Sign Up First', 'url'=>url('/register')]);
        }
        // $validateOtp = substr($userPhone->phone,strlen($phone)-6);
        $validateOtp = $verfication->otp;

        if($otp != $validateOtp){
            return response()->json(['status'=>false,'msg'=>'Invalid Otp']);
        }

        $userPhone = User::where('phone', $phone)->first();
        if($userPhone){
            Auth::login($userPhone);
            return response()->json(['status'=>true, 'msg'=>'Valid Otp', 'url'=>url('/')]);
        }
        else{
            return response()->json(['status'=>false, 'msg'=>'Please Sign Up First', 'url'=>url('/register')]);
        }
      }

    public function resendOtp($phone){
        $otp = rand(100000, 999999);
        $resArr = $this->sendOtpApi($phone,$otp);
            if(isset($resArr['status']) && $resArr['status'] == true ){
                return response()->json(['success'=>true,"msg"=>'OTP Sent Successfully']);
            } else {
                return response()->json(['success'=>false,"msg"=>'Please Try Again After Some Time']);
           }
        }

    public function search($q)
    { 
       if(!$q){
        return false;
       }
       // $products=Product::select('name')->where('name','LIKE','%'.$request->search."%")->get();
        $data = Product::where('product_name','LIKE',"%{$q}%")->get();
        $output = '';

        if (count($data)>0) {
            // concatenate output to the array
            $output = '<ul class="list-group " >';
            // loop through the result array
            foreach ($data as $row){
                // concatenate output to the array
            
              $output .= '<li class="list-group-item" " data-id="'.$row->id.'"><a style="text-decoration:none;color:black;" href="'.url('/product/'.$row->slug).'">'.$row->product_name.'</a></li>';
            }
        
            // end of output
            $output .= '</ul>';
        }
        else {
            // if there's no matching results according to the input
            $output .= '<li class="list-group-item">'.'No result founds'.'</li>';
        }
        // return output result array
        return $output;
    }

    public function reviewSubmit(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'rating' => 'required'
        ]);

        $review = new Review_product ;
        
        if ($request->hasFile('image')) {
                $imageName = time() . '.' . request()->image->getClientOriginalExtension();
                request()->image->move(public_path('/uploads/reviewProduct'), $imageName);
                $review->image = $imageName;
            }

        $review->product_id = $request->product_id; 
        $review->name = $request->name;
        $review->email = $request->email;
        $review->rating = $request->rating;
        $review->message = $request->message;
        $review->save();
        if($review){
            return response()->json(['status'=>true, 'success'=>'Review submitted successfully']);
        }else{
            return response()->json(['status'=>false, 'success'=>'Review Not submitted successfully']);
        }
    }




}
