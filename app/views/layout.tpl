<?xml version="1.0" ?>
<opt:root>
<opt:prolog />
<opt:dtd template="xhtml10transitional" />
<html>
	<head>
		<title>Sample Zend Framework application</title>

	</head>
	<body>
		<h1>Sample Zend Framework and Open Power Libs application</h1>

		<p>In the near future, this application will become much more practical,
		but for now it only tests, whether everything works.</p>

		<opt:show name="content">
		<div id="content">
			<h3>Content placeholder</h3>
			<opt:section>
				<opt:include from="content">
					<p>Sorry, no template was found!</p>
				</opt:include>
			</opt:section>
		</div>
		</opt:show>

		<opt:show name="secondary">
		<div id="secondary">
			<h3>Secondary placeholder</h3>
			<opt:section>
				<opt:include from="secondary">
					<p>Sorry, no template was found!</p>
				</opt:include>
			</opt:section>
		</div>
		</opt:show>
	</body>
</html>
</opt:root>