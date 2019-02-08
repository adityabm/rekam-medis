<template>
    <div class="modal fade" role="dialog" id="modal-detail-pasien" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="background: white">
                <div class="modal-header">
                    <h4 class="modal-title">Detail Pasien</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample">
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">No Rekam Medis</label>
                        <label class="col-sm-10 col-form-label">: &nbsp;&nbsp;{{item.no_rekam_medis}}</label>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Nama</label>
                        <label class="col-sm-10 col-form-label">: &nbsp;&nbsp;{{item.nama}}</label>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                        <label class="col-sm-10 col-form-label">: &nbsp;&nbsp;{{item.tanggal_lahir | fullDate}}</label>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Alamat</label>
                        <label class="col-sm-10 col-form-label">: &nbsp;&nbsp;{{item.alamat}}</label>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">No Telp / No HP</label>
                        <label class="col-sm-10 col-form-label">: &nbsp;&nbsp;{{item.kontak}}</label>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                        <label class="col-sm-10 col-form-label">: &nbsp;&nbsp;{{item.jenis_kelamin == 'l' ? 'Laki-Laki' : 'Perempuan'}}</label>
                      </div>
                      <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Gol. Darah</label>
                        <label class="col-sm-10 col-form-label">: &nbsp;&nbsp;{{item.gol_darah == 'a' ? 'A' : (item.gol_darah == 'b' ? 'B' : (item.gol_darah == 'ab' ? 'AB' : 'O'))}}</label>
                      </div>
                      <table class="table table-striped">
                          <thead>
                            <th>No</th>
                            <th>Diagnosa</th>
                            <th>Tanggal Rawat</th>
                            <th>Lama Rawat</th>
                            <th>Tindakan</th>
                            <th>Obat</th>
                            <th>Aksi</th>
                          </thead>
                          <tbody>
                              <template v-for="(riw,index) in item.riwayat">
                                <tr>
                                    <td>{{index + 1}}</td>
                                    <td>{{riw.diagnosa_sakit}}</td>
                                    <td>{{riw.tanggal_dirawat | fullDate}}</td>
                                    <td>{{riw.lama_rawat ? riw.lama_rawat : '0'}} Hari</td>
                                    <td>{{riw.tindakan}}</td>
                                    <td>{{riw.obat ? riw.obat : 'Tidak Ada'}}</td>
                                    <td>
                                        <a href="#" @click="hapus(riw.id)"><span class="fa fa-trash"></span></a>
                                    </td>
                                </tr>
                              </template>
                          </tbody>
                      </table>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    export default {
        props: [],
        data() {
            return {
                item: {
                },
                base_url: base_url,
            }
        },
        methods: {
            open(oid, item) {
                if (oid == 'detail-pasien') {
                    this.item = item;
                    $('#modal-detail-pasien').modal("show");
                }
            },
            hapus(riw){
                var that = this;
                this.$swal("Apakah Anda Yakin Akan Menghapus Data Ini?", {
                  buttons: {
                    cancel: "Batal",
                    ya: true,
                  },
                })
                .then((value) => {
                  switch (value) {
                 
                    case "ya":
                      axios.post(that.base_url + '/hapus-riwayat', 
                        {
                          _token: that.$root.csrf_token,
                          id:riw
                        }).then(response => {
                          var res = response.data;

                          if(res.success){
                            that.$swal("Berhasil!", "Berhasil menghapus Data Riwayat", "success");
                            eventHub.$emit('refresh-ajaxtable','data-pasien');
                            $('#modal-detail-pasien').modal("hide");
                          }else{
                            that.$swal("Gagal!", res.message, "error");
                          }

                        });
                      break;
                  }
                });
            }
        },
        mounted() {
            this.$nextTick(function () {
                eventHub.$on('open-modal', this.open);
            }.bind(this));
        }
    }
</script>
