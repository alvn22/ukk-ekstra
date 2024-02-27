<?php

    function redirect($url){
        echo"<script>
            window.location.href='$url'
        </script>";
        exit;
    }

    function alert($type,$msg){
        $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
        echo <<<alert
            <div class="alert $bs_class alert-dismissible fade show custom-alert" role="alert">
                <strong class="me-3">$msg</strong>
                <button class="close" type="button" class="btn-close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            </div>
        alert;
    }

?>