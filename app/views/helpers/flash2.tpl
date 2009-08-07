<?xml version="1.0" ?>
<opt:root>
	<h1>FlashMessage helper</h1>
	<p>The FlashMessage helper. <a parse:href="url('/helpers/index')">Back</a></p>

	<p>If you accessed this page through a link in a menu, you should see a flash message below.
	Otherwise, you'll see nothing.</p>

	<p opt:if="$helper.flashMessage.hasMessage">{$helper.flashMessage.message}</p>
</opt:root>