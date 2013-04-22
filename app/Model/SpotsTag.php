<?php

App::uses("AppModel", "Model");

class SpotsTag extends AppModel {
	
	public $name = "SpotsTag";
	
	public $useTable = "spots_tags";
	
	public $belongsTo = array(
		'Spot',
		'Tag' => array(
			'className'  => 'Tag',
			'foreignKey' => 'tag_id',
			'conditions' => '',
			'fields'     => '',
			'order'      => ''
		)
	);
	
}