 <div id="login_form">
	<fieldset>
		<legend>Create User</legend>
		
		<?php
		echo $this->Form->create('User');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $this->Form->submit('Register', array('class' => 'btn btn-primary'));
		echo $this->Form->end();
		?>
	
	</fieldset>
</div>