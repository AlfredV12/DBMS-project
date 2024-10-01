<!DOCTYPE html>
<html>

<head>
  <title>Layout Example</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      background: #eaeaea; /* Set the default background color for the remaining 70% */
      font-family: Arial, sans-serif;
    }

    img {
      width: 300px;
      height: 200px;
      display: block;
      margin: auto;
    }

    .content-section {
      float: right;
      width: 100%;
      height: 40px;
      padding: 20px; /* Add some padding for content */
      box-sizing: border-box; /* Include padding in the width calculation */
      background-color: #ffffff; /* Set the background color for the content section */
    }
  </style>
</head>

<body>
  <div class="content-section">
    <h1>Your Content Goes Here</h1>
    <img src="./images/test.jpg" alt="error message">
    <p>This is the content area with a different background color.</p>
  </div>

</body>

</html>
