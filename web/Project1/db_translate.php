<?php
/**************************************************************
* DATABASE STATUS EVAULATION FUNCTIONS
* by Kyle West
*
* A set of functions to interpret the database status codes
**************************************************************/

/**************************************************************
* Evaluate a review's status code from the reviewer's POV
**************************************************************/
function evaluteReviewStatus($stat) {
	switch($stat) {
		case -9: return "Rejected Offer";
		case  1: return "Awaiting Response";
		case  2: return "Being Reviewed";
		case  3: return "Review Complete!";
	}
}

/**************************************************************
* Evaluate a review's status code from the owner's POV
**************************************************************/
function evaluteDeleteButtonTitleStatus($stat) {
	switch($stat) {
		case  3: // fall through
		case -9: return "Remove Review";
		case  1: return "Cancel Review";
	}
}

?>
