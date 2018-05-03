<?php

/**
 * Mousetrap style keybindings (https://craig.is/killing/mice)
 * Can be modifed via this filter: cornerstone_keybindings
 *
 * For single keys, you can add a prefix to ensure a behavior
 * keypress:, keydown:, keyup:
 *
 * Be careful. Everything is bound as "Global" meaning it will take
 * effect even is a user is working in a textarea or text input.
 */

return array(
	'delete-confirm' => 'keydown:shift',
  'delete-release' => 'keyup:shift',
  'mod-key-press' => 'keydown:mod',
  'mod-key-release' => 'keyup:mod',
  'alt-key-press' => 'keydown:alt',
  'alt-key-release' => 'keyup:alt',
	'skeleton-mode'  => 'mod+k',
  'save'  => 'mod+s',
  'find'  => 'mod+f',
);
