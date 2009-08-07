<?xml version="1.0" ?>
<opt:root>
	<h1>Title helper</h1>
	<p>The title helper. <a parse:href="url('/helpers/index')">Back</a></p>

	<p>Example 1 - direct access to the helper.</p>
	<p>{$helper.title}</p>

	<p>Example 2 - OPT-controller access.</p>
	<p><opt:section name="title" str:separator=" / ">{$title}</opt:section></p>
</opt:root>