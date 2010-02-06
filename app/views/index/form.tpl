<?xml version="1.0" ?>
<opt:root include="snippets.tpl">
{@formStyleTextValid is 'foo'}
{@formStyleTextInvalid is 'bar'}
<form zf:form-data="$form">
	<opt:section name="fields" datasource="$form.fields">
		<opt:component from="$fields.component" template="formField"></opt:component>
	</opt:section>

	<p><input type="submit" value="OK" /></p>
</form>
</opt:root>