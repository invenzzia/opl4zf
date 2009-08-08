<?xml version="1.0" ?>
<opt:root>
	<h1>NavigationTree helper</h1>
	<p>The NavigationTree helper. <a parse:href="url('/helpers/index')">Back</a></p>

	<p>Example - OPT-controller access.</p>
	<opt:tree name="navigationTree">
		<opt:list><ul><opt:content /></ul></opt:list>
		<opt:node><li><a parse:href="$navigationTree.attr.href">{$navigationTree.label}</a><opt:content /></li></opt:node>
	</opt:tree>
</opt:root>