 <div id="login_form">
	<fieldset>
		<legend>Admin Login</legend>
		
		<?php
		echo $this->Form->create('User');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->submit('Login', array('class' => 'btn btn-primary'));
		echo $this->Form->end();
		?>
	
	</fieldset>
</div>
