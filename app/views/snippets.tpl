<?xml version="1.0" ?>
<opt:root>
	<opt:snippet name="formField">
		<p>{$opt.component.label}: <opt:display /></p>
		<opt:onEvent name="error">
			<p>Some errors occured:</p>
			<opt:section name="componentErrors" datasource="$componentErrors">
				<p>{$componentErrors}</p>
			</opt:section>
		</opt:onEvent>
	</opt:snippet>
</opt:root>