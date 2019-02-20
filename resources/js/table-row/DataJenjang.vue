<template>
  <tr>
    <td v-text="(pagination.page - 1) * pagination.perpage + 1 + index"></td>
    <td>{{item.name}}</td>
    <td>
      <a href="#" @click="edit(item)"><span class="fa fa-edit"></span></a> | 
      <a href="#" @click="hapus(item.id)"><span class="fa fa-trash"></span></a>
    </td>
  </tr>
</template>
<script>
export default {
  props: ['item','pagination','rowparams','index'],
  data() {
    return {
      base_url: base_url
    }
  },
  methods: {
    hapus(item){
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
            axios.post(that.base_url + '/hapus-jenjang', 
              {
                _token: that.$root.csrf_token,
                id:item
              }).then(response => {
                var res = response.data;

                if(res.success){
                  that.$swal("Berhasil!", "Berhasil menghapus Data Jenjang", "success");
                  eventHub.$emit('refresh-ajaxtable','data-jenjang');
                }else{
                  that.$swal("Gagal!", res.message, "error");
                }

              });
            break;
        }
      });
    },
    edit(item){
      eventHub.$emit('open-modal','form-jenjang',item);
    }
  }
}
</script>
