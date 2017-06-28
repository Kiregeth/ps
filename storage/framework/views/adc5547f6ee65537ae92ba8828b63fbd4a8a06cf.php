<a href="<?php echo e(route('logout')); ?>"
   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
    Logout
</a>

<form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
    <?php echo e(csrf_field()); ?>

</form>