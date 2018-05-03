<label>
  <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
  <textarea <?php $this->link(); ?> rows="10" style="width: 98%;"><?php echo esc_textarea( $this->value() ); ?></textarea>
</label>
