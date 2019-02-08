<template id="table-template">
    <div v-bind:id="oid">
        <div v-if="config.has_entry_page || config.has_search_input" style="margin-bottom: 10px">
            <div class="form-inline">
                <div class="form-group" v-if="config.has_entry_page">
                    Show &nbsp;
                    <select class="input-sm" v-model="pagination.perpage" v-on:change="changePage()">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="500">500</option>
                    </select>
                    Entry &nbsp;
                </div>
                <div class="form-group pull-right" v-if="config.has_search_input">
                    Cari &nbsp;
                    <input class="input-sm form-control" type="text" v-model="search_input" @keyup="doSearchDebounce">
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div v-bind:class="{ 'dimmed': isLoading }" v-show="!showCustomEmptyPage">
            <div v-bind:class="config.class.wrapper">
                <table class="dataTable table table-up table-striped b-t b-b" v-bind:class="config.class.table">
                    <thead v-bind:class="config.class.thead" v-if="!config.disable_header || config.has_search_header">
                    <tr :is="config.custom_header" v-if="!config.disable_header && config.custom_header != ''"
                        :sort="sort" :sort-column.sync="sortColumn" :sort-dir.sync="sortDir"></tr>
                    <tr v-if="!config.disable_header">
                        <th v-if="config.has_number" class="header_no" style="width: 1%">No</th>
                        <th v-for="(column_name,column) in columns"
                            v-bind:style="columnsStyle ? columnsStyle[column] : {}" class="ewPointer"
                            v-on:click="sort(column)">
                            {{column_name}}
                            <sorter :sort-dir.sync="sortDir" :column-name="column"
                                    :sort-column.sync="sortColumn"></sorter>
                        </th>
                        <th v-if="config.has_action" class="header_action">Aksi</th>
                    </tr>
                    <tr v-if="config.has_search_header">
                        <th v-bind:colspan="totalColumns" class="th_search">
                            <i class="icon-bdg_search"></i>
                            <input type="search" class="table-search form-control b-none w-full"
                                   v-bind:placeholder="config.search_placeholder ? config.search_placeholder : 'Cari'"
                                   v-model="search_input" @keyup="doSearchDebounce">
                        </th>
                    </tr>
                    </thead>
                    <tbody v-bind:class="config.class.tbody">
                    <tr v-for="(item,index) in items" :is="rowtemplate" :rowparams.sync="rowparams" :index="index"
                        :item="item" :pagination="pagination" :key="index"></tr>
                    <tr v-if="pagination.count == 0">
                        <td v-bind:colspan="totalColumns">No data to be showed</td>
                    </tr>
                    </tbody>
                    <tfoot v-if="config.custom_footer && config.custom_footer != ''" :is="config.custom_footer"
                           :info.sync="info"></tfoot>
                </table>
            </div>
            <div v-if="config.has_pagination" style="margin-top: 10px;display: none" v-show="pagination.count > 0">
                <div class="row">
                    <div class="col-sm-6" style="line-height: 40px">
                        <div class="">
                            Entry&nbsp;{{ (pagination.page - 1) * pagination.perpage + 1 }}&nbsp;to&nbsp;{{
                            Math.min(pagination.count, pagination.page * pagination.perpage) }}&nbsp;from&nbsp;{{
                            pagination.count }}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-right form-group">
                            Page &nbsp;
                            <!--first page button-->
                            <a class="btn btn-default btn-xs" v-on:click="paginate('first')"><i
                                    class="fa fa-step-backward"></i></a>
                            <a class="btn btn-default btn-xs" v-on:click="paginate('previous')"><i
                                    class="fa fa-chevron-left"></i></a>
                            <input class="input-sm" type="text" size="4" v-model="pagination.page"
                                   v-on:change="changePage()">
                            <a class="btn btn-default btn-xs" v-on:click="paginate('next')"><i
                                    class="fa fa-chevron-right"></i></a>
                            <a class="btn btn-default btn-xs" v-on:click="paginate('last')"><i
                                    class="fa fa-step-forward"></i></a>
                            &nbsp;dari&nbsp;{{ Math.floor((pagination.count - 1) / pagination.perpage) + 1 }}
                            &nbsp;&nbsp;&nbsp;&nbsp;
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
        <div style="display: none" v-show="showCustomEmptyPage">
            <slot name="empty-page">
                <div class="empty-state">
                    <p>No data to be shown</p>
                </div>
            </slot>
        </div>
    </div>
</template>

<style>
    .ewPointer {
        cursor: pointer;
    }

    table.dataTable{
        border-collapse: collapse !important;
    }

    .table-nolrpadding > thead > tr > th, .table-nolrpadding > tbody > tr > th, .table-nolrpadding > tfoot > tr > th, .table-nolrpadding > tbody > tr > td, .table-nolrpadding > tfoot > tr > td {
        padding-left: 0;
        padding-right: 0;
    }

    .dimmed {
        position: relative;
    }

    .dimmed:after {
        content: " ";
        z-index: 10;
        display: block;
        position: absolute;
        height: 100%;
        top: 0;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.5);
    }

    .input-sm {
        padding: 0.5rem 0.7rem;
        font-size: 0.9rem;
        line-height: 1.25;
        color: #464a4c;
        text-align: center;
        background-color: #fff;
        background-image: none;
        background-clip: padding-box;
        border: 1px solid #cecece;
        border-radius: 0.25rem;
        transition: border-color ease-in-out 0.15s, box-shadow ease-in-out 0.15s;
    }
</style>

<script>
    export default {
        props: ['oid', 'url', 'params', 'columns', 'config', 'rowparams', 'rowtemplate', 'columnsStyle'],
        data() {
            return {
                isLoading: true,
                items: [],
                info: {},
                pagination: {
                    page: 1,
                    previous: false,
                    next: false,
                    perpage: 20,
                    count: 0,
                },
                search: '',
                search_input: '',
                sortColumn: null,
                sortDir: null,
                detail: {},
                showDetail: false,
            }
        },
        methods: {
            paginate(direction) {
                if (direction === 'previous') {
                    if (this.pagination.page > 1) {
                        --this.pagination.page;
                        this.changePage();
                    }
                } else if (direction === 'next') {
                    if (Math.floor((this.pagination.count - 1) / this.pagination.perpage) != (this.pagination.page - 1)) {
                        ++this.pagination.page;
                        this.changePage();
                    }
                } else if (direction === 'first') {
                    this.pagination.page = 1;
                    this.changePage();
                } else if (direction === 'last') {
                    this.pagination.page = Math.floor((this.pagination.count - 1) / this.pagination.perpage) + 1;
                    this.changePage();
                }
            },
            changePage(page) {
                if (isNaN(parseInt(this.pagination.page)) || this.pagination.page < 1) {
                    this.pagination.page = 1;
                }
                this.getData(this.pagination.page);
            },
            clearFilter() {
                for (var key in this.params) {
                    if (this.params.hasOwnProperty(key)) {
                        this.params[key] = '';
                    }
                }
                this.search          = '';
                this.search_input    = '';
                this.sortColumn      = null;
                this.sortDir         = null;
                this.pagination.page = 1;
                this.changePage();
            },
            sort(col, default_sort_dir) {
                if (this.sortColumn == col) {
                    this.sortDir = default_sort_dir ? default_sort_dir : ((this.sortDir == 'asc') ? 'desc' : 'asc');
                } else {
                    this.sortColumn = col;
                    this.sortDir    = default_sort_dir ? default_sort_dir : 'asc';
                }
                if (this.config.local_sort) {

                } else {
                    this.pagination.page = 1;
                    this.changePage();
                }
            },
            doSearch() {
                this.search          = this.search_input;
                this.pagination.page = 1;
                this.changePage();
            },
            doSearchDebounce: _.debounce(function () {
                this.doSearch();
            }, 300),
            getData(page) {
                var that       = this;
                that.isLoading = true;
                $.getJSON(that.url,
                    {
                        page: page,
                        perpage: that.config.show_all ? 99999 : that.pagination.perpage,
                        params: that.params,
                        search: that.search,
                        order: that.sortColumn,
                        order_direction: that.sortDir,
                    },
                    function (data) {
                        that.items            = data.data;
                        that.info             = data.info;
                        that.isLoading        = false;
                        that.pagination.count = data.count;
                        if (that.pagination.count > 0 && that.pagination.page > Math.floor((that.pagination.count - 1) / that.pagination.perpage) + 1) {
                            that.pagination.page = Math.floor((that.pagination.count - 1) / that.pagination.perpage) + 1;
                            that.changePage();
                        }
                    });
            },
        },
        computed: {
            showCustomEmptyPage: function () {
                return this.config.custom_empty_page == true && this.pagination.count == 0 && !this.isLoading && this.search == '';
            },
            totalColumns: function () {
                return (this.config.has_number ? 1 : 0) + _.size(this.columns) + (this.config.has_action ? 1 : 0);
            },
        },
        events: {
            'do-search'(objid) {
                if (objid == this.oid) {
                    this.doSearch();
                }
            },
            'clear-filter'(objid) {
                if (objid == this.oid) {
                    this.clearFilter();
                }
            },
            'reset-search'(objid) {
                if (objid == this.oid) {
                    this.search          = '';
                    this.search_input    = '';
                    this.sortColumn      = null;
                    this.sortDir         = null;
                    this.pagination.page = 1;
                    this.doSearch();
                }
            },
        },
        mounted() {
            var that = this;
            this.$nextTick(function () {
                if (that.config.default_sort) {
                    if (that.config.autoload) {
                        that.sort(that.config.default_sort, that.config.default_sort_dir)
                    } else {
                        that.sortColumn = that.config.default_sort;
                        that.sortDir    = that.config.default_sort_dir ? that.config.default_sort_dir : 'asc';
                    }
                } else if (that.config.autoload) {
                    that.changePage(1)
                }
                $('.empty-state').show();
                window.eventHub.$on('refresh-ajaxtable', function (objid) {
                    if (objid == that.oid) {
                        that.changePage();
                    }
                })
            });
        }
    }
</script>
