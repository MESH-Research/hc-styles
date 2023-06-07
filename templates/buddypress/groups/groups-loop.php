<?php
/**
 * BuddyPress - Groups Loop
 *
 * @since 3.0.0
 * @version 7.0.0
 */

bp_nouveau_before_loop(); ?>

<?php if ( bp_get_current_group_directory_type() ) : ?>
	<p class="current-group-type"><?php bp_current_group_directory_type_message(); ?></p>
<?php endif; ?>

<?php if ( bp_has_groups( bp_ajax_querystring( 'groups' ) ) ) : ?>

	<?php bp_nouveau_pagination( 'top' ); ?>

	<ul id="groups-list" class="<?php bp_nouveau_loop_classes(); ?>">

		<?php while ( bp_groups() ) : bp_the_group(); ?>

			<li <?php bp_group_class(); ?>>
			<div class="item-avatar">
				<?php /* <a href="<?php bp_group_permalink(); ?>">  */?>
					<?php bp_group_avatar( 'type=full&width=70&height=70' ); ?>
				<?php /* </a>  */?>
			</div>

			<div class="item">
				<div class="item-title"><a href="<?php bp_group_permalink(); ?>"><?php bp_group_name(); ?></a></div>
				<div class="item-meta"><div class="mobile"><?php bp_group_type(); ?></div><span class="activity"><?php printf( __( 'active %s', 'boss' ), bp_get_group_last_active() ); ?></span></div>

				<div class="item-desc"><?php bp_group_description_excerpt(); ?></div>

                <div class="item-meta">

                    <?php
                    global $groups_template;
                    if ( isset( $groups_template->group->total_member_count ) ) {
                         $count = (int) $groups_template->group->total_member_count;
                    } else {
                         $count = 0;
                    }

                    $html = sprintf( _n( '<span class="meta-wrap"><span class="count">%1s</span> <span>member</span></span>', '<a href="' . bp_get_group_all_members_permalink() . '"<span class="meta-wrap"><span class="count">%1s</span> <span>members</span></span></a>', $count, 'boss' ), $count );

                    ?>

                    <span class="desktop"><?php bp_group_type(); ?>&nbsp; / </span><?php  echo $html; ?>

                </div>

				<?php do_action( 'bp_directory_groups_item' ); ?>

			</div>

			<div class="action">

                <div class="action-wrap">

                    <?php do_action( 'bp_directory_groups_actions' ); ?>
				</div>

			</div>

			<div class="clear"></div>
		</li>

		<?php endwhile; ?>

	</ul>

	<?php bp_nouveau_pagination( 'bottom' ); ?>

<?php else : ?>

	<?php bp_nouveau_user_feedback( 'groups-loop-none' ); ?>

<?php endif; ?>

<?php
bp_nouveau_after_loop();

