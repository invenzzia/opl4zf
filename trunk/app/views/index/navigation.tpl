<?xml version="1.0" ?>
<opt:root>
	<!-- breadcrumbs -->
	<p>
	<opt:selector name="breadcrumbs" str:separator=" / ">
		<opt:current>{$breadcrumbs.title}</opt:current>
		<opt:default><a parse:href="$breadcrumbs.url">{$breadcrumbs.title}</a></opt:default>
	</opt:selector>
	</p>

	<!-- menu -->
	<opt:tree name="menu">
		<opt:list><ul><opt:content /></ul></opt:list>
		<opt:node><li><a parse:href="$menu.url">{$menu.title}</a><opt:content /></li></opt:node>
	</opt:tree>

</opt:root>