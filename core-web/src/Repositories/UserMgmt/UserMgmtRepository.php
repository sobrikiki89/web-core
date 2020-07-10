<?php
namespace App\Repositories\UserMgmt;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use function GuzzleHttp\Psr7\stream_for;
use App\Domain\UserMgmt\Model\User;
use Illuminate\Support\Facades\Config;

class UserMgmtRepository extends ServiceProvider
{
    
    const TIME_OUT = 5;
    
    private $infoStaffBaseURL;
    private $authBaseURL;
    private $authBaseBearerToken;
    
    protected $token;
    
    public function __construct()
    {
        $this->infoStaffBaseURL = Config::get('authapi.base_url_api') . '/system_events/staf/';
        $this->authBaseURL = Config::get('authapi.base_url_api') . '/stars/login';
        $this->authBaseBearerToken = Config::get('authapi.base_bearer_token_api');
        
    }
    
    public function staffInfomation($staffId){
        
        $data = $this->getMethod($this->infoStaffBaseURL.$staffId);
        
        if(array_key_exists('ERROR',$data)){
            return $data;
        }if(array_key_exists('msg',$data) && $data['msg'] != 'Rekod dijumpai'){
            return array( 'ERROR' => __('messages_core_web.noDataFound'));
        }else{
            return array (
                'staffId' => $data['No Pekerja'],
                'title' => ($data['Gelaran'] != null ? $data['Gelaran'].' ' : ''),
                'name' => $data['Nama'],
                'department' => $data['Jabatan Sekarang - Keterangan'],
                'designation' => $data['Jawatan Sekarang - Keterangan'],
                //'contactNo' => ($data['bk_tel_bimbit']  != 'None' ? $data['bk_tel_bimbit'] : ''),
                'contactNo' => '',
                'email' => ($data['Alamat emel']  != null ? $data['Alamat emel'] : ''),
                'department_code' => $data['Jabatan Sekarang - Kod'],
                'designation_code' => $data['Jawatan Sekarang - Kod']
            );
        }
        
    }
    
    public function getUserInfo($userId){
        $user = User::where('id', $userId)->get();
        $arrayJsonUser = $user->toArray();
        return $this->staffInfomation($arrayJsonUser[0]['staff_no']);
    }
    
    public function attemptLogin($credentials){
        $data = '{ "username": "'.$credentials['staff_no'].'", "password": "'.$credentials['password'].'" }';
        $respond = $this->postMethod($this->authBaseURL, $data);
        return $respond;
    }
    
    public function createUser($attributes)
    {
        $user = new User();
        
        $user->name = $attributes['name'];
        $user->email = ($attributes['email'] ? $attributes['email'] : '');
        $user->created_at = Carbon::now();
        $user->staff_no = $attributes['staff_no'];
        $user->active = ((array_key_exists('active', $attributes) && $attributes['active'] == 'on') ? true : false);
        $user->session_timeout = ($attributes['session_timeout'] ? $attributes['session_timeout'] : 100);
        $user->invalid_count_login = ($attributes['invalid_count_login'] ? $attributes['invalid_count_login'] : 0);
        $user->max_count_login = ($attributes['max_count_login'] ? $attributes['max_count_login'] : 100);
        $user->last_login_date = ( (isset($attributes['last_login_date']) && $attributes['last_login_date'] ) ? $attributes['last_login_date'] : Carbon::now());
        $user->save();
        
        return DB::table('users')->where('staff_no', $attributes['staff_no'])->get();
    }
    
    public function updateUser($attributes)
    {
        return DB::table('users')
        ->where('staff_no', $attributes['staff_no'])
        ->update(
            array (
                'active' => ((array_key_exists('active', $attributes) && $attributes['active'] == 'on') ? true : false),
                'session_timeout' => ($attributes['session_timeout'] ? $attributes['session_timeout'] : 100),
                'invalid_count_login' => ($attributes['invalid_count_login'] ? $attributes['invalid_count_login'] : 0),
                'max_count_login' => ($attributes['max_count_login'] ? $attributes['max_count_login'] : 100),
                'last_login_date' => ( (isset($attributes['last_login_date']) && $attributes['last_login_date'] ) ? $attributes['last_login_date'] : Carbon::now()),
            )
            );
    }
    
    public function updateInvalidCountInvalidLogin($staffNo, $amount){
        return DB::table('users')
        ->where('staff_no', $staffNo)
        ->update(
            array (
                'invalid_count_login' => $amount,
            )
            );
    }
    
    public function updateILastLogin($staffNo){
        return DB::table('users')
        ->where('staff_no', $staffNo)
        ->update(
            array (
                'last_login_date' => Carbon::now(),
            )
            );
    }
    
    public function getUserByStaffId($staffId){
        return DB::table('users')->where('staff_no', $staffId)->first();
    }
    
    public function getUserObjectById($id){
        return User::find($id);
    }
    
    public function getMethod($urlRequest){
        
        try {
            $client = new Client();
            $response = $client->request('GET',
                $urlRequest,
                ['headers' =>
                    [
                        'Authorization' => 'Bearer '.$this->authBaseBearerToken,
                        'Content-Type' => 'application/json'
                    ],
                    'timeout' => self::TIME_OUT
                ]
                );
            $statusCode = $response->getStatusCode();
            if($statusCode == '200'){
                return json_decode($response->getBody()->getContents(), true);
            }else{
                return array( 'ERROR' => __('messages_core_web.generalError'));
            }
        } catch (RequestException $e) {
            return array( 'ERROR' => __('messages_core_web.generalError'));
        }
    }
    
    public function postMethod($urlRequest, $data){
        try {
            
            $stream = stream_for($data);
            $client = new Client();
            $response = $client->request('POST', $urlRequest,
                ['headers' =>
                    [
                        'Authorization' => 'Bearer '.$this->authBaseBearerToken,
                        'Content-Type' => 'application/json'
                    ],
                    'body' => $stream,
                    'timeout' => self::TIME_OUT
                ]
                );
            $statusCode = $response->getStatusCode();
            
            if($statusCode == '200'){
                return json_decode($response->getBody()->getContents(), true);
            }else{
                return array( 'ERROR' => __('messages_core_web.generalError'));
            }
        } catch (RequestException $e) {
            return array( 'ERROR' => __('messages_core_web.generalError'));
        }
    }
    
    public function gridUser(){
        
        $listUser = DB::table('users')->orderBy('name')->get();
        
        return $listUser;
    }
}