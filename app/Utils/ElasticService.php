<?php 
namespace App\Utils;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ElasticService{
    protected $HOST;
    protected $USERNAME;
    protected $PASSWORD;

    public function __construct(){
        $this->HOST = env('ELASTIC_HOST');
        $this->USERNAME = env('ELASTIC_USERNAME');
        $this->PASSWORD = env('ELASTIC_PASSWORD');
    }

    public function SendLog($request, $response, $captured_time, $duration){
        $log = [
            "full_url"=> $request->fullUrl(),
            "path"=> $request->path(),
            
            "client_ip"=> $request->ip(),
            "server_ip"=> $request->server('REMOTE_ADDR'),

            "method"=> $request->method(),
            "user_agent"=> $request->server('HTTP_USER_AGENT'),
            "request_body" => json_decode($request->getContent()),

            "response_body" => json_decode($response->getContent()),
            "response_status_code" => $response->status(),

            "request_at" => $captured_time[0],
            "response_at" => $captured_time[1],

            "duration_in_ms" => $duration
        ];

        $response = Http::withOptions([
            'cert'=> '../elastic/cert.pem',
            'ssl_key'=> '../elastic/cert.pem',
            'verify' => false
        ])->withBasicAuth($this->USERNAME, $this->PASSWORD)->post($this->HOST."/log_ealokasi_ipubers/_doc", $log);
    }

}