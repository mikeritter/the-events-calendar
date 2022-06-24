<?php if ( 'migration-complete' === $phase && $state->should_allow_reverse_migration() ) : ?>
	<a
		href="#"
		class="tec-ct1-upgrade-revert-migration tec-ct1-upgrade__link-danger"
	>
		<?php echo esc_html( $text->get( 'reverse-migration-button' ) ); ?>
	</a>
<?php else : ?>
	<div class="tec-ct1-action-container tec-ct1-upgrade__report-header-section tec-ct1-upgrade__report-header-section--rerun">
		<em title="<?php esc_attr( $text->get( 're-run-preview-button' ) ) ?>">
			<?php $this->template( 'migration/icons/rerun' ); ?>
		</em>
		<a
			class="tec-ct1-upgrade-start-migration-preview"
			href="#"
		>
			<?php echo esc_html( $text->get( 're-run-preview-button' ) ); ?>
		</a>
	</div>
<?php endif; ?>

