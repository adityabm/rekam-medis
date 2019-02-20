<template>
  <div class="row">
    <div class="col-md-12 d-flex align-items-stretch grid-margin">
      <div class="row flex-grow">
        <div class="col-12 stretch-card">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Form Data Pasien</h4>
              <form class="forms-sample">
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">No Rekam Medis</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="RMXXXXXX" v-model="pasien.no_rekam_medis">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nama</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" v-model="pasien.nama">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Tanggal Lahir</label>
                  <div class="col-sm-10">
                    <flat-pickr
                        v-model="pasien.tanggal_lahir"
                        :config="config"
                        class="form-control" style="background: white" placeholder="YYYY-MM-DD"
                        name="date"></flat-pickr>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Alamat</label>
                  <div class="col-sm-10">
                    <textarea class="form-control" v-model="pasien.alamat"></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">No Telp / No HP</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="62xxx" v-model="pasien.kontak">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
                  <div class="col-sm-10">
                    <select class="form-control" v-model="pasien.jenis_kelamin">
                      <option value="">Pilih Jenis Kelamin</option>
                      <option value="l">Laki-Laki</option>
                      <option value="p">Perempuan</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Gol. Darah</label>
                  <div class="col-sm-10">
                    <select class="form-control" v-model="pasien.gol_darah">
                      <option value="">Pilih Golongan Darah</option>
                      <option value="a">A</option>
                      <option value="b">B</option>
                      <option value="ab">AB</option>
                      <option value="o">O</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Jenjang Pendidikan</label>
                  <div class="col-sm-10">
                    <select class="form-control" v-model="pasien.jenjang_id">
                      <option value="">Pilih Jenjang</option>
                      <option v-for="jen in jenjang" :value="jen.id">{{jen.name}}</option>
                    </select>
                  </div>
                </div>
                <button type="button" class="btn btn-primary mr-2 mb-3" @click="tambahRiwayat()">Tambah Riwayat Pasien</button>
                <template v-for="(riw,index) in riwayat">
                  <fieldset>
                    <legend>Riwayat Pasien {{index + 1}}<button type="button" class="btn btn-danger btn-sm pull-right" @click="remove(index)">-</button></legend>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Diagnosa Penyakit</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="riw.diagnosa_sakit">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Tanggal Rawat</label>
                      <div class="col-sm-10">
                        <flat-pickr
                            v-model="riw.tanggal_dirawat"
                            :config="config"
                            class="form-control" style="background: white" placeholder="YYYY-MM-DD"
                            name="date"></flat-pickr>
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Lama Rawat</label>
                      <div class="col-sm-10">
                        <input type="number" class="form-control" v-model="riw.lama_rawat">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Tindakan</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="riw.tindakan">
                      </div>
                    </div>
                    <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Obat Yang Diberikan</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" v-model="riw.obat">
                      </div>
                    </div>
                  </fieldset>
                </template>
                <button type="button" class="btn btn-success pull-right" @click="save()">Simpan</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
        props: ['item','jenjang'],
        data() {
          return {
            pasien:{
              id:null,
              jenis_kelamin:'',
              gol_darah:'',
              jenjang_id:''
            },
            riwayat:[],
            base_url: base_url,
            config:{
              maxDate: Date.now()
            }
          }
        },
        methods:{
          tambahRiwayat(){
            this.riwayat.push({
              diagnosa_sakit:'',
              tanggal_dirawat:'',
              lama_rawat:'',
              tindakan:'',
              obat:''
            })
          },
          remove(index){
            this.riwayat.splice(index,1);
          },
          save(){
            var that = this;

            axios.post(this.base_url + '/proses-pasien', 
              {
                _token: this.$root.csrf_token,
                id:this.pasien.id,
                no_rekam_medis:that.pasien.no_rekam_medis,
                nama:that.pasien.nama,
                tanggal_lahir:that.pasien.tanggal_lahir,
                alamat:that.pasien.alamat,
                kontak:that.pasien.kontak,
                jenis_kelamin:that.pasien.jenis_kelamin,
                gol_darah:that.pasien.gol_darah,
                jenjang_id:that.pasien.jenjang_id,
                riwayat:that.riwayat
              }).then(response => {
                var res = response.data;

                if(res.success){
                  this.$swal("Berhasil!", "Berhasil mengedit Data Pasien", "success");
                  setTimeout(function(){
                      location = that.base_url + '/data-pasien'
                    },1000)
                }else{
                  this.$swal("Gagal!", res.message, "error");
                }

              });
          }
        },
        mounted(){
          this.pasien = this.item;
          this.riwayat = this.item.riwayat;
        }
    }
</script>
