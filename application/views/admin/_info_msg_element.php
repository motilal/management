<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<?php
$success = $this->session->flashdata("success");
$error = $this->session->flashdata("error");
$warning = $this->session->flashdata("warning");
$notification = $this->session->flashdata("notification");
$showmsgFunction = "";
if (!empty($success)) {
    $showmsgFunction = "showMessage('success', {message : " . json_encode($success) . "});";
} else if (!empty($error)) {
    $showmsgFunction = "showMessage('error', {message : " . json_encode($error) . "});";
} else if (!empty($warning)) {
    $showmsgFunction = "showMessage('warning', {message : " . json_encode($warning) . "});";
} else if (!empty($notification)) {
    $showmsgFunction = "showMessage('info', {message : " . json_encode($notification) . "});";
} 
?>
<script type="text/javascript">
    var Time_Interval = null;
    function hideAllMessages() {
        var messagesHeights = new Array(); /* this array will store height for each */
        var myMessages = ['info', 'warning', 'error', 'success'];
        for (i = 0; i < myMessages.length; i++) {
            messagesHeights[i] = $('#IEWSM > .' + myMessages[i]).outerHeight(); /* fill array */
            $('#IEWSM > .' + myMessages[i]).animate({top: -messagesHeights[i]}, 500);
        }
        if (Time_Interval !== null) {
            clearInterval(Time_Interval);
        }
    }
    function showMessage(type, params) {
        if (typeof params.h3 != "undefined") {
            $('#IEWSM > .' + type + " > h3").html(params.h3);
        }
        if (typeof params.message != "undefined") {
            $('#IEWSM > .' + type + " > p").html(params.message);
        }
        Time_Interval = setInterval(hideAllMessages, 3000);
        $('#IEWSM > .' + type).animate({top: "0"}, 500);
    }
    $(function () {
        $("#IEWSM").show();
        $("#IEWSM > div").click(function () {
            hideAllMessages();
        });
            <?php echo $showmsgFunction; ?>
    });
</script> 
<div id="IEWSM" style="display: none;">
    <div class="info message">
        <h3>FYI, something just happened!</h3>
        <p>This is just an info notification message.</p>
    </div>
    <div class="error message">
        <h3>Oops, an error occurred</h3>
        <p>This is just an error notification message.</p>
    </div>
    <div class="warning message">
        <h3>Wait, I must warn you!</h3>
        <p>This is just a warning notification message.</p>
    </div>
    <div class="success message">
        <h3>Congrats, you did it!</h3>
        <p>This is just a success notification message.</p>
    </div>
</div>