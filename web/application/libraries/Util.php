<?php 
/**
 * Util Library for everything
 * All the functions are tested, please look at the unit_test to see how to use 
 * this class.
 **/
class Util 
{
   var $CI;

   function __construct()
   {
      $this->CI =& get_instance();

      //Load library
      $this->CI->load->library('eventful');
      $this->CI->load->library('location');
   }

   //Using this http://ipinfodb.com/my_ip_location.php
   //For location api
   public function getLocation()
   {
      $geoloc = $this->CI->location->getLocation();

      //validate city name
      $special_string = '/(\=|\+|\-|\(|\))/';

      // If city could not be guessed, then we default into Los Angeles
      if(empty($geoloc['longitude']) 
         || empty($geoloc['latitude'])
         || (preg_match($special_string, $geoloc['zipCode']) != 0)) {
         $geoloc['zipCode'] = 'Los Angeles';
         $geoloc['latitude'] = "34.05223420";
         $geoloc['longitude'] = "-118.24368490";
      }
      return $geoloc;
   }

   public function getEvents($filter)
   {
      return $this->CI->eventful->getEvents($filter);
   }

   public function getCategories()
   {
      return $this->CI->eventful->getCategories();
   }

   public function event_filter($events, $fields) 
   {
      if (empty($fields)) {
        return "Error: Second argument - fileds, cannot be empty";
      }

      $filtered_events = array();
      foreach ($events as $key => $value) {
         $tmp = array();
         foreach ($fields as $v) {
            $tmp[$v] = utf8_encode(preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-:]/s', '', $value[$v]));
         }
         $filtered_events []= $tmp;
      }
      return json_encode($filtered_events);
   }

   public function getPublicUrl()
   {
      //Load helper
      $this->CI->load->helper('url');
      $splitary = preg_split('/web/i', base_url());
      return $splitary[0] . 'web/';
   }
   
   //Return key words that found in events.
   public function search_keywords($events, $keywords=false) {
      if (!$keywords) {
         $keywords = array('free', 'food');
      }
      $is_existed  = array();
   
      //Find if the key word existed
      foreach ($keywords as $kw) {
         foreach ($events as $e) {
            $words = str_word_count($e['description'], 1);
            foreach ($words as $w) {
               if ($w === $kw) {
                  $is_existed[] = $kw;
                  break;
               }
            }
         }
      }
   
      //Return all the found keywords
      return $is_existed;
   }
}
