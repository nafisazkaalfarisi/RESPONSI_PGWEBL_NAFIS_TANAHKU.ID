<?php if(session()->has('success')): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">

        <div class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="liveToastSuccess">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo e(session('success')); ?>

                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script>
        var toastLive = document.getElementById('liveToastSuccess')
        var toast = new bootstrap.Toast(toastLive)

        toast.show()

        //console.log("<?php echo e(session('success')); ?>");
    </script>
<?php endif; ?>

<?php if(session()->has('error')): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">

        <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="liveToastError">
            <div class="d-flex">
                <div class="toast-body">
                    <?php echo e(session('error')); ?>

                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script>
        var toastLive = document.getElementById('liveToastError')
        var toast = new bootstrap.Toast(toastLive)

        toast.show()

        //console.log("<?php echo e(session('error')); ?>");
    </script>
<?php endif; ?>

<?php if($errors->any()): ?>
    <div class="toast-container position-fixed bottom-0 end-0 p-3">

        <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
            aria-atomic="true" id="liveToastError">
            <div class="d-flex">
                <div class="toast-body">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo e($error); ?><br>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                    aria-label="Close"></button>
            </div>
        </div>
    </div>
    <script>
        var toastLive = document.getElementById('liveToastError')
        var toast = new bootstrap.Toast(toastLive)

        toast.show()

        //console.log("<?php echo e(session('error')); ?>");
    </script>
<?php endif; ?>
<?php /**PATH D:\PGWL_NAFIS\pgwl\resources\views/components/toast.blade.php ENDPATH**/ ?>