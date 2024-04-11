<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="styles.css">
   <title>Chat - UAM</title>
</head>
<body>
   <div id="messages" class="messages">
      <?php include 'backend/load.php' ?>
      <!-- 
      <div class="message sent">
         <div class="metadata">
            <p class="autor">Autor</p>
            <p class="date">Date</p>
         </div>
         <div class="content">
            Lorem ipsum dolor sit amet consectetur adipisicing elit. A saepe numquam blanditiis eos eveniet quis iusto ex minima cum alias! Ducimus nobis vero quae voluptatem ipsam temporibus in doloribus adipisci?
         </div>
      </div> 
   -->
   </div>
   <form method="POST" action="backend/sent.php" > 
      <div class="write-message">
         <label for="username">Username: <input id="username" name="username" type="text"> </label>
         <textarea id="message-body" class="message-body" placeholder="255 chars max lenght" name="message-body" rows="5" minlength="1" maxlength="255"></textarea>
         <button class="button" id="button-send">Send</button>
      </div>
   </form>

   <script src="script.js"></script>

</body>
</html>