@extends('layouts.dashboard')

@section('content')
<div class="row">
  <div class="col-md-12 d-flex align-items-stretch grid-margin">
    <div class="row flex-grow">
      <div class="col-12 stretch-card">
        <div class="card">
          <div class="card-body">
            <button class="btn btn-primary pull-right" onclick="window.eventHub.$emit('open-modal', 'form-jenjang',{id:null,name:null});">Tambah Jenjang</button>
            <h4 class="card-title">Jenjang Pendidikan</h4>
            <ajax-table
                :url="'{{url('get-data-jenjang') }}'"
                :oid="'data-jenjang'"
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
                :rowtemplate="'tr-data-jenjang'"
                :columns="{
                    name: 'Nama Jenjang',
                }" 
                >
            </ajax-table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<modal-form-jenjang></modal-form-jenjang>
@endsection
