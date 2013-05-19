$(document).ready(function(){

	$("form").submit(function(e){
		
		$.ajax({
			type: 'POST',
			url: 'calculate.php',
			data : $('form').serialize()
			
		}).done(function(data){
			
			console.log(data);

			obj = $.parseJSON(data);
/*			$('#price .amount').empty().append(obj.price);
			$('#new_price .amount').empty().append(obj.new_price);
			$('#finance_amount .amount').empty().append(obj.finance_amount);
			$('#term .amount').empty().append(obj.term);
			$('#apr .amount').empty().append(obj.apr);
			$('#optional_final_payment .amount').empty().append(obj.optional_final_payment);
			$('#weekly_payment .amount').empty().append("&euro;" + obj.weekly);
			$('#monthly_payment .amount').empty().append("&euro;" + obj.monthly);
		*/
            $('#weekly_payment').html("&euro;" +  obj.weekly);
            $('#monthly_payment').html("&euro;" + obj.monthly)
            $('#quote').css('display', 'block');

            $('html body').animate({
              scrollTop : $('#quote').offset().top 
              }, 500);
			
		});
		
		return false;
		
	});
	
});
