<?php

/************************************************************
* GET DATABASE CONNECTION
*************************************************************/
require_once('database.php');

/************************************************************
* RETRIEVE ALL CAR MODELS AND CAR VERSIONS
*************************************************************/

$car_models = $mysqli->query('SELECT model FROM car_models');
$car_versions = $mysqli->query('SELECT version FROM versions');

?>
<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/calculator.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
<script type="text/javascript" src="js/js.js"></script>
</head>
<body>
<div id="header">
<img src="img/logo.png" id="logo"/>
<h1>Nissan PCP Calculator</h1>
</div>
	<div id="container">
        <form method="post">
            <div class="step_header">
            STEP 1
            </div>
            <div class="step_desc">Choose Car Model, Version and Mileage</div>
            <div class="field_select row clear" id="row-1">
                <div class="arrow"></div>
				<select name="model" class="">
					<?php
					// loop through car models and output with select option markup
						while($car_model = $car_models->fetch_assoc())
							echo '<option>' . $car_model['model'] . '</option>';
					?>
				</select>
			</div>
            <div class="field_select row clear" id="row-2">
                <div class="arrow"></div>
				<select name="version" class="">
					<?php 
					// loop through car versions and output with select option markup
						while($car_version = $car_versions->fetch_assoc())
							echo '<option>' . $car_version['version'] . '</option>';
					?>
				</select>
			</div>
            <div class="field_select row clear" id="row-3">
                <div class="arrow"></div>
				<select name="mileage" class="">
						<option>10000</option>
						<option>15000</option>
						<option>20000</option>
						<option>25000</option>
						<option>30000</option>
				</select>
            </div>
            <div class="buffer"></div>
            <div class="step_header">
            STEP 2
            </div>
            <div class="step_desc">Provide values for any options, accessories, discounts, and deposit</div>
            <div class="field_input row clear" id="options">
                <div class="euro">&euro;</div>
				<input name="options" class="input"/>
			</div>
			<div class="field_input row clear" id="accessories">
                <div class="euro">&euro;</div>
                <input name="accessories" class="input"/>
			</div>
            <div class="field_input row clear" id="discounts">
                <div class="euro">&euro;</div>
                <input name="discounts" class="input"/>
			</div>
			<div class="field_input row clear" id="deposit">
                <div class="euro">&euro;</div>
				<input name="deposit" class="input"/>
			</div>
            <div class="buffer"></div>
            <div class="step_header">
            STEP 3
            </div>
            <div class="step_desc">Choose the repayment term</div>
            <div class="field_select row clear" id="term-sel">
                <div class="arrow"></div>
				<select name="term" class="">
						<option>24</option>
						<option>36</option>
				</select>
			</div>
            <div class="buffer"></div>
			<input type="submit" id="submit" value="Calculate">
        </form>
        
        <div id="submit_container"><div id="submit">Calculate Quote</div></div>
        <div id="quote">
            <div id="quote_header">Your Quote</div>
            <div id="" class="quote_row">
                <div class="quote_label">Weekly Payment</div>
                <div class="quote_data" id="weekly_payment"></div>
            </div>
            <div id="" class="quote_row">
                <div class="quote_label">Monthly Payment</div>
                <div class="quote_data" id="monthly_payment"></div>
            </div>
        </div>   
 </div>
</body>
</html>
