<?php

/**
 * Can be modifed via this filter: cornerstone_keybindings
 *
 * For single keys, you can add a prefix to ensure a behavior
 * keydown:
 * keyup:
 *
 * Be careful. Everything is bound as "Global" meaning it will take
 * effect even is a user is working in a textarea or text input.
 */

return array(
  'advanced-mode'  => 'mod+shift+a',
  'toggle-collapse' => 'mod+shift+e',
  'duplicate' => 'mod+d',
  'delete' => 'delete',
  'quick-delete' => 'shift+delete',
  'nav-layout'  => 'mod+k',
  'save'  => 'mod+s',
  'find'  => 'mod+f',
  'copy'  => 'mod+c',
  'paste'  => 'mod+v',
  'paste-style' => 'mod+shift+v',
  'esc'   => 'esc'
);
