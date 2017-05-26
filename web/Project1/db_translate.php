<?php
function evaluteReviewStatus($stat) {
	switch($stat) {
		case -9: return "Rejected Offer";
		case  1: return "Awaiting Response";
		case  2: return "Being Reviewed";
		case  3: return "Review Complete!";
	}
}

function evaluteDeleteButtonTitleStatus($stat) {
	switch($stat) {
		case  3:
		case -9:
			return "Remove Review";

		case  1: return "Cancel Review";
	}
}

?>
