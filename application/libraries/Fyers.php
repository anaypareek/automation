<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Fyers {

    protected $CI;

    // Constructor: get CodeIgniter super object
    public function __construct() {
        $this->CI =& get_instance();
        $this->CI->load->database();
    }

    public function fetch_data() {
        $query = $this->CI->db->get('my_table'); // Assuming you're fetching from 'my_table'
        return $query->result();
    }

    public function get_price($symbol)
    {
    $auth_code = $this->auth_code();
  // SYMBOL -> STOCK OR OPTION NAME
  //
                  $curl = curl_init();

                  curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://api.fyers.in/data-rest/v2/quotes/?symbols='.$symbol,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(
                      'Authorization: CAQOD0H5N3-100:'.$auth_code
                    ),
                  ));

                  $response = curl_exec($curl);
                $r = json_decode($response);
                // foreach($response as $rr){
                // print_r($r);
                // exit;
                if($r->s=="error"){
                return "err";
                }
                // }
                // print_r($r->d);
                // exit;
                else{
                $r1=$r->d;
                $r2 = $r1[0];

                $r3=$r2->v;
                $r4=$r3->ask;

                return $r4;
                curl_close($curl);
                }

              }


              public function auth_code(){
                $this->CI->db->select('*');
                            $this->CI->db->from('tbl_config');
                            $this->CI->db->order_by('id','DESC');
                            $dsa= $this->CI->db->get();
                            $da=$dsa->row();
                            if(!empty($da)){
                          $auth = $da->auth_code;
                            }

            return $auth;


              }

}
