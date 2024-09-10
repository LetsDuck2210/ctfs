<?php
error_reporting(0);
class file {
        public $file = "dump.txt";
        public $data = "dump test";
        function __destruct(){
                file_put_contents($this->file, $this->data);
        }
}


$file_name = $_GET['file'];
if(isset($file_name) && !file_exists($file_name)){
        echo "File no Exist!";
}

if($file_name=="index.php"){
        $content = file_get_contents($file_name);
        $tags = array("", "");
        echo bin2hex(strrev(base64_encode(nl2br(str_replace($tags, "", $content)))));
}
unserialize(file_get_contents($file_name));
?>

<!DOCTYPE html>
    <head>
        <title>StuxCTF</title>
	<meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="assets/css/style.css" />
    </head>
        <body>
        <nav class="navbar navbar-default navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
              </button>
              <a class="navbar-brand" href="index.php">Home</a>
            </div>
          </div>
        </nav>
        <!-- hint: /?file= -->
        <div class="container">
            <div class="jumbotron">
				<center>
					<h1>Follow the white rabbit..</h1>
				</center>
            </div>
        </div>            
        <script src="assets/js/jquery-1.11.3.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
    </body>
</html>

