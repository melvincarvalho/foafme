<?php
// Poor container for popup version of chat
?>
<html>
  <head>
    <title><?php elgg_echo("Chat") ?></title>
    <script type="text/javascript">
    <?php
    if (isloggedin()) {
      echo 'PFC_POPUP_WIN = true;';
    }
    ?>
    </script>
  </head>
  <body>
    <?php $chat->printChat(); ?>
  </body>
</html>
