<?php
/** @var int $max_length */
/** @var string $field_name */
/** @var string $value */
/** @var bool $required */
/** @var bool $isGrid */
?>

<div
	class="field-limits-field<?php if ($max_length) { ?> js-field-limits-limited<?php } ?>"
	<?php if ($max_length) { ?>
		data-limit="<?= $max_length ?>"
	<?php } ?>
>
	<input
		type="text"
		name="<?= $field_name ?>"
		value="<?= htmlentities($value) ?>"
		<?php if ($max_length) { ?>
			maxlength="<?= $max_length ?>"
		<?php } ?>
		class="field-limits-field__input<?php if (! $isGrid) { ?> field-limits-field__input--standard<?php } ?> js-field-limits-input"
		<?php if ($isGrid and $required) { ?>
			data-grid-required="true"
		<?php } elseif ($required) { ?>
			required
		<?php } ?>
	>
	<?php if ($max_length) { ?>
		<?= ee()->load->view('embed/counter') ?>
	<?php } ?>
</div>
