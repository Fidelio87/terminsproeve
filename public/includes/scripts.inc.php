<?php
/**
 * Created by PhpStorm.
 * User: 3529588
 * Date: 28/08/2017
 * Time: 12:50
 */
?>

<script src="../bower_components/jquery/dist/jquery.min.js"></script>
<script src="../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!--DATEPICKER-->
<script src="../bower_components/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
<script src="../bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.da.js"></script>
<!-- Googles prettyprint -->
<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
<script>

    $('#date-picker.input-daterange').datepicker({
        language: "da",
        toggleActive: true,
        defaultViewDate: { year: 2006, month: 0, day: 1 }
    });
</script>
