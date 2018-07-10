<?php if (isset($type)): ?>
    <div class="alert <?php echo "alert-{$type}" ?> alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <p><?php echo isset($message) ? $message : null ?></p>
    </div>
<?php endif; ?>