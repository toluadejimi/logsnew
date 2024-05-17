<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
    <style>
        /* Remove the navbar's default margin-bottom and rounded borders */
        .navbar {
            margin-bottom: 0;
            border-radius: 0;
        }

        /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
        .row.content {
            height: 450px
        }

        /* Set gray background color and 100% height */
        .sidenav {
            padding-top: 20px;
            background-color: #f1f1f1;
            height: 100%;
        }

        /* Set black background color, white text and some padding */
        footer {
            background-color: #555;
            color: white;
            padding: 15px;
        }

        /* On small screens, set height to 'auto' for sidenav and grid */
        @media screen and (max-width: 767px) {
            .sidenav {
                height: auto;
                padding: 15px;
            }

            .row.content {
                height: auto;
            }
        }
    </style>
</head>
<body>


<div class="container-fluid">
    <div class="row content">

        <div class="col-sm-8 p-4">

            <div class="card p-5">
                <div class="card-body">


                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger my-4">
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
                        <div class="alert alert-danger mt-2">
                            <?php echo e(session()->get('error')); ?>

                        </div>
                    <?php endif; ?>

                    <h4>Resolve Deposit</h4>

                    <form action="/deposit-now" method="post">
                        <?php echo csrf_field(); ?>

                        <select class="form-control my-2" name="vendor">
                            <option value="log">Log market Place</option>
                            <option value="boost">Palash Boost</option>
                            <option value="verifyasp">Verify asap</option>
                        </select>


                        <label class="my-2">Enter Customer Email</label>
                        <input class="form-control" name="email" type="email" required>


                        <label class="my-2">Enter Amount (NGN)</label>
                        <input class="form-control" name="amount" type="number" required>

                        <button type="submit" class="btn btn-success btn-sm my-4"> Continue </button>

                    </form>

                </div>


            </div>

        </div>

    </div>
</div>



</body>
</html>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/project/logsnew/core/resources/views/templates/basic/resolve-support.blade.php ENDPATH**/ ?>