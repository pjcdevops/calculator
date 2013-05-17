<?
/*****************************************************************************
* HELPER FUNCTIONS
*****************************************************************************/
function getFieldHeadings($array){
	
	if(is_array($array))
	return array_keys($array[0][key(reset($array))]);
	
}

/****************************************************************************
* RESULTS TABLE
*****************************************************************************/

$fieldHeadings = getFieldHeadings($data);

echo '<div id="sub_menu">';
echo '<h3>Calculator Options</h3>';
echo '<ul class="nav nav-tabs nav-stacked">';
echo '<li>' . $this->Html->link('View Car Models', 
								array('action' => 'index', 2), 
								array('escape' => false)) . '</li>';
echo '<li>' . $this->Html->link('View Car Versions', 
								array('action' => 'index', 1), 
								array('escape' => false)) . '</li>';
echo '<li>' . $this->Html->link('View Rv Percentages',  
								array('action' => 'index', 3), 
								array('escape' => false)) . '</li>';
echo '</ul>';

echo '<ul class="nav nav-tabs nav-stacked">';
echo '<li>' . $this->Html->link('Add Car Model', 
								array('action' => 'add', 2), 
								array('escape' => false)) . '</li>';
echo '<li>' . $this->Html->link('Add Car Version', 
								array('action' => 'add', 1), 
								array('escape' => false)) . '</li>';
echo '<li>' . $this->Html->link('Add Rv Percentage',  
								array('action' => 'add', 3), 
								array('escape' => false)) . '</li>';
echo '</ul>';
echo '</div>';



echo '<div id="table_container">';
	echo '<h2>' . $desc . '</h2>';
	echo '<table class="table table-condensed table-bordered table-striped">';
	echo '<thead>';
	echo '<tr>';

	foreach($fieldHeadings as $fieldHeading){
		
		echo '<th>' . $fieldHeading .  '</th>';

	}
	echo '<th><span class="label label-inverse">Actions</span></th>';

	echo '</tr>';
	echo '</thead>';
	echo '<tbody>';

	// loop through data to get table
	foreach($data as $table){
		// loop table rows
		foreach($table as $row){
			$id = $row['id'];
			echo '<tr>';
			//loop through row values
			foreach($row as $entry){
				echo '<td>' . $entry . '</td>';
			}
			/* ACTION LINKS HERE */
			echo '<td>'.$this->Html->link('Edit', 
											array('action' => 'edit', $model, $id), 
											array('class' => 'btn btn-mini admin_button'));
			echo $this->Html->link('Delete', 
											array('action' => 'delete', $model, $id), 
											array('class' => 'btn btn-mini btn-danger admin_button'), 
											"Are you sure you wish to delete this entry?") .'</td>';
			echo '</tr>';	
		}
	}
	echo '</tbody>';
	echo '</table>';


/*********************************************************************
* PAGINATION
**********************************************************************/

	// make sure paginator includes url paramters in the paginated link
	$this->Paginator->options(array('url' => $this->passedArgs));

	// pagination counters
	echo '<div class="admin-pagination-count">';
		echo $this->Paginator->counter(
		    'Page {:page} of {:pages}, showing {:current} records out of
		     {:count} total, starting on record {:start}, ending on {:end}'
		);
	echo '</div>';
	// pagination
	echo '<div class="pagination"><ul>';
	 echo $this->Paginator->prev(
	 
	 ' << ' . __('prev'), 
	 array('tag' => 'li'), 
	 null, 
	 array('class' => 'disabled', 'tag' => 'li', 'disabledTag' => 'a')

	 );

	echo $this->Paginator->numbers(

	array(
		'tag' => 'li', 
		'separator' => FALSE, 
		'currentTag' => 'a', 
		'currentClass' => 'disabled', 
		'first' => 'first', 
		'last' => 'last', 
		'previous' => 'previous', 
		'next' => 'next')

	);

	echo $this->Paginator->next(

	__('next') . ' >> ', 
	array('tag' => 'li'), 
	null, 
	array(
		'class' => 'disabled', 
		'tag' => 'li', 
		'disabledTag' => 'a')

	);
	echo '</ul></div>';
echo '</div>';