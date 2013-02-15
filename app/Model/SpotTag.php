<?php

App::uses("AppModel", "Model");

class SpotTag extends AppModel {
	
	public $name = "SpotTag";
	
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