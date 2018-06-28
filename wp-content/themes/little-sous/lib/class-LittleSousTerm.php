<?php

class LittleSousTerm extends TimberTerm {

	function icon() {
		return LittleSous::icon_match($this->name) ?? false;
	}


}