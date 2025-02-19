<?php
/**
 * Frontend form.
 *
 * @package codereview
 */

use WideEye\CodeReview\API;

?>
<form id="palette-form">
	<h2>Create A New Palette</h2>
	<select name="model">
		<?php
		foreach ( API::$palette_options as $key => $value ) {
			echo '<option value="' .  $key . '">' . $value . '</option>';
		}
		?>
	</select>
	<button type="submit">Submit</button>
</form>
<div id="palette-results"></div>