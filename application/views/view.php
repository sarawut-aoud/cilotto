<div class="row ">
    <div class="row mb-3  justify-content-center">
        <div class="col-10">
            <div class="row">
                <div class="mb-3 col-sm-12 col-md-6">
                    <div class="content">
                        <div class="content-pirce">
                            <div class="text">เบอร์ละ</div>
                            <div class="price">50 .-</div>
                        </div>
                        <div class="content-date">
                            <div class="text"><?= date('d-M-Y') ?></div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 col-sm-12 col-md-6">
                    <div class="content-pay">
                        <div class="text">
                            <h1>เบอร์เงินสด</h1>
                        </div>
                        <div class="top-number">
                            ถูกบน 300 .-
                        </div>
                        <div class="bottom-number">
                            ถูกล่าง 3000 .-
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="row mb-3 justify-content-center">
        <div class="row">
            <div class="mb-3 col-xxl-12 col-xl-12 col-md-12 col-sm-12">
                <div class="bg-light  rounded-3 box-content p-3">
                    <div class="box-container">
                        <?php for ($i = 0; $i <= 99; $i++) : ?>
                            <div class="box-item " data-number="<?= $i <= 9 ? '0' . $i : $i ?>">
                                <div class="box-item-image">
                                    <img src="{base_url}assets/images/Sold-Out-PNG.png" alt="">
                                </div>
                                <div class="box-item-tool"></div>
                                <div class="box-item-number"><?= $i <= 9 ? '0' . $i : $i ?></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>