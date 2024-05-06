<?php $__env->startSection('content'); ?>
        <!-- Banner End -->
        <div class="account-box">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-7 col-xl-5">
                        <div class="d-flex justify-content-center">
                            <div class="verification-code-wrapper">

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

                                <div class="verification-area">
                                    <form action="<?php echo e(route('user.password.verify.code')); ?>" method="POST"
                                          class="submit-form">
                                        <?php echo csrf_field(); ?>
                                        <p class="mb-3"><?php echo app('translator')->get('A 6 digit verification code sent to your email address'); ?>
                                            : <?php echo e(showEmailAddress($email)); ?></p>
                                        <input type="hidden" name="email" value="<?php echo e($email); ?>">

                                        <label>Verification Code</label>
                                        <input type="text" name="code" id="verification-code" class="form-control overflow-hidden my-2 mb-4" required autocomplete="off">

                                        <div class="form-group my-3">
                                            <button type="submit" class="btn btn-block" style="color: white; border-radius: 10px;   background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%);"><?php echo app('translator')->get('Submit'); ?></button>
                                        </div>

                                        <div class="form-group" style="margin-bottom: 800px">
                                            <?php echo app('translator')->get('Please check including your Junk/Spam Folder. if not found, you can'); ?>
                                            <a href="<?php echo e(route('user.password.request')); ?>"
                                               class="text--base"><?php echo app('translator')->get('Try to send again'); ?></a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make($activeTemplate . 'layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/project/logsnew/core/resources/views/templates/basic/user/auth/passwords/code_verify.blade.php ENDPATH**/ ?>