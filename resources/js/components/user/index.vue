<template>
  <div class="index-page category-index form-box-container">
    <div class="row">
      <div class="col-lg-9 col-md-9 col-sm-7 col-6">
        <div class="row">
          <div class="delete-all-item">
            <div class="form-check form-check-inline">
              <label
                class="
                  container-checkbox
                  form-check-label
                  align-items-center
                  height-14
                  mr-3
                  p-0
                "
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
              @click="deleteAll(user.id)"
              class="btn border-radius-7"
              v-bind:class="{
                'btn-outline-secondary': !isBtnDeleteAll,
                'background-white': !isBtnDeleteAll,
                'btn-success': isBtnDeleteAll,
                disabled: !isBtnDeleteAll,
              }"
            >
              Delete All
            </button>
          </div>
          <div class="card">
            <input type="text" v-model="searchText" @keyup="getData(1)" />
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-3 col-sm-5 col-6">
        <a
          class="
            btn btn-block btn-success
            align-items-center
            text-white
            border-radius-7
            max-width-191
            float-lg-right
          "
          :href="initData.userCreate"
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
            <th>Avatar</th>
            <th>Name</th>
            <th class="text-center">Email</th>
            <th class="text-center">Gender</th>
            <th class="text-center">Phone</th>
            <th class="text-center">Created</th>
            <th class="text-center"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(user, index) in users" :key="user.id">
            <td>
              <div class="form-check form-check-inline">
                <label
                  class="
                    container-checkbox
                    form-check-label
                    align-items-center
                    height-17
                    p-0
                  "
                  :for="`category${index}`"
                >
                  <input
                    class="form-check-input"
                    type="checkbox"
                    v-model="selectedIds"
                    :id="`user${index}`"
                    name="user"
                    @change="updateCheckAll"
                    :value="user.id" />
                  <span class="checkmark"></span
                ></label>
              </div>
            </td>
            <td>
              <div class="category-image">
                <img :src="'/public/uploads/' + user.avatar" alt="" />
              </div>
            </td>
            <td>
              <a
                class="link-item text-view"
                :href="`/admin/category/item/${user.id}`"
                >{{ user.name }}</a
              >
            </td>
            <td>
              <a
                class="link-item text-view"
                :href="`/admin/user/item/${user.id}`"
                >{{ user.email }}</a
              >
            </td>
            <td class="text-center">
              <span v-if="user.gender == 1">Male</span>
              <span v-else-if="user.gender == 2">Female</span>
              <span v-else>Other</span>
            </td>
            <td class="text-center">
              {{ user.phone }}
            </td>
            <td class="text-center">
              {{ user.created_at }}
            </td>
            <td></td>
            <div class="modal-footer">
              <button
                type="button"
                @click.prevent="deleteItem(user.id)"
                class="btn-danger"
              >
                Delete
              </button>
              <a
                class="btn btn-danger"
                @click.="editUser(user.id)"
                :href="'/admin/user/edit/' + user.id"
                >Edit</a
              >
            </div>
          </tr>
        </tbody>
      </table>
      <div class="position-relative" v-if="users != ''">
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
          class="dataTables_info hiragino-sans-w5"
          id="dataTable_info"
          role="status"
          aria-live="polite"
        >
          {{ numberOfFirstRecord }} - {{ numberOfPage }}/{{ totalNumber }}Items
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
      searchText: "",
      users: [],
      currentPage: "",
      numberOfFirstRecord: "",
      numberOfPage: "",
      totalNumber: "",
      lastPage: 0,
      isBtnDeleteAll: false,
      isInputALl: false,
      selectedIds: [],
      id: "",
      email: "",
      phone: "",
      name: "",
      password: "",
      birthdate: "",
      avatar: "",
      gender: "",
    };
  },
  props: ["initData"],
  methods: {
    deleteItem(id) {
      axios.delete("/admin/user/deleteItem/" + id).then((response) => {
        this.$toast.error("Delete success!", {
          position: "top-right",
          timeout: 2000,
          closeOnClick: true,
          pauseOnFocusLoss: true,
          pauseOnHover: true,
          draggable: true,
          draggablePercent: 0.6,
          showCloseButtonOnHover: false,
          hideProgressBar: true,
          closeButton: "button",
          icon: "bi bi-trash",
          rtl: false,
        });
        this.getData();
      });
    },
    deleteAll() {
      axios.post("/admin/user/deleteAll", this.selectedIds).then((response) => {
        this.getData();
      });
    },
    checkAll() {
      this.isInputALl = !this.isInputALl;
      this.selectedIds = [];
      if (this.isInputALl) {
        this.users.forEach((item, index) => {
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
        if (this.selectedIds.length == this.users.length) {
          this.isInputALl = true;
        } else {
          this.isInputALl = false;
        }
      } else {
        this.isBtnDeleteAll = false;
      }
    },
    onChange(e) {
      this.avatar = e.target.files[0];
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
            name: this.searchText,
          },
        })
        .then(function (response) {
          that.users = response.data.data;
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
