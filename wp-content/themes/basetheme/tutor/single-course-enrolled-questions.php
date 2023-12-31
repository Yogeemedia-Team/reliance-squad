<?php
/**
 * NOTE: This template is from the TutorLMS plugin. It is overridden in theme for better theme support of TutorLMS.
 * Template for displaying single course
 *
 * Edited by TheBase Theme, Original Author:
 * @author Themeum
 * @url https://themeum.com
 *
 * @package TutorLMS/Templates
 * @version 1.4.3
 */

get_header();

?>

<?php do_action( 'tutor_course/single/enrolled/before/wrap' ); ?>
	<div <?php tutor_post_class( 'tutor-question-answare-wrap tutor-page-wrap' ); ?>>
		<div class="tutor-container">
			<div class="tutor-row">
				<div class="tutor-col-8  tutor-col-md-100">
					<?php do_action( 'tutor_course/single/enrolled/before/inner-wrap' ); ?>
					<?php tutor_course_enrolled_lead_info(); ?>
					<?php tutor_course_enrolled_nav(); ?>
					<?php tutor_course_question_and_answer(); ?>
					<?php do_action( 'tutor_course/single/enrolled/after/inner-wrap' ); ?>
				</div>
				<div class="tutor-col-4">
					<div class="tutor-single-course-sidebar">
						<?php do_action( 'tutor_course/single/enrolled/before/sidebar' ); ?>
						<?php tutor_course_enroll_box(); ?>
						<?php tutor_course_requirements_html(); ?>
						<?php tutor_course_tags_html(); ?>
						<?php tutor_course_target_audience_html(); ?>
						<?php do_action( 'tutor_course/single/enrolled/after/sidebar' ); ?>
					</div>
				</div>
			</div>
		</div>
	</div><!-- .wrap -->

<?php
do_action( 'tutor_course/single/enrolled/after/wrap' );
get_footer();
