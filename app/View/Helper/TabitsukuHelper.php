<?php
App::uses('AppHelper', 'View/Helper');
App::import("Model", "Category");;

class TabitsukuHelper extends AppHelper {
	
	public $helpers = array('Form', 'Html');
	
	public $uses = array("Category");
	
	public function input_category($category = array(), $options = array()) {
		$Category = new Category;
		$category_list = $Category->find("list",
				array(
					"conditions" => array(
						"parent_id" => "",
						"status"    => 1
					)
				));
		$html = '<ul class="categories">';
		for($i = 0; $i < 3; $i++) {
			$html .= '<li class="category'.($i+1).'">';
			if (isset($category[$i])) {
				$html .= '<a href="#add" class="mouse_over category_add" style="display:none;"><img src="'.$this->Html->url("/img/user/spot/addbtn.gif").'" alt="カテゴリを追加" /></a>';
				$html .= '<input type="hidden" name="category[]" value="'.$category[$i]["path"].'" class="maincategory" />';
				$html .= '<p class="selectedCategory">';
				$html .= '<a href="#close" class="close mouse_over"><img src="'.$this->Html->url("/img/common/search/close.gif").'" alt="CLOSE" /></a>'.implode(" : ", $category[$i]["info"]).'</p>';
			} else {
				$html .= '<a href="#add" class="mouse_over category_add"><img src="'.$this->Html->url("/img/user/spot/addbtn.gif").'" alt="カテゴリを追加" /></a>';
			}
			$html .= '</li>';
		}
		$html .= '</ul>';
		$html .= '<div class="categoryselect">';
		$html .= '<ul>';
		foreach ($category_list as $key => $val) {
			$html .= '<li data-category-id="'.$key.'"><a href="">'.$val.'</a></li>';
		}
		$html .= '</ul>';
		$html .= '<select name="subcategory_input" class="text" readonly="readonly"></select>';
		$html .= '<p class="close"><a href="#close" class="mouse_over"><img src="'.$this->Html->url("/img/common/search/close.png").'" alt="CLSOE" /></a></p>';
		$html .= '<p class="add"><a href="#add" class="mouse_over"><img src="'.$this->Html->url("/img/common/icon/add.gif").'" alt="追加" /></a></p>';
		$html .= '<p class="tri">&nbsp;</p>';
		$html .= '</div>';
		$html .= '<!-- //categoryselect -->';
		return $html;
	}
}