<div class="col-12">
    <div class="row mb-3 justify-content-start">
        <div class="mb-2 col-sm-6 col-md-6 col-lg-3 ">
            <div class="bg-light border rounded-3">
                <div class="card ">
                    <div class="card-header">
                        <h5>Pay</h5>
                    </div>
                    <div class="card-body card-body-content">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="" id="pay_name" aria-describedby="helpId" placeholder="เบอร์ละ">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="" id="pay_number" aria-describedby="helpId" placeholder="50">
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-primary save-data" data-module="pay">บันทึก</button>
                        <button type="button" class="btn btn-secondary close-data">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-2 col-sm-12 col-md-12 col-lg-3">
            <div class="bg-light border rounded-3">
                <div class="card ">
                    <div class="card-header">
                        <h5>Date</h5>
                    </div>
                    <div class="card-body card-body-content">
                        <div class="mb-3">
                            <input type="date" class="form-control" name="" id="date_number" min="<?= date('Y-m-d'); ?>" aria-describedby="helpId" placeholder="งวดวันที่">
                        </div>

                    </div>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-primary save-data-date">บันทึก</button>
                        <button type="button" class="btn btn-secondary close-data">ยกเลิก</button>

                    </div>
                </div>
            </div>
        </div>

        <div class="mb-2 col-sm-6 col-md-6 col-lg-3">
            <div class="bg-light border rounded-3">
                <div class="card ">
                    <div class="card-header">
                        <h5>Topic Top Number</h5>
                    </div>
                    <div class="card-body card-body-content">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="" id="top_name" aria-describedby="helpId" placeholder="ถูกบน">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="" id="top_number" aria-describedby="helpId" placeholder="300">
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-primary save-data" data-module="top">บันทึก</button>
                        <button type="button" class="btn btn-secondary close-data">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-2 col-sm-6 col-md-6 col-lg-3">
            <div class="bg-light border rounded-3">
                <div class="card ">
                    <div class="card-header">
                        <h5>Topic Bottom Number</h5>
                    </div>
                    <div class="card-body card-body-content">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="" id="bottom_name" aria-describedby="helpId" placeholder="ถูกล่าง">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="" id="bottom_number" aria-describedby="helpId" placeholder="3000">
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <button type="button" class="btn btn-primary save-data" data-module="bottom">บันทึก</button>
                        <button type="button" class="btn btn-secondary close-data">ยกเลิก</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-2 col-sm-12 col-md-12 col-lg-12 col-xl-6 col-xxl-6">
            <div class="bg-light border rounded-3">
                <div class="card ">
                    <div class="card-header">
                        <h5>set Date</h5>
                    </div>
                    <div class="card-body card-body-content">

                        <div class="mb-3 ">
                            <table id="tabledate" class="table table-hover table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>วันที่</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="row mb-3 justify-content-start">
        <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-5 justify-content-center">
                        <div class="col-8">
                            <div class="mb-3 w-100">
                                <select class="form-select " name="" id="date-select">
                                    <option>------------</option>
                                </select>
                            </div>

                        </div>

                        <div class="row text-center">
                            <div class="col-12">
                                <button type="button" class="btn btn-secondary"><i class="fas fa-search"></i> Search</button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-hover table-bordered" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>ชื่อ</th>
                                        <th>เลข</th>
                                        <th>งวดวันที่</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php for ($i = 0; $i <= 10; $i++) : ?>
                                        <tr class="">
                                            <td>กหฟกหฟกกฟหกฟกฟห</td>
                                            <td><?= $i ?></td>
                                            <td><?= date('d-M-Y') ?></td>
                                        </tr>
                                    <?php endfor; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>