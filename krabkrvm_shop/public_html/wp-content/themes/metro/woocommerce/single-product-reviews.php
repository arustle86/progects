<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 4.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="rdtheme-wc-reviews" class="rdtheme-wc-reviews">
	<div id="comments">
		<?php if ( have_comments() ) : ?>

			<ol class="commentlist">
				<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
			</ol>

			<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
				echo '<nav class="woocommerce-pagination">';
				paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
					'prev_text' => '&larr;',
					'next_text' => '&rarr;',
					'type'      => 'list',
				) ) );
				echo '</nav>';
			endif; ?>

		<?php else : ?>

			<p class="woocommerce-noreviews"><?php esc_html_e( 'Отзывов пока нет', 'metro' ); ?></p>

		<?php endif; ?>
	</div>

	<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

		<?php
			$commenter = wp_get_current_commenter();

			$comment_form = array(
				'title_reply'          => have_comments() ? esc_html__( 'Добавить отзыв', 'metro' ) : sprintf( esc_html__( 'Будьте первым, кто оставит отзыв &ldquo;%s&rdquo;', 'metro' ), get_the_title() ),
				'title_reply_to'       => esc_html__( 'Оставить комментарий к %s', 'metro' ),
				'title_reply_before'   => '<h3 id="reply-title" class="comment-reply-title">',
				'title_reply_after'    => '</h3>',
				'comment_notes_after'  => '',
				'fields'               => array(
					'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Имя', 'metro' ) . '&nbsp;<span class="required">*</span></label> ' .
								'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" required /></p>',
					'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'metro' ) . '&nbsp;<span class="required">*</span></label> ' .
								'<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" required /></p>',
				),
				'label_submit'  => esc_html__( 'Разместить', 'metro' ),
				'logged_in_as'  => '',
				'comment_field' => '',
			);

			if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
				$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( __( 'You must be <a href="%s">logged in</a> to post a review.', 'metro' ), esc_url( $account_page_url ) ) . '</p>';
			}

			if ( wc_review_ratings_enabled() ) {
				$comment_form['comment_field'] = '<div class="comment-form-rating"><label for="rating">' . esc_html__( 'Ваша оценка', 'metro' ) . '</label><select name="rating" id="rating" required>
					<option value="">' . esc_html__( 'Rate&hellip;', 'metro' ) . '</option>
					<option value="5">' . esc_html__( 'Perfect', 'metro' ) . '</option>
					<option value="4">' . esc_html__( 'Good', 'metro' ) . '</option>
					<option value="3">' . esc_html__( 'Average', 'metro' ) . '</option>
					<option value="2">' . esc_html__( 'Not that bad', 'metro' ) . '</option>
					<option value="1">' . esc_html__( 'Very poor', 'metro' ) . '</option>
				</select></div>';
			}

			$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your review', 'metro' ) . '&nbsp;<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" required></textarea></p>';

			comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
		?>

	<?php else : ?>

		<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'metro' ); ?></p>

	<?php endif; ?>

	<div class="clear"></div>
</div>
