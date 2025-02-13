<?php
/**
 * Frontend form.
 *
 * @package codereview
 */

?>
<form id="palette-form">
	<h2>Create A New Palette</h2>
	<select name="model">
		<option value="default">Default</option>
		<option value="ui">UI</option>
		<option value="amelie_film">Graphic</option>
		<option value="nature_photography">Interior</option>
		<option value="kaguya_film">Fashion</option>
	</select>
	<button type="submit">Submit</button>
</form>
<div id="palette-results"></div>