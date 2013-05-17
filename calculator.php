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
<link rel="stylesheet" href="style.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js" ></script>
<script type="text/javascript" src="js.js"></script>
</head>
<body>
	<div id="container">
		<div id="calc-container" class="left">
		<form method="post">
		<div id="header">NISSAN PCP CALCULATOR</div>
			<div class="row-sel" id="row-1">
				<span class="label-select">MODEL</span>
				<select name="model" class="right">
					<?php
					// loop through car models and output with select option markup
						while($car_model = $car_models->fetch_assoc())
							echo '<option>' . $car_model['model'] . '</option>';
					?>
				</select>
			</div>
			<div class="row-sel" id="row-2">
				<span class="label-select">VERSION</span>
				<select name="version" class="right">
					<?php 
					// loop through car versions and output with select option markup
						while($car_version = $car_versions->fetch_assoc())
							echo '<option>' . $car_version['version'] . '</option>';
					?>
				</select>
			</div>
			<div class="row-sel" id="row-3">
				<span class="label-select">MILEAGE</span>
				<select name="mileage" class="right">
						<option>10000</option>
						<option>15000</option>
						<option>20000</option>
						<option>25000</option>
						<option>30000</option>
				</select>
			</div>
			<div class="row" id="price">
				<span class="label">PRICE</span>
				<span class="amount right"></span>
			</div>
			<div class="row" id="options">
			<div class="exclamation">!</div>
				<span class="label">OPTIONS</span>
				<input name="options" class="amount right"/>
			</div>
			<div class="row" id="accessories">
				<div class="exclamation">!</div>
				<span class="label">ACCESSORIES</span>
				<input name="accessories" class="amount right"/>
			</div>
			<div class="row" id="discounts">
			<div class="exclamation">!</div>
				<span class="label">DISCOUNTS</span>
				<input name="discounts" class="amount right"/>
			</div>
			<div class="row" id="new_price">
				<span class="label">NEW PRICE</span>
				<span class="amount right"></span>
			</div>
			<div class="row" id="deposit">
			<div class="exclamation">!</div>
				<span class="label">DEPOSIT</span>
				<input name="deposit" class="amount right"/>
			</div>
			<div class="row" id="finance_amount">
				<span class="label">FINANCE AMOUNT</span>
				<span class="amount right"></span>
			</div>
			<div class="row" id="term-sel">
				<span class="label">TERM</span>
				<select name="term" class="right">
						<option>24</option>
						<option>36</option>
				</select>
			</div>
			<div class="row" id="term">
				<span class="label">TERM</span>
				<span class="amount right"></span>
			</div>
			<div class="row" id="apr">
				<span class="label">APR</span>
				<span class="amount right"></span>
			</div>
			<div class="row" id="optional_final_payment">
				<span class="label">OPTIONAL FINAL PAYMENT</span>
				<span class="amount right"></span>
			</div>
			<div class="buffer-20"></div>
			<div class="row" id="monthly_payment">
				<span class="label">MONTHLY PAYMENT</span>
				<span class="amount right"></span>
			</div>
			<div class="row" id="weekly_payment">
				<span class="label">WEEKLY PAYMENT</span>
				<span class="amount right"></span>
			</div>
			<br/><br/>
			<input type="submit" id="submit" value="Calculate">
		</form>
		</div>
		<div id="model_image" class="left"></div>
	</div>
</body>
</html>