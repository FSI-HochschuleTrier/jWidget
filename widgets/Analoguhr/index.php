<?php /**
 * Created by PhpStorm.
 * User: Philipp Dippel
 * Date: 31.05.17
 * Time: 17:44
 */

?>

<div id="mainContainer">
    <canvas id="mainCanvas" width="2000" height="2000"></canvas>
</div>

<script type="text/javascript">

    $('document').ready(function ()
    {
            $.getScript("widgets/Analoguhr/ClockStyleKit.js")
                .done(function (script, textStatus)
                {
                    clock();
                })
                .fail(function (jqxhr, settings, exception)
                {
                    console.error("Failed to load ClockStyleKit");
                    console.error(exception);
                });
    });


</script>