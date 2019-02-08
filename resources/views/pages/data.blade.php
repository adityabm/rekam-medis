@extends('layouts.dashboard')

@section('content')
<div class="row">
  <div class="col-md-12 d-flex align-items-stretch grid-margin">
    <div class="row flex-grow">
      <div class="col-12 stretch-card">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Data Pasien</h4>
            <ajax-table
                :url="'{{url('get-data-pasien') }}'"
                :oid="'data-pasien'"
                :params="params"
                :config="{
                    autoload: true,
                    show_all: false,
                    has_number: true,
                    has_entry_page: false,
                    has_pagination: true,
                    has_action: true,
                    has_search_input: true,
                    has_search_header: false,
                    custom_header: '',
                    default_sort: 'id',
                    default_sort_dir: 'asc',
                    custom_empty_page: false,
                    search_placeholder: 'Search',
                    class: {
                      wrapper: ['table-responsive'],
                    }
                }"
                :rowparams="{}"
                :rowtemplate="'tr-data-pasien'"
                :columns="{
                    no_rekam_medis: 'No Rekam Medis',
                    nama: 'Nama Pasien',
                    tanggal_lahir: 'Tanggal Lahir',
                    kontak: 'No Telp',
                    jumlah:'Jumlah Riwayat'
                }" 
                >
            </ajax-table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<modal-detail-pasien></modal-detail-pasien>
@endsection
