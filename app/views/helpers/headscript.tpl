<?xml version="1.0" ?>
<opt:root>
	<h1>HeadScript helper</h1>
	<p>The HeadScript helper. <a parse:href="url('/helpers/index')">Back</a></p>

	<p>Example 1 - direct access to the helper.</p>
	<p>{u:$global.helper.headscript}</p>

	<p>Example 2 - OPT-controller access.</p>
	<opt:selector name="script" datasource="$global.helper.headscript">
		<opt:standard>
			<p>Aliases a group of template-defined scripts with the name "standard".</p>
		</opt:standard>
		<opt:printable>
			<p>Aliases a group of template-defined scripts with the name "printable".</p>
		</opt:printable>
		<opt:file>
			<p>Links an action-defined file: {$script.file}</p>
		</opt:file>
		<opt:script>
			<p>Links an action-defined script: {$script.script}</p>
		</opt:script>
	</opt:selector>
</opt:root>