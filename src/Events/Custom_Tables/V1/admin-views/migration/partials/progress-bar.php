<?php

use TEC\Events\Custom_Tables\V1\Migration\Reports\Site_Report;
use TEC\Events\Custom_Tables\V1\Migration\State;
use TEC\Events\Custom_Tables\V1\Migration\String_Dictionary;

/**
 * @var Site_Report       $report Our migration site report.
 * @var string            $phase  The current migration phase.
 * @var String_Dictionary $text   The text dictionary.
 */

$in_progress_phases = [
	State::PHASE_MIGRATION_FAILURE_IN_PROGRESS,
	State::PHASE_PREVIEW_IN_PROGRESS,
	State::PHASE_MIGRATION_IN_PROGRESS,
];

if ( ! in_array( $phase, $in_progress_phases, true ) ) {
	?>
	<div class="tec-ct1-upgrade-update-bar-container">
		<p><?php echo esc_html( $text->get( 'loading-message' ) ); ?></p>
	</div>
	<?php
	return;
}

$report                 = Site_Report::build();
$remaining_events       = $report->total_events_remaining;
$total_previewed_events = $report->total_events_migrated;
$progress               = $report->progress_percent;
$percent                = "$progress%";
if ( $phase === State::PHASE_PREVIEW_IN_PROGRESS ) {
	$progress_text  = sprintf(
		$text->get( 'preview-progress-bar-events-done' ),
		'<strong>',
		$total_previewed_events,
		'</strong>'
	);
	$remaining_text = sprintf(
		$text->get( 'preview-progress-bar-events-remaining' ),
		'<strong>',
		$remaining_events,
		'</strong>'
	);
} else {
	$progress_text  = sprintf(
		$text->get( 'migration-progress-bar-events-done' ),
		'<strong>',
		$total_previewed_events,
		'</strong>'
	);
	$remaining_text = sprintf(
		$text->get( 'migration-progress-bar-events-remaining' ),
		'<strong>',
		$remaining_events,
		'</strong>'
	);
}
?>
<div class="tec-ct1-upgrade-update-bar-container">
	<div class="tribe-update-bar">
		<div class="progress" title="<?php echo esc_attr( $percent ); ?>">
			<div class="bar" style="width: <?php echo esc_attr( $progress ); ?>%"></div>
		</div>
		<div class="tribe-update-bar__summary">
			<div class="tribe-update-bar__summary-progress-text">
				<?php echo $progress_text; ?>
			</div>
			<div class="tribe-update-bar__summary-remaining-text">
				<?php echo $remaining_text; ?>
			</div>
		</div>
	</div>
</div>