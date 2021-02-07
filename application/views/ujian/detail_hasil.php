<div class="box">
    <div class="box-header with-border">
        <h3 class="box-title"><?=$subjudul?></h3>
        <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12 mb-4">
                <a href="<?=base_url()?>hasilujian" class="btn btn-flat btn-sm btn-default"><i class="fa fa-arrow-left"></i> Kembali</a>
                <button type="button" onclick="reload_ajax()" class="btn btn-flat btn-sm bg-purple"><i class="fa fa-refresh"></i> Reload</button>
                <div class="pull-right">
                    <a target="_blank" href="<?=base_url()?>hasilujian/cetak_detail/<?=$this->uri->segment(3)?>" class="btn bg-maroon btn-flat btn-sm">
                        <i class="fa fa-print"></i> Print
                    </a>
                     <button type="button" class="btn bg-blue btn-flat btn-sm" data-toggle="modal" data-target="#exampleModalLong">
                        <i class="fa fa-envelope"></i> Kirim Ke Email
                   </button>
                    
                </div>
            </div>
            <div class="col-sm-6">
                <table class="table w-100">
                    <tr>
                        <th>Nama Ujian</th>
                        <td><?=$ujian->nama_ujian?></td>
                    </tr>
                    <tr>
                        <th>Jumlah Soal</th>
                        <td><?=$ujian->jumlah_soal?></td>
                    </tr>
                    <tr>
                        <th>Waktu</th>
                        <td><?=$ujian->waktu?> Menit</td>
                    </tr>
                    <tr>
                        <th>Tanggal Mulai</th>
                        <td><?=strftime('%A, %d %B %Y', strtotime($ujian->tgl_mulai))?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Selasi</th>
                        <td><?=strftime('%A, %d %B %Y', strtotime($ujian->terlambat))?></td>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <table class="table w-100">
                    <tr>
                        <th>Mata Kuliah</th>
                        <td><?=$ujian->nama_matkul?></td>
                    </tr>
                    <tr>
                        <th>Dosen</th>
                        <td><?=$ujian->nama_dosen?></td>
                    </tr>
                    <tr>
                        <th>Nilai Terendah</th>
                        <td><?=$nilai->min_nilai?></td>
                    </tr>
                    <tr>
                        <th>Nilai Tertinggi</th>
                        <td><?=$nilai->max_nilai?></td>
                    </tr>
                    <tr>
                        <th>Rata-rata Nilai</th>
                        <td><?=$nilai->avg_nilai?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="table-responsive px-4 pb-3" style="border: 0">
        <table id="detail_hasil" class="w-100 table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Jumlah Benar</th>
                <th>Nilai</th>
            </tr>        
        </thead>
        <tfoot>
            <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>Jurusan</th>
                <th>Jumlah Benar</th>
                <th>Nilai</th>
            </tr>
        </tfoot>
        </table>
    </div>
</div>
<!-- Modal -->

<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
       </button>
      <div class="user-panel">
      <div class="pull-left image">
                <img src="<?=base_url()?>assets/dist/img/paper-plane.png" class="img-circle" alt="User Image" >
      </div>
            
            <h5 class="modal-title">KIRIM HASIL NILAI KE EMAIL</h5>

    </div>
    
    
      <div class="modal-body">
           <?= form_open_multipart('hasilujian/kirimmail'); ?>
          
                        <div class="row">
                            <div class="col-md-6">
                                                                
                                <div class="form-group">
                                    <label>Alamat Email</label>
                                    <input type="email" name="email" class="form-control" placeholder="contoh@gmail.com" required />
                                </div>
                                
                                        
                                <div class="form-group">
                                     <textarea name="pesan"  class="form-control" required rows="8">Berikut adalah Laporan Hasil Nilai Ujian Sementara , Salam Sukses :)</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Upload</label>
                                    <input type="file" name="resume" accept=".doc,.docx, .pdf" required />
                                </div>
                                <div class="col-sm-3">
                                <a target="_blank" href="<?=base_url()?>hasilujian/cetak_detail/<?=$this->uri->segment(3)?>" class="btn btn-sm btn-success">
                                <i class="fa fa-eye" aria-hidden="true"></i> Preview
                                 </a>
                                 </div>
                              
                         </div>
                     </div>
              </div>
                                      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
          <form method="post" action=""> 
                      
        <button type="submit" name="submit_email"  class="btn btn-primary">Kirim</button>
       
        </form>
        <?= form_close(); ?> 
      </div>
     
    </div>
  </div>
</div>


<script type="text/javascript">
    var id = '<?=$this->uri->segment(3)?>';
</script>

<script src="<?=base_url()?>assets/dist/js/app/ujian/detail_hasil.js"></script>