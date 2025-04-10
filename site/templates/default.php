<?php if (option('site.maintenance') === true): ?>
  <!DOCTYPE html>
  <html lang="de">
  <head>
    <meta charset="UTF-8">
    <title>In Bearbeitung</title>
    <style>
      body {
        font-family: sans-serif;
        background: #f2f2f2;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
      }
      .message {
        text-align: center;
      }
    </style>
  </head>
  <body>
    <div class="message">
      <h1>Website in Bearbeitung</h1>
      <p>Bitte schau später nochmal vorbei.</p>
    </div>
  </body>
  </html>
  <?php return; ?>
<?php endif ?>
