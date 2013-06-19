<!DOCTYPE html>
<html lang="">
<head>
	<meta charset="utf-8">
	<title>Twitter JS</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<meta name="robots" content="" />
	<link href="twcss.css" media="all" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<script src="jquery-1.7.1.min.js"></script>
	<script src="twjs.js"></script>
	<script>
		function reloadTweets()
		{
			var us = $('#twtuser').val();
			user = us;
			$('#twtbox_body').html('');
			twtjs_loadTweets(us);
		}
	</script>
</head>
<body>
<div style="width:285px; margin:0 auto; padding:10px 20px">
<input name="twtuser" id="twtuser" value="f0vela"><input type="button" value="Cargar" onclick="reloadTweets();"/>
</div>
<div id="twtbox">
	<div id="twtbox_head">
	<div id="twtbox_head_name">Tweets</div>
	<div id="twtbox_head_subname">Mis Tweets</div>
	</div>
	<div id="twtbox_body"></div>
	<div id="twtbox_footer"></div>
</div>

</body>
</html>