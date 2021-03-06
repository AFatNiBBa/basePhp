
<?php
	$out = ob::func(function() use($page, $_ARGS) {
		if (preg_match("~^/?private~", $page) || !@assemble($page, $_ARGS, true)[0])
			assemble("../error", [ "code" => 404 ]);
	})();

	if (!($_MSG["template"] ?? true))
	{
		echo $out;
		return;
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<base href="/">
		<title> ????? - <?= @htmlspecialchars(ucfirst(end(explode("/", $page ? $page : "main")))) ?> </title>
		<link rel="icon" href="utils/res/logo.png">
		<meta charset="UTF-8">

		<!-- Librerie Lato Client -->
		<?php assemble("includes", [".html"]) ?>
	</head>
	<body>
		<?php if ($_MSG["header"] ?? true) assemble("header") ?>
		<div id="root">
			<?= $out ?>
		</div>
		<?php if ($_MSG["footer"] ?? true) assemble("footer") ?>
	</body>
</html>