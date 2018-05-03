<div class="tco-reset tco-wrap tco-wrap-about tco-alt-cs">
  <div class="tco-content">
    <div class="wrap"><h2>WordPress Wrap</h2></div>
    <div class="tco-main">

      <?php if ( ! $is_validated ) : ?>
      <div class="tco-row">
        <div class="tco-column">
        <?php do_action( '_cornerstone_home_not_validated' ); ?>
        </div>
      </div>
      <?php endif; ?>

      <div class="tco-row">
        <div class="tco-column">
          <?php
            include( $this->locate_view( 'admin/home-box-auto-updates' ) );
          ?>
        </div>
        <?php if ( ! apply_filters( '_cornerstone_integration_remove_support_box', false ) ) : ?>
        <div class="tco-column">
          <?php
            include( $this->locate_view( 'admin/home-box-support' ) );
          ?>
        </div>
      	<?php endif; ?>
      </div>

      <div class="tco-row">
        <div class="tco-column">
          <?php
            include( $this->locate_view( 'admin/home-box-templates' ) );
          ?>
        </div>
        <div class="tco-column tco-man"></div>
      </div>

    </div>
  </div>

  <?php include( $this->locate_view( 'admin/home-sidebar' ) ); ?>

</div>