<div class="card">
    <div class="<?php echo('card-header bg-'.$items['color'].' text-white') ?>">
        {{ $items['title'] }}
        <span class="<?php echo('fas '.$items['icon'].' fa-lg float-right my-1') ?>"></span>
    </div>
    <div class="<?php echo('card-body text-center text-'.$items['color']) ?>">
        <h1 class="h1 h1-responsive">
            {{$slot}}
        </h1>
    </div>
    <div class="<?php echo('card-footer bg-'.$items['color']) ?>"></div>
</div>