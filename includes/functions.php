<?php
// Helper : URL relative depuis n'importe quelle page
function base_url($path = '') {
    return rtrim(SITE_URL, '/') . '/' . ltrim($path, '/');
}

// Helper : chemin relatif vers la racine
function root_path() {
    $depth = substr_count($_SERVER['PHP_SELF'], '/') - 1;
    return str_repeat('../', $depth);
}
