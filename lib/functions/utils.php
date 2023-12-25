<?php

function mb( $txt ){
    return mb_encode_mimeheader( $txt );
}

function h($str) {
  return htmlspecialchars($str, ENT_COMPAT, 'UTF-8');
}