<?php
/**
 * About This Version administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once __DIR__ . '/admin.php';

/* translators: Page title of the About WordPress page in the admin. */
$title = _x( 'About', 'page title' );

list( $display_version ) = explode( '-', get_bloginfo( 'version' ) );

require_once ABSPATH . 'wp-admin/admin-header.php';
?>
	<div class="wrap about__container">

		<div class="about__header">
			<div class="about__header-image">
				<img alt="<?php _e( 'Code is Poetry' ); ?>" src="images/about-badge.svg" />
			</div>

			<div class="about__header-title">
				<p>
					<?php _e( 'WordPress' ); ?>
					<?php echo $display_version; ?>
				</p>
			</div>

			<div class="about__header-text">
				<?php _e( 'Jazz up your stories in an editor that’s cleaner, crisper, and does more to get out of your way.' ); ?>
			</div>

			<nav class="about__header-navigation nav-tab-wrapper wp-clearfix" aria-label="<?php esc_attr_e( 'Secondary menu' ); ?>">
				<a href="about.php" class="nav-tab nav-tab-active" aria-current="page"><?php _e( 'What&#8217;s New' ); ?></a>
				<a href="credits.php" class="nav-tab"><?php _e( 'Credits' ); ?></a>
				<a href="freedoms.php" class="nav-tab"><?php _e( 'Freedoms' ); ?></a>
				<a href="privacy.php" class="nav-tab"><?php _e( 'Privacy' ); ?></a>
			</nav>
		</div>

		<div class="about__section is-feature has-subtle-background-color">
			<div class="column">
				<h1 class="is-smaller-heading">
					<?php
					printf(
						/* translators: %s: The current WordPress version number. */
						__( 'Step into WordPress %s.' ),
						$display_version
					);
					?>
				</h1>
				<p>
					<?php
					printf(
						/* translators: %s: The current WordPress version number. */
						__( 'With this new version, the editor cleans up the colors and helps you work in a few places you couldn’t before—at least, not without getting into code or hiring a pro. The controls you use most, like changing type sizes, are in more places—right where you need them. And layout changes that should be simple, like full-height images, get even simpler to make.' ),
						$display_version
					);
					?>
				</p>
			</div>
		</div>

		<hr class="is-large" />

		<div class="about__section has-2-columns">
			<h2 class="is-section-header is-smaller-heading">
				<?php _e( 'Now the editor is easier to use' ); ?>
			</h2>
			<div class="column">
				<p>
					<?php
					_e( '<strong>Font-size adjustment in more places:</strong> now, font-size controls are right where you need them in the List and Code blocks. No more trekking to another screen to make that single change!' );
					?>
				</p>
				<p>
					<?php
					_e( '<strong>Reusable blocks:</strong> several enhancements make reusable blocks more stable and easier to use. And now they save automatically with the post when you click the Update button.' );
					?>
				</p>
				<p>
					<?php
					_e( '<strong>Inserter drag-and-drop:</strong> drag blocks and block patterns from the inserter right into your post.' );
					?>
				</p>
			</div>
			<div class="column about__image">
				<video controls>
					<source src="https://make.wordpress.org/core/files/2021/02/about-57-drag-drop-image.mp4" type="video/mp4" />
				</video>
			</div>
		</div>

		<div class="about__section has-2-columns">
			<h2 class="is-section-header is-smaller-heading">
				<?php _e( 'You can do more without writing custom code' ); ?>
			</h2>
			<div class="column">
				<p>
					<?php
					_e( '<strong>Full-height alignment:</strong> have you ever wanted to make a block, like the Cover block, fill the whole window? Now you can.' );
					?>
				</p>
				<p>
					<?php
					_e( '<strong>Buttons block:</strong> now you can align the content in buttons vertically. And you can set the width of a button to a preset percentage.' );
					?>
				</p>
				<p>
					<?php
					_e( '<strong>Social Icons block:</strong> you can now change the size of the icons in the Social Icons block.' );
					?>
				</p>
			</div>
			<div class="column about__image">
				<img src="https://make.wordpress.org/core/files/2021/02/about-57-cover-1.jpg" alt="" />
			</div>
		</div>

		<hr />

		<div class="about__section has-subtle-background-color">
			<div class="column">
				<h2 class="is-smaller-heading"><?php _e( 'A Simpler Default Color Palette' ); ?></h2>
			</div>
		</div>

		<div class="about__section has-subtle-background-color">
			<div class="column about__image">
				<div class="about__image-comparison">
					<div class="about__image-comparison-resize">
						<img src="https://make.wordpress.org/core/files/2021/02/about-57-color-new.png" />
					</div>
					<img src="https://make.wordpress.org/core/files/2021/02/about-57-color-old.png" />
				</div>
			</div>
		</div>

		<div class="about__section has-2-columns has-subtle-background-color">
			<div class="column">
				<p>
					<?php
					printf(
						/* translators: %s: WCAG information link. */
						__( 'This new streamlined color palette collapses all the colors that used to be in the WordPress source code down to seven core colors and a range of 56 shades that meet the <a href="%s">WCAG 2.0 AA recommended contrast ratio</a> against white or black.' ),
						'https://www.w3.org/WAI/WCAG2AAA-Conformance'
					);
					?>
				</p>
				<p>
					<?php
					_e( 'The colors are perceptually uniform from light to dark in each range, which means they start at white and get darker by the same amount with each step.' );
					?>
				</p>
			</div>
			<div class="column">
				<p>
					<?php
					_e( 'Half the range has a 4.5 or higher contrast ratio against black, and the other half maintains the same contrast against white.' );
					?>
				</p>
				<p>
					<?php
					printf(
						/* translators: %s: Color palette dev note link. */
						__( 'Find the new palette in the default WordPress Dashboard color scheme, and use it when you’re building themes, plugins, or any other components. For all the details, <a href="%s">check out the Color Palette dev note</a>.' ),
						'https://make.wordpress.org/core/2021/02/23/standardization-of-wp-admin-colors-in-wordpress-5-7'
					);
					?>
				</p>
			</div>
		</div>

		<div class="about__section has-subtle-background-color">
			<div class="column about__image">
				<picture>
					<source media="(max-width: 600px)" srcset="images/about-color-palette-vert.svg" />
					<img alt="" src="images/about-color-palette.svg" />
				</picture>
			</div>
		</div>

		<hr />

		<div class="about__section has-2-columns">
			<div class="column">
				<h3><?php _e( 'From HTTP to HTTPS in a single click' ); ?></h3>
				<p><?php _e( 'Starting now, switching a site from HTTP to HTTPS is a one-click move. WordPress will automatically update database URLs when you make the switch. No more hunting and guessing!' ); ?></p>
				<h3><?php _e( 'New Robots API' ); ?></h3>
				<p>
					<?php
					_e( 'The new Robots API lets you include the filter directives in the robots meta tag, and the API includes the directive <code>max-image-preview: large</code> by default. That means search engines can show bigger image previews (unless the blog is marked as not public), which can boost your traffic.' )
					?>
				</p>
			</div>
			<div class="column">
				<h3><?php _e( 'Ongoing cleanup after update to jQuery 3.5.1' ); ?></h3>
				<p><?php _e( 'For years jQuery helped make things move on the screen in ways the basic tools couldn’t—but that keeps changing, and so does jQuery.' ); ?></p>
				<p><?php _e( 'One side effect: it generated a set of cryptic messages on the dashboard that informed only developers. In 5.7, you will get far fewer of those messages, and they will be in plain language.' ); ?></p>
				<h3><?php _e( 'Lazy-load your iframes' ); ?></h3>
				<p><?php _e( 'Now it’s simple to let iframes lazy-load. Just add the <code>loading="lazy"</code> attribute to iframe tags on the front end.' ); ?></p>
			</div>
		</div>

		<hr class="is-small" />

		<div class="about__section">
			<div class="column">
				<h3><?php _e( 'Check the Field Guide for more!' ); ?></h3>
				<p>
					<?php
					printf(
						/* translators: %s: WordPress 5.7 Field Guide link. */
						__( 'Check out the latest version of the WordPress Field Guide. It highlights developer notes for each change you may want to be aware of. <a href="%s">WordPress 5.7 Field Guide.</a>' ),
						'https://make.wordpress.org/core/2021/02/23/wordpress-5-7-field-guide'
					);
					?>
				</p>
			</div>
		</div>

		<hr />

		<div class="return-to-dashboard">
			<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
				<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
					<?php is_multisite() ? _e( 'Go to Updates' ) : _e( 'Go to Dashboard &rarr; Updates' ); ?>
				</a> |
			<?php endif; ?>
			<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? _e( 'Go to Dashboard &rarr; Home' ) : _e( 'Go to Dashboard' ); ?></a>
		</div>
	</div>
<?php

require_once ABSPATH . 'wp-admin/admin-footer.php';

// These are strings we may use to describe maintenance/security releases, where we aim for no new strings.
return;

__( 'Maintenance Release' );
__( 'Maintenance Releases' );

__( 'Security Release' );
__( 'Security Releases' );

__( 'Maintenance and Security Release' );
__( 'Maintenance and Security Releases' );

/* translators: %s: WordPress version number. */
__( '<strong>Version %s</strong> addressed one security issue.' );
/* translators: %s: WordPress version number. */
__( '<strong>Version %s</strong> addressed some security issues.' );

/* translators: 1: WordPress version number, 2: Plural number of bugs. */
_n_noop(
	'<strong>Version %1$s</strong> addressed %2$s bug.',
	'<strong>Version %1$s</strong> addressed %2$s bugs.'
);

/* translators: 1: WordPress version number, 2: Plural number of bugs. Singular security issue. */
_n_noop(
	'<strong>Version %1$s</strong> addressed a security issue and fixed %2$s bug.',
	'<strong>Version %1$s</strong> addressed a security issue and fixed %2$s bugs.'
);

/* translators: 1: WordPress version number, 2: Plural number of bugs. More than one security issue. */
_n_noop(
	'<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bug.',
	'<strong>Version %1$s</strong> addressed some security issues and fixed %2$s bugs.'
);

/* translators: %s: Documentation URL. */
__( 'For more information, see <a href="%s">the release notes</a>.' );
