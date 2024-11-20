<tr>

    <td class="inner">
        <a style="margin: 12px" href="#" data-help="Click to read detailed description">
            <img src="<?php echo e(url('')); ?>/assets/images/product/<?php echo e($product->image); ?>" height="50" width="50" loading="lazy">
        </a>
    </td>
    <td class="small col-sm-12">
        <a href="/open/details?id=<?php echo e($product->id); ?>"> <?php echo e(\Illuminate\Support\Str::limit($product->name,
                                    50, '...Show more')); ?></a>
    </td>

    <td class="small">
        ₦<?php echo e(number_format($product->price, 2)); ?>

    </td>
    <td>

    </td>
    <td>
        <?php if($product->in_stock == 0): ?>
            <div>
                0 pcs.
                <button type="button"  class="form-control border-0" type="button" data-id="12005">
                    <ion-icon class="text-dark" name="bag-add"></ion-icon>
                </button>
            </div>
        <?php else: ?>
            <form action="/products/details/<?php echo e($product->id); ?>" method="get">
                <?php echo csrf_field(); ?>
                <div class="button-wrap" onclick="subscribeBuyItem(6);">
                    <div data-help="Buy Now">
                        <?php echo e($product->in_stock); ?> pcs.
                        <button type="submit" class="form-control" type="button"
                                data-id="12005">
                            <ion-icon class="" style="border: 0px;"
                                      name="bag-add"></ion-icon>
                        </button>
                    </div>
                </div>
            </form>
    </td>

    <?php endif; ?>
</tr>
<?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/project/logsnew/core/resources/views/templates/basic/partials/products.blade.php ENDPATH**/ ?>