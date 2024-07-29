<?php $__env->startSection('content'); ?>

    <div class="container">
        <div class="flex">

            <?php if($errors->any()): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if(session()->has('message')): ?>
                <div class="alert alert-success">
                    <?php echo e(session()->get('message')); ?>

                </div>
            <?php endif; ?>
            <?php if(session()->has('error')): ?>
                <div class="alert alert-danger">
                    <?php echo e(session()->get('error')); ?>

                </div>
            <?php endif; ?>


            <div class="col-lg-6">
                <div class="card">
                    <div class="card-body " style="margin-bottom: 100px">
                        <form action="/user/pass-reset" method="POST">
                            <label>Enter Registered Email</label>
                            <input type="text" class="form-control" name="email" value="<?php echo e(old('value')); ?>" required
                                   autofocus>
                            <button style="color: white; border-radius: 10px;   background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%);"  class="btn btn-sm my-3" type="submit">Reset</button>

                        </form>
                    </div>
                </div>
            </div>

                <div style="padding-bottom: 700px" class="col-lg-12 mb-90">
                </div>
        </div>
    </div>






<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/project/logsnew/core/resources/views/templates/basic/user/auth/passwords/email.blade.php ENDPATH**/ ?>