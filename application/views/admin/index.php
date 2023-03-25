<input type="hidden" value="1" id="home">
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
                            <div class="text">1/3/2566</div>
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
            <div class="mb-3 col-xxl-8 col-xl-8 col-md-7 col-sm-12">
                <div class="bg-light border rounded-3 box-content">
                    <div class="box-container">
                        <?php for ($i = 0; $i <= 99; $i++) : ?>
                            <div class="box-item btnList " data-number="<?= $i <= 9 ? '0' . $i : $i ?>">
                                <div class="box-item-image ">
                                    <img src="<?=base_url('assets/images/Sold-Out-PNG.png')?>" alt="">
                                </div>
                                <div class="box-item-tool"></div>
                                <div class="box-item-number"><?= $i <= 9 ? '0' . $i : $i ?></div>
                            </div>
                        <?php endfor; ?>
                    </div>
                </div>
            </div>
            <div class="mb-3 col-xxl-4 col-xl-4 col-md-5 col-sm-12">
                <div class="bg-light border rounded-3 box-content">
                    <div class="content-number">
                        <div class="text">N/A</div>
                    </div>
                    <div class="row w-100">
                        <div class="mb-3">
                            <label for="" class="form-label">Name</label>
                            <input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Phone</label>
                            <input type="text" class="form-control" name="" id="" aria-describedby="helpId" placeholder="">
                        </div>
                        <div class="row text-center">
                            <div class="mb-3 ">
                                <button type="button" id="savedata" class="btn btn-primary">บันทึก</button>
                                <button type="button" id="canceldata" class="btn btn-secondary">ยกเลิก</button>
                            </div>
                        </div>

                    </div>

                </div>
            </div>


        </div>
    </div>
</div>