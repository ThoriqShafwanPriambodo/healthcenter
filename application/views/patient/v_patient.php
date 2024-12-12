<!-- Begin Page Content -->
<div class="page-content">
    <div class="modal modal-add fade modal-lg" id="loginModal" tabindex="-1" aria-labelledby="myModalLabel33" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Masukkan Data Pasien</h4>
                    <button type="button" class="close btn-closed" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>

                <form action="#">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group has-icon-left">
                                    <label>Nama</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control"
                                            placeholder=""
                                            id="txnama">
                                        <div class="form-control-icon">
                                            <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Gender</label>
                                <div class="input-group mb-1">
                                    <label class="input-group-text"><i class="bi bi-balloon-heart"></i></label>
                                    <select class="form-select" id="txgender">
                                        <option disabled selected>...</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label>Gol Darah</label>
                                <div class="input-group mb-1">
                                    <label class="input-group-text"><i class="bi bi-droplet"></i></label>
                                    <select class="form-select" id="txgoldarah">
                                        <option selected>...</option>
                                        <option value="A+">A+</option>
                                        <option value="A-">A-</option>
                                        <option value="B+">B+</option>
                                        <option value="B-">B-</option>
                                        <option value="AB+">AB+</option>
                                        <option value="AB-">AB-</option>
                                        <option value="O+">O+</option>
                                        <option value="O-">O-</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group has-icon-left">
                                    <label>NIK</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control angka" maxlength="16"
                                            placeholder="" id="txnik">
                                        <div class="form-control-icon">
                                            <i class="bi bi-123"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group has-icon-left">
                                    <label>Nomor Telepon</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control angka" maxlength="13"
                                            placeholder="" id="txtelepon">
                                        <div class="form-control-icon">
                                            <i class="bi bi-phone"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group has-icon-left">
                                    <label>Tempat Lahir</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control"
                                            placeholder="" id="txtempat">
                                        <div class="form-control-icon">
                                            <i class="bi bi-geo"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group has-icon-left">
                                    <label>Tanggal Lahir</label>
                                    <div class="position-relative">
                                        <input type="date" class="form-control"
                                            placeholder="" id="txtanggal">
                                        <div class="form-control-icon">
                                            <i class="bi bi-calendar2-event"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="form-group has-icon-left">
                                    <label>Alamat</label>
                                    <div class="position-relative">
                                        <input type="text" class="form-control"
                                            placeholder="" id="txalamat">
                                        <div class="form-control-icon">
                                            <i class="bi bi-geo-alt"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="btn-closed d-none d-sm-block ">Close</span>
                                </button>
                                <button type="button" class="btn btn-primary btn-submit ms-1" onclick="save_data()">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Submit</span>
                                </button>
                                <button type="button" class="btn btn-warning btn-editen ms-1" hidden onclick="update_data()">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Update</span>
                                </button>
                            </div>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="card card-dta">

    <div class="card-body">
        <button class="btn btn-success btn-add" data-bs-toggle="modal" data-bs-target="#loginModal"><i
                class="bi bi-plus-lg"> </i>Tambah</button>
        <button class="btn btn-primary" onclick="load_patient()"><i class="bi bi-arrow-clockwise"> </i>Refresh</button>
        <div class="card-title ">
            <P></P>
            <p>Masukkan data pasien</p>
        </div>
        <div class="table-responsive">
            <table class="table table-hover" id="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th style="width:25%">Nama</th>
                        <th>Gender</th>
                        <th>Gol. Darah</th>
                        <th style="width:30%">TTL</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($patient as $pt): ?>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</section>
</div>
</div>
</section>
</div>
</section>
</div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->