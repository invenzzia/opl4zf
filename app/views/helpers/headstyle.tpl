<?xml version="1.0" ?>
<opt:root>
	<h1>HeadStyle helper</h1>
	<p>The HeadStyle helper. <a parse:href="url('/helpers/index')">Back</a></p>

	<p>Example 1 - direct access to the helper.</p>
	<p>{u:$global.helper.headstyle}</p>

	<p>Example 2 - OPT-controller access.</p>
	<opt:selector name="style" datasource="$global.helper.headstyle">
		<opt:standard>
			<p>Aliases a group of template-defined styles with the name "standard".</p>
		</opt:standard>
		<opt:printable>
			<p>Aliases a group of template-defined styles with the name "printable".</p>
		</opt:printable>
		<opt:file>
			<p>Links an action-defined file: {$style.file}</p>
		</opt:file>
		<opt:style>
			<p>Links an action-defined style: {$style.style}</p>
		</opt:style>
	</opt:selector>
</opt:root>