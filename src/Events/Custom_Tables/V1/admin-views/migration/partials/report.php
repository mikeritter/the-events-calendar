<?php

use TEC\Events\Custom_Tables\V1\Migration\CSV_Report\File_Download;
use TEC\Events\Custom_Tables\V1\Migration\Reports\Event_Report;
use TEC\Events\Custom_Tables\V1\Migration\String_Dictionary;
use TEC\Events\Custom_Tables\V1\Migration\Reports\Site_Report;

/**
 * @var String_Dictionary $text               The text dictionary.
 * @var string            $datetime_heading   The heading for the date of completion.
 * @var Site_Report       $report             The site report data.
 * @var array<mixed>      $event_categories   A list of the event report data inside of each category.
 *
 */
?>
<div class="tec-ct1-upgrade__report">
	<header class="tec-ct1-upgrade__report-header">
		<div class="tec-ct1-upgrade__report-header-section tec-ct1-upgrade__report-header-section--timestamp">
			<?php echo $text->get( 'previewed-date-heading' ); ?>
			<strong><?php echo esc_html( $report->date_completed ); ?></strong>
		</div>
		<div class="tec-ct1-upgrade__report-header-section tec-ct1-upgrade__report-header-section--total">
			<?php echo $text->get( 'previewed-total-heading' ); ?>
			<strong><?php echo esc_html( $report->total_events ); ?></strong>
		</div>
		<?php $this->template( 'migration/partials/heading-action' ) ?>
	</header>
	<div class="tec-ct1-upgrade__report-body">
		<div class="tec-ct1-upgrade__report-body-content">
			<?php if ( ! $report->has_changes ) : ?>
				<p>
					<strong><?php echo esc_html( $text->get( 'migration-prompt-no-changes-to-events' ) ); ?></strong>
				</p>
			<?php endif; ?>
			<?php
			if ( $report->has_errors ) {
				$this->template( 'migration/partials/failure-event-loop' );
			} else {
				foreach ( $event_categories as $category ) {
					$this->template( 'migration/partials/event-loop', [
						'category' => $category,
					] );
				}
			}
			?>
		</div>
		<footer class="tec-ct1-upgrade__report-body-footer">
			<a href="http://evnt.is/recurrence-2-0-report" target="_blank"
			   rel="noopener"><?php echo esc_html( $text->get( 'migration-prompt-learn-about-report-button' ) ); ?></a>
			|
			<a href="<?php echo File_Download::get_download_url(); ?>"><?php echo $text->get( 'migration-download-report-button' ); ?></a>
		</footer>
	</div>
</div>
