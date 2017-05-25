<?php
function evaluteReviewStatus($stat) {
	switch($stat) {
		case -9: return "Rejected Offer";
		case  1: return "Awaiting Response";
		case  2: return "Being Reviewed";
		case  3: return "Review Complete!";
	}
}

?>
