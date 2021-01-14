<?php
    echo "<input type='hidden' id='txt_csrfname' name='". $this->security->get_csrf_token_name() ."' value='" . $this->security->get_csrf_hash() . "'>";
?>