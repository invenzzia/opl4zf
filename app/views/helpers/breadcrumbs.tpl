<?xml version="1.0" ?>
<opt:root>
	<h1>BreadCrumbs helper</h1>
	<p>The breadcrumbs helper. <a parse:href="url('/helpers/index')">Back</a></p>

	<p>Example 1 - direct access to the helper.</p>
	<p>{u:$global.helper.breadcrumbs}</p>

	<p>Example 2 - OPT-controller access.</p>
	<p>
	<opt:selector name="breadcrumbs" str:separator=" / ">
		<opt:current>{$breadcrumbs.title}</opt:current>
		<opt:default><a parse:href="$breadcrumbs.url">{$breadcrumbs.title}</a></opt:default>
	</opt:selector>
	</p>
</opt:root>