<?php $__env->startSection('content'); ?>



    <!-- Bootstrap JavaScript CDN -->
    <script src=
                "https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js">
    </script>

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
        <div class="page-content">
            <div class="dashboard-area">
                <div class="row">
                    <div style="margin-right: 126px" class="col d-flex justify-content-start">
                        <?php if($categories->count()): ?>
                            <div class="category-nav">
                                <button class="category-navbutton" style="background: #10113D;"><span
                                        class="search-text text-white"><?php echo app('translator')->get('
                                Category'); ?></span>
                                    <span class="arrow"><i class="las la-angle-down"></i></span>
                                </button>
                                <ul class="dropdown--menu" style="background: #10113D; color:#ffffff">
                                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="dropdown--menu__item text-white">
                                            <a href="/open-products/<?php echo e($category->name); ?>/<?php echo e($category->id); ?>" class="dropdown--menu__link text-white">  <?php echo e($category->name); ?>

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

                </div>
                <div class="col-12">
                    <?php if(auth()->guard()->check()): ?>

                        <div class="card-title mt-3 text-center">
                            <h6 style="background: #565656; padding: 10px; border-radius: 10px; color: white"
                                class="text-left">LAST ORDER</h6>
                        </div>


                        <div style="height:400px; width:100%; overflow-y: scroll;" class="card">
                            <div class="card-body">
                                <?php if($bought_qty == 0): ?>
                                <?php else: ?>
                                    <?php $__currentLoopData = $bought; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>



                                        <div class="row justify-content-around">
                                            <div style="font-size: 10px" class="col">
                                                <svg width="10" height="10" viewBox="0 0 14 14" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.61913 13.2708H4.37496C3.37163 13.2708 2.61913 13.0025 2.15246 12.4717C1.6858 11.9408 1.50496 11.1708 1.62746 10.1733L2.15246 5.79833C2.30413 4.50917 2.6308 3.35416 4.9058 3.35416H9.1058C11.375 3.35416 11.7016 4.50917 11.8591 5.79833L12.3841 10.1733C12.5008 11.1708 12.3258 11.9467 11.8591 12.4717C11.375 13.0025 10.6283 13.2708 9.61913 13.2708ZM4.89996 4.22916C3.21996 4.22916 3.13829 4.89416 3.01579 5.89749L2.4908 10.2725C2.4033 11.0133 2.50829 11.5558 2.80579 11.8883C3.10329 12.2208 3.6283 12.39 4.37496 12.39H9.61913C10.3658 12.39 10.8908 12.2208 11.1883 11.8883C11.4858 11.5558 11.5908 11.0133 11.5033 10.2725L10.9783 5.89749C10.8558 4.88832 10.78 4.22916 9.09413 4.22916H4.89996Z"
                                                        fill="url(#paint0_linear_309_90)"/>
                                                    <path
                                                        d="M9.33334 5.10416C9.09417 5.10416 8.89584 4.90583 8.89584 4.66666V2.625C8.89584 1.995 8.505 1.60416 7.87501 1.60416H6.12501C5.49501 1.60416 5.10417 1.995 5.10417 2.625V4.66666C5.10417 4.90583 4.90584 5.10416 4.66667 5.10416C4.42751 5.10416 4.22917 4.90583 4.22917 4.66666V2.625C4.22917 1.51083 5.01084 0.729164 6.12501 0.729164H7.87501C8.98917 0.729164 9.77084 1.51083 9.77084 2.625V4.66666C9.77084 4.90583 9.5725 5.10416 9.33334 5.10416Z"
                                                        fill="url(#paint1_linear_309_90)"/>
                                                    <path
                                                        d="M11.9058 10.3717H4.66667C4.42751 10.3717 4.22917 10.1733 4.22917 9.93418C4.22917 9.69501 4.42751 9.49668 4.66667 9.49668H11.9058C12.145 9.49668 12.3433 9.69501 12.3433 9.93418C12.3433 10.1733 12.145 10.3717 11.9058 10.3717Z"
                                                        fill="url(#paint2_linear_309_90)"/>
                                                    <defs>
                                                        <linearGradient id="paint0_linear_309_90" x1="7.00467"
                                                                        y1="3.35416"
                                                                        x2="7.00467" y2="13.2708"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="#FF6304"/>
                                                            <stop offset="1" stop-color="#FF1888"/>
                                                        </linearGradient>
                                                        <linearGradient id="paint1_linear_309_90" x1="7.00001"
                                                                        y1="0.729164"
                                                                        x2="7.00001" y2="5.10416"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="#FF6304"/>
                                                            <stop offset="1" stop-color="#FF1888"/>
                                                        </linearGradient>
                                                        <linearGradient id="paint2_linear_309_90" x1="8.28626"
                                                                        y1="9.49668"
                                                                        x2="8.28626" y2="10.3717"
                                                                        gradientUnits="userSpaceOnUse">
                                                            <stop stop-color="#FF6304"/>
                                                            <stop offset="1" stop-color="#FF1888"/>
                                                        </linearGradient>
                                                    </defs>
                                                </svg>

                                                <?php echo e(\Illuminate\Support\Str::limit($data->user_name,4, '.')); ?>, | <span style="color: #0AC028"> bought </span>|<span><?php echo e(\Illuminate\Support\Str::limit($data->item,
                                    16, '...')); ?></span>|<span style="color: #FF6304">₦<?php echo e(number_format($data->amount)); ?></span>|<a href="#" style=" font-size: 6px; background: linear-gradient(90deg, #FF6304 0%, #FF0D9B 100%); border-radius: 5px; padding: 3px; color: white"><?php echo e(diffForHumans($data->created_at)); ?></a>
                                                <hr>
                                            </div>
                                        </div>

                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>

                            </div>
                        </div>

                    <?php else: ?>

                    <?php endif; ?>

                </div>
                <div style="border-top: 80px">
                    <div class="card border-0">
                        <button style="margin-bottom: 70px" class="mb-5" onclick="topFunction()" id="myBtn" title="Go to top"><i class="fa fa-arrow-up"></i></button>
                    </div>
                </div>
            </div>
            <style>
                #myBtn {
                        display: none;
                        position: fixed;
                        bottom: -10px;
                        z-index: 70;
                        font-size: 20px;
                        border: none;
                        outline: none;
                        background-color: red;
                        color: white;
                        cursor: pointer;
                        padding: 0;
                        border-radius: 4px;
                        box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
                        width: 50px;
                        margin-top: 60px;
                        height: 40px;
                }

                #myBtn:hover {
                    background-color: #555; /* Darken background color on hover */
                }
            </style>



        </div>
        <script>
            function topFunction() {
                document.body.scrollTop = 0; // For Safari
                document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
            }

            // Show the button when user scrolls down 20px from the top of the document
            window.onscroll = function() {
                scrollFunction();
            };

            function scrollFunction() {
                if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                    document.getElementById("myBtn").style.display = "block";
                } else {
                    document.getElementById("myBtn").style.display = "none";
                }
            }
        </script>




    </div>




<?php $__env->stopSection(); ?>





<?php echo $__env->make($activeTemplate . 'layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/project/logsnew/core/resources/views/templates/basic/products.blade.php ENDPATH**/ ?>