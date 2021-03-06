<?php
/**
* This file is part of the Checkbook NYC financial transparency software.
* 
* Copyright (C) 2012, 2013 New York City
* 
* This program is free software: you can redistribute it and/or modify
* it under the terms of the GNU Affero General Public License as
* published by the Free Software Foundation, either version 3 of the
* License, or (at your option) any later version.
* 
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU Affero General Public License for more details.
* 
* You should have received a copy of the GNU Affero General Public License
* along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
?>
<?php
$current_fy_year = _getFiscalYearID();
$current_cal_year = _getCalendarYearID();

$current_url = explode('/',$_SERVER['REQUEST_URI']);
$url = $current_url[1];
if($current_url[1] == 'contracts_landing' || $current_url[1] == 'contracts_revenue_landing' || $current_url[1] == 'contracts' ||
   $current_url[1] == 'contracts_pending_exp_landing' || $current_url[1] == 'contracts_pending_rev_landing'){

   $all_agency_url = $url = 'contracts_landing/status/A/yeartype/B/year/'.$current_fy_year;
}else if($current_url[1] == 'payroll'){
    $all_agency_url = $url = 'payroll/yeartype/B/year/'.$current_fy_year;
}else if($current_url[1] == 'budget'){
    $all_agency_url = $url = 'budget/yeartype/B/year/'.$current_fy_year;
}else if($current_url[1] == 'revenue'){
    $all_agency_url = $url = 'revenue/yeartype/B/year/'.$current_fy_year;
}else{
    $all_agency_url = $url = 'spending_landing/yeartype/B/year/'.$current_fy_year;
}


$selected_text = 'Citywide (All Agencies)';

foreach($node->data as $key => $value){
	if($value['agency_id'] == $agency_id_value){
		$selected_text = $value['agency_name'];
	}
}

$agencies = array_chunk($node->data, 10);

$agency_list = "<div id='agency-list'>";
$agency_list .= "<div class='agency-list-open'><span>$selected_text</span></div>";
$agency_list .= "<div class='agency-list-content'>";
$agency_list .= "<div class='listContainer1'>";

foreach($agencies as $key => $agencies_chunck){
    $agency_list .= ((($key+1)%2 == 0)? "" : "<div class='agency-slide'>");
    $agency_list .= "<ul class='listCol".($key+1)."'>";
    foreach($agencies_chunck as $a => $agency){
        $agency_url ="";
        $agency_url = ($current_url[1] == 'payroll')?'payroll/agency/'.$agency['agency_id'].'/yeartype/B/year/'.$current_fy_year
                                              : $url.'/agency/'.$agency['agency_id'];
        
        $agency_list .= "<li id=agency-list-id-".$agency['agency_id'].">
                            <a href='/".$agency_url. "'>".$agency['agency_name']."</a>
                        </li>";
    }
    $agency_list .= "</ul>";
    $agency_list .= (($key%2 == 1)? "</div>" : "");
}

$agency_list .= "</div>";
$agency_list .= "</div>";
$agency_list .= "<div class='agency-list-nav'><a href='#' id='prev'>Prev</a><a href='#' id='next'>Next</a>";
$agency_list .= "<a href='/".$all_agency_url."' id='citywide_all_agencies'>CITYWIDE ALL AGENCIES</a></div>";
$agency_list .= "<div class='agency-list-close'><a href='#'>x Close</a></div>";
$agency_list .= "</div></div>";
print $agency_list;
