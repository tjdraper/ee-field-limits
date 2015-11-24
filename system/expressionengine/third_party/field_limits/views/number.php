<?php
/** @var int $content */
/** @var int $min */
/** @var int $max */
/** @var int $step */
/** @var string $field_name */
/** @var string $value */
/** @var bool $required */
/** @var bool $isGrid */
?>

<div class="field-limits-field">
	<input
		type="number"
		name="<?= $field_name ?>"
		value="<?= $value ?>"
		class="field-limits-field__input js-field-limits-input"
		<?php if ($min) { ?>
		min="<?= $min ?>"
		<?php } ?>
		<?php if ($max) { ?>
		max="<?= $max ?>"
		<?php } ?>
		<?php if ($content === 'num') { ?>
		step="any"
		<?php } elseif ($step) { ?>
		step="<?= $step ?>"
		<?php } ?>
		<?php if (! $isGrid and $required) { ?>
		required
		<?php } elseif ($required) { ?>
		data-grid-required="true"
		<?php } ?>
	>
</div>