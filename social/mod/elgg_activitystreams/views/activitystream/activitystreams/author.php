<?php
	$subject = $vars['entity'];
?>
                <author>
                  <activity:object-type>http://activitystrea.ms/schema/1.0/person</activity:object-type>
                  <id><?php echo htmlspecialchars($subject->getURL()); ?></id>
                  <name><?php echo $subject->title?$subject->title:$subject->name; ?></name>
                  <link rel="alternate" type="text/html" href="<?php echo htmlspecialchars($subject->getURL()); ?>" />
                  <link rel="preview" href="<?php echo htmlspecialchars($subject->getIcon('tiny')); ?>" />
                </author>
