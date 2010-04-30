<?php
	$url = full_url();
	$context = get_context();
        if (substr_count($url,'?')) {
                $url .= "&view=activitystream";
        } else {
                $url .= "?view=activitystream";
        }

	
?>
<link rel="alternate" type="application/atom+xml" title="Atom/Ostatus" href="<?php echo $url; ?>" />
