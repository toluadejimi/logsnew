<?php $__env->startSection('content'); ?>

    <div class="container">

        <style>
            div#social-links {
                margin: 0 auto;
                max-width: 500px;
            }

            div#social-links ul li {
                display: inline-block;
            }

            div#social-links ul li a {
                padding: 10px;
                border: 1px solid #fff;
                margin: 2.5px;
                font-size: 20px;
                color: #222;
                background-color: #ff087c;
                border-radius: 10px;
                color: white;
            }
        </style>

        <!-- section start -->

        <div class="collection-wrapper">
            <div class="container">
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
                <div class="row">


                    <div class="col-lg-6">

                        <div class="card">


                            <div class="card-body">


                                <div class="product-right">


                                    <div class="page-content">
                                        <div class="d-flex justify-content-center my-4">
                                            <img class="my-2"
                                                 src="<?php echo e(getImage(getFilePath('product') . '/' . $product->image, getFileSize('product'))); ?>"
                                                 width="100px" height="100px">
                                        </div>
                                    </div>
                                    <div class="detail-content">
                                        <div class="flex-1">
                                            <h4><?php echo e(__($product->name)); ?></h4>
                                            <p> <?php echo $product->description; ?></p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-5">
                                            <h6 class="mt-2">NGN<?php echo e(number_format($product->price)); ?>/Pcs</h6>
                                        </div>

                                        <div class="col-7">
                                            <button type="button"
                                                    class="btn btn-outline-success btn-block"><?php echo e($product->in_stock); ?>

                                                Available in stock
                                            </button>
                                            </span>
                                        </div>
                                    </div>

                                    <hr>


                                    <div class="row">
                                        <div class="col-6">
                                            <button style="background-color: #4d4d4d; color: white" class="btn"
                                                    onclick="decrementQuantity()">-
                                            </button>
                                            <span class="p-2" id="quantity">1</span>
                                            <button style="background-color: #FF0B9E; color: white" class="btn"
                                                    onclick="incrementQuantity()">+
                                            </button>
                                        </div>

                                        <div class="col-6">
                                            <button type="button" style="background-color: #10113D; color: white"
                                                    class="btn btn-block">NGN<span id="total">10.00</span></button>

                                        </div>
                                    </div>


                                    <hr>

                                    <div class="col-12 mt-3">
                                        <h6  class="mb-3">Share product</h6>
                                        <span class=""><?php echo $shareComponent; ?> </span>
                                    </div>

                                    <hr>

                                    <form action="<?php echo e(route('user.deposit.insert')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>

                                        <h6 class="">Have a coupon?</h6>
                                        <input class="form-control mb-3 p-1" name="coupon_code" type="text"
                                               placeholder="Enter Coupon Code">

                                        <input type="text" hidden id="quantityInput" name="qty" value="1">
                                        <input type="text" hidden name="id" value="<?php echo e($product->id); ?>">
                                        <input type="text" hidden type="text" name="payment" value="wallet">
                                        <input type="text" hidden name="gateway" value="250">


                                        <?php if($product->in_stock == 0): ?>
                                        <button disabled type="submit"
                                                style="background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%); color: white;"
                                                class="btn btn-block">Out of stock
                                        </button>
                                        <?php else: ?>
                                            <button type="submit"
                                                    style="background: linear-gradient(279deg, #FF0B9E -6.58%, #FF6501 121.69%); color: white;"
                                                    class="btn btn-block">Buy
                                                now
                                            </button>
                                        <?php endif; ?>

                                    </form>
                                </div>


                            </div>


                        </div>
                    </div>


                </div>


                <div class="col-lg-6" style="padding-bottom: 50px">


                    <div class="card">
                        <div class="card-body">

                            <div class="card-title mt-3 text-center">
                                <h6>Disclaimer</h6>

                            </div>


                            <div class="text-center">
                                <p>By purchasing any product, you agree that you are fully aware of these
                                    terms/conditions and agree to follow them! 👉🏽<a href="/user/rules"> TERMS AND
                                        CONDITIONS</a></p>

                            </div>


                        </div>
                    </div>

                </div>


            </div>


        </div>

        <!-- Section ends -->


        <script>
            // Variables to track quantity and price
            let quantity = 1;
            const price = <?php echo e($product->price); ?>;

            // Functions to increment and decrement quantity
            function incrementQuantity() {
                quantity++;
                updateView();
            }

            function decrementQuantity() {
                if (quantity > 1) {
                    quantity--;
                    updateView();
                }
            }

            // Function to update the view with new quantity and total
            function updateView() {
                const quantityElement = document.getElementById("quantity");
                const totalElement = document.getElementById("total");
                const quantityInput = document.getElementById("quantityInput");

                const total = (quantity * price).toFixed(2);

                quantityElement.textContent = quantity;
                totalElement.textContent = total;
                quantityInput.value = quantity;
            }

            // Function to submit quantity to the server
            function submitQuantity() {
                const quantityInput = document.getElementById("quantityInput");
                alert("Quantity submitted: " + quantityInput.value);
                // You can send the quantityInput.value to the server here
            }

            // Initialize the view
            updateView();
        </script>

<?php $__env->stopSection(); ?>




<?php echo $__env->make($activeTemplate . 'layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/project/logsnew/core/resources/views/templates/basic/product_details.blade.php ENDPATH**/ ?>