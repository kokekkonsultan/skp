<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Breadcrumb class
 *
 * DESCRIPTION : Class to show breadcrumb navigation
 *
 * MODIFICATION HISTORY
 * V1.0 2009-07-03 04:05 PM - Ibnu Daqiqil Id   - Created
 *  2009-07-03 02:32 PM     - Ibnu Daqiqil id - change html element to display using <ul>
 *
 * @package    Markeet
 * @author     Ibnu Daqiqil Id
 *
 **/
 
class Breadcrumb
{
 protected $data = array();
 
 /**
  * Class Constructor
  *
  * @return void
  * @author Ibnu Daqiqil Id
  **/
 function __construct() 
 {
 
 }
 
    /**
  * add new crumb element
  *
  * @param  string $title The crumb title
  * @param  string $uri Crumb url path 
  * @return void
  * @author Ibnu Daqiqil Id
  **/
 
 public function add($title, $uri='') 
 {
  $this->data[] = array('title'=>$title, 'uri'=>$uri);
  return $this;
 }
 
 /**
  * Fetch crumb data
  *
  * @return void
  * @author Ibnu Daqiqil Id
  **/
 
 public function fetch() 
 {
  return $this->data;
 }
 
 /**
  * Reset crumb data
  *
  * @return void
  * @author Ibnu Daqiqil Id
  **/
 public function reset() 
 {
  $this->data = array();
 }
 
 
 /**
  * Dislpay all crumb element
  *
  * @param  string $home_site first path title
  * @param  string $id id of ul html
  * @return void
  * @author Ibnu Daqiqil Id
  **/
 public function show($home_site ="Home", $id = "crumbs", $sep=""  ) 
 {
  $ci = &get_instance();
  $site = $home_site;
  $breadcrumbs = $this->data;
  $out  = '<ul id="'.$id.'" class="breadcrumb breadcrumb-transparent breadcrumb-dot font-weight-bold p-0 my-2 font-size-sm">';
  if ($breadcrumbs && count($breadcrumbs) > 0) {
   $out .= '<li class="breadcrumb-item text-muted"><a href="' . base_url() .'dashboard" class="text-muted"/>'. $site . '</a></li>';
   $i=1;
   foreach ($breadcrumbs as $crumb): 
 
    if ($i != count($breadcrumbs)) {
     $out .= $sep . '<li class="breadcrumb-item text-muted"><a href="' .site_url($crumb['uri']). '" class="text-muted">'. $crumb['title'] .'</a></li>';
    } else {
     $out .= $sep . '<li class="breadcrumb-item text-muted selected">'. $crumb['title'] .'</li>';
    }
    $i++;
   endforeach;
  } else {
   $out .= '<li class="selected">' . $site . '</li>';
  }
  $out .= '</ul>';
  return $out; 
 }
 
}
 
// END  Breadcrumb class
 
/* End of file Breacrumb.php */
/* Location: /Applications/XAMPP/xamppfiles/htdocs/multishop/application/library/Breadcrumb.php  */
