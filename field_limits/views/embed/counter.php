<?php
/** @var int $max_length */
/** @var string $value */
?>

<div class="field-limits-count<?php if ($isGrid) { ?> field-limits-count--grid<?php } ?> js-field-limits-count-wrap">
	<span class="js-field-limits-count"><?= strlen($value) ?></span>
	/
	<span class="js-field-limits-limit"><?= $max_length ?></span>
</div>
