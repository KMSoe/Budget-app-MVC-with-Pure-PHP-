<?php
include_once "../app/views/partials/head.php";
?>
<div class="container position-relative" style="width: 100vw;height: 100vh;">
    <div class="row justify-content-center">
        <div class="col-md-6 position-absolute top-50 start-50 translate-middle">
            <div class="card bg-success text-white">
                <div class="card-header">
                    <strong>Mail Sent</strong>
                </div>
                <div class="card-body">
                    <p class="text-white" style="letter-spacing: 1px;">
                        <?= htmlspecialchars($data["link"]) ?> has been sent.
                        <b><i>Check your mail!</i></b>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include_once "../app/views/partials/end.php";
?>