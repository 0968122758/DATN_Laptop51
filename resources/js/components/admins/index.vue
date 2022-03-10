<template>
    <div class="index-page category-index form-box-container">
        <div class="row">
            <div class="col-lg-9 col-md-9 col-sm-7 col-6">
                <div class="row">
                    <div class="delete-all-item">
                        <div class="form-check form-check-inline">
                            <label
                                class="container-checkbox form-check-label align-items-center height-14 mr-3 p-0"
                                for="checkAll"
                            >
                                <input
                                    v-model="isInputALl"
                                    class="form-check-input"
                                    type="checkbox"
                                    id="checkAll"
                                    name="checkAll"
                                    @click="checkAll" />
                                <span class="checkmark"></span
                            ></label>
                        </div>
                        <button
                            class="btn border-radius-7"  @click="deleteAll(admin.id)"
                            v-bind:class="{
                                'btn-outline-secondary': !isBtnDeleteAll,
                                'background-white': !isBtnDeleteAll,
                                'btn-success': isBtnDeleteAll,
                                disabled: !isBtnDeleteAll,
                            }"
                        >
                            Delete All
                        </button>
                        
                    <input type="text" placeholder="Search by email "  class="text-center search-admins" v-model="searchText" @keyup="getData(1)"> <button
                            class="btn btn-search border-radius-7 btn-success"
                        >
                            Search
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-5 col-6">
                 <a
                    class="btn btn-block btn-success align-items-center text-white border-radius-7 max-width-191 float-lg-right"
                    href=" http://127.0.0.1:8000/admin/admins/create"
                >
                    <svg class="c-icon mr-2 mt-0">
                        <use xlink:href="/images/icons/plus.svg#plus"></use>
                    </svg>
                    <span class="flex-grow-1 hiragino-sans-w6">Add new</span>
                </a>
            </div>
        </div>
        <div class="sp-margin-15 mt-4">
            <table class="table table-responsive-sm table-striped table-banner">
                <thead>
                    <tr>
                        <th></th>
                        <th>Name</th>
                        <th class="text-center">Email</th>
                        <th class="text-center">Created</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr
                        v-for="(admin, index) in admins"
                        :key="index"
                    >
                        <td>
                            <div class="form-check form-check-inline">
                                <label
                                    class="container-checkbox form-check-label align-items-center height-17 p-0"
                                    :for="`admin${index}`"
                                >
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        v-model="selectedIds"
                                        :id="`admin${index}`"
                                        name="admin"
                                        @change="updateCheckAll"
                                        :value="admin.id" />
                                    <span class="checkmark"></span
                                ></label>
                            </div>
                        </td>
                         <td>
                            <a
                                class="link-item text-view"
                                :href="`/admin/admins/item/${admin.id}`"
                                >{{ admin.name }}</a
                            >
                        </td>
                        <td>
                            <a
                                class="link-item text-view"
                                :href="`/admin/admins/item/${admin.id}`"
                                >{{ admin.email }}</a
                            >
                        </td>
                        <td>
                            <a
                                class="link-item text-view"
                                :href="`/admin/admins/item/${admin.id}`"
                                >{{ admin.created_at }}</a
                            >
                        </td>
                        <td>
                            <button
                                class="btn btn-light icon-close"
                                @click="deleteItem(admin.id)"
                            ></button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class=" position-relative" v-if="admins.length != 0">
                <paginate
                    :page-count="lastPage"
                    :container-class="'pagination d-flex justify-content-center mt-3'"
                    :page-class="'page-item'"
                    :page-link-class="'page-link'"
                    :prev-class="'page-item prev-item'"
                    :prev-link-class="'page-link'"
                    :next-class="'page-item next-item'"
                    :next-link-class="'page-link'"
                    :prev-text="'<span><img src=\'/images/icons/angle-left.svg\'></span>'"
                    :next-text="'<span><img src=\'/images/icons/angle-right.svg\'></span>'"
                    :click-handler="getData"
                >
                </paginate>
                <div
                    class="totalNumber dataTables_info hiragino-sans-w5"
                    id="dataTable_info"
                    role="status"
                    aria-live="polite"
                >
                    {{ numberOfFirstRecord }} - {{ numberOfPage }}/{{
                        totalNumber
                    }}Items
                </div>
            </div>
            <div class="text-center" v-else>NO DATA!</div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            admin: "",
            searchText:"",
            admins: [],
            currentPage: "",
            numberOfFirstRecord: "",
            numberOfPage: "",
            totalNumber: "",
            lastPage: 0,
            isBtnDeleteAll: false,
            isInputALl: false,
            selectedIds: [],
        };
    },
    props: ["initData"],
    methods: {
         deleteItem(id){
            axios.delete('/admin/admins/deleteItem/'+id).then(response =>{
                this.getData();
            });
        },
        deleteAll(){
            axios.post('/admin/admins/deleteAll',this.selectedIds).then(response =>{
                this.getData();
            });
        },
        checkAll() {
            this.isInputALl = !this.isInputALl;
            this.selectedIds = [];
            if (this.isInputALl) {
                this.admins.forEach((item, index) => {
                    this.selectedIds.push(item.id);
                    this.isBtnDeleteAll = true;
                });
            } else {
                this.isBtnDeleteAll = false;
            }
        },
        updateCheckAll() {
            if (this.selectedIds.length > 0) {
                this.isBtnDeleteAll = true;
                if (this.selectedIds.length == this.admins.length) {
                    this.isInputALl = true;
                } else {
                    this.isInputALl = false;
                }
            } else {
                this.isBtnDeleteAll = false;
            }
        },
        prev() {},
        next() {},
        chanePage: function (page) {},
        getData(page) {
            let that = this;
            axios
                .get(this.initData.urlGetData, {
                    params: {
                        _token: Laravel.csrfToken,
                        page: page,
                        name: this.searchText
                    },
                })
                .then(function (response) {
                    that.admins = response.data.data;
                    that.totalNumber = response.data.total;
                    that.currentPage = response.data.current_page;
                    that.numberOfPage = response.data.to;
                    that.numberOfFirstRecord = response.data.from;
                    that.lastPage = response.data.last_page;
                })
                .catch((error) => {});
        },
    },
    created() {
        this.getData(1);
    },
};
</script>
