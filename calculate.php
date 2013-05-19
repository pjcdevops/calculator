<?php
/*******************************************************************
**********************  S E T   U P  *******************************
********************************************************************/

/******************************
INCLUDE PHPExcel for calc engine
*******************************/

require_once 'classes/PHPExcel.php';

/******************************
INCLUDE DB CONNECTION SCRIPT 
******************************/

require_once('database.php');

/*****************************
HELPER FUNCTIONS FOR DB ACCESS 
******************************/

/**
* get_car_price() get price of car based on version
* @param db_connection $db_connection
* @param string $car_version
* @return int
*/
function get_car_price($db_connection, $car_version){

	$res = $db_connection->query( "SELECT price FROM versions WHERE version="."'".$car_version."'");
	if(!$res)
		return false;
	
	$return = $res->fetch_assoc();
	return $return['price'];
}
// test
//echo(get_car_price($mysqli, 'JUKE 1.6 SV CVT'));


/**
* get_nominal_rate() get nominal rate of car based on car model
* @param db_connection $db_connection
* @param string $car_model
* @return float
*/
function get_nominal_rate($db_connection, $car_model){

	$res = $db_connection->query( "SELECT nominal_rate FROM car_models WHERE model="."'".$car_model."'");
	if(!$res)
		return false;
	
	$return = $res->fetch_assoc();
	return $return['nominal_rate'];
}
//test
//echo(get_nominal_rate($mysqli, 'Micra'));

/**
* get_rv_percent() get rv percent of selection based on car version, mileage and term
* @param db_connection $db_connection
* @param string $search_key
* @return float
*/
function get_rv_percent($db_connection, $search_key){

	$res = $db_connection->query( "SELECT rv_percent FROM rv_percentages WHERE search_key="."'".$search_key."'");
	if(!$res)
		return false;
	
	$return = $res->fetch_assoc();
	return $return['rv_percent'];
}
//test
//echo(get_rv_percent($mysqli, "102410000"));

/**
* get_version_num() gets the associated number with a car version
* @param db_connection $db_connection
* @param int $version
* @return int
*/
function get_version_num($db_connection, $version){

	$res = $db_connection->query( "SELECT id FROM versions WHERE version="."'".$version."'");
	if(!$res)
		return false;
	
	$return = $res->fetch_assoc();
	return $return['id'];
}

/**************************************
END OF HELPER FUNCTIONS FOR DB ACCESS
**************************************/

/*************************************
HELPER FUNCTIONS FOR CALCULATING 
**************************************/

/**
* get_new_price() get price of car taking in to account 
* optional extras, accessories, discounts and the original car price
* @param float $opt
* @param float $asc
* @param float $disc
* @param int $price
* @return float
*/
function get_new_price($opt, $asc, $disc, $price){
	
	return $opt + $asc - $disc + $price;
}

/**
* get_finance_amount() gets finance amount of car based on new price and 
* any deposit amount 
* @param float $the_deposit
* @param float $the_new_price
* @return float
*/
function  get_finance_amount($the_deposit, $the_new_price){
	
	return $the_new_price - $the_deposit;
}

/**
* get_optional_final_payment() gets optional final payment
* @param float $car_price
* @param float $rv_percent
* @return float
*/
function get_optional_final_payment($car_price, $rv_percent){

	return $car_price * $rv_percent;
}

/**
* get_monthly_payment() gets montly payment using PVT and PMT excel functions
* executed with help from PHPExcel calculation engine
* @param float $apr
* @param float $optional_final_payment
* @param int $term
* @param float $finance_amount 
* @return float
*/

function get_monthly_payment($apr, $optional_final_payment, $term, $finance_amount, $test){
	//arguments to PVT excel function
	$pvt_arg1 = $apr / 12;
	$pvt_arg2 = 1;
	$pvt_arg3 = - $optional_final_payment;
	$formula = '=PV(' . $pvt_arg1 . ',' . $pvt_arg2 . ',' . $pvt_arg3 . ')';
	
	//arguments to PMT excel function
	$pmt_arg1 = $apr / 12;
	$pmt_arg2 = $term;
	$pmt_arg3 = - $finance_amount;
	$pmt_arg4 = PHPExcel_Calculation::getInstance()->calculateFormula($formula);
    
	$formula = '=PMT(' . $pmt_arg1 . ',' . $pmt_arg2 . ',' . $pmt_arg3 . ',' .  $pmt_arg4 . ')';

	return round(PHPExcel_Calculation::getInstance()->calculateFormula($formula), 2);
}

/**
* get_weekly_payment() gets weekly payment based on montly payment
* @param float $montly_payment
* @return float
*/
function get_weekly_payment($monthly_payment){

	$weekly_payment = ($monthly_payment * (12 / 52));
	return number_format($weekly_payment, 2, '.', '');
}

/****************************************
END OF HELPER FUNCTIONS FOR CALCULATING 
*****************************************/

/*******************************************************************
************** E N D   O F   S E T   U P  **************************
********************************************************************/

/*******************************************************************
***********   A J A X   R E Q U E S T   H A N D L I N G   **********
********************************************************************/

/*****************************************
GET DATA POSTED IN AJAX REQUEST
*****************************************/

$model = $_POST["model"];
$version = $_POST["version"];
$mileage = $_POST["mileage"];
$term = $_POST["term"];
$options = $_POST["options"];
$accessories = $_POST["accessories"];
$discount = $_POST["discounts"];
$deposit = $_POST["deposit"];

/***************************************
CALCULATE OUTPUT
***************************************/
// get car price
$car_price = get_car_price($mysqli, $version);
// get new price (takes into account accessorites, options and any discount)
$new_price = get_new_price($options, $accessories, $discount, $car_price);
// get finance amount
$finance_amount = get_finance_amount($deposit, $new_price);
// get the apr
$apr = get_nominal_rate($mysqli, $model);
// get the car version's associated number (used to build rv_percentage search key)
$version_num = get_version_num($mysqli, $version);
// build search key and obtain the rv percentage
$rv_key =  $version_num . "" . $term . $mileage;
$rv_percent = get_rv_percent($mysqli, $rv_key);
//get optional final payment
$optional_final_payment = get_optional_final_payment($car_price, $rv_percent);
//calculate the monthly and weekly payments
$monthly = get_monthly_payment($apr, $optional_final_payment, $term, $finance_amount);
$weekly = get_weekly_payment($monthly);

/***************************************
ENCODE RESULTS TO JSON AND SEND BACK
****************************************/

$result = array();
$result['monthly'] = $monthly;
$result['weekly'] = $weekly;
$result['price'] =  number_format($car_price);
$result['new_price'] = number_format($new_price);
$result['finance_amount'] = number_format($finance_amount);
$result['term'] = $term;
$result['apr'] = $apr;
$result['optional_final_payment'] = number_format($optional_final_payment);


echo json_encode($result);

/*$test = array();
$test['rv_key'] = $rv_key;
$test['rv_percent'] = $rv_percent;
$test['apr'] = $apr;
$test['pv_args'] = array($apr / 12, 1, -$optional_final_payment);
$test['pmt_args'] = array($apr /12, $term, - $finance_amount);


//echo json_encode($test);
