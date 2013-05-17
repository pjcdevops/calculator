<?php
echo '<div class="form_container">';
	echo '<h2>Edit ' . Inflector::Singularize($desc) . '</h2>';
	echo $this->Form->create($model_name);
	echo $this->Form->inputs($form_fields, 
							 array('created', 
							 	   'modified', 
							 	   'updated',
							 	   'dt_added'
							 	   ), 
							 array('legend' => false));
	echo $this->Form->submit('Save', 
		  				  	  array('class' => 'btn btn-primary'));
	echo $this->Form->end(); 
echo '</div>';