<template>
    <div class="modal fade" role="dialog" id="modal-form-jenjang" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="background: white">
                <div class="modal-header">
                    <h4 class="modal-title">Form Jenjang</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form class="forms-sample">
                      <div class="form-group row">
                        <label class="col-sm-4 col-form-label">Nama Jenjang</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" v-model="item.name" style="border:1px solid #cecece">
                        </div>
                      </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                    <button type="button" class="btn btn-success" @click="save()">Simpan</button>
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
                if (oid == 'form-jenjang') {
                    this.item = item;
                    $('#modal-form-jenjang').modal("show");
                }
            },
            save(){
                var that = this;
                axios.post(that.base_url + '/tambah-jenjang', 
                  {
                    _token: that.$root.csrf_token,
                    id:that.item.id,
                    name:that.item.name
                  }).then(response => {
                    var res = response.data;

                    if(res.success){
                      that.$swal("Berhasil!", "Berhasil menyimpan data jenjang", "success");
                      eventHub.$emit('refresh-ajaxtable','data-jenjang');
                      $('#modal-form-jenjang').modal("hide");
                    }else{
                      that.$swal("Gagal!", res.message, "error");
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
