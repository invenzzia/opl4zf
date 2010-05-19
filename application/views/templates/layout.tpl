<?xml version="1.0" encoding="UTF-8" standalone="no"?>
<opt:root include="snippets.tpl" xmlns:opt="http://xml.invenzzia.org/opt">
<opt:prolog />
<opt:dtd template="xhtml10transitional" />
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

	<!-- use the helper for displaying titles -->
	<title>{$helper.title}</title>

	<!-- The HeadStyle helper provides a comprehensive management over CSS styles -->
	<opt:selector name="headStyle">
	

		<!-- standard style group -->
		<opt:standard>
			<link rel="stylesheet" href="/design/design.css" type="text/css" />
			<!--[if IE 6]>
			<link rel="stylesheet" href="/design/ie6.css" type="text/css" />
			<![endif]-->
		</opt:standard>

		<!-- style group for printing -->
		<opt:printable>
			<link rel="stylesheet" href="/design/print.css" type="text/css" />
		</opt:printable>

		<!-- for manually-defined CSS files -->
		<opt:file>
			<link rel="stylesheet" parse:href="$headStyle.file" type="text/css" />
		</opt:file>

		<!-- for manually-defined CSS styles -->
		<opt:style>
			<style>
				{u:$headStyle.style}
			</style>
		</opt:style>
	</opt:selector>
</head>
<body>
<div id="header">
	<h1>Zend Framework + OPL/OPT application</h1>
	<h3>A sample application written with Zend Framework and Open Power Template 2</h3>
</div>

<div id="content">
	<opt:section name="content">
		<opt:include from="content">
			<p>One of the view templates has not been found.</p>
		</opt:include>
	</opt:section>
</div>

<div id="footer">
	<p>Copyright &copy; <a href="http://www.invenzzia.org">Invenzzia Group</a> 2010</p>
	<p>Distributed under <a href="http://www.invenzzia.org/license/new-bsd">New BSD License</a></p>
</div>
</body>
</html>
</opt:root>
