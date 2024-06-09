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
        </div>

        <!-- Recent -->
        <div class="mb-5">
            <div class="swiper-btn-center-lr">
                <div class="swiper-container demo-swiper">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide"><a href="#"><img
                                    src="<?php echo e(url('')); ?>/assets/assets2/concept/assets/images/Logplace__1.png" class=""
                                    alt="..." width="100" height="50"></a></div>
                        <div class="swiper-slide"><a href=" https://t.me/logmkp"><img
                                    src="<?php echo e(url('')); ?>/assets/assets2/concept/assets/images/Logplace__2.png"
                                    class="d-block w-100"
                                    alt="..."></a></div>
                        <div class="swiper-slide"><a href="https://tinyurl.com/logsgroup2"><img
                                    src="<?php echo e(url('')); ?>/assets/assets2/concept/assets/images/Logplace__5.png"
                                    class="d-block w-100"
                                    alt="..."></a></div>
                        <div class="swiper-slide"><img
                                src="<?php echo e(url('')); ?>/assets/assets2/concept/assets/images/Logplace__3.png"
                                class="d-block w-100" alt="...">
                        </div>
                        <div class="swiper-slide"><a href="https://t.me/logmarketplacee"><img
                                    src="<?php echo e(url('')); ?>/assets/assets2/concept/assets/images/Logplace__4.png"
                                    class="d-block w-100"
                                    alt="..."></a></div>


                    </div>
                </div>
            </div>
        </div>
        <!-- Recent -->


        <!-- Page Content -->
        <div class="page-content">

            <div class="dashboard-area">

                <!-- Recomended Start -->
                <div class="row">
                    <div style="margin-right: 126px" class="col d-flex justify-content-start">
                        <?php if($categories->count()): ?>
                            <div class="category-nav">
                                <button class="category-nav__button" style="background: #10113D;"><span
                                        class="search-text text-white"><?php echo app('translator')->get('
                                Category'); ?></span>
                                    <span class="arrow"><i class="las la-angle-down"></i></span>
                                </button>
                                <ul class="dropdown--menu" style="background: #10113D; color:#ffffff">
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="dropdown--menu__item text-white">
                                            <a href="/category-products/<?php echo e($category->name); ?>/<?php echo e($category->id); ?>" class="dropdown--menu__link text-white">  <?php echo e($category->name); ?>

                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col d-flex justify-content-end">
                        <h2 class="">Hi, <?php echo e(Auth::user()->username ?? "User"); ?>, </h2>
                    </div>
                </div>


                <div class="row mt-2">

                    <div class="col-xxl-10 col-xl-11">
                        <?php $__empty_1 = true; $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $products = $category->products;
                            ?>



                            <div class="catalog-item-wrapper mb-2">

                                <div class="d-grid gap-2 mb-2">
                                    <strong>
                                        <p class="p-2"
                                           style="color: white; border-radius: 10px;   background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%);"><?php echo e(__($category->name)); ?></p>
                                    </strong>
                                </div>


                                <div class="card">
                                    <div class="card-body">


                                        <table class="table table-sm table-responsive-sm">
                                            <thead style="border-radius: 100px; background: #10113D;color: #ffffff;">
                                            <tr class>
                                                <th style="border-radius: 10px 0px 0px 10px;"></th>
                                                <th>Product</th>
                                                <th>Price</th>
                                                <th></th>
                                                <th style="border-radius: 0px 10px 10px 0px;">Stock</th>
                                            </tr>
                                            </thead>
                                            <tbody>


                                            <?php $__currentLoopData = $products->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php echo $__env->make($activeTemplate . 'partials/products', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </tbody>


                                        </table>


                                    </div>
                                </div>


                                <div class="col-12  mb-4">
                                    <a style="color:white; border-radius: 10px; background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%);"
                                       href="<?php echo e(route('category.products', ['search' => request()->search, 'slug' => slug($category->name), 'id' => $category->id])); ?>"
                                       class="btn  btn-block">
                                        <?php echo app('translator')->get('View All'); ?>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                             fill="currentColor" class="bi bi-arrow-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                  d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/>
                                        </svg>


                                    </a>
                                </div>


                            </div>

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

                            <div class="empty-data text-center">
                                <div class="thumb">
                                    <img src="<?php echo e(asset($activeTemplateTrue . 'images/not-found.png')); ?>">
                                </div>

                                <h4 class="title"><?php echo app('translator')->get('No result found for "' . request()->search . '"'); ?></h4>
                            </div>
                        <?php endif; ?>
                        <?php echo e(paginateLinks($categories)); ?>

                    </div>




                    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
                    <a href="#" style="position: sticky;width: 50px; height: 50px;" onclick="topFunction()" data-toggle="modal" data-target="#exampleModalCenter" class="float" target="_blank">
                        <i class="fa fa-arrow-up"></i>
                    </a>


                    <div class="container">

                        <div class="card p-3">
                            <div class="card-body p-3">
                            </div>


                            <h5>Why do people Buy social media
                                accounts?</h5>
                            <p class="small">A solid social media
                                account can be a powerful tool for
                                branding and marketing.</p>
                            <p class="small">A good social media
                                account
                                has an active and responsive
                                community
                                fired up by the
                                topic or niche that brought them
                                together.</p>
                            <p class="small">Sometimes it makes
                                sense to
                                buy or sell a social media account
                                depending on where
                                you are with your business and how
                                goals
                                have changed and evolved.</p>
                            <p class="small">There is a thriving
                                market
                                for buying/selling social media
                                accounts, but it’s
                                important to know what the best
                                platforms are. </p>

                            <p class="small"><strong>Let’s dig
                                    in!</strong></p>



                        </div>


                        <script>
                            // When the user scrolls down 20px from the top of the document, show the button
                            window.onscroll = function() {scrollFunction()};

                            function scrollFunction() {
                                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                                    document.getElementById("scrollToTopBtn").style.display = "block";
                                } else {
                                    document.getElementById("scrollToTopBtn").style.display = "none";
                                }
                            }

                            // When the user clicks on the button, scroll to the top of the document
                            function topFunction() {
                                document.body.scrollTop = 0; // For Safari
                                document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
                            }

                        </script>






                    </div>
                </div>
            </div>

        </div>
    </div>



<?php $__env->stopSection(); ?>





<?php echo $__env->make($activeTemplate . 'layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/project/logsnew/core/resources/views/templates/basic/products.blade.php ENDPATH**/ ?>