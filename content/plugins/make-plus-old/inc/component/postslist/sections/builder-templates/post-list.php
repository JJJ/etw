<?php
/**
 * @package Make Plus
 */

ttfmake_load_section_header();

global $ttfmake_section_data, $ttfmake_is_js_template;
$section_name = ttfmake_get_section_name( $ttfmake_section_data, $ttfmake_is_js_template );
$data = MakePlus()->get_component( 'postslist' )->save_section( $ttfmake_section_data['data'] );

?>
	<div class="ttfmake-post-list-options-container">
		<div class="ttfmake-post-list-options-column column-1">
			<div class="ttfmake-type-select-wrapper">
				<h4><?php esc_html_e( 'Type', 'make-plus' ); ?></h4>
				<select id="<?php echo $section_name; ?>[type]" name="<?php echo $section_name; ?>[type]" class="ttfmp-posts-list-select-type">
					<?php foreach ( ttfmake_get_section_choices( 'type', 'post-list' ) as $value => $label ) : ?>
						<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, $data['type'] ); ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<div class="ttfmake-taxonomy-select-wrapper">
				<h4><?php esc_html_e( 'From', 'make-plus' ); ?></h4>
				<select id="<?php echo $section_name; ?>[taxonomy]" name="<?php echo $section_name; ?>[taxonomy]" class="ttfmp-posts-list-select-from">
					<?php echo MakePlus()->get_component( 'postslist' )->filter()->render_choice_list( $data['type'], $data['taxonomy'] ); ?>
				</select>
			</div>

			<h4 class="ttfmake-post-list-options-title">
				<?php esc_html_e( 'Keyword', 'make-plus' ); ?>
			</h4>
			<input placeholder="<?php esc_attr_e( 'e.g. coffee', 'make-plus' ); ?>" id="<?php echo $section_name; ?>[keyword]" class="code" type="text" name="<?php echo $section_name; ?>[keyword]" value="<?php echo esc_attr( $data['keyword'] ); ?>" />
		</div>

		<div class="ttfmake-post-list-options-column">
			<div class="ttfmake-sortby-select-wrapper">
				<h4><?php esc_html_e( 'Sort', 'make-plus' ); ?></h4>
				<select id="<?php echo $section_name; ?>[sortby]" name="<?php echo $section_name; ?>[sortby]">
					<?php foreach ( ttfmake_get_section_choices( 'sortby', 'post-list' ) as $value => $label ) : ?>
						<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, $data['sortby'] ); ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<h4 class="ttfmake-post-list-options-title">
				<?php esc_html_e( 'Number to show', 'make-plus' ); ?>
			</h4>
			<input id="<?php echo $section_name; ?>[count]" class="code" type="number" name="<?php echo $section_name; ?>[count]" value="<?php echo (int) $data['count']; ?>" />
			<p><?php echo wp_kses( __( 'To show all, set to <code>-1</code>.', 'make-plus' ), wp_kses_allowed_html() ); ?></p>
			<h4 class="ttfmake-post-list-options-title">
				<?php esc_html_e( 'Item offset', 'make-plus' ); ?>
			</h4>
			<input id="<?php echo $section_name; ?>[offset]" class="code" type="number" name="<?php echo $section_name; ?>[offset]" value="<?php echo (int) $data['offset']; ?>" />
		</div>

		<div class="ttfmake-post-list-options-column">
			<div class="ttfmake-columns-select-wrapper">
				<h4><?php esc_html_e( 'Columns', 'make-plus' ); ?></h4>
				<select id="<?php echo $section_name; ?>[columns]" name="<?php echo $section_name; ?>[columns]">
					<?php foreach ( ttfmake_get_section_choices( 'columns', 'post-list' ) as $value => $label ) : ?>
						<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, $data['columns'] ); ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<h4><?php esc_html_e( 'Elements', 'make-plus' ); ?></h4>

			<p>
				<input id="<?php echo $section_name; ?>[show-title]" type="checkbox" name="<?php echo $section_name; ?>[show-title]" value="1"<?php checked( absint( $data['show-title'] ) ); ?> />
				<label for="<?php echo $section_name; ?>[show-title]">
					<?php esc_html_e( 'Show title', 'make-plus' ); ?>
				</label>
			</p>
			<p>
				<input id="<?php echo $section_name; ?>[show-date]" type="checkbox" name="<?php echo $section_name; ?>[show-date]" value="1"<?php checked( absint( $data['show-date'] ) ); ?> />
				<label for="<?php echo $section_name; ?>[show-date]">
					<?php esc_html_e( 'Show date', 'make-plus' ); ?>
				</label>
			</p>
			<p>
				<input id="<?php echo $section_name; ?>[show-author]" type="checkbox" name="<?php echo $section_name; ?>[show-author]" value="1"<?php checked( absint( $data['show-author'] ) ); ?> />
				<label for="<?php echo $section_name; ?>[show-author]">
					<?php esc_html_e( 'Show author', 'make-plus' ); ?>
				</label>
			</p>
			<p class="show-taxonomy">
				<input id="<?php echo $section_name; ?>[show-categories]" type="checkbox" name="<?php echo $section_name; ?>[show-categories]" value="1"<?php checked( absint( $data['show-categories'] ) ); ?> />
				<label for="<?php echo $section_name; ?>[show-categories]">
					<?php esc_html_e( 'Show categories', 'make-plus' ); ?>
				</label>
			</p>
			<p class="show-taxonomy">
				<input id="<?php echo $section_name; ?>[show-tags]" type="checkbox" name="<?php echo $section_name; ?>[show-tags]" value="1"<?php checked( absint( $data['show-tags'] ) ); ?> />
				<label for="<?php echo $section_name; ?>[show-tags]">
					<?php esc_html_e( 'Show tags', 'make-plus' ); ?>
				</label>
			</p>
			<p>
				<input id="<?php echo $section_name; ?>[show-comments]" type="checkbox" name="<?php echo $section_name; ?>[show-comments]" value="1"<?php checked( absint( $data['show-comments'] ) ); ?> />
				<label for="<?php echo $section_name; ?>[show-comments]">
					<?php esc_html_e( 'Show comment count', 'make-plus' ); ?>
				</label>
			</p>
		</div>

		<div class="ttfmake-post-list-options-column">
			<div class="ttfmake-thumbnail-select-wrapper">
				<h4><?php esc_html_e( 'Show featured image', 'make-plus' ); ?></h4>
				<select id="<?php echo $section_name; ?>[thumbnail]" name="<?php echo $section_name; ?>[thumbnail]">
					<?php foreach ( ttfmake_get_section_choices( 'thumbnail', 'post-list' ) as $value => $label ) : ?>
						<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, $data['thumbnail'] ); ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="ttfmake-aspect-select-wrapper">
				<h4><?php esc_html_e( 'Image aspect ratio', 'make-plus' ); ?></h4>
				<select id="<?php echo $section_name; ?>[aspect]" name="<?php echo $section_name; ?>[aspect]">
					<?php foreach ( ttfmake_get_section_choices( 'aspect', 'post-list' ) as $value => $label ) : ?>
						<option value="<?php echo esc_attr( $value ); ?>"<?php selected( $value, $data['aspect'] ); ?>>
							<?php echo esc_html( $label ); ?>
						</option>
					<?php endforeach; ?>
				</select>
			</div>

			<h4><?php esc_html_e( 'Excerpt', 'make-plus' ); ?></h4>

			<p>
				<input id="<?php echo $section_name; ?>[show-excerpt]" type="checkbox" name="<?php echo $section_name; ?>[show-excerpt]" value="1"<?php checked( absint( $data['show-excerpt'] ) ); ?> />
				<label for="<?php echo $section_name; ?>[show-excerpt]">
					<?php esc_html_e( 'Show excerpt', 'make-plus' ); ?>
				</label>
			</p>

			<h4 class="ttfmake-post-list-options-title">
				<?php esc_html_e( 'Excerpt length (words)', 'make-plus' ); ?>
			</h4>
			<input id="<?php echo $section_name; ?>[excerpt-length]" class="code" type="number" name="<?php echo $section_name; ?>[excerpt-length]" value="<?php echo (int) $data['excerpt-length']; ?>" />
		</div>
	</div>

	<input type="hidden" class="ttfmake-section-state" name="<?php echo $section_name; ?>[state]" value="<?php if ( isset( $ttfmake_section_data['data']['state'] ) ) echo esc_attr( $ttfmake_section_data['data']['state'] ); else echo 'open'; ?>" />

<?php ttfmake_load_section_footer(); ?>