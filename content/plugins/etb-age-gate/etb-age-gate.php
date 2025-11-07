<?php
/**
 * Plugin Name: ETB - Simple Age Gate
 * Description: Sitewide "Are you 21 or older?" modal.
 * Version:     1.1.0
 * Author:      JJJ
 */

if ( ! defined( 'ABSPATH' ) ) exit;

final class Simple_Age_Gate {
	/** @var self|null */
	private static $instance = null;

	/** Singleton */
	public static function instance(): self {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/** Bootstrap */
	private function __construct() {
		add_action( 'wp_head',  [ $this, 'output_head_css' ], 5 );
		add_action( 'wp_footer',[ $this, 'output_footer_markup_script' ], 100 );
		add_shortcode( 'age_gate_trigger', [ $this, 'shortcode_trigger' ] );
	}

	/** Config — override via filters */
	private function cookie_name(): string {
		return (string) apply_filters( 'sag_cookie_name', 'age_gate_ok' );
	}
	private function cookie_days(): int {
		return (int) apply_filters( 'sag_cookie_days', 30 );
	}
	private function min_age(): int {
		return (int) apply_filters( 'sag_min_age', 21 );
	}
	private function deny_url(): string {
		$url = apply_filters( 'sag_deny_url', home_url( '/' ) );
		return esc_url( $url );
	}

	/** Should we render the gate this request? */
	private function should_render(): bool {

		// No admin or AJAX
		if ( is_admin() || wp_doing_ajax() ) {
			return false;
		}

		// Cookie already accepted
		$cookie = $this->cookie_name();
		if ( isset( $_COOKIE[ $cookie ] ) && '1' === $_COOKIE[ $cookie ] ) {
			return false;
		}

		// Skip for logged-in users
		if ( is_user_logged_in() ) {
			return false;
		}

		// Only for these 2 pages
		if ( is_page( 'our-drink-menu' ) || is_page( 'our-cocktail-menu' ) ) {
			return true;
		}

		return false;
	}

	/** Minimal, non-conflicting styles */
	public function output_head_css(): void {
		if ( ! $this->should_render() ) {
			return;
		}
		?>
		<style id="sag-styles">
			#sag-overlay { position: fixed; inset: 0; display: none; align-items: center; justify-content: center;
				background: rgba(0,0,0,.75); z-index: 2147483647; }
			#sag-overlay.sag-open { display: flex; }
			#sag-modal { max-width: 32rem; width: 92%; background: #111; color: #fff; border-radius: 12px;
				box-shadow: 0 10px 30px rgba(0,0,0,.6); padding: 1.5rem; font: 16px/1.5 system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif; }
			#sag-modal h2 { margin: 0 0 .75rem; font-size: 1.5rem; font-family: initial; color: #fff; }
			#sag-modal p { margin: 0 0 1rem; opacity: .9; }
			#sag-actions { display: grid; grid-template-columns: 1fr 1fr; gap: .75rem; margin-top: 1rem; }
			.sag-btn { appearance: none; border: 0; padding: .75rem 1rem; border-radius: 10px; cursor: pointer; font-weight: 600; }
			.sag-yes { background: #22c55e; color: #051b0b; }
			.sag-no  { background: #e11d48; color: #fff; }
			@media (prefers-reduced-motion:no-preference) {
				#sag-modal { transform: translateY(6px); opacity: .98; transition: transform .18s ease-out, opacity .18s ease-out; }
				#sag-overlay.sag-open #sag-modal { transform: translateY(0); opacity: 1; }
			}
			body.sag-locked { overflow: hidden !important; }
		</style>
		<?php
	}

	/** Modal markup + JS */
	public function output_footer_markup_script(): void {
		if ( ! $this->should_render() ) {
			return;
		}

		$cookie  = esc_js( $this->cookie_name() );
		$maxAge  = $this->cookie_days() * DAY_IN_SECONDS;
		$minAge  = (int) $this->min_age();
		$denyUrl = $this->deny_url();
		?>
		<div id="sag-overlay" role="dialog" aria-modal="true" aria-labelledby="sag-title" aria-describedby="sag-desc">
			<div id="sag-modal">
				<h2 id="sag-title">Are you <?php echo (int) $minAge; ?> or older?</h2>
				<p id="sag-desc">You must be at least <?php echo (int) $minAge; ?> to enter this site.</p>
				<div style="display:flex;align-items:center;gap:.5rem;margin:.5rem 0;">
					<label style="display:flex;gap:.5rem;align-items:center;">
						<input id="sag-remember" type="checkbox" checked aria-label="Remember my choice for <?php echo (int) $this->cookie_days(); ?> days">
						Remember for <?php echo (int) $this->cookie_days(); ?> days
					</label>
				</div>
				<div id="sag-actions">
					<button type="button" class="sag-btn sag-yes" id="sag-yes" autofocus>Yes, let me in</button>
					<button type="button" class="sag-btn sag-no" id="sag-no">No</button>
				</div>
			</div>
		</div>
		<script>
		(function(){
			var overlay  = document.getElementById('sag-overlay');
			var yesBtn   = document.getElementById('sag-yes');
			var noBtn    = document.getElementById('sag-no');
			var remember = document.getElementById('sag-remember');
			var COOKIE   = '<?php echo $cookie; ?>';
			var MAXAGE   = <?php echo (int) $maxAge; ?>;
			var DENY     = '<?php echo $denyUrl; ?>';

			function setCookie(name, value, maxAge) {
				document.cookie = name + '=' + value + '; path=/; max-age=' + maxAge + '; SameSite=Lax';
			}
			function getCookie(name) {
				return document.cookie.split('; ').find(function(r){ return r.startsWith(name+'='); })?.split('=')[1];
			}
			function openGate() {
				overlay.classList.add('sag-open'); document.body.classList.add('sag-locked');
				overlay.addEventListener('keydown', function(e){
					if (e.key === 'Tab') { e.preventDefault(); (document.activeElement===yesBtn?noBtn:yesBtn).focus(); }
				});
				yesBtn.focus();
			}
			function closeGate() {
				overlay.classList.remove('sag-open'); document.body.classList.remove('sag-locked');
			}
			function verifyAndEnter() {
				if (remember && remember.checked) {
					try { localStorage.setItem(COOKIE, '1'); } catch(e) {}
					setCookie(COOKIE, '1', MAXAGE);
				}
				closeGate();
			}
			function deny() {
				window.location.href = DENY;
			}

			// Defense-in-depth: skip if already verified (in case PHP didn't see cookie)
			try { if (localStorage.getItem(COOKIE)==='1' || getCookie(COOKIE)==='1') return; } catch(e) {}
			openGate();
			yesBtn.addEventListener('click', verifyAndEnter);
			noBtn.addEventListener('click', deny);

			// Public API
			window.SAG = {
				reset: function(){
					try { localStorage.removeItem(COOKIE); } catch(e) {}
					setCookie(COOKIE, '', -1);
					openGate();
				},
				open: openGate,
				close: closeGate
			};
		})();
		</script>
		<?php
	}

	/** Shortcode: [age_gate_trigger]Re-verify age[/age_gate_trigger] */
	public function shortcode_trigger( $atts, $content = null ): string {
		$label = $content ?: 'Re-verify age';
		return '<a href="#" onclick="if(window.SAG){SAG.reset();} return false;">' . esc_html( $label ) . '</a>';
	}
}

// Kick it off.
add_action( 'plugins_loaded', [ Simple_Age_Gate::class, 'instance' ] );
