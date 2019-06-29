<?php
/**
 * @author Eduardo Acevedo Farje.
 * @link www.eduardoaf.com
 * @version 1.0.0
 * @name TheFramework\Helpers\HelperJson
 * @date 29-06-2019 15:12 (SPAIN)
 * @file helper_json.php
 */
namespace TheFramework\Helpers;

class HelperJson 
{
    const CONTINUE = 100;  
    const SWITCHING_PROTOCOLS = 101;  
    const PROCESSING = 102;  

    const OK = 200;  
    const CREATED = 201;  
    const ACCEPTED = 202;  
    const NON_AUTHORITATIVE_INFORMATION = 203;  
    const NO_CONTENT = 204;  
    const RESET_CONTENT = 205;  
    const PARTIAL_CONTENT = 206;  
    const MULTI_STATUS = 207;  
    const ALREADY_REPORTED = 208;  
    const IM_USED = 226;  
    const MULTIPLE_CHOICES = 300;  
    const MOVED_PERMANENTLY = 301;  
    const FOUND = 302;  
    const SEE_OTHER = 303;  
    const NOT_MODIFIED = 304;  
    const USE_PROXY = 305;  
    const SWITCH_PROXY = 306;  
    const TEMPORARY_REDIRECT = 307;  
    const PERMANENT_REDIRECT = 308;  

    const BAD_REQUEST = 400;  
    const UNAUTHORIZED = 401;  
    const PAYMENT_REQUIRED = 402;  
    const FORBIDDEN = 403;  
    const NOT_FOUND = 404;  
    const METHOD_NOT_ALLOWED = 405;  
    const NOT_ACCEPTABLE = 406;  
    const PROXY_AUTHENTICATION_REQUIRED = 407;  
    const REQUEST_TIMEOUT = 408;  
    const CONFLICT = 409;  
    const GONE = 410;  
    const LENGTH_REQUIRED = 411;  
    const PRECONDITION_FAILED = 412;  
    const REQUEST_ENTITY_TOO_LARGE = 413;  
    const REQUEST_URI_TOO_LONG = 414;  
    const UNSUPPORTED_MEDIA_TYPE = 415;  
    const REQUESTED_RANGE_NOT_SATISFIABLE = 416;  
    const EXPECTATION_FAILED = 417;  
    const IM_A_TEAPOT = 418;  
    const AUTHENTICATION_TIMEOUT = 419;  
    const ENHANCE_YOUR_CALM = 420;  
    const METHOD_FAILURE = 420;  
    const UNPROCESSABLE_ENTITY = 422;  
    const LOCKED = 423;  
    const FAILED_DEPENDENCY = 424;  
    const UNORDERED_COLLECTION = 425;  
    const UPGRADE_REQUIRED = 426;  
    const PRECONDITION_REQUIRED = 428;  
    const TOO_MANY_REQUESTS = 429;  
    const REQUEST_HEADER_FIELDS_TOO_LARGE = 431;  
    const NO_RESPONSE = 444;  
    const RETRY_WITH = 449;  
    const BLOCKED_BY_WINDOWS_PARENTAL_CONTROLS = 450;  
    const REDIRECT = 451;  
    const UNAVAILABLE_FOR_LEGAL_REASONS = 451;  
    const REQUEST_HEADER_TOO_LARGE = 494;  
    const CERT_ERROR = 495;  
    const NO_CERT = 496;  
    const HTTP_TO_HTTPS = 497;  
    const CLIENT_CLOSED_REQUEST = 499; 

    const INTERNAL_SERVER_ERROR = 500;  
    const NOT_IMPLEMENTED = 501;  
    const BAD_GATEWAY = 502;  
    const SERVICE_UNAVAILABLE = 503;  
    const GATEWAY_TIMEOUT = 504;  
    const HTTP_VERSION_NOT_SUPPORTED = 505;  
    const VARIANT_ALSO_NEGOTIATES = 506;  
    const INSUFFICIENT_STORAGE = 507;  
    const LOOP_DETECTED = 508;  
    const BANDWIDTH_LIMIT_EXCEEDED = 509;  
    const NOT_EXTENDED = 510;  
    const NETWORK_AUTHENTICATION_REQUIRED = 511;  
    const NETWORK_READ_TIMEOUT_ERROR = 598;  
    const NETWORK_CONNECT_TIMEOUT_ERROR = 599;  

    private $arCodes;
    private $arResponse;

    public function __construct($arPayload=[])
    {
        //https://jsonapi.org/format/
        $this->arResponse["header"]["http"]["code"] = 200; 
        $this->arResponse["header"]["http"]["message"] = "200 ok"; //CODIGO MENSAJE
        //$this->arResponse["header"]["Allow"] = "GET, HEAD, OPTIONS";
        //$this->arResponse["header"]["Content-Type"] = "application/json";
        //$this->arResponse["header"]["Vary"] = "Accept";

        $this->arResponse["payload"]["status"] = 1;
        $this->arResponse["payload"]["message"] = "";
        $this->arResponse["payload"]["links"] = [];
        $this->arResponse["payload"]["errors"] = [];
        $this->arResponse["payload"]["data"] = $arPayload;
        $this->arResponse["payload"]["included"] = [];
        $this->load_codes();
        return $this;
    }
    
    public function show($isExit=0)
    {
        // clear the old headers
        header_remove();
        // set the actual code
        http_response_code($this->arResponse["header"]["http"]["code"]);
        // set the header to make sure cache is forced
        header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
        // treat this as json
        header('Content-Type: application/json');
        // ok, validation error, or failure
        header("Status: {$this->arResponse["header"]["http"]["message"]}");        

        $sJson = json_encode($this->arResponse["payload"]);
        echo $sJson;
        if($isExit) exit();
    }

    private function load_codes()
    {
        /**
         * Content from http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
         **/
        $this->arCodes = [
            100 => "Continue",
            101 => "Switching Protocols",
            102 => "Processing", // WebDAV; RFC 2518
            200 => "OK",
            201 => "Created",
            202 => "Accepted",
            203 => "Non-Authoritative Information", // since HTTP/1.1
            204 => "No Content",
            205 => "Reset Content",
            206 => "Partial Content",
            207 => "Multi-Status", // WebDAV; RFC 4918
            208 => "Already Reported", // WebDAV; RFC 5842
            226 => "IM Used", // RFC 3229
            300 => "Multiple Choices",
            301 => "Moved Permanently",
            302 => "Found",
            303 => "See Other", // since HTTP/1.1
            304 => "Not Modified",
            305 => "Use Proxy", // since HTTP/1.1
            306 => "Switch Proxy",
            307 => "Temporary Redirect", // since HTTP/1.1
            308 => "Permanent Redirect", // approved as experimental RFC
            400 => "Bad Request",
            401 => "Unauthorized",
            402 => "Payment Required",
            403 => "Forbidden",
            404 => "Not Found",
            405 => "Method Not Allowed",
            406 => "Not Acceptable",
            407 => "Proxy Authentication Required",
            408 => "Request Timeout",
            409 => "Conflict",
            410 => "Gone",
            411 => "Length Required",
            412 => "Precondition Failed",
            413 => "Request Entity Too Large",
            414 => "Request-URI Too Long",
            415 => "Unsupported Media Type",
            416 => "Requested Range Not Satisfiable",
            417 => "Expectation Failed",
            418 => "I\"m a teapot", // RFC 2324
            419 => "Authentication Timeout", // not in RFC 2616
            420 => "Enhance Your Calm", // Twitter
            420 => "Method Failure", // Spring Framework
            422 => "Unprocessable Entity", // WebDAV; RFC 4918
            423 => "Locked", // WebDAV; RFC 4918
            424 => "Failed Dependency", // WebDAV; RFC 4918
            424 => "Method Failure", // WebDAV)
            425 => "Unordered Collection", // Internet draft
            426 => "Upgrade Required", // RFC 2817
            428 => "Precondition Required", // RFC 6585
            429 => "Too Many Requests", // RFC 6585
            431 => "Request Header Fields Too Large", // RFC 6585
            444 => "No Response", // Nginx
            449 => "Retry With", // Microsoft
            450 => "Blocked by Windows Parental Controls", // Microsoft
            451 => "Redirect", // Microsoft
            451 => "Unavailable For Legal Reasons", // Internet draft
            494 => "Request Header Too Large", // Nginx
            495 => "Cert Error", // Nginx
            496 => "No Cert", // Nginx
            497 => "HTTP to HTTPS", // Nginx
            499 => "Client Closed Request", // Nginx
            500 => "Internal Server Error",
            501 => "Not Implemented",
            502 => "Bad Gateway",
            503 => "Service Unavailable",
            504 => "Gateway Timeout",
            505 => "HTTP Version Not Supported",
            506 => "Variant Also Negotiates", // RFC 2295
            507 => "Insufficient Storage", // WebDAV; RFC 4918
            508 => "Loop Detected", // WebDAV; RFC 5842
            509 => "Bandwidth Limit Exceeded", // Apache bw/limited extension
            510 => "Not Extended", // RFC 2774
            511 => "Network Authentication Required", // RFC 6585
            598 => "Network read timeout error", // Unknown
            599 => "Network connect timeout error", // Unknown
        ];        
    }
  
    //**********************************
    //             SETS
    //**********************************
    public function set_payload($arData)
    {
        $this->arResponse["payload"]["data"] = $arData;
        return $this;
    }

    public function set_links($arLinks)
    {
        $this->arResponse["payload"]["links"] = $arLinks;
        return $this;
    }

    public function set_error($arErrors)
    {
        $this->arResponse["payload"]["errors"] = $arErrors;
        return $this;
    }        

    public function set_code($iCode)
    {
        $this->arResponse["payload"]["status"] = (boolean)($iCode<300);        
        $this->arResponse["header"]["http"]["code"] = $iCode;
        $this->arResponse["header"]["http"]["message"] = "$iCode {$this->arCodes[$iCode]}";
        return $this;
    }

    public function set_message($sErrMessage)
    {
        $this->arResponse["payload"]["message"] = $sErrMessage?$sErrMessage:$this->arResponse["header"]["http"]["message"];
        return $this;        
    }

    //**********************************
    //             GETS
    //**********************************

}//HelperJson